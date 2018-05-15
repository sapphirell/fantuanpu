<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\System\CoreController;
use App\Http\Controllers\User\UserHelperController;
use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\Thread_model;
use App\Http\DbModel\UserNoticeModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ForumBaseController extends Controller
{
    public $forumModel;
    public $threadModel;
    public $helpModel;
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
        $this->data['list'] = $this->threadModel->getThreadList($fid,$page);
        $this->data['fid']  = $fid;
        $this->data['page']  = $page;
        return view('PC/Forum/ThreadList')->with('data',$this->data);
    }
    public function ForumIndex(Request $request)
    {
        $cacheKey = CoreController::NODES;
        $this->data['forumGroup']   = Cache::remember($cacheKey['keys'],$cacheKey['time'],function ()
        {
            return $this->forumModel->get_nodes();
        });

        return view('PC/Forum/Node')->with('data',$this->data);
    }
    public function talk(Request $request,Forum_forum_model $forum_model)
    {
        return view('PC/Forum/Talk')->with('data',$this->data);
    }
    public function notice(Request $request)
    {
        if ($request->input('username') && $request->input('message') )
        {
            $notice = new UserNoticeModel();
            $notice->username = $request->input('username') ;
            $notice->message = $request->input('message') ;
            $notice->save();
            return redirect()->route('notice');
        }
        $this->data['notice'] = UserNoticeModel::select()->get();

        return view('PC/Forum/Notice')->with('data',$this->data);
    }
    public function save_notice(Request $request)
    {

        $notice = new UserNoticeModel();
        $notice->username = $request->input('username') ;
        $notice->message = $request->input('message') ;
        $notice->save();
        return redirect()->route('notice');
    }
    public function webim()
    {
        return view('PC/Forum/Webim')->with('data',$this->data);
    }
    public function about()
    {
    }
}
