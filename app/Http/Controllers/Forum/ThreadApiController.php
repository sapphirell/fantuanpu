<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\System\ActionController;
use App\Http\Controllers\System\CoreController;
use App\Http\DbModel\CommonMemberCount;
use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\ForumPostModel;
use App\Http\DbModel\ForumPostTableidModel;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\HomeNotification;
use App\Http\DbModel\SukiNoticeModel;
use App\Http\DbModel\User_model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class ThreadApiController extends Controller
{
    public $threadModel;
    public $postModel;
    public function __construct(ForumThreadModel $threadModel,ForumPostModel $postModel)
    {
        $this->threadModel  = $threadModel;
        $this->postModel    = $postModel;
    }

    //
    public function NewThread(Request $request)
    {
        $user_info      = session('user_info');

        if (empty($user_info))
            return self::response([],40002,'需要登录');
        if($user_info->groupid == 4 || $user_info->groupid == 5)
            return self::response([],40003,'您的账户已被禁言');
        if($user_info->groupid == 8)
            return self::response([],40003,'您的账户邮箱未验证,因此不能发表主题');

        $checkParams = $this->checkRequest($request,['subject','message']);
        if($checkParams !== true)
        {
            return self::response([],40001,'缺少参数'.$checkParams);
        }

        $fid    = $request->input('fname')
                ? Forum_forum_model::where('name',"=",$request->input('fname'))->first()->fid
                : $request->input('fid');
        if (!$fid)
            return self::response([],40004,'fid为空,至少需要传输fname或fid');

        $this->_newThread(
                            $fid,
                            $request->input('subject'),
                            $request->input('message'),
                            $request->getClientIp(),
                            $user_info
                        );
        return self::response([],200,'发帖成功');
    }
    public function _newThread($fid,$subject,$message,$ip,$user_info,$from="fantuanpu")
    {
        $data['fid']        = $fid;
        $data['author']     = $user_info->username;
        $data['lastposter']     = $user_info->username;
        $data['authorid']   = $user_info->uid;
        $data['subject']    = $subject;
        $data['dateline']   = time();
        $data['lastpost']   = time();

        foreach ($data as $key => $value)
        {
            if (!$value)
            {
                return self::response([],40001,"缺少参数{$key}");
            }
            else
            {
                $this->threadModel->{$key} = $value;
            }
        }
        $this->threadModel->replies = 1;
        $this->threadModel->anonymous = in_array($fid,self::$anonymous_forum) ? 2 : 1;
        $from == "suki" && $this->threadModel->ascription = 2;
        $this->threadModel->save();
        /**
         * 添加post一楼数据
         */
        $tableId = new ForumPostTableidModel();
        $tableId->save();

        $postModel      = $this->postModel;
        $postModel->fid = $fid;
        $postModel->tid = $this->threadModel->tid;
        $postModel->pid = $tableId->pid;
        $postModel->first   = 0;
        $postModel->author  = $user_info->username;
        $postModel->authorid = $user_info->uid;
        $postModel->subject = $subject;
        $postModel->dateline = time();
        $postModel->message = $message;
        $postModel->useip   = $ip;
        $postModel->save();
        /**
         *  论坛当日帖子+1
         */
        $forum              = Forum_forum_model::find($fid);
        $forum->todayposts  = $forum->todayposts +1;
        $forum->threads     = $forum->threads +1;
        $forum->save();
        /**
         * 用户统计更新
         */
        if ($from == "fantuanpu")
            CommonMemberCount::AddUserCount($user_info->uid,"threads",1);
        if ($from == "suki")
            CommonMemberCount::AddUserCount($user_info->uid,"sukithreads",1);
        /**
         *  完成动作 发帖
         */
        return ActionController::complete_action('PNT',$user_info->uid,$this->threadModel->tid);
    }
    /**
     * 回复帖子,如果$thread_origin =fantuanpu 通知HomeNotification表, =suki 通知SukiNotice表
     * @param Request $request
     * @返回 mixed
     */
    public function PostsThread(Request $request,$user_info = false,$thread_origin = "fantuanpu")
    {
        $user_info = $user_info ? : session('user_info');
        if(empty($user_info))
        {
            return self::response([],40001,'请先登录');
        }
        if ($this->checkRequest($request,['fid','tid','subject','message']) !== true)
        {
            return self::response([],40002,'缺少参数');
        }
        if($user_info->groupid == 4 || $user_info->groupid == 5)
            return self::response([],40003,'您的账户已被禁言');



        /**
         * 获取帖子自增长id
         */
        $tableId = new ForumPostTableidModel();
        $tableId->save();

        $postModel      = $this->postModel;
        $postModel->fid = $request->input('fid');
        $postModel->tid = $request->input('tid');
        $postModel->pid = $tableId->pid;
        $postModel->first   = 0;
        $postModel->author  = $user_info->username;
        $postModel->authorid = $user_info->uid;
        $postModel->subject = $request->input('subject');
        $postModel->dateline = time();
        $postModel->message = $request->input('message');
        $postModel->useip   = $request->getClientIp();
        $postModel->save();
        /**
         * 查找回帖所属的主题,并讲回复数+1
         */
        $thread = $this->threadModel->find($request->input('tid'));
        if ($thread)
        {
            $thread->replies = $thread->replies +1;
            $thread->save();
        }

        /**
         *  论坛当日帖子+1
         */
        $forum = Forum_forum_model::find($request->input('fid'));
        $forum->todayposts = $forum->todayposts +1;
        $forum->posts = $forum->posts +1;
        $forum->save();

        /**
         *  通知帖主帖子被回复
         */
        if ($thread_origin == "fantuanpu" && $thread->authorid != $user_info->uid)
        {
            $notification = new HomeNotification();
            $notification->uid = $thread->authorid;
            $notification->type = 'post';//通知类型:"doing"记录,"friend"好友请求,"sharenotice"好友分享,"post"话题回复,
            $notification->new = 1;
            $notification->authorid = $user_info->uid;
            $notification->author = $user_info->username;
            $notification->note = " <a href=\"home.php?mod=space&uid=36\">{$user_info->username}</a> 回复了您的帖子 
                                <a href=\"forum.php?mod=redirect&goto=findpost&ptid={$thread->tid}&pid={$tableId->pid}\" target=\"_blank\">{$request->input('subject')}</a> &nbsp; 
                                <a href=\"forum.php?mod=redirect&goto=findpost&pid={$thread->tid}&ptid={$tableId->pid}\" target=\"_blank\" class=\"lit\">查看</a>";
            $notification->dateline = time();
            $notification->from_id = $tableId->pid;
            $notification->from_idtype = 'quote';
            $notification->from_num = '0';
            $notification->save();
            /**
             * 用户统计更新
             */
            CommonMemberCount::AddUserCount($user_info->uid,'posts',1);
        }
        if ($thread_origin == "suki" && $thread->authorid != $user_info->uid)
        {
            $post = $postModel->where('pid',$postModel->pid)->first();
            $notice = new SukiNoticeModel();
            $notice->uid = $thread->authorid;
            $notice->position_id = json_encode(["tid"=>$request->input('tid'),"pid"=>$tableId->pid,"floor"=>$post->position]);
            $notice->authorid = $user_info->uid;
            $notice->message =  $request->input('message');
            $notice->author = $user_info->username;
            $notice->place = 1;
            $notice->notice_time = time();
            $notice->save();
            /**
             * 用户统计更新
             */
            CommonMemberCount::AddUserCount($user_info->uid,'sukiposts',1);
            /**
             * 界面上显示小红点
             */
            $author = User_model::find($thread->authorid);
            $useralert =  $author->useralert ? json_decode($author->useralert,true) : [];

            $useralert['suki']['reply'] = 1;

            $author->useralert = json_encode($useralert);
//            ddd( $author->useralert);
            $author->save();
            User_model::flushUserCache($thread->authorid);
        }

        /**
         *  通知用户帖子被回复
         */
        self::call_message_queue('common','user_notice',[
                'to_uid'=>$thread->authorid,
                'msg'=> $user_info->username . '回复了您的帖子'
            ]);

        /**
         * 清理帖子回帖缓存 ,获取当前回帖所在页数,并删除该页的缓存(咕咕)
         */
        $post = $postModel->where('pid',$postModel->pid)->first();

        $posts_cache_key    = CoreController::POSTS_VIEW;
//        dd($posts_cache_key['key'].$request->input('tid') ."_" . ceil($post->position/20));
        Cache::forget( $posts_cache_key['key'].$request->input('tid') ."_" . ceil($post->position/20));
        /**
         * 更新主题的预览图片,如果是前一页的楼层,就要更新
         */

        if ($post->position <= CoreController::THREAD_REPLY_PAGE)
            ForumThreadModel::flush_thread_preview_image($request->input('tid'),"insert",$request->input('message'));

        //完成动作
        ActionController::complete_action('RCT',$user_info->uid,$request->input('tid'));
        return self::response([],200,'回帖成功');
    }
}
