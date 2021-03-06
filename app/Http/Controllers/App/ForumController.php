<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Forum\ThreadApiController;
use App\Http\Controllers\Forum\ThreadController;
use App\Http\Controllers\System\CoreController;
use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\ForumPostModel;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\HomeNotification;
use App\Http\DbModel\MemberLikeModel;
use App\Http\DbModel\Thread_model;
use App\Http\DbModel\User_model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class ForumController extends Controller
{

    public function forum_list(Request $request)
    {
        $cacheKey = CoreController::NODES;
        $data     = Redis::remember(
            $cacheKey['key'],
            $cacheKey['time'],
            function ()
            {
                return $this->forumModel->get_nodes();
            }
        );

        return self::response($data);
    }
    public function all_forum(Request $request)
    {
        return self::response(['红茶馆','腐女小窝','绘图交流','美图分享','签名作坊','萌化资源','情报专区','动漫讨论',
        '个人原创文发表','轻小说','微文区',
//            '单机游戏','联机游戏',
            '幻想乡','手办模型','VOCALOID',
//            '视频分享','音乐分享'
        ]);
    }
    //随便看看
    public function look_look(Request $request)
    {
        $token = $request->input('token');
        $cacheKey = CoreController::USER_TOKEN;
        $cacheKey = $cacheKey['key'] . $token ;

        $uid = Redis::get($cacheKey);
        if ($token && $uid)
        {
            //如果登录中
            return $this->_login_look($uid);
        }
        else
        {
            return $this->_logout_look();
        }
    }
    public function _login_look($uid)
    {
        $data['user_like_forum'] = MemberLikeModel::where('uid',$uid)
                                    ->leftJoin('pre_forum_forum','pre_member_like.fid','=','pre_forum_forum.fid')
                                    ->select()->get();
        $data['thread_list'] = ForumThreadModel::get_new_thread();
        //用户的关注板块
        return self::response($data);
    }
    public function _logout_look()
    {
        $data['thread_list'] = ForumThreadModel::get_new_thread();
        return self::response($data);
    }

    public function viewThread(ThreadController $threadController,Request $request)
    {

        if (!$request->input('tid') && !$request->input('pid'))
            return self::response([],40001,'缺少参数tid和pid,必须含有其中之一');

        if ($request->input('pid'))
            $tid = ForumPostModel::where('pid',$request->input('pid'))->first()->tid;
        else
            $tid = $request->input('tid');

        $data = $threadController->_viewThread($tid,$request->input('page')?:0);
        $data['thread']['thread_subject']->avatar =  config('app.online_url').\App\Http\Controllers\User\UserHelperController::GetAvatarUrl($data['thread']['thread_subject']->authorid);
        //对帖子ubb进行处理
        foreach ($data['thread']['thread_post'] as &$value)
        {
            $value->message = str_replace(array(
                '[/color]', '[/backcolor]', '[/size]', '[/font]', '[/align]', '[b]', '[/b]', '[s]', '[/s]', '[hr]', '[/p]',
                '[i=s]', '[i]', '[/i]', '[u]', '[/u]', '[list]', '[list=1]', '[list=a]',
                '[list=A]', "\r\n[*]", '[*]', '[/list]', '[indent]', '[/indent]' ,'[/float]',
            ), array(
                '', '', '', '', '', '', '', '', '', '', '', '', '',
                '', '', '', '', '', '',
                '', '', '', '', '', '',  ''
            ), preg_replace(array(
                "/\[color=([#\w]+?)\]/i",
                "/\[color=((rgb|rgba)\([\d\s,]+?\))\]/i",
                "/\[backcolor=([#\w]+?)\]/i",
                "/\[backcolor=((rgb|rgba)\([\d\s,]+?\))\]/i",
                "/\[size=(\d{1,2}?)\]/i",
                "/\[size=(\d{1,2}(\.\d{1,2}+)?(px|pt)+?)\]/i",
                "/\[font=([^\[\<]+?)\]/i",
                "/\[align=(left|center|right)\]/i",
                "/\[p=(\d{1,2}|null), (\d{1,2}|null), (left|center|right)\]/i",
                "/\[float=left\]/i",
                "/\[float=right\]/i",
                "/\[url=[\w\W]*?\][\w\W]*?\[\/url\]/i"

            ), array(
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                ""
            ), $value->message));
//            dd( $value->message);
            $value->avatar = config('app.online_url').\App\Http\Controllers\User\UserHelperController::GetAvatarUrl($value->authorid);
            $value->postdate = date("m-d",$value->dateline);
        }


        return self::response($data);
    }

    public function hitokoto()
    {
        $hitokoto = \GuzzleHttp\json_decode(file_get_contents(public_path('/hitokoto.json')));

        return self::response($hitokoto[ array_rand($hitokoto, 1) ]);
    }

    public function new_thread(Request $request, ThreadApiController $threadApiController)
    {
        $token = $request->input('token');
        $uid   = Redis::get(CoreController::USER_TOKEN['key'] . $token);

        $user_info = User_model::find($uid);


        if (empty($user_info))
            return self::response([], 40002, '需要登录');
        if ($user_info->groupid == 4 || $user_info->groupid == 5)
            return self::response([], 40003, '您的账户已被禁言');
        if ($user_info->groupid == 8)
            return self::response([], 40003, '您的账户邮箱未验证,因此不能发表主题');

        $checkParams = $this->checkRequest($request, ['title', 'content']);
        if ($checkParams !== true)
        {
            return self::response([], 40001, '缺少参数' . $checkParams);
        }

        $fid = $request->input('fname')
            ? Forum_forum_model::where('name', "=", $request->input('fname'))->first()->fid
            : $request->input('fid');
        if (!$fid)
            return self::response([], 40004, 'fid为空,至少需要传输fname或fid');

        $result = $threadApiController->_newThread(
            $fid,
            $request->input('title'),
            $request->input('content'),
            $request->getClientIp(),
            $user_info
        );

        return self::response();
    }

    //app回复帖子
    public function reply_thread(Request $request, ThreadApiController $threadApiController)
    {
        $token = $request->input('token');
        $uid   = Redis::get(CoreController::USER_TOKEN['key'] . $token);

        $user_info = User_model::find($uid);


        if (empty($user_info))
            return self::response([], 40002, '需要登录');
        if ($user_info->groupid == 4 || $user_info->groupid == 5)
            return self::response([], 40003, '您的账户已被禁言');

        return $threadApiController->PostsThread($request, $user_info);
    }

    //获取用户消息
    public function get_notice(Request $request)
    {
        $token = $request->input('token');
        $uid   = Redis::get(CoreController::USER_TOKEN['key'] . $token);

        $data = HomeNotification::where('uid', $uid)->orderBy('id', 'desc')->paginate(15);
        if (!empty($data))
        {
            $data = $data->toArray()['data'];

            foreach ($data as &$value)
            {
                $value['renote'] = preg_replace("\<a.*?\>|\<\/a\>", '', $value['note']);
                $value['date']   = date("Y-m-d H:i", $value['dateline']);
                //                $value['renote'] = preg_replace('','', $value['note'] ) ;
                $value['poster_avatar'] = $value['authorid'] ? config(
                        'app.online_url'
                    ) . \App\Http\Controllers\User\UserHelperController::GetAvatarUrl($value['authorid']) : '';
            }
        }

        return self::response($data);
    }

    /**
     * 获取帖子回帖的其它页数的信息
     *
     * @param Request $request
     */
    public function post_next_page(Request $request, Thread_model $thread_model)
    {
        //        return self::response(json_encode($request->input()));
        if (empty($request->input('tid')))
            return self::response([], 40001, '缺少tid');
        if (empty($request->input('page')))
            return self::response([], 40001, '缺少page');

        $data = $thread_model->getPostOfThread($request->input('tid'), $request->input('page'));
        foreach ($data as &$value)
        {
            $value->avatar = config('app.online_url') . \App\Http\Controllers\User\UserHelperController::GetAvatarUrl(
                    $value > authorid
                );
        }

        return $request->input('need') == 'html' ? view("PC/Forum/Reply")->with(
            'data',
            ['thread_post' => $data]
        ) : self::response($data);
    }

    public function version(Request $request)
    {
        return self::response(['version' => '1.0']);
    }

}
