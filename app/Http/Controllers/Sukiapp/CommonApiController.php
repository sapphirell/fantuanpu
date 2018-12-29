<?php

namespace App\Http\Controllers\Sukiapp;

use App\Http\Controllers\Forum\ThreadApiController;
use App\Http\Controllers\Forum\ThreadController;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\MemberLikeModel;
use App\Http\DbModel\MyLikeModel;
use App\Http\DbModel\SukiFriendModel;
use App\Http\DbModel\SukiFriendRequestModel;
use App\Http\DbModel\SukiNoticeModel;
use App\Http\DbModel\Thread_model;
use App\Http\DbModel\UserSettingModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommonApiController extends Controller
{
    public static function _suki_add_friend($uid,$friend)
    {
        if (SukiFriendModel::is_friend($uid,$friend))
        {
            return false;
        }

        $suki_friends = new SukiFriendModel();
        $suki_friends->uid = $uid;
        $suki_friends->friend_id = $friend;
        $suki_friends->save();
        return true;
    }
    //发送好友申请
    public static function _suki_send_friend_request($uid,$friend,$message)
    {
        if (SukiFriendModel::is_friend($uid,$friend))
        {
            return false;
        }
        $friend_request = new SukiFriendRequestModel();
        $friend_request->uid = $uid;
        $friend_request->friend_id = $friend;
        $friend_request->message = $message;
        $friend_request->time = time();
        $friend_request->save();
        return true;
    }
    //添加suki喜欢的帖子
    public static function _suki_add_my_like_thread(int $uid,int $tid)
    {
        MyLikeModel::add_user_like($uid,$tid,3);
    }
    //移除suki喜欢的帖子
    public static function _suki_rm_my_like_thread(int $uid,int $tid)
    {
        MyLikeModel::rm_user_like($uid,$tid,3);
    }
}
