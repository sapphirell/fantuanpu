<?php

namespace App\Http\Controllers\Sukiapp;

use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\Thread_model;
use App\Http\DbModel\UserSettingModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommonApiController extends Controller
{
    public function get_thread(Request $request,Thread_model $thread_model)
    {
        $my_setting = self::get_user_setting();
        $thread = ForumThreadModel::get_new_thread(self::$fantuanpu_forum);
//        dd($thread);
        return self::response($thread);
    }

}
