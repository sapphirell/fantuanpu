<?php

namespace App\Http\Controllers\User;

use App\Dbmodel\Ucenter_member_model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserHelperController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /****
     * @param $data 传入数组则认为是用户数据,进行用户登录信息录入,传入字符串则认为是用户邮箱
     * @return bool
     */
    public static function SetLoginStatus($data){

        if( $data->uid ){

            session(['login_status_code' => "1",'user_info' => $data]);

        } else{
            session([ 'login_status_code' => "1",
                      'user_info'         => \App\Http\DbModel\UCenter_member_model::GetUserInfoByEmail($data)
                ]);
        }

        return true;

    }



}
