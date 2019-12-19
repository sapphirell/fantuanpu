<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\User\UserApiController;
use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\GroupBuyingExpressModel;
use App\Http\DbModel\GroupBuyingLogModel;
use App\Http\DbModel\GroupBuyingOrderModel;
use App\Http\DbModel\GroupBuyingStockItemModel;
use App\Http\DbModel\GroupBuyingStockItemTypeModel;
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
//        $this->recreateOrders();
//        $this->flush();
//        $this->reOrder();
//        $this->rm_log();
//        $this->checkNotCancelPackage();
        $this->updateItemName();
    }
    public function updatePassword()
    {
        $user = UCenter_member_model::find("50761");
        dd($user);
        $user->password = md5(md5("123456"). $user->salt);
        $user->save();
        User_model::flushUserCache($user->uid);
        return self::response();
    }
    public function updateItemName()
    {
        $item_id = 401;
        $new_item_name = "立体兔耳袜";
        //查询所有的log
        $allSuccessLog = GroupBuyingLogModel::where("status",3)->where("item_id",$item_id)->get();
        if(empty($allSuccessLog))
        {
            return false;
        }
        $uids = [];
        foreach ($allSuccessLog as $value)
        {
            if (!in_array($value->uid, $uids))
            {
                $uids[] = $value->uid;
            }
        }
        $allOrders = GroupBuyingOrderModel::where("group_id",7)->whereIn("uid", $uids)->get();
        foreach ($allOrders as $value)
        {

        }
        dd($allOrders);
    }

    public function ping(Request $request)
    {
        $arr =
            [
//             '黄凯玲'			  => '776001381519412'
            ];

        foreach ($arr as $name => $waybill_no)
        {
            $exps = GroupBuyingExpressModel::where("name","=",$name)->where("status","=","3")->orderBy("id","desc")->first();


            if (empty($exps))
            {
                dd($name);
            }

            $exps->waybill_no = $waybill_no;
            $exps->status = 4;
            $exps->save();
            $orders = json_decode($exps->orders,true);
            foreach ($orders as $orderId)
            {
                $order = GroupBuyingOrderModel::find($orderId);
                $order->status = 3;
                $order->save();
                $logids = json_decode($order->log_id,true);
                foreach ($logids as $logid)
                {
                    $lg = GroupBuyingLogModel::find($logid);
                    $lg->status = 6;
                    $lg->save();
                }

            }
//            dd($ids);
        }


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

    public function alert()
    {
        $alert = [
//            "岛田龙猫"     => 1620256406,
//            "怡个怡怡"     => 2247338302,
//            "Kirara"   => 956101428,
//            "朴橞理奈"     => 3166335148,
//            "芝麻糊了吧"    => 2779214381,
//            "千年"       => 1351143438,
//            "乔婉"       => 1159707150,
//            "帅"        => 3084318263,
//            "筱七七"      => 2419560255,
//            "半罐次元酱"    => 2219103323,
//            "热心市民暴躁笙笙" => 408793478,
//            "夏尔凡多姆"    => 593017061,
//            "咘叮"       => 2856490425,
//            "Peel"     => 2732389151,
//            "越水唯"      => 1718351495,
//            "紫萱SAMA"   => 2036340454,
//            "boxob"    => 2904755864,
//            "失足月亮"     => 1945115097,
//            "狼狼"       => 363387628,
            "沙雕eu" => 252118428
        ];
        $res = [];
        foreach ($alert as $name => $qq)
        {

            $mail = $qq."@qq.com";

            $input = [
                'email'     => $mail,
                'toUser'    => $mail,
                'subject'   => "尊敬的".$name ."您好,Suki团购提醒,即将截止。",
                'msg'       => "即将截止",
                'view'      => "GroupBuyingAlert"
            ];
            $res[] = MailController::sendMail($input);
        }
        var_dump($res);
    }
    public function recreateOrders()
    {
        $log_ids = [5212,5218,5219,5220,5221,5223,5226,5215,5222,5224,5225];
        foreach ($log_ids as $log_id)
        {
            $log = GroupBuyingLogModel::find($log_id);
            var_dump($log->status);
        }
    }
    public function reOrder()
    {
        $orders = GroupBuyingOrderModel::where("status","=",4)->get();
        $exps = GroupBuyingExpressModel::where("status","=",3)->get();
        $oids = [];
        foreach ($exps as $exp)
        {
            foreach (json_decode($exp->orders,true) as $oid)
            {
                $oids[] = $oid;
            }

        }
//        dd($oids);
        $updIds = [];
        foreach ($orders as $order)
        {
            if (in_array($order->id,$oids))
            {
                $updIds[] = $order->id;
                $order->status = 6;
                $order->save();
            }
        }
        dd($updIds);

    }
//array:14 [▼
//0 => 306
//1 => 316
//2 => 395
//3 => 475
//4 => 489
//5 => 496
//6 => 502
//7 => 510
//8 => 511
//9 => 519
//10 => 531
//11 => 556
//12 => 564
//13 => 569
//]
    public function flush(){
        User_model::flushUserCache(51179);
    }
    public function rm_log()
    {
        $data = GroupBuyingLogModel::where("item_id","=",289)->where("status","=",1)->get();
        foreach ($data as $value)
        {
            $info = json_decode($value->order_info,true);
            foreach ($info as $key => $num)
            {
                $type_arr = explode("_",$key);
                if ($type_arr[0] == "踩脚")
                {
                    $value->status = 40;
                    $value->save();
                    break;
                }
            }
        }
    }

    //检查未打包列表中实际上已经在待发货列表里的
    public static function checkNotCancelPackage()
    {
        $express = GroupBuyingExpressModel::select()->where("status","=",3)->get();
        $packages = GroupBuyingOrderModel::select("id")->where("status", "=", "4")->get();

        $pids = [];
        foreach ($packages as $package)
        {
            $pids[] = $package->id;
        }
        $err_id = [];
        foreach ($express as $value)
        {
            $orders = json_decode($value->orders,true);
            foreach ($orders as $oid)
            {
                if (in_array($oid, $pids))
                {
                    $err_id[]  = $oid;
                }
            }
        }

        return $err_id;
    }
}
