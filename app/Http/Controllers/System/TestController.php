<?php

namespace App\Http\Controllers\System;

use App\Http\DbModel\Forum_forum_model;
use Illuminate\Container\Container;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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
        $user_info = session('user_info');
        dd($user_info);
//        return $this->forum_model ::GetForumList();
//        return $this->mail->re();

        //return $this->mail;
        //Redis::set('key123','value123');
        echo Redis::get('key123');
    }
}
