<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CoreController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /***********
     * @param $condition 加密参数,数组
     * @return string md5秘钥
     */
    public static function GetCacheKey($condition){
        $cache_key = 'fp_';
        $array_count = count($condition);

        foreach ($condition as $key=>$value){//生成缓存秘钥
            $cache_key .= $key.$value;
        }
        return $cache_key;

    }
    /**
     * 板块列表缓存key
     */
    const NODES = 'nodes_array';
}
