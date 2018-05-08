<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\System\CoreController;
use App\Http\DbModel\ForumPostModel;
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
}
