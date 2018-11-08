<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class User_model extends Model
{
    public $primaryKey = 'uid';
    public $table='pre_common_member';
    public $timestamps = false;
    public static function getUserListByUsername($usrname)
    {
        return User_model::where('username','like',"%$usrname%")->select("username","email","uid")->paginate(30);
    }
    public static function getUserListByNameOrMail($input)
    {
        return User_model::where('username','like',"%$input%")->orWhere('email','=',$input)->select("username","email","uid")->paginate(30);
    }
    public function createUser($email,$password)
    {
        $this->email = $email;
//        $this->username =
    }
    public static function getUserByEmial($mail,$avatar=true)
    {
        $user = User_model::where('email',$mail)->first();
        if ($avatar)
            $user->avatar = config('app.online_url').\App\Http\Controllers\User\UserHelperController::GetAvatarUrl($user->uid);
        return $user;
    }
}
