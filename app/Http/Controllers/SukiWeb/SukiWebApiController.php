<?php

namespace App\Http\Controllers\SukiWeb;

use App\Http\Controllers\Forum\ThreadApiController;
use App\Http\Controllers\Sukiapp\CommonApiController;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\MyLikeModel;
use App\Http\DbModel\SukiClockModel;
use App\Http\DbModel\SukiFriendRequestModel;
use App\Http\DbModel\SukiMessageBoardModel;
use App\Http\DbModel\Thread_model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SukiWebApiController extends Controller
{
    /**
     * 回复suki帖子
     * @param Request $request
     */
    public function suki_reply_thread(Request $request,ThreadApiController $threadApiController)
    {
        return $threadApiController->PostsThread($request,false,"suki");
    }
    public function get_thread(Request $request,Thread_model $thread_model)
    {
        //        dd($request->input("view_forum"));
        self::set_suki_view(session("user_info")->uid ?: 0,$request->input("view_forum")?:[157]);
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
     * 用户空间留言
     * @param Request $request
     * @返回 mixed
     */
    public function suki_reply_board(Request $request)
    {
        $check = self::checkRequest($request,["uid","message"]);
        if ($check !== true)
            return self::response([],40001,"缺少参数".$check);

        $message = new SukiMessageBoardModel();
        $message->uid = $request->input("uid");
        $message->authorid = $this->data['user_info']->uid;
        $message->message = $request->input("message");
        $message->send_time = time();
        $message->save();

        return self::response([],200,"留言成功");

    }

    /**
     * 关注用户
     * @param Request $request
     */
    public function suki_follow_user(Request $request)
    {

        $check = self::checkRequest($request,["uid","to_uid","to_do"]);
        if ($check !== true)
            return self::response([],40001,"缺少参数$check");

        $like_all = MyLikeModel::get_user_like($request->input("uid"),4);
        $uid_arr =[];
        foreach ($like_all as $value)
        {
            $uid_arr[] = $value->like_id;
        }


        if ($request->input("to_do") == "follow" )
        {
            if (in_array($request->input("to_uid"),$uid_arr))
            {
                return self::response([],40002,"已经关注了");
            }
            else
            {
                MyLikeModel::add_user_like($this->data["user_info"]->uid,$request->input("to_uid"),4);
                return self::response([],200,"关注成功了");
            }


        }
        if ($request->input("to_do") == "unfollow" )
        {
            if (in_array($request->input("to_uid"),$uid_arr))
            {
                MyLikeModel::rm_user_like($this->data["user_info"]->uid,$request->input("to_uid"),4);
                return self::response([],200,"取消关注成功");
            }
            else
            {

                return self::response([],40002,"您还未关注");
            }


        }
    }

    /**
     * 添加suki好友
     * @param Request $request
     */
    public function add_suki_friend(Request $request)
    {
        $check = self::checkRequest($request,["friend_id","message"]);
        if ($check !== true)
            return self::response([],40001,"缺少参数".$check);

        $res = CommonApiController::_suki_send_friend_request($this->data["user_info"]->uid,$request->input("friend_id"),$request->input("message"));

        return $res ? self::response([],200,"已经发送申请") : self::response([],40002,"你们已经是好友了");
    }

    /***
     * suki添加喜欢帖子
     */
    public function add_suki_like(Request $request)
    {
        $check = self::checkRequest($request,["tid","todo"]);
        if ($check !== true)
            return self::response([],40001,"缺少参数{$check}");
        $has_follow = MyLikeModel::has_like($this->data['user_info']->uid,$request->input("tid"),3);

        if ($request->input("todo") == "follow")
        {
            if ($has_follow)
                return self::response([],40002,"已经喜欢过该帖子了~");

            CommonApiController::_suki_add_my_like_thread($this->data['user_info']->uid,$request->input('tid'));
            return self::response([],40002,"收藏成功");
        }
        else
        {
            if (!$has_follow)
                return self::response([],40002,"尚未关注~");
            CommonApiController::_suki_rm_my_like_thread($this->data['user_info']->uid,$request->input('tid'));
            return self::response([],40002,"取关成功");
        }
    }

    /**
     * 添加suki的好友
     */
    public function apply_suki_friends(Request $request)
    {
        $check = self::checkRequest($request,["applicant_id","ship_id","to_do"]);
        if ($check !== true)
            return self::response([],40001,"缺少参数$check");

        $res = SukiFriendRequestModel::apply_suki_friend_request(
                $request->input("applicant_id"),
                $request->input("ship_id"),
                $request->input("to_do")
            );

        if ($res == true)
            return self::response();
        else
            return self::response([],40002,"操作失败,该申请已失效。");
    }
    // suki闹钟增删改查
    public function setting_clock(Request $request)
    {
        $check = self::checkRequest($request,['name','money','date']);
        if ($check !== true)
            return self::response([],40001,"缺少参数$check");
        if ($request->input('cid'))
            $data = SukiClockModel::find($request->input('cid'));
        else
        {
            $data = new SukiClockModel();

            if (empty($data))
                return self::response([],40002,"记录不存在");
        }
        if ($request->input('to_do') == 'del')
        {
            $data->delete();
            return self::response();
        }

        $data->uid = $this->data['user_info']->uid;
        $data->clock_name = $request->input("name");
        $data->clock_money = $request->input("money");
        $data->clock_date = $request->input("date");
        $data->save();

        return self::response();
    }
}