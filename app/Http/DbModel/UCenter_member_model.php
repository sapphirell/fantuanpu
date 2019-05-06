<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UCenter_member_model extends Model
{
    public $primaryKey = 'uid';
    public $table='pre_ucenter_members';
    public $timestamps = false;

    public static function GetUserInfoByEmail($email){
        return User_model::where('email',$email)->select()->first();
    }
    public static function UpdateUserPassword($uid,$newpass)
    {
        $user = self::find($uid);
//        var_dump(self::GetSaltPass($newpass,$user->salt));die();
        $user->password = self::GetSaltPass($newpass,$user->salt);
        $user->save();

    }
    public static function GetSaltPass($psw,$salt)
    {
        return md5(md5($psw).$salt);
    }
}
