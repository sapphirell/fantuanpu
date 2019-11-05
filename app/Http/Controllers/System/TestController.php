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
//        $user = UCenter_member_model::find("50761");
//        dd($user);

//        $user->password = md5(md5("123456"). $user->salt);
//        $user->save();
//        User_model::flushUserCache($user->uid);
//        return self::response();

//        $this->recreateOrders();
//        $this->flush();
//        $this->reOrder();
//        $this->rm_log();
        $this->checkNotCancelPackage();
    }
    public function ping(Request $request)
    {
        $arr =
            [
//                '肖惠梅'			  => '776001380929657',
//             '唐芳月'			  => '776001385203735',
//             '蔡月璇'			  => '776001361377669',
//             '闫静雅'			  => '776001385387653',
//             '范新月'			  => '776001372455145',
//             '杜岸'			  => '776001380450635',
//             '沈雪莹'			  => '776001378255725',
//             '王有容'			  => '776001378591140',
//             '于昕'			  => '776001375734643',
//             '韩钰琳'			  => '776001383670941',
//             '邢悠然'			  => '776001362330141',
//             '胡月'			  => '776001385241645',
//             '李可爱'			  => '776001382280626',
//             '裘雪雯'			  => '776001383443075',
//             '刘秀儒'			  => '776001384106599',
//             '秦润田'			  => '776001384026775',
//             '苏煜潇'			  => '776001382917887',
//             '西西'			  => '776001378090582',
//             '刘浩桥'			  => '776001380472625',
//             '吕欣'			  => '776001384103042',
//             '陈彦伶'			  => '776001385371764',
//             '北屿野'			  => '776001385080608',
//             '钟淑茵'			  => '776001363695820',
//             '朱海宁'			  => '776001380448009',
//             '谢怜'			  => '776001372855910',
//             '凶凶'			  => '776001371086521',
//             '魏雯'			  => '776001384108574',
//             '小羊'			  => '776001378688817',
//             '何姣'			  => '776001376477293',
//             '孙传'			  => '776001366674230',
//             '肖莉'			  => '776001378505681',
//             '梁芷茵'			  => '776001383578555',
//             '廖雯洁'			  => '776001385137450',
//             '韦唯'			  => '776001384162708',
//             '蔡萌萌'			  => '776001380385348',
//             '何韵彤'			  => '776001383964638',
//             '肖博文'			  => '776001376057020',
//             '朱吉方'			  => '776001380755742',
//             '粉色'			  => '776001374025975',
//             '刘师媛'			  => '776001378288887',
//             '林培霆'			  => '776001385367005',
//             '范诗柯'			  => '776001379113828',
//             '池掰'			  => '776001379973481',
//             '丁薇'			  => '776001374790956',
             '任晴'			  => '776001370676588',
//             '李面子'			  => '776001381586176',
//             '张晴'			  => '776001383457816',
//             '陈科宇'			  => '776001372891322',
//             '陆一昕'			  => '776001384304894',
//             '扇贝'			  => '776001381539646',
//             '孙徐婕'			  => '776001376446290',
//             '黄雯静'			  => '776001385493685',
//             '夕格'			  => '776001378857134',
//             '康静雯'			  => '776001380973377',
//             '刘丽'			  => '776001384909045',
             '冯晨'			  => '776001374371463',
//             '李琳'			  => '776001382762787',
//             '阮忠亲'			  => '776001380736422',
//             '陈陈陈'			  => '776001380669555',
//             '陈兰'			  => '776001385413835',
//             'kb'			  => '776001368974628',
//             '熊露清'			  => '776001385267263',
//             '林箐'			  => '776001380257429',
//             '言希'			  => '776001379100683',
//             '田伟'			  => '776001382339507',
//             '沈怡'			  => '776001383931696',
//             '夏清'			  => '776001371323007',
//             '苏霞镱'			  => '776001346669648',
//             '万海玲'			  => '776001362285422',
//             '申懿君'			  => '776001356352196',
//             '何梓'			  => '776001375317859',
//             '齐美华'			  => '776001384907060',
//             '杜松树'			  => '776001380915342',
//             '沙一薇'			  => '776001372428273',
//             '简妍'			  => '776001329125455',
//             '鸭鸭'			  => '776001368363695',
//             '琪小琪'			  => '776001382078722',
//             '蒋雯'			  => '776001366613808',
//             '岛岛'			  => '776001365757285',
//             '龙猫靓妹'			  => '776001366436365',
//             '陈楚颖'			  => '776001367364224',
//             '木里'			  => '776001382912719',
             '罗静轩'			  => '776001356734201',
//             '鹿茔'			  => '776001370650795',
//             '橙汁'			  => '776001383838815',
//             '金志琳'			  => '776001385451606',
//             '郑仁乐'			  => '776001383095833',
//             '云菁'			  => '776001367620493',
//             '鹿玖'			  => '776001381700538',
//             '罗红'			  => '776001381518923',
//             '绾绾'			  => '776001381151869',
//             '胡图图'			  => '776001384810431',
//             '王帅涵'			  => '776001364099826',
//             '鞠凌潇'			  => '776001372568356',
//             '胡娇美'			  => '776001384556430',
//             '静香'			  => '776001373648055',
//             '吴心怡'			  => '776001376263954',
             '韦清月'			  => '776001385219435',
//             '陈可馨'			  => '776001377251749',
//             '王月半'			  => '776001378479777',
//             '田可欣'			  => '776001381956879',
//             '张泽'			  => '776001377206726',
//             '葱白'			  => '776001369878388',
//             '张子萌'			  => '776001384420253',
//             '沈小凡'			  => '776001383371539',
//             '布丁'			  => '776001378966640',
//             '唐婕'			  => '776001379812844',
//             '林静'			  => '776001384115978',
//             '张家铭'			  => '776001367482962',
//             '乌苏里'			  => '776001378041743',
             '昕昕'			  => '776001381957198',
//             '吴立欣'			  => '776001376945648',
//             '张鱼'			  => '776001370669706',
//             '戴诗悦'			  => '776001382647029',
//             '喻沁茹'			  => '776001383386939',
//             '陈茹'			  => '776001376267885',
//             '黄靖贻'			  => '776001379182907',
//             '谈心怡'			  => '776001379206458',
//             '歪歪'			  => '776001348650839',
//             '郁超群'			  => '776001370700328',
//             '叶晴'			  => '776001364517402',
//             '初夏诀。'			  => '776001352733609',
             '许默'			  => '776001384308648',
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
