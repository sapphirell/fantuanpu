<?php

namespace App\Http\DbModel;

use App\Http\Controllers\System\CoreController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CommonMemberCount extends Model
{
    //
    public $table = 'pre_common_member_count';
    public $primaryKey = 'uid';
    public $timestamps = false;
    public static $extcredits = [
        'extcredits1' => '酸奶',
        'extcredits2' => '扑币',
        'extcredits3' => '项链',
        'extcredits4' => '草莓棉花糖',
        'extcredits5' => '灵魂宝石',
        'extcredits6' => '文点',
        'extcredits7' => '分享积分',
        'extcredits8' => '图点',
        'extcredits9' => '积分',
    ];
    public static function find($primaryKey)
    {
        return self::GetUserCoin($primaryKey);
    }
    /**
     * 获取用户积分,如果没有则会创建用户积分记录
     * foreach ($user_count as $key => $value)
     *      if (isset(self::$extcredits[$key]))
     *      $user_count['count'][self::$extcredits[$key]] = $value;
     * return $user_count;
     */

    public static function GetUserCoin($uid)
    {
        if (!$uid)
            return false;
        $cache_key = CoreController::USER_COUNT;
        $user_count  = Cache::remember($cache_key['key'] .$uid,$cache_key['time'],function () use ($uid)
        {
            $user_count = self::where('uid',$uid)->first();
            if (empty($user_count))
            {
                $user_count = new self();
                $user_count->uid = $uid;
                $user_count->save();
            }
            return $user_count->toArray();
        });
        $user_count['extcredits'] = self::$extcredits;

        return $user_count;
    }

    /**
     * 更新用户统计表数据
     * @param $uid
     * @param $field 更新哪个字段
     * @param $value 更新的值,可正可负
     */
    public static function AddUserCount($uid,$field,$value=1,$operation=false,$relatedid=1)
    {
        $cache_key = CoreController::USER_COUNT;
        $user = self::where('uid',$uid)->first() ;
        if (empty($user))
        {
            $user = new self();
            $user->uid      = $uid;
        }
        $user->{$field}    += $value;
        $user->save();
        //如果是变更积分,则记录积分变更日志
        if (in_array($field,self::$extcredits))
        {
            $log = new CreditLogModel();
            $log->operation = $operation;
            $log->$relatedid = $relatedid;
            $log->dateline = time();
            $log->{$field}    = $value;
            $log->save();
        }

        Cache::forget($cache_key['key'] .$uid);
    }

    /**
     *  一次更新用户多个字段的值
     * $operation = false 则不记录变更log
     */
    public static function BatchAddUserCount($uid ,$data,$operation='RPR',$relatedid=1)
    {
        $cache_key = CoreController::USER_COUNT;
        $log_update = false;
        $user = self::where('uid', $uid)->first();
        if (empty($user))
        {
            $user = new self();
            $user->uid = $uid;
        }
        if ($operation !== false)
        {
            #j积分变更日志
            $log = new CreditLogModel();
            $log->operation = $operation;
            $log->$relatedid = $relatedid;
            $log->dateline = time();
        }

        foreach ($data as $key => $value)
        {
            $user->{$key}    += $value;
            if (in_array($key,self::$extcredits))
            {
                $log_update     = true;
                $log->{$key}    = $value;
            }
        }
        $log_update && $log->save();
        $user->save();
        Cache::forget($cache_key['key'] .$uid);
    }
    public static function exp2level()
    {
        //sukiexp
    }
}
