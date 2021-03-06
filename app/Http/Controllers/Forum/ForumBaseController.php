<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\System\CoreController;
use App\Http\Controllers\System\RedisController;
use App\Http\Controllers\User\UserBaseController;
use App\Http\Controllers\User\UserHelperController;
use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\ForumPlusModel;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\Thread_model;
use App\Http\DbModel\UserNoticeModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Session\Session;

class ForumBaseController extends Controller
{
    public $forumModel;
    public $threadModel;
    public $helpModel;

    public function __construct(Forum_forum_model $forum_model, Thread_model $thread_model)
    {

        parent::__construct();

        $this->forumModel  = $forum_model;
        $this->threadModel = $thread_model;

    }

    //    public function index(Request $request)
    //    {
    //        switch ($mod = $request->input('mod')){
    //
    //            case 'viewthread':
    //                return $this->ViewThread($request); break;
    //
    //            default:
    //                return $this->ForumIndex($request); break;
    //                break;
    //        }
    //    }
    public function ThreadList(Request $request, $fid, $page)
    {
        $this->data['plus_ids'] = ForumPlusModel::find($fid);
        $this->data['list']     = $this->threadModel->getThreadList($fid, $page, $this->data['plus_ids']);
        $this->data['fid']      = $fid;
        $this->data['forum']    = Forum_forum_model::get_nodes_by_fid($fid);
        //        dd($this->data['forum']);
        $this->data['page'] = $page;
        //帖子置顶信息以及板块版主
        $this->data['forum_plus'] = ForumPlusModel::get_forum_plus($fid);
        //        dd($this->data['forum_plus']["master"]);
        //合并置顶帖进去
        $this->data['list'] = array_merge($this->data['forum_plus']['top'], $this->data['list']);

        return view('PC/Forum/ThreadList')->with('data', $this->data);
    }

    public function ForumIndex(Request $request, UserBaseController $userBaseController)
    {
        $cacheKey                 = CoreController::NODES;
        $this->data['forumGroup'] = Redis::remember(
            $cacheKey['key'],
            $cacheKey['time'],
            function ()
            {
                return $this->forumModel->get_nodes();
            }
        );
        $this->data['hot']        = $this->hot_thread();
        $this->data['new_reply']  = $this->new_reply();
        $this->data['new_thread'] = $this->new_thread();
        //        //获取IM
        //        $this->data = array_merge($this->data,$userBaseController->get_im_message());
        $this->data['avatar'] = config(
                'app.online_url'
            ) . \App\Http\Controllers\User\UserHelperController::GetAvatarUrl(session('user_info')->uid);

        return view('PC/Forum/Node')->with('data', $this->data);
    }

    public function new_reply()
    {
        $cacheKey = CoreController::NEW_REPLY;

        return Cache::remember(
            $cacheKey['key'],
            $cacheKey['time'],
            function ()
            {
                return ForumThreadModel::where('fid', '<>', '63')
                    ->orderBy('lastpost', 'desc')
                    ->offset(0)
                    ->limit(20)
                    ->get();
            }
        );
    }

    public function new_thread()
    {
        $cacheKey = CoreController::NEW_THREAD;

        return Cache::remember(
            $cacheKey['key'],
            $cacheKey['time'],
            function ()
            {
                return ForumThreadModel::where('fid', '<>', '63')
                    ->orderBy('dateline', 'desc')
                    ->offset(0)
                    ->limit(20)
                    ->get();
            }
        );
    }

    public function hot_thread()
    {
        $cacheKey = CoreController::HOT_THREAD;
        $thread   = Cache::remember(
            $cacheKey['key'],
            $cacheKey['time'],
            function ()
            {
                return ForumThreadModel::orderBy('replies', 'desc')->offset(0)->limit(20)->get();
            }
        );

        return $thread;
    }

    public function talk(Request $request, Forum_forum_model $forum_model)
    {
        return view('PC/Forum/Talk')->with('data', $this->data);
    }

    public function notice(Request $request)
    {
        if ($request->input('username') && $request->input('message'))
        {
            $notice           = new UserNoticeModel();
            $notice->username = $request->input('username');
            $notice->message  = $request->input('message');
            $notice->save();

            return redirect()->route('notice');
        }
        $this->data['notice'] = UserNoticeModel::select()->get();

        return view('PC/Forum/Notice')->with('data', $this->data);
    }

    public function save_notice(Request $request)
    {

        $notice           = new UserNoticeModel();
        $notice->username = $request->input('username');
        $notice->message  = $request->input('message');
        $notice->save();

        return redirect()->route('notice');
    }

    public function webim()
    {
        return view('PC/Forum/Webim')->with('data', $this->data);
    }

    public function about()
    {
    }

    public function fantuanpuDevelopers()
    {

    }

    public function app_download()
    {
        return view('PC/Forum/AppDownload')->with('data', $this->data);
    }
}
