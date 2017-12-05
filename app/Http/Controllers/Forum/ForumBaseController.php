<?php

namespace App\Http\Controllers\Forum;

use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\Thread_model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ForumBaseController extends Controller
{
    public $forumModel;
    public $threadModel;
    public function __construct(Forum_forum_model $forum_model,Thread_model $thread_model)
    {
        parent::__construct();
        $this->forumModel = $forum_model;
        $this->threadModel = $thread_model;
    }

    public function index(Request $request){

        switch ($mod = $request->input('mod')){

            case 'viewthread':
                return $this->ViewThread($request); break;

            default:
                return $this->ForumIndex($request); break;
                break;
        }


    }
    public function ThreadList(Request $request,$fid,$page)
    {
        $this->data['list'] = $this->threadModel->getThreadList($fid);
//        dd($this->data);
        return view('PC/Forum/ThreadList')->with('data',$this->data);
    }
    public function ForumIndex(Request $request)
    {
        $this->data['forumGroup']   =   $this->forumModel->get_nodes();
//        dd($this->data['forumGroup']  );
        return view('PC/Forum/Node')->with('data',$this->data);
    }
    public function talk(Request $request,Forum_forum_model $forum_model)
    {
        return view('PC/Forum/Talk')->with('data',$this->data);
    }


}
