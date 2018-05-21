<?php

namespace App\Http\Controllers\Forum;


use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\ForumPostModel;
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
//        dd($request->input());
//        dd($request->getClientIp());

    }

    public function ViewThread(Request $request,$tid,$page){
        $this->data['thread']   = $this->threadModel->getThread($tid);
        $this->data['forum']    = Forum_forum_model::get_nodes_by_fid($this->data['thread']['thread_subject']->fid);
        $this->data['tid']  = $tid;
        $this->data['fid']  = $this->data['thread']['thread_subject']->fid;
        /**
         * 查看数+1
         */
        $thread = ForumThreadModel::find($tid);
        $thread->views += 1;
        $thread->save();
        return view('PC/Forum/ThreadView')->with('data',$this->data);

    }
}
