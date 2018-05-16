<?php

namespace App\Http\Controllers;

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
    }
    public static function response($data = null,$ret='200',$msg='操作成功')
    {
        if (!empty($data)&&!is_object($data)&&!is_array($data)){
            throw new  \ErrorException('data类型错误');
        }

        if (empty($data)) {
            $res =  ['ret'=>intval($ret),'msg'=>$msg,'data'=>[]];
        } else {
            $res =  ['ret'=>intval($ret),'msg'=>$msg,'data'=>$data];
        }
        return response(json_encode($res,JSON_UNESCAPED_UNICODE))->header('Content-Type', 'application/json')->header('Charset','UTF-8');
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

}
