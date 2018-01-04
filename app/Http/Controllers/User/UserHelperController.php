<?php

namespace App\Http\Controllers\User;

use App\Dbmodel\Ucenter_member_model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserHelperController extends Controller
{
    const LOCAL = 'http://localhost:9999/user_ava/';

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

    public static function GetAvatarUrl($uid,$size = 'middle' )
    {
        $avatar = 'images/'.self::GetAvatarDir($uid, $size);


        //var_dump( dirname(dirname(__FILE__)).'/image/user_ava/images/'.$this->get_avatar($uid, $size) );

//        if( file_exists(dirname(dirname(__FILE__)).'/image/user_ava/images/'.self::GetAvatarDir($uid, $size)) ){

            return self::LOCAL.'/'.$avatar;

//        }else{
//
//            return self::LOCAL.'images/noavatar_'.$size.'.gif';
//        }

    }

    public static function GetAvatarDir($uid, $size)
    {

        $size = in_array($size, array('big', 'middle', 'small')) ? $size : 'middle';

        $uid = sprintf("%09d", abs(intval($uid)));

        $dir1 = substr($uid, 0, 3);

        $dir2 = substr($uid, 3, 2);

        $dir3 = substr($uid, 5, 2);

        $typeadd = $type == 'real' ? '_real' : '';

        return $dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2).$typeadd."_avatar_$size.jpg";
    }


}
