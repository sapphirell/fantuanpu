<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\System\ActionController;
use App\Http\Controllers\System\CoreController;
use App\Http\DbModel\CommonMemberCount;
use App\Http\DbModel\UserSignModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class SignController extends Controller
{
    public function sign(Request $request)
    {
        $user_info = session('user_info');
        if (!$user_info->uid)
            return self::response([],40001,'需要登录');
        $cacheKey = CoreController::USER_SIGN;
        UserSignModel::find($user_info->uid);
        if(Cache::add($cacheKey['key'].$user_info->uid.'_'.date("Ymd"), $user_info->uid, $cacheKey['time']))
        {
            $call_res = self::call_message_queue('Common','user_sign',[
                'uid'=>$user_info->uid,
            ]);
            return self::response();
        }
        return self::response([],40002,'签到失败');
    }

    /**
     * swoole 签到回调时根据队列位置返回是当天第几个签到的
     * @param Request $request
     */
    public function swoole_sign_callback(Request $request)
    {


    }
}
