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

    public function __construct(Mail $mail, Forum_forum_model $forum_model)
    {
        $this->mail        = $mail;
        $this->forum_model = $forum_model;
    }

    public function index()
    {
        //        $this->recreateOrders();
        //        $this->flush();
        //        $this->reOrder();
        //        $this->rm_log();
        //        $this->checkNotCancelPackage();
//        $this->updateItemName();
        return $this->updatePassword();
    }

    public function updatePassword()
    {
        $user = UCenter_member_model::find("50761");
//        dd($user);
//        $user->password = md5(md5("123456") . $user->salt);
//        $user->save();
//        User_model::flushUserCache($user->uid);
        return self::response();
    }

    public function updateItemName()
    {
        $item_id       = 401;
        $new_item_name = "立体兔耳袜";
        //查询所有的log
        $allSuccessLog = GroupBuyingLogModel::where("status", 3)->where("item_id", $item_id)->get();
        if (empty($allSuccessLog)) {
            return false;
        }
        $uids = [];
        foreach ($allSuccessLog as $value) {
            if (!in_array($value->uid, $uids)) {
                $uids[] = $value->uid;
            }
        }
        $allOrders = GroupBuyingOrderModel::where("group_id", 7)->whereIn("uid", $uids)->get();
        foreach ($allOrders as $value) {

        }
        dd($allOrders);
    }

    public function ping(Request $request)
    {
        $arr = [
//            "郑仁乐"	=>"4306896407751",
//            "鹿玖"	=>"4306896464754",
//            "杨雨轩"	=>"4306896494738",
//            "吴心怡"	=>"4306896449919",
//            "kb"	=>"4306896556840",
//            "施乐"	=>"4306896530583",
//            "管钰"	=>"4306896624223",
//            "向思琪"	=>"4306896608099",
//            "高妍"	=>"4306896626970",
//            "懒蛋蛋"	=>"4306896635379",
//            "李美玲"	=>"4306896672018",
//            "章媛媛"	=>"4306896645327",
//            "迪迪"	=>"4306896651963",
//            "刘桢"	=>"4306896675432",
//            "迟筱楠"	=>"4306896618820",
//            "陆一昕"	=>"4306896695539",
//            "長莱"	=>"4306896742109",
//            "林允儿"	=>"4306896715525",
//            "杨婉仪"	=>"4306896698283",
//            "李琳"	=>"4306896806476",
//            "孙传"	=>"4306896770311",
//            "刘彩妮"	=>"4306896771674",
//            "黎黎"	=>"4306896810050",
//            "吴网友"	=>"4306896776721",
//            "颖颖冲冲冲"	=>"4306896819567",
//            "胡昭"	=>"4306896835027",
//            "布丁"	=>"4306896701451",
//            "纸诺"	=>"4306896778266",
//            "白何"	=>"4306896802022",
//            "曹睿"	=>"4306896886885",
//            "一只沙茶酱啊"	=>"4306896779626",
//            "陈科宇"	=>"4306896868800",
//            "杨铃钰"	=>"4306896906349",
//            "林培霆"	=>"4306896935889",
//            "涂艳青"	=>"4306896781470",
//            "雪儿"	=>"4306896951983",
//            "杨洋"	=>"4306896946118",
//            "熊娅媗"	=>"4306896966481",
//            "北屿野"	=>"4306896961653",
//            "云菁"	=>"4306897000174",
//            "李丹"	=>"4306896978138",
//            "刘师媛"	=>"4306897022611",
//            "阿静"	=>"4306897023695",
//            "昕昕"	=>"4306896992247",
//            "黑猫"	=>"4306897054403",
//            "林箐"	=>"4306896969602",
//            "金志琳"	=>"4306897056242",
//            "高钰坤"	=>"4306897070427",
//            "蔡月璇"	=>"4306897070705",
//            "程彤"	=>"4306897044452",
//            "高宁馨"	=>"4306897080841",
//            "廖雯洁"	=>"4306897134066",
//            "齐美华"	=>"4306897098382",
//            "青青"	=>"4306897106336",
//            "刘女士"	=>"4306897073431",
//            "刘泳思"	=>"4306897122728",
//            "唐婕"	=>"4306897123530",
//            "简妍"	=>"4306897074434",
//            "张鱼"	=>"4306897175941",
//            "旺旺米饼"	=>"4306897191633",
//            "麦子"	=>"4306897214361",
//            "康静雯"	=>"4306897160205",
//            "何丹芙"	=>"4306897076616",
//            "鹿茔"	=>"4306897181277",
//            "夏令"	=>"4306897230332",
//            "黄舟颖"	=>"4306897218388",
//            "刘晰"	=>"4306897154413",
//            "张子萌"	=>"4306897226322",
//            "吴安娜"	=>"4306897227340",
//            "朱吉方"	=>"4306897286108",
//            "乌屿"	=>"4306897235213",
//            "凶凶"	=>"4306897301868",
//            "童锁"	=>"4306897294721",
//            "幽幽紫"	=>"4306897309610",
//            "想吃软糖"	=>"4306897282494",
//            "甘甜"	=>"4306897349661",
//            "陈筱玥"	=>"4306897258017",
//            "小菁菁"	=>"4306897320561",
//            "刘丽"	=>"4306897314742",
//            "木禾"	=>"4306897378530",
//            "玥"	=>"4306897408070",
//            "顾飞"	=>"4306914653798",
//            "陈乐"	=>"4306917756877",
            "陈凤"	=>"4306919044253",
            "钱晨"	=>"4306919171548",
            "蒋雯"	=>"4306919122724",
            "葱白"	=>"4306919262704",
            "鞠凌潇"	=>"4306919334133",
            "苏打"	=>"4306919196398",
            "刘宇"	=>"4306919307375",
            "静小静"	=>"4306919351732",
            "和西"	=>"4306919382840",
            "郁超群"	=>"4306919341126",
            "黄祺昀"	=>"4306919314998",
            "张家铭"	=>"4306919360171",
            "戴诗悦"	=>"4306919424912",
            "沈馨冉"	=>"4306919427256",
            "谈心怡"	=>"4306919428206",
            "蒋晨歆"	=>"4306919442024",
            "王雅"	=>"4306919495097",
            "王依琪"	=>"4306919432877",
            "孙徐婕"	=>"4306919444700",
            "刘浩桥"	=>"4306919433626",
            "姚薇"	=>"4306919491414",
            "许默"	=>"4306919499121",
            "火山"	=>"4306919493000",
            "夕格"	=>"4306919541951",
            "黄凯玲"	=>"4306919551006",
            "张利燕"	=>"4306919551651",
            "徐立"	=>"4306919566424",
            "刘媛媛"	=>"4306919543617",
            "子木"	=>"4306919554760",
            "何宸依"	=>"4306919585370",
            "白泽"	=>"4306919564308",
            "林月辞"	=>"4306919557247",
            "黄靖贻"	=>"4306919714480",
            "陈方琳"	=>"4306919750460",


        ];

        foreach ($arr as $name => $waybill_no) {
            $exps = GroupBuyingExpressModel::where("name", "=", $name)->where("status", "=", "3")->orderBy("id",
                "desc")->first();


            if (empty($exps)) {
                dd($name);
            }

            $exps->waybill_no = $waybill_no;
            $exps->status     = 4;
            $exps->save();
            $orders = json_decode($exps->orders, true);
            foreach ($orders as $orderId) {
                $order         = GroupBuyingOrderModel::find($orderId);
                $order->status = 3;
                $order->save();
                $logids = json_decode($order->log_id, true);
                foreach ($logids as $logid) {
                    $lg         = GroupBuyingLogModel::find($logid);
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
        $res   = [];
        foreach ($alert as $name => $qq) {

            $mail = $qq . "@qq.com";

            $input = [
                'email'   => $mail,
                'toUser'  => $mail,
                'subject' => "尊敬的" . $name . "您好,Suki团购提醒,即将截止。",
                'msg'     => "即将截止",
                'view'    => "GroupBuyingAlert"
            ];
            $res[] = MailController::sendMail($input);
        }
        var_dump($res);
    }

    public function recreateOrders()
    {
        $log_ids = [5212, 5218, 5219, 5220, 5221, 5223, 5226, 5215, 5222, 5224, 5225];
        foreach ($log_ids as $log_id) {
            $log = GroupBuyingLogModel::find($log_id);
            var_dump($log->status);
        }
    }

    public function reOrder()
    {
        $orders = GroupBuyingOrderModel::where("status", "=", 4)->get();
        $exps   = GroupBuyingExpressModel::where("status", "=", 3)->get();
        $oids   = [];
        foreach ($exps as $exp) {
            foreach (json_decode($exp->orders, true) as $oid) {
                $oids[] = $oid;
            }

        }
        //        dd($oids);
        $updIds = [];
        foreach ($orders as $order) {
            if (in_array($order->id, $oids)) {
                $updIds[]      = $order->id;
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
    public function flush()
    {
        User_model::flushUserCache(51179);
    }

    public function rm_log()
    {
        $data = GroupBuyingLogModel::where("item_id", "=", 289)->where("status", "=", 1)->get();
        foreach ($data as $value) {
            $info = json_decode($value->order_info, true);
            foreach ($info as $key => $num) {
                $type_arr = explode("_", $key);
                if ($type_arr[0] == "踩脚") {
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
        $express  = GroupBuyingExpressModel::select()->where("status", "=", 3)->get();
        $packages = GroupBuyingOrderModel::select("id")->where("status", "=", "4")->orderBy("uid", "desc")->get();

        $pids = [];
        foreach ($packages as $package) {
            $pids[] = $package->id;
        }
        $err_id = [];
        foreach ($express as $value) {
            $orders = json_decode($value->orders, true);
            foreach ($orders as $oid) {
                if (in_array($oid, $pids)) {
                    $err_id[] = $oid;
                }
            }
        }

        return $err_id;
    }
}
