<?php

namespace App\Http\Controllers;

//use App\Http\Requests\Request;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

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

    public function __construct()
    {
        error_reporting(E_ERROR);
        date_default_timezone_set('Asia/Shanghai');
        $request = new Request();
        $this->data['request'] = $request->input();
    }
    public static function response($data = null,$ret='200',$msg='操作成功')
    {
        if (empty($data))
        {
            $res =  ['ret'=>intval($ret),'msg'=>$msg,'data'=>[]];
        } else {
            $res =  ['ret'=>intval($ret),'msg'=>$msg,'data'=>$data];
        }
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
            {
                return $value;
            }
        }
        return true;
    }
    //
    public function mobile()
    {
        return view("Mobile/index");
    }
}
