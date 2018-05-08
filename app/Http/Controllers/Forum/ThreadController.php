<?php

namespace App\Http\Controllers\Forum;


use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\Thread_model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;


class ThreadController extends Controller
{
    public $threadModel;
    public function __construct(Thread_model $thread_model)
    {
        parent::__construct();
        $this->threadModel = $thread_model;
    }

    public function NewThreadView(Request $request)
    {

        return view('PC/Forum/NewThread');
    }

    public function StorePosts(Request $request)
    {
        dd($request);
    }

    public function ViewThread(Request $request,$tid,$page){
        $this->data['thread']   = $this->threadModel->getThread($tid);
        $this->data['forum']    = Forum_forum_model::get_nodes_by_fid($this->data['thread']['thread_subject']->fid);
        return view('PC/Forum/ThreadView')->with('data',$this->data);

    }
}
