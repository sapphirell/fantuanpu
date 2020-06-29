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
//            "林品如"	=>"4305581215498",
//            "程彤"	=>"4305581185884",
//            "郑妍婧"	=>"4305581092245",
//            "周晓阳"	=>"4305581123288",
//            "冯佳楠"	=>"4305581123290",
//            "沈馨冉"	=>"4305581193636",
//            "梁芷茵"	=>"4305581206661",
//            "黄舟颖"	=>"4305581206663",
//            "郑诗怡"	=>"4305581199364",
//            "程簌"	=>"4305581199368",
//            "蔡敏宁"	=>"4305581211763",
//            "迪迪"	=>"4305581275278",
//            "林月辞"	=>"4305581283157",
//            "王涵"	=>"4305581325844",
//            "陈筱玥"	=>"4305581253050",
//            "咕咕咕"	=>"4305581253064",
//            "懒蛋蛋"	=>"4305581288258",
//            "颖颖冲冲冲"	=>"4305581312369",
//            "熊露清"	=>"4305581204452",
//            "邓玉美"	=>"4305581267297",
//            "李丹"	=>"4305581327373",
//            "戴诗悦"	=>"4305581299466",
//            "杨婉仪"	=>"4305581307866",
//            "刘泳思"	=>"4305581315379",
//            "李琳"	=>"4305581307877",
//            "唐婕"	=>"4305581213369",
//            "高宁馨"	=>"4305581289746",
//            "周咏雯"	=>"4305581258857",
//            "陈方琳"	=>"4305581213380",
//            "清水郁江"	=>"4305581350244",
//            "孔昕怡"	=>"4305581331248",
//            "小琪"	=>"4305581414955",
//            "秦润田"	=>"4305581424118",
//            "蒋雯"	=>"4305581454200",
//            "刘师媛"	=>"4305581462164",
//            "刘师媛"	=>"4305581474553",
//            "想吃软糖"	=>"4305581419978",
//            "万海玲"	=>"4305581505425",
//            "李晶波"	=>"4305581535095",
//            "和西"	=>"4305581542219",
//            "邓良凤"	=>"4305581505446",
//            "肖莉"	=>"4305581496317",
//            "谈心怡"	=>"4305581535118",
//            "张明安"	=>"4305581469161",
//            "张明安"	=>"4305581484739",
//            "鹿茔"	=>"4305581420007",
//            "李美玲"	=>"4305581530972",
//            "朱玉枫"	=>"4305581538910",
//            "静小静"	=>"4305581560426",
//            "郁超群"	=>"4305581544096",
//            "曾韵昕"	=>"4305581509114",
//            "鞠凌潇"	=>"4305581560455",
//            "歪歪"	=>"4305581531041",
//            "初夏诀"	=>"4305581498194",
//            "王依琪"	=>"4305581568683",
//            "凶凶"	=>"4305581512731",
//            "沈屾"	=>"4305581514887",
//            "魏雯"	=>"4305581500328",
//            "罗美沙"	=>"4305581583831",
//            "布丁"	=>"4305581615327",
//            "吴梦洁"	=>"4305581546264",
//            "苏霞镱"	=>"4305581501494",
//            "陆一昕"	=>"4305581639661",
//            "喻沁茹"	=>"4305581647289",
//            "玥"	=>"4305581600974",
//            "封帆"	=>"4305581701904",
//            "葱白"	=>"4305581635816",
//            "姚薇"	=>"4305581635832",
//            "韦清月"	=>"4305581663501",
//            "施乐"	=>"4305581588059",
//            "于昕"	=>"4305581722366",
//            "星星"	=>"4305581711889",
//            "吴雅莹"	=>"4305581666214",
//            "孙可盈"	=>"4305581604856",
//            "王文静"	=>"4305581759698",
//            "何姣"	=>"4305581741237",
//            "范建军"	=>"4305581759704",
//            "陈科宇"	=>"4305581774870",
//            "北屿野"	=>"4305581747884",
//            "吴网友"	=>"4305581713799",
//            "kb"	=>"4305581682790",
//            "孙徐婕"	=>"4305581682799",
//            "管钰"	=>"4305581774928",
//            "黄超男"	=>"4305581791449",
//            "罗拉"	=>"4305581840402",
//            "杨铃钰"	=>"4305581797541",
//            "康静雯"	=>"4305581847175",
//            "黑猫"	=>"4305581777779",
//            "吴江琴"	=>"4305581819431",
//            "徐立"	=>"4305581777802",
//            "音"	=>"4305583218608",
//            "DQ"	=>"4305587845308",
            "张鱼"	=>"4305588343106",
            "绫兮"	=>"4305588366164",
            "王琳凯"	=>"4305588373882",
            "贺越越"	=>"4305588352699",
            "蒋雯"	=>"4305589567496",

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
