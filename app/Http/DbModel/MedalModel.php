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
    public function find($mid)
    {
        $cachekey = CoreController::MEDAL_INFO . $mid;
        return Cache::remember($cachekey['key'],$cachekey['time'],function () use ($mid){
            return self::where('id',$mid)->first();
        });
    }

}
