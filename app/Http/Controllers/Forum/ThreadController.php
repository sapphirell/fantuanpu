<?php

namespace App\Http\Controllers\Forum;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ThreadController extends Controller
{
    //
    public function NewThreadView()
    {
        return view('PC/Forum/NewThread');
    }
    public function StorePosts(Request $request)
    {
        dd($request);
    }


    public function ViewThread(Request $request,$fid,$page){
        echo $fid;
        echo $page;
    }
}
