<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UserSettingModel extends Model
{
    public $table='pre_user_setting';
    public $timestamps = false;
    public $primaryKey = 'uid';
    public static function find($uid)
    {
        $data = self::where("uid",$uid)->first();
        if (empty($data))
        {
            $data = new self();
            $data->uid = $uid;
            $data->save();
            $data = self::where("uid",$uid)->first();
        }
        return $data;
    }


}
