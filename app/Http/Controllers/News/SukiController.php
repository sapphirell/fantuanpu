<?php

namespace App\Http\Controllers\News;

use App\Http\DbModel\Forum_forum_model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SukiController extends Controller
{
    public function index(Request $request)
    {
        $this->data['nodes'] = (new Forum_forum_model())->get_suki_nodes();

        return view('PC/Suki/News')->with('data',$this->data);
    }
}
