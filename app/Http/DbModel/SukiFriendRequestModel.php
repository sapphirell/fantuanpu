<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class SukiFriendRequestModel extends Model
{
    public $table='pre_suki_friend_request';
    public $timestamps = false;
    public $primaryKey = 'id';

    public static function get_user_friend_request(int $uid,$page)
    {
        $data = self::where(["uid" => $uid])->orderBy("id","desc")->offset(($page-1)*10)->limit(10)->get();
        return $data;
    }
}
