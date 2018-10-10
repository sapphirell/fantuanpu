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
    public function _viewThread($tid,$page)
    {
        $this->data['thread']   = $this->threadModel->getThread($tid,$page);
        $this->data['title'] = $this->data['thread']['thread_subject']->subject;
//        dd($this->data['thread']['thread_subject'] );
        $this->data['forum']    = Forum_forum_model::get_nodes_by_fid($this->data['thread']['thread_subject']->fid);

        $this->data['tid']  = $tid;
        $this->data['fid']  = $this->data['thread']['thread_subject']->fid;
        foreach ($this->data['thread'] as &$value)
        {
            $value->dateline = date("Y-m-d H:i",$value->dateline );
            $value->lastpost = date("Y-m-d H:i",$value->lastpost);
        }
        /**
         * 查看数+1
         */
        if($this->data['fid'])
        {
            $thread = ForumThreadModel::find($tid);
            $thread->views += 1;
            $thread->save();
        }

        return $this->data;
    }
    public function ViewThread(Request $request,$tid,$page){
        $this->_viewThread($tid,$page);
        return view('PC/Forum/ThreadView')->with('data',$this->data);

    }
}
