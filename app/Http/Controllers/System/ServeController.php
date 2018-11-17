<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Forum\ForumBaseController;
use App\Http\Controllers\User\UserBaseController;
use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\Thread_model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ServeController extends Controller
{
    public static function ss(){
        dd(session()->all());
    }
    public static function info(){
        phpinfo();
    }
    public static function mem(){}

    public function index(Request $request)
    {
        if (false)
            return 12;
        $domain = $request->getHost();
        if (in_array($domain,self::$local_domain))
            return view("PC/Common/LocalhostIndex");
        if (in_array($domain,self::$fantuanpu_domain))
            return (new ForumBaseController((new Forum_forum_model()) , (new Thread_model())))
                ->ForumIndex($request,(new UserBaseController())); // -_-什么鬼...
        if (in_array($domain,self::$local_domain));
            return ;
    }
}
