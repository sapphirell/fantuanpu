<?php

namespace App\Http\Controllers\Sukiapp;

use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\UserSettingModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SukiAppResponseController extends Controller
{
    //suki 首页 homePage
    public function suki_home_page(Request $request)
    {
        //suki的板块
        $this->data["suki_forum"] = (new Forum_forum_model())->get_suki_nodes();
        //suki第一页帖子
        $this->data["suki_threads"] = ForumThreadModel::get_new_thread(
            json_decode(session("setting")->lolita_viewing_forum),
            $request->input("page")?:1
        );


        return self::response($this->data);
    }
}
