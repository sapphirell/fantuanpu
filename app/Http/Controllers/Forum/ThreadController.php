<?php

namespace App\Http\Controllers\Forum;


use App\Http\DbModel\Thread_model;
use App\ForumThread;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ThreadController extends Controller
{
    public $threadModel;
    public function __construct(Thread_model $thread_model)
    {
        parent::__construct();
        $this->threadModel = $thread_model;
    }

    public function NewThreadView()
    {
        return view('PC/Forum/NewThread');
    }

    public function StorePosts(Request $request)
    {
        dd($request);
    }

    public function ViewThread(Request $request,$tid,$page){
//        echo $tid;
//        echo $page;

        $this->data['thread'] = $this->threadModel->getThread($tid);

        dd( $this->data['thread']);
        return view('PC/Forum/ThreadView')->with('data',$this->data);

    }
}
