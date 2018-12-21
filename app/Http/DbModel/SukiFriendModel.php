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
}
