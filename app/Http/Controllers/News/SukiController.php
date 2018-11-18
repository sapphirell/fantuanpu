<?php

namespace App\Http\Controllers\News;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SukiController extends Controller
{
    public function index(Request $request)
    {
        return view('PC/Suki/News')->with('data',$this->data);
    }

}
