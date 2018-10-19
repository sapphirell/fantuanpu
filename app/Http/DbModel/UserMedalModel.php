<?php

namespace App\Http\DbModel;

use App\Http\Controllers\System\CoreController;
use Illuminate\Database\Eloquent\Model;
use Prophecy\Call\CallCenter;

class UserMedalModel extends Model
{
    public $table='pre_user_medal';
    public $timestamps = false;

    public static function get_user_medal($uid)
    {
        $cacheKey = CoreController::USER_MEDAL . $uid;
        return Cache::remember($cacheKey['key'],$cacheKey['time'],function () use ($uid){
            $user_medal = UserMedalModel::where('uid',$uid)->get();
            $data = [];
            foreach ($user_medal as $value)
            {
                if ($value->status == 1)
                    $data['in_adorn'] = $value;
                elseif ($value->status == 2)
                    $data['in_box'] = $value;
                elseif($value->status == 3)
                    $data['in_store'] = $value;
            }
            return $data;
        });
    }
}

