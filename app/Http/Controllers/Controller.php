<?php

namespace App\Http\Controllers;

//use App\Http\Requests\Request;
use App\Http\Controllers\System\CoreController;
use App\Http\DbModel\ImModel;
use App\Http\DbModel\MemberFieldForumModel;
use App\Http\DbModel\User_model;
use App\Http\DbModel\UserSettingModel;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Schema;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    /*****
     * @var $data 加载入视图内的全局变量
     */
    public $data;
    /******
     * @var 该用户信息的暂存,不可信
     */
    public $User;

    /**
     *
     */
    const DOMAIN = 'http://www.fantuanpu.com/';
    const FANTUANPU_DOMAIN = 'http://fantuanpu.com/';
    const LOLITA_DOMAIN = 'https://sukisuki.org/';


    public static $lolita_domain = [
        'sukisuki.org',
        'www.sukisuki.org',
        'suki-suki.me',
        'local.suki-suki.me',
        'www.suki-suki.me',
    ];
    public static $fantuanpu_domain = [
        'fantuanpu.com',
        'www.fantuanpu.com',
        'local.fantuanpu.com',

    ];
    public static $local_domain = [
        'localhost',
    ];
    public static $fantuanpu_forum = [1,36,41,49,52,56,64,2,37,38,123,125,126,44,66,50,51,69,93,114,57,73,75,65,71,83,85];
    public static $suki_forum = [157,158,159,160,161,162];
    //在这些板块里发帖会匿名
    public static $anonymous_forum = [160];
    //超级管理员
    const MASTER_USER = [1,2];
    /**
     * 帖子回帖分页数量
     */
    const THREAD_REPLY_PAGE = 20;
    /**
     * swoole 验证token
     */
    const SWOOLE_TOKEN = 'OHMYJXY_hahaha';
    public function __construct()
    {
        error_reporting(E_ERROR);
        if (!$access_id = session('access_id'))
        {
            $rand_code = md5(rand(0, 99999) .time()); // 没有登录的时候充当uid用
            session(['access_id' => $rand_code]);
            $this->data['access_id'] = $rand_code;
        }else
        {
            $this->data['access_id'] = $access_id;
        }
        $this->data['request']      =  request()->input();
        $this->data['title']        = false;
        $this->data['user_info']    = User_model::find(session("user_info")->uid);
        if ($this->data['user_info']->uid)
        {
            //用户是否签到
            $user_has_sign = CoreController::USER_SIGN;
            $this->data['user_has_sign'] = Cache::get($user_has_sign['key'] . $this->data['user_info'] ->uid .'_'. date("Ymd"));
            //签名档
            $this->data['field_forum'] = MemberFieldForumModel::find($this->data['user_info']->uid);
            //用户权限级别 1 普通用户 2 管理员 3 超级管理
            $this->data["auth_level"] = 1;
            in_array($this->data["auth_level"],self::MASTER_USER) && $this->data["auth_level"] = 3;
            //用户提醒
            $this->data['user_info']->useralert = $this->data['user_info']->useralert ? json_decode($this->data['user_info']->useralert,true) : [];
//            dd($this->data['user_info']->useralert);
        }
        //获取IM
        $this->data = array_merge($this->data,$this->get_im_message());
        //初始化setting
        if (!session("setting"))
        {
            $setting = UserSettingModel::find($this->data['user_info']->uid?:0);
            session(['setting' => $setting]);
        }
        else
        {
            $setting = session("setting");
        }
        $this->data['setting'] = json_encode($setting);
    }
    public static function get_user_setting()
    {
        return UserSettingModel::find(session("user_info")->uid ? :0);
    }
    public function rand_name()
    {
        $ornament   = ['头戴草帽','手持巨剑','身负重甲','膝盖中箭','穿遇到异世界','擅长魔法','被qb选中'];
        $pre        = ['蓝头发的','粉头发的','红头发的','长尾巴的','有一对猫耳的','赤瞳的','貌若天仙的','肌肉发达的','家财万贯的','短路的'];
        $center     = ['痴呆','怨念','元气','弱气','弱渣','强气','笨蛋','机智','可爱','呆萌','凶猛','卑鄙'];
        $last       = ['兔娘','猫娘','小恶魔','史莱姆','小公举','骑士','穿越者','飞龙','冒险者','勇者','王子','智者','先知','国王','机器人','人气偶像','过气偶像','魔法师','死宅'];
        return $ornament[rand(0,count($ornament)-1)].$pre[rand(0,count($pre)-1)].$center[rand(0,count($center)-1)].$last[rand(0,count($last)-1)];
    }
    public function get_im_message()
    {
        //查询10条历史消息
        $this->data['msg'] = ImModel::orderBy('id','desc')->offset(0)->limit(15)->get();
        $user = session('user_info');
        if (!session('im_username'))
        {
            //未生成虚拟名称时候生成一次
            session(['im_username' => ['name'=>$this->rand_name(),'show_im_name'=>true,'id'=> session('access_id') ]]);
        }
        $this->data['im_username'] = $user->username ?: session('im_username')['name'];
        return $this->data;
    }
    /**
     *  调起swoole消息队列
     *  $async 决定是否异步执行此函数
     */
    public function call_message_queue($class,$action,$data,$async = false)
    {
        $data['class']  = $class;
        $data['action'] = $action;
        $redis = Redis::connection('socket');
        $push = $redis->rpush('list',json_encode($data));
//        dd($redis->keys('*'));
        return $push;
    }
    public static function response($data = null,$ret='200',$msg='提交成功(๑•ㅂ•́)و✧')
    {
        if (empty($data))
            $res =  ['ret'=>intval($ret),'msg'=>$msg,'data'=>[]];
        else
            $res =  ['ret'=>intval($ret),'msg'=>$msg,'data'=>$data];

        return response(json_encode($res,JSON_UNESCAPED_UNICODE))->header('Content-Type', 'application/json')->header('Charset','UTF-8');
    }
    public function jsReturn($url,$msg='提交成功(๑•ㅂ•́)و')
    {
        if (empty($url))
            return false;

        return "<script> alert('" . $msg ."');window.location.href='".$url."'</script>";
    }
    public function checkRequest($Request,$param)
    {
        foreach ($param as $value)
        {
            if ($Request->input($value) === false || $Request->input($value) === null || $Request->input($value) === "")
                return $value;
        }
        return true;
    }

    /**
     * 配置suki的查看板块
     */
    public function set_suki_view(int $uid , array $fid)
    {
        foreach ($fid as &$value)
            $value = intval($value);
//        dd($fid);
        if ($uid === 0 || $uid === '0')
        {
            $setting = json_decode($this->data["setting"]);
            $setting->lolita_viewing_forum = json_encode($fid);

        }
        else
        {
            $setting = UserSettingModel::find($uid);
            $setting->lolita_viewing_forum = json_encode($fid);
            $setting->save();
        }
        session(['setting' => $setting]);
        return true;
    }
    public function mobile()
    {
        return view("Mobile/index");
    }
    /**
     * 求两个日期之间相差的天数
     * (针对1970年1月1日之后，求之前可以采用泰勒公式)
     * @param string $day1
     * @param string $day2
     * @return number
     */
    function diffBetweenTwoDays ($day1, $day2)
    {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);

        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        return ($second1 - $second2) / 86400;
    }

}
