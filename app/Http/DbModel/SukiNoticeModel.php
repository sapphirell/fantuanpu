<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class SukiNoticeModel extends Model
{
    public $table = 'pre_suki_notice';
    public $primaryKey = 'uid';
    public $timestamps = false;

    /**
     *
     * @param     $uid
     * @param int $place 1=position代表帖子id
     */
    public static function find_user_notice(int $uid,int $place=1)
    {
        $data = self::where(['uid' => $uid,'place' => $place])->orderBy("id","desc")->get();
        foreach ($data as &$value)
        {
            $value->position = json_decode($value->position_id);
            $value->subject = (new Thread_model())->getThread($value->position->tid);
        }

        return $data;
    }
}
