<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class SukiFriendRequestModel extends Model
{
    public $table='pre_suki_friend_request';
    public $timestamps = false;
    public $primaryKey = 'id';

    //获取这个用户的好友申请
    public static function get_user_friend_request(int $to_uid,$page)
    {
        $data = self::where(["friend_id" => $to_uid])->orderBy("id","desc")->offset(($page-1)*10)->limit(10)->get();
        return $data;
    }

    /***
     * 同意suki的好友申请
     * @param int $applicant 申请人uid
     * @param int $ship_id  被申请人uid
     * @param int $to_do  2=已经同意 3=已经拒绝
     */
    public static function apply_suki_friend_request(int $applicant,int $ship_id,int $to_do=2)
    {
        $data = self::where(["uid" => $applicant, "friend_id" => $ship_id,"result" => 1])->first();

        if (empty($data))
            return false;

        $data->result = $to_do;
        $data->save();

        if(!SukiFriendModel::is_friend($applicant,$ship_id))
        {
            SukiFriendModel::insert([
                ['uid' => $applicant,'friend_id' => $ship_id],
                ['uid' => $ship_id,'friend_id' => $applicant],
            ]);
        }
        return true;
    }
}
