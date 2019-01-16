<?php

namespace App\Http\DbModel;

use App\Http\Controllers\System\CoreController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class MemberFieldForumModel extends Model
{
    public $table = 'pre_common_member_field_forum';
    public $primaryKey = 'uid';
    public $timestamps = false;

    public static function find(int $uid)
    {
        $cacheKey = CoreController::USER_FIELD;
        $field =  Cache::remember($cacheKey['key'].$uid,$cacheKey['time'],function () use ($uid)
        {
            $field = self::where("uid",$uid)->first();
            if (empty($field->uid))
            {
                $field = new self();
                $field->uid = $uid;
                $field->save();
            }

            return $field;
        });
        return $field;
    }
    public static function update_field(int $uid,array $upd)
    {
        $cacheKey = CoreController::USER_FIELD;
        $field      = self::find($uid);
        foreach ($upd as $key => $value)
        {
            $field->{$key} = $value;
        }
        $field->save();

        Cache::forget($cacheKey['key'].$uid);
    }
}
