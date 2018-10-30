<?php

namespace App\Http\DbModel;

use App\Http\Controllers\System\CoreController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class MedalModel extends Model
{
    public $table = 'pre_medal';
    public $primaryKey = 'id';
    public $timestamps = false;

    public static function addMedal()
    {

    }
    public static function flush_medal($mid)
    {
        $cachekey = CoreController::MEDAL_INFO;
        Cache::forget($cachekey['key'].$mid);
    }
    public static function find($mid)
    {
        $cachekey = CoreController::MEDAL_INFO;
        return Cache::remember($cachekey['key'].$mid,$cachekey['time'],function () use ($mid){
            return self::where('id',$mid)->first();
        });
    }

}
