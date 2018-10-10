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
    public static function AddUserCount($uid,$field,$value)
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
        Cache::forget($cache_key['key'] .$uid);
    }
}
