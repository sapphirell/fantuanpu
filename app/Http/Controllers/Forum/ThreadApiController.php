<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\System\CoreController;
use App\Http\DbModel\ForumPostModel;
use App\Http\DbModel\ForumPostTableidModel;
use App\Http\DbModel\ForumThreadModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ThreadApiController extends Controller
{
    public $threadModel;
    public $postModel;
    public function __construct(ForumThreadModel $threadModel,ForumPostModel $postModel)
    {
        $this->threadModel  = $threadModel;
        $this->postModel    = $postModel;
    }

    //
    public function NewThread(Request $request)
    {

        $user_info      = session('user_info');
        if (empty($user_info))
        {
            return self::response([],40002,'需要登录');
        }
        $data['fid']        = $request->input('fid');
        $data['author']     = $user_info->username;
        $data['lastposter']     = $user_info->username;
        $data['authorid']   = $user_info->uid;
        $data['subject']    = $request->input('subject');
        $data['dateline']   = time();
        $data['lastpost']   = time();

        foreach ($data as $key => $value)
        {
            if (!$value)
            {
                return self::response([],40001,"缺少参数{$key}");
            }
            else
            {
                $this->threadModel->{$key} = $value;
            }
        }
        $this->threadModel->save();

        return self::response();
    }
    public function PostsThread(Request $request)
    {
        $user_info = session('user_info');
        if(empty($user_info))
        {
            return self::response([],40001,'请先登录');
        }
        if (!$this->checkRequest($request,['fid','tid','subject','message']))
        {
            return self::response([],40002,'缺少参数');
        }
        /**
         * 获取帖子自增长id
         */
        $tableId = new ForumPostTableidModel();
        $tableId->save();

        $postModel      = $this->postModel;
        $postModel->fid = $request->input('fid');
        $postModel->tid = $request->input('tid');
        $postModel->pid = $tableId->pid;
        $postModel->first   = 0;
        $postModel->author  = $user_info->username;
        $postModel->authorid = $user_info->uid;
        $postModel->subject = $request->input('subject');
        $postModel->dateline = time();
        $postModel->message = $request->input('message');
        $postModel->useip   = $request->getClientIp();
        $postModel->save();
        return self::response();
    }
}
