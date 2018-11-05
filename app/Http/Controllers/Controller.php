<?php

namespace App\Http\Controllers;

//use App\Http\Requests\Request;
use App\Http\Controllers\System\CoreController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

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
        date_default_timezone_set('Asia/Shanghai');
        if (!session('access_id'))
        {
            $rand_code = md5(rand(0,99999).time());
            session(['access_id' => $rand_code]);
        }

        $request = new Request();
        $this->data['request'] = $request->input();
        $this->data['title'] = false;
        $user_info = session('user_info');
        if ($user_info->uid)
        {
            $user_has_sign = CoreController::USER_SIGN;
            $this->data['user_has_sign'] = Cache::get($user_has_sign['key'] . $user_info->uid .'_'. date("Ymd"));
        }
        //获取IM
        $this->data = array_merge($this->data,$this->get_im_message());

    }
    public function get_im_message()
    {
        //查询10条历史消息
        $this->data['msg'] = ImModel::orderBy('id','desc')->paginate(15);
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
     */
    public function call_message_queue($class,$action,$data)
    {
        $data['class']  = $class;
        $data['action'] = $action;
        $redis = Redis::connection('socket');
        $push = $redis->rpush('list',json_encode($data));
//        dd($redis->keys('*'));
        return $push;
    }
    public static function response($data = null,$ret='200',$msg='操作成功')
    {
        if (empty($data))
            $res =  ['ret'=>intval($ret),'msg'=>$msg,'data'=>[]];
        else
            $res =  ['ret'=>intval($ret),'msg'=>$msg,'data'=>$data];

        return response(json_encode($res,JSON_UNESCAPED_UNICODE))->header('Content-Type', 'application/json')->header('Charset','UTF-8');
    }
    public function jsReturn($url,$msg='操作成功')
    {
        if (empty($url))
            return false;

        return "<script> alert('" . $msg ."');window.location.href='".$url."'</script>";
    }
    public function checkRequest($Request,$param)
    {
        foreach ($param as $value)
        {
            if ($Request->input($value) === false || $Request->input($value) === null)
                return $value;
        }
        return true;
    }
    //
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
