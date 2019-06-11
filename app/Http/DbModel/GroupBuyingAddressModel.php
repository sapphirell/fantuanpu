<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class GroupBuyingAddressModel extends Model
{
    //
    public $table = 'pre_group_buying_address';
    public $primaryKey = 'id';
    public $timestamps = false;

    public static function save_address(string $name,string $address,int $telphone,int $uid)
    {
        $ad = self::get_my_address($uid) ? : new self();
        $ad->name = $name;
        $ad->address = $address;
        $ad->telphone = $telphone;
        $ad->uid = $uid;
        $ad->save();
        return $ad;
    }
    public static function get_my_address(int $uid)
    {
        return self::where(["uid" => $uid])->select()->first();
    }
}
