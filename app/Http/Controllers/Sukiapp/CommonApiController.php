<?php

namespace App\Http\Controllers\Sukiapp;

use App\Http\Controllers\Forum\ThreadApiController;
use App\Http\Controllers\Forum\ThreadController;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\Thread_model;
use App\Http\DbModel\UserSettingModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommonApiController extends Controller
{
    public function get_thread(Request $request,Thread_model $thread_model)
    {
//        dd($request->input("view_forum"));
        self::set_suki_view(session("user_info")->uid,$request->input("view_forum"));
        $this->data['thread'] = ForumThreadModel::get_new_thread($request->input("view_forum"));

        return $request->input("need") == 'html' ?  view('PC/Suki/SukiThreadList')->with('data',$this->data) : self::response($this->data);
    }

    /**
     * 在suki发表新的帖子
     */
    public function suki_new_thread(Request $request,ThreadApiController $threadApiController)
    {
        $user_info      = session('user_info');

        if (empty($user_info))
            return self::response([],40002,'需要登录');
        if($user_info->groupid == 4 || $user_info->groupid == 5)
            return self::response([],40003,'您的账户已被禁言');
        if($user_info->groupid == 8)
            return self::response([],40003,'您的账户邮箱未验证,因此不能发表主题');

        $checkParams = $this->checkRequest($request,['subject','message']);
        if($checkParams !== true)
        {
            return self::response([],40001,'缺少参数'.$checkParams);
        }

        $fid    = $request->input('fname')
            ? Forum_forum_model::where('name',"=",$request->input('fname'))->first()->fid
            : $request->input('fid');
        if (!$fid)
            return self::response([],40004,'请选择发帖分类');

        $threadApiController->_newThread(
            $fid,
            $request->input('subject'),
            $request->input('message'),
            $request->getClientIp(),
            $user_info
        );
        return self::response();
    }

    /***
     * 查看suki的帖子
     * @param Request $request
     */
    public function view_thread(Request $request,$tid,$page)
    {
        $this->data = (new ThreadController(new Thread_model()))->_viewThread($tid,$page);
        return view('PC/Suki/SukiThread')->with('data',$this->data);
    }
}
