<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Api\ThreadApiController;
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
        $data['thread_list'] = ForumThreadModel::orderBy('lastpost','desc')->paginate(15)->toArray()['data'];
        //用户的关注板块
        return self::response($data);
    }
    public function _logout_look()
    {
        $data['thread_list'] = ForumThreadModel::orderBy('lastpost','desc')->paginate(15)->toArray()['data'];
        return self::response($data);
    }
}
