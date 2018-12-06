<?php

namespace App\Http\Controllers\Sukiapp;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SukiWebController extends Controller
{
    public function suki_myfollow(Request $request)
    {
        return view("PC/Suki/SukiMyFollow");
    }
}
