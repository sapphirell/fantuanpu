<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\User\UserApiController;
use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\GroupBuyingExpressModel;
use App\Http\DbModel\GroupBuyingLogModel;
use App\Http\DbModel\GroupBuyingOrderModel;
use App\Http\DbModel\UCenter_member_model;
use App\Http\DbModel\User_model;
use Illuminate\Container\Container;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    protected $mail;
    protected $forum_model;
    public function __construct(Mail $mail,Forum_forum_model $forum_model)
    {
        $this->mail = $mail;
        $this->forum_model = $forum_model;
    }

    public function index(){
        $logs = GroupBuyingLogModel::getNotCancelLog(1,false);
        dd($logs[0]);
        $num = 0;
        foreach ($logs as $log)
        {
            $order_info = json_decode($log->order_info,true);
            foreach ($order_info as $type=>$num)
            {

                $num += $num;
            }
        }
        echo $num;

    }
    public function ping(Request $request)
    {
        $exps = GroupBuyingExpressModel::where("status","=",4)->get();

        $order = [];
        foreach ($exps as $exp)
        {
            $order[] = GroupBuyingOrderModel::where("id","=",json_decode($exp->orders,true)[0])
            ->first();

        }
        $logids = [] ;
        foreach ($order as $value)
        {
            $logs = json_decode($value["log_id"],true);
            $logids = array_merge($logids,$logs);
            if ($value->status == 4)
            {
                $value->status = 3;
                $value->save();
            }


        }
        $ids = "" ;
        foreach ($logids as $id)
        {
            $ids .= $id . ",";
        }
        dd($ids);

//
//        $login_status = UserApiController::Api_DoLogin($request);
//        dd($login_status);
//        $user = UCenter_member_model::find("49356");
////        dd($user);
//
//        $user->password = md5(md5("12345678765"). $user->salt);
//        $user->save();
//        User_model::flushUserCache($user->uid);
//        return self::response();
//        header('Access-Control-Allow-Origin:*');
//        return 'ok';
    }

}
