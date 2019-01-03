<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class SukiFriendModel extends Model
{
    public $table='pre_suki_friend';
    public $timestamps = false;
    public $primaryKey = 'id';

    public static function is_friend(int $uid,int $fid)
    {
        $data = self::where(['uid' => $uid ,'friend_id' => $fid])->first();
        return empty($data) ? false : true;
    }

    public static function get_my_friends(int $uid,$page)
    {
        $data = self::where("uid",$uid)->limit(10)->offset(($page-1) * 10)->get();
        foreach ($data as &$value)
        {
            $value->user = User_model::find($value->friend_id);
        }
        return $data;
    }
}
