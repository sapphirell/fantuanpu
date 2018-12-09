<?php

namespace App\Http\DbModel;

use App\Http\Controllers\System\CoreController;
use Illuminate\Database\Eloquent\Model;

class MyLikeModel extends Model
{
    public $table='pre_my_like';
    public $timestamps = false;

    public static function get_user_like($uid,$type=1)
    {
//        $thread_cache_key   = CoreController::USER_INFO;

//        $res['thread_subject']  =   Cache::remember($thread_cache_key['key'].$uid."_type_",$thread_cache_key['time'],
//            function () use ($tid) {
//                return DB::table($this->table_thread)->select()->where(['tid'=>$tid])->first();
//            });

        $data = self::where(["uid"=>$uid,"like_type"=>$type])->get();

        return $data;
    }
}
