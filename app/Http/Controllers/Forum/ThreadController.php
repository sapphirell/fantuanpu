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
}
