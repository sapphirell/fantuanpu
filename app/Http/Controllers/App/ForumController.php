<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Api\ThreadApiController;
use App\Http\Controllers\Forum\ThreadController;
use App\Http\Controllers\System\CoreController;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\MemberLikeModel;
use App\Http\DbModel\Thread_model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class ForumController extends Controller
{
    //
    public function forum_list(Request $request)
    {
        $cacheKey = CoreController::NODES;
        $data = Redis::remember($cacheKey['key'],$cacheKey['time'],function ()
        {
            return $this->forumModel->get_nodes();
        });
        return self::response($data);
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
        if (!$request->input('tid'))
            return self::response([],40001,'缺少参数tid');

        $data = $threadController->_viewThread($request->input('tid'));
        //对帖子ubb进行处理
        foreach ($data['thread']['thread_post'] as &$value)
        {
            $value->message = str_replace(array(
                '[/color]', '[/backcolor]', '[/size]', '[/font]', '[/align]', '[b]', '[/b]', '[s]', '[/s]', '[hr]', '[/p]',
                '[i=s]', '[i]', '[/i]', '[u]', '[/u]', '[list]', '[list=1]', '[list=a]',
                '[list=A]', "\r\n[*]", '[*]', '[/list]', '[indent]', '[/indent]','[blockquote]','[/blockquote]' ,'[/float]'
            ), array(
                '', '', '', '', '', '', '', '', '', '', '', '', '',
                '', '', '', '', '', '',
                '', '', '', '', '', '', '', '', ''
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
                "/\[float=right\]/i"

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
        }


        return self::response($data);
    }
}
