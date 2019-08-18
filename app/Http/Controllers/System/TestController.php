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

        $user = UCenter_member_model::find("50761");
//        dd($user);

        $user->password = md5(md5("123456"). $user->salt);
        $user->save();
        User_model::flushUserCache($user->uid);
        return self::response();

//        $logs = GroupBuyingLogModel::getNotCancelLog(1,false);
//        dd($logs[0]);
//        $num = 0;
//        foreach ($logs as $log)
//        {
//            $order_info = json_decode($log->order_info,true);
//            foreach ($order_info as $type=>$num)
//            {
//
//                $num += $num;
//            }
//        }
//        echo $num;

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
            "毛丽茹" => 123
        ];
        foreach ($arr as $name => $waybill_no)
        {
            $exps = GroupBuyingExpressModel::where("name","=",$name)->orderBy("id","desc")->first();


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

}
