<?php

namespace App\Http\Controllers\Forum;


use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\ForumPlusModel;
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
        $this->data['keywords'] = $this->data['thread']['thread_subject']->subject;
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

    /**
     * 设置帖子为置顶帖子|饭团扑的
     * @param Request $request
     */
    public function set_top_thread(Request $request)
    {
        $checkParams = $this->checkRequest($request,['tid','fid','todo']);
        $flag_prower = "null";
        $flag_toped = "null";
        if($checkParams !== true)
        {
            return self::response([],40001,'缺少参数'.$checkParams);
        }
        // 获取板块目前的附加信息
        $forum_plus = ForumPlusModel::find($request->input('fid'));
        $flag_prower = in_array(session("user_info")->uid,json_encode("master_id",true));
        $flag_toped = in_array($request->input('tid'),json_encode($forum_plus["top_thread_id"],true));
        dd(in_array(session("user_info")->uid,json_encode("master_id",true)));
    }
}
