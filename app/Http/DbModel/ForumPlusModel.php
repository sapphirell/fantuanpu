<?php

namespace App\Http\DbModel;

use App\Http\Controllers\System\CoreController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ForumPlusModel extends Model
{
    public $table = 'pre_forum_plus';
    public $primaryKey = 'fid';
    public $timestamps = false;

    public static function find($fid)
    {
        $cache_key = CoreController::FORUM_PLUS;

        $plus  = Cache::remember($cache_key['key'].$fid ,$cache_key['time'],function () use ($fid)
        {
            $plus = self::where("fid",$fid)->first();
            if (empty($plus))
            {
                $plus = new self();
                $plus->fid = $fid;
                $plus->top_thread_id    = json_encode([]);
                $plus->master_id        =  json_encode([]);
                $plus->save();
            }
            $plus->top_thread_id    = json_decode($plus->top_thread_id );
            $plus->master_id        =  json_decode($plus->master_id);
            return $plus;
        });
        return $plus;
    }
    public static function get_forum_plus($fid)
    {
        $plus = self::find($fid);
        $data = ['top'=>[],'master'=>[]];
        $thread_model = new Thread_model();
        foreach ($plus['top_thread_id'] as $value)
        {
            $thread = $thread_model->getThread($value)["thread_subject"];
            $thread->top = 1;
            $data['top'][] = $thread;
        }

        foreach ($plus['master_id'] as $value)
            $data['master'][] = User_model::find($value);

        return $data;
    }
}
