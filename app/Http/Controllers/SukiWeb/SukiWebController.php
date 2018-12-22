<?php

namespace App\Http\Controllers\SukiWeb;

use App\Http\Controllers\Forum\ThreadController;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\MyLikeModel;
use App\Http\DbModel\SukiFriendRequestModel;
use App\Http\DbModel\SukiMessageBoardModel;
use App\Http\DbModel\SukiNoticeModel;
use App\Http\DbModel\Thread_model;
use App\Http\DbModel\User_model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SukiWebController extends Controller
{

    /**
     * 查看suki空间的follow
     * @param Request $request
     * @返回 $this
     */
    public function suki_myfollow(Request $request)
    {
        if ($request->input("like_type") == 1) // 用户
        {

            $this->data["my_follow"]= MyLikeModel::get_user_like($this->data['user_info']->uid,$request->input("like_type"));
            foreach ($this->data["my_follow"] as &$value)
            {
                $value->user = User_model::find($value->like_id,["username","uid"]);
            }
        }
        //            $this->data["follow"] = MyLikeModel::leftJoin("pre_common_member","pre_my_like.like_id",'=',"pre_common_member.uid")
        //                ->where("pre_common_member.uid",$this->data['user_info']->uid)
        //                ->where("pre_my_like.like_type",1)
        //                ->get();

        //        dd( $this->data["my_follow"]);
        return view("PC/Suki/SukiMyFollow")->with("data",$this->data);
    }

    /**
     * @param $uid
     * @返回 $this
     */
    public function suki_userhome($uid)
    {
        $this->data['user'] = User_model::find($uid);
        $this->data['thread'] = ForumThreadModel::get_user_thread($uid,1);
        $this->data['has_follow'] = MyLikeModel::has_follow($this->data["user_info"]->uid,$uid);
        $this->data['message_board'] = SukiMessageBoardModel::get_user_message($uid,1);

        return view("PC/Suki/SukiUserHome")->with("data",$this->data);
    }

    /**
     * @param Request $request
     */
    public function suki_get_user_thread(Request $request)
    {
        $check = self::checkRequest($request,["uid","page","need"]);
        if ($check !== true)
            return self::response([],40001,"缺少参数".$check);
        $this->data['thread'] = ForumThreadModel::get_user_thread($request->input("uid"),$request->input("page"));


        return $request->input("need")  == "html" ? view("PC/Suki/SukiUcThreadlist")->with("data",$this->data) :self::response($this->data['thread']);
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

    /**
     * 弹出的suki加好友申请的面板
     * @param Request $request
     */
    public function add_suki_friend_view(Request $request)
    {
        return  view('PC/Suki/SukiAddFriend')->with('data',$this->data);
    }

    /**
     * 用户提醒列表
     * @param Request $request
     */
    public function suki_notice(Request $request)
    {
        switch ($request->input("type"))
        {
            case "reply_me" :
                $this->data["reply_me"] = SukiNoticeModel::find_user_notice($this->data['user_info']->uid,1);
                break;
            case "my_message": //我的私信
                break;
            case "call_me": //@

                break;
            case "friend_request":
                $this->data["friend_request"] = SukiFriendRequestModel::get_user_friend_request($this->data['user_info']->uid,$request->input("page")?:1);
                break;
            default :
                $this->data["reply_me"] = SukiNoticeModel::find_user_notice($this->data['user_info'],1);
                break;
        }
//        dd($this->data);
        return  view('PC/Suki/SukiNoticeView')->with('data',$this->data);
    }
}
