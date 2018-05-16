<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\System\CoreController;
use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\ForumPostModel;
use App\Http\DbModel\ForumPostTableidModel;
use App\Http\DbModel\ForumThreadModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

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
        {
            return self::response([],40002,'需要登录');
        }
        $data['fid']        = $request->input('fid');
        $data['author']     = $user_info->username;
        $data['lastposter']     = $user_info->username;
        $data['authorid']   = $user_info->uid;
        $data['subject']    = $request->input('subject');
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
        $this->threadModel->save();
        /**
         * 添加post一楼数据
         */
        $tableId = new ForumPostTableidModel();
        $tableId->save();

        $postModel      = $this->postModel;
        $postModel->fid = $request->input('fid');
        $postModel->tid = $this->threadModel->tid;
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
         *  论坛当日帖子+1
         */
        $forum              = Forum_forum_model::find($request->input('fid'));
        $forum->todayposts  = $forum->todayposts +1;
        $forum->threads     = $forum->threads +1;
        $forum->save();
        return self::response();
    }
    public function PostsThread(Request $request)
    {
        $user_info = session('user_info');
        if(empty($user_info))
        {
            return self::response([],40001,'请先登录');
        }
        if ($this->checkRequest($request,['fid','tid','subject','message']) !== true)
        {
            return self::response([],40002,'缺少参数');
        }

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
        return self::response();
    }
}
