<?php

namespace App\Http\DbModel;

use App\Http\Controllers\System\CoreController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ActionModel extends Model
{
    public $table = 'pre_action';
    public $primaryKey = 'id';
    public $timestamps = false;
    public static function name($name)
    {
        $cachekey = CoreController::ACTION_INFO;
        return Cache::remember($cachekey['key'] . $name,$cachekey['time'],function () use ($name){
            return self::where('action_key',$name)->first();
        });
    }
}
