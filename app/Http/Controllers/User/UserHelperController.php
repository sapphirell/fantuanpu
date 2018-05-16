<?php

namespace App\Http\Controllers\User;

use App\Dbmodel\Ucenter_member_model;
use App\Http\Controllers\System\CoreController;
use App\Http\DbModel\CommonUsergroupModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

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
    public static function SetLoginStatus($data)
    {

        //用户信息需要取usermodel的
        $data = \App\Http\DbModel\UCenter_member_model::GetUserInfoByEmail($data->email);

        //取用户组数据
        $cacheKey = CoreController::USER_GROUP;

        $data['group'] =  Cache::remember($cacheKey['key'].$data->groupid ,$cacheKey['time'],function () use ($data)
        {
            return CommonUsergroupModel::find($data->groupid);
        });
        session(['login_status_code' => "1",'user_info' => $data]);
        return true;
    }

    public static function GetAvatarUrl($uid,$size = 'middle' )
    {
        $usrAvatar      = self::GetAvatarDir($uid, $size);
        //远程目录
//        $avatar = 'images/'.$usrAvatar;
        //本地目录模式
        $local      = dirname(dirname(dirname(dirname(__DIR__)))) . '/public/';
        $avadir     = 'Image/user_ava/images/';
        $avatar     = $local . $avadir . $usrAvatar;

        if( file_exists($avatar) )
        {
            return $avadir . $usrAvatar;
        }else
        {
            return $avadir .'/noavatar_middle.gif';
        }

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
