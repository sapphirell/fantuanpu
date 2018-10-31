<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class SignController extends Controller
{
    public function sign(Request $request)
    {
        $user_info = session('user_info');
        self::call_message_queue('common','user_sign',[
            'uid'=>$user_info->uid
        ]);
    }
}
