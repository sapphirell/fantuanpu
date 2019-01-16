<?php

namespace App\Http\Controllers\News;

use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\ForumThreadModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SukiController extends Controller
{
//    public function index(Request $request)
//    {
//        $this->data['nodes'] = (new Forum_forum_model())->get_suki_nodes();
//        $this->data['thread'] = ForumThreadModel::get_new_thread(
//            json_decode(session("setting")['lolita_viewing_forum'])
//        );
//        //        dd($this->data['thread']);
//        return view('PC/Suki/News')->with('data',$this->data);
//    }
}
