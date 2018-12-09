<?php

namespace App\Http\Controllers\Sukiapp;

use App\Http\DbModel\MyLikeModel;
use App\Http\DbModel\User_model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SukiWebController extends Controller
{
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

    public function suki_userhome($uid)
    {
        $this->data['user'] = User_model::find($uid);

        return view("PC/Suki/SukiUserHome")->with("data",$this->data);
    }
}
