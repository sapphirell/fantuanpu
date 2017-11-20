<?php

namespace App\Http\Controllers\Admincp;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdmincpController extends Controller
{
    //
    public function IndexCp(){

        return view('PC/Admincp/Index')->with('data',$this->data);
    }
}
