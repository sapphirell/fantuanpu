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
//
//        $user = UCenter_member_model::find("50761");
////        dd($user);
//
//        $user->password = md5(md5("123456"). $user->salt);
//        $user->save();
//        User_model::flushUserCache($user->uid);
//        return self::response();

        $this->recreateOrders();

    }
    public function ping(Request $request)
    {
//        $arr = ['18161275217' => '3102625302033',
//         '13575446183' => '3102625302034',
//         '18569671121' => '3102625302035',
//         '15881288143' => '3102625302036',
//         '13075878351' => '3102625302037',
//         '15802889520' => '3102625302038',
//         '18955177413' => '3102625302039',
//         '13910067741' => '3102625302040',
//         '15988824046' => '3102625302041',
//         '15574756325' => '3102625302042',
//         '18778549997' => '3102625302043',
//         '17863632808' => '3102625302044',
//         '15320368909' => '3102625302045',
//         '15258092226' => '3102625302046',
//         '13267057341' => '3102625302047',
//         '15910923193' => '3102625302048'];
//        $arr =  ["肖雨涵"  => "776000115881304",
//                 "徐佳瑶"  => "776000115604660",
//                 "许玫娜"  => "776000115560247",
//                 "和西"  => "776000114692994",
//                 "叶晴"  => "776000115516576",
//                 "桑桑"  => "776000115469421",
//                 "林品如"  => "776000115388676",
//                 "余雪芳"  => "776000115938879",
//                 "康康"  => "776000115763533",
//                 "丁佳祺"  => "776000115549828",
//                 "李奕卿"  => "776000115313709",
//                 "苏沐橙"  => "776000115897953",
//                 "姚薇"  => "776000115962444",
//                 "王琳凯"  => "776000115535884",
//                 "思桐"  => "776000115781501",
//                 "谈心怡"  => "776000115218946",
//                 "孙敏丹"  => "776000115915549",
//                 "郁超群"  => "776000115724118",
//                 "吴佳利"  => "776000115411708",
//                 "小诺"  => "776000115701445",
//                 "孙可盈"  => "776000115870492",
//                 "王月半"  => "776000115828715",
//                 "裘球秋"  => "776000115554468",
//                 "烤肉"  => "776000115771141",
//                 "王恒"  => "776000115848269",
//                 "金碧涵"  => "776000115635122",
//                 "鹿玖"  => "776000115188589",
//                 "高扬"  => "776000115753288",
//                 "郑仁乐"  => "776000115996260",
//                 "杨玉峰"  => "776000115939241",
//                 "周丽霞"  => "776000115950784",
//                 "戴诗悦"  => "776000115639429",
//                 "葱白"  => "776000115642400",
//                 "戴希渝"  => "776000115849524",
//                 "王墨"  => "776000115987852",
//                 "岛岛"  => "776000115583553",
//                 "沈意"  => "776000115976711",
//                 "屎坨坨"  => "776000115697751",
//                 "王一"  => "776000115914842",
//                 "李耀红"  => "776000115150388",
//                 "樱桃"  => "776000115973408",
//                 "清水郁江"  => "776000115436417",
//                 "许雅静"  => "776000115859581",
//                 "张霞"  => "776000115978375",
//                 "苏霞镱"  => "776000115512890",
//                 "周静雯"  => "776000115873095",
//                 "林小冉"  => "776000115732462",
//                 "罗红"  => "776000115037572",
//                 "孙亚薇"  => "776000115326187",
////                 "义玲"  => "776000115758656",
//                 "朴嘭嘭"  => "776000115710496",
//                 "黄凯玲"  => "776000115987499",
//                 "王志芳"  => "776000115865773",
//                 "张明安"  => "776000115714986",
//                 "汪怡敏"  => "776000115896984",
//                 "王周华"  => "776000115805222",
//                 "鹿阿绿"  => "776000115900034",
//                 "张鱼"  => "776000115611388",
//                 "申懿君"  => "776000115745528",
//                 "柯柯"  => "776000115899370",
//                 "吴雅莹"  => "776000115481362",
//                 "陈方琳"  => "776000115564895",
//                 "布丁"  => "776000115877573",
//                 "小魔女"  => "776000114421082",
//                 "刘宇"  => "776000116177240",
//                 "芝麻"  => "776000116133532",
//                 "绿吃葱"  => "776000115554456",
//                 "赈早见琥珀主"  => "776000114928050",
//                 "绛灵"  => "776000115758656",
//                 "易昂" => "776000115963012"];
//        $arr = ["张家铭"=>"3102631714808","梦晨"=>3102631714807];

        $arr = [
//            "田可欣" => 3102633429069,
//            "胡图图" => 3102633429068,
//            "七刀" => 3102633429072,
//            "蒋雯" => 3102633429071,
//            "林语嫣" => 3102633429070
//            "绫兮" => 3102633429745,
//            "肖艳" => 3102633429744,
//            "毛丽茹" => 123
        ];
        $arr = [
            "柔柔"   => 3102726119189,
            "小魔女"  => 3102726119184,
            "张爱荣"  => 3102726119208,
            "王周华"  => 3102726119207,
            "陈英虹"  => 3102726119205,
            "刘媛媛"  => 3102726119204,
            "果子"   => 3102726119188,
            "张鱼"   => 3102726119196,
            "火山"   => 3102726119201,
            "金碧涵"  => 3102726119183,
            "林玫婷"  => 3102726119192,
            "苏霞镱"  => 3102726119206,
            "康静雯 " => 3102726119186,
            "刘佳璐"  => 3102726119197,
            "邹贞"   => 3102726119203,
            "听风"   => 3102726119194,
            "木里"   => 3102726119191,
            "房湲"   => 3102726119195,
            "简妍" => 3102726119190,
            "王一(内蒙古)" =>3102726119180,
            "戴诗悦"   => 3102726119210,
            "王先生"   => 3102726119187,
            "林涵宇"   => 3102726119173,
            "Yuio"  => 3102726119175,
            "裘江蒙"   => 3102726119176,
            "吴心怡"   => 3102726119185,
            "裴珍映"   => 3102726119177,
            "阿葵"    => 3102726119178,
            "和西"    => 3102726119179,
            "清水郁江 " => 3102726119181,
            "冯晨"    => 3102726119202,
            "刘宇"    => 3102726119160,
            "黄雯静"   => 3102726119161,
            "绛灵"    => 3102726119162,
            "罗红"    => 3102726119163,
            "迟筱楠"   => 3102726119164,
            "程彤"    => 3102726119165,
            "郁超群"   => 3102726119166,
            "陈楚颖"   => 310272611917,
            "kb"    => 3102726119168,
            "兰兰"    => 3102726119169,
            "谈心怡"   => 3102726119170,
            "陈科宇"   => 3102726119155,
            "陈茹 "   => 3102726119156,
            "金志琳"   => 3102726119157,
            "思桐"    => 3102726119158,
            "黄垂莹"   => 3102726119159,
            "葱白"    => 3102726119198,
            "杨慧"    => 3102726119200,
            "吴佳聪"   => 3102726119209,
            "王灿"    => 3102726119199,
            "闵一"    => 3102726119211,
            "郑诗怡"   => 3102726119172,
            "张贝"   => 3102726119174,
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
        $orders = GroupBuyingOrderModel::where("group_id","=",0)->where("status","=","2")->get();
        $order_info = [
            "log_id" =>[]
        ];
        foreach ($orders as $order)
        {
            $submit_logs = json_decode($order->log_id,true);
            $order->ori_order_data = $order->order_info;
            foreach (json_decode($value->order_info,true) as $tp => $num)
            {
                if ($d->size."_".$d->color == $tp)
                {
                    $tp_arr = explode("_",$tp);
                    $detail_arr[$d->id]["stock_id"] = $d->id;
                    $detail_arr[$d->id]["item_size"] =  $tp_arr[0];
                    $detail_arr[$d->id]["item_color"] =  $tp_arr[1];
                    $detail_arr[$d->id]["buy_num"] =  $num;
                    break;
                }
            }

            $value->order_detail = $detail_arr;
            foreach ($submit_logs as $submit_log)
            {

                foreach ($submit_log->order_detail as $stock_item_id => $buy_detail)
                {
                    $order_info[$submit_log->item_id][$stock_item_id]["num"] += $buy_detail["buy_num"];
                    $order_info[$submit_log->item_id][$stock_item_id]["detail"]["size"] = $buy_detail['item_size'];
                    $order_info[$submit_log->item_id][$stock_item_id]["detail"]["color"] = $buy_detail['item_color'];
                    $order_info[$submit_log->item_id][$stock_item_id]["detail"]["item_name"] = $submit_log->item_name;
                    $order_info["log_id"][] = $submit_log->id;

                }

            }
        }
        {

        }


    }
}
