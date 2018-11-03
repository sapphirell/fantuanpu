<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\System\ActionController;
use App\Http\DbModel\CommonMemberCount;
use App\Http\DbModel\UserSignModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class SignController extends Controller
{
    public function sign(Request $request)
    {
        $user_info = session('user_info');
        UserSignModel::find($user_info->uid);
        $call_res = self::call_message_queue('Common','user_sign',[
            'uid'=>$user_info->uid,
        ]);
        dd($call_res);
    }

    /**
     * swoole 签到回调时根据队列位置返回是当天第几个签到的
     * @param Request $request
     */
    public function swoole_sign_callback(Request $request)
    {


    }
}
