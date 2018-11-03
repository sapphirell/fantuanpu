<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class UserSignModel extends Model
{
    public $table='pre_user_sign';
    public $primaryKey = 'uid';
    public $timestamps = false;

    public static function find($uid)
    {
        $user_sign = self::where('uid',$uid)->first();
        if (empty($user_sign))
        {
            $user_sign = new self();
            $user_sign->uid = $uid;
            $user_sign->hit = 0;
            $user_sign->save();
        }
        return $user_sign;
    }
}
