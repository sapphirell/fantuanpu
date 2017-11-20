<?php

namespace App\Http\Controllers\System;

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
}
