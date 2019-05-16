<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class GroupBuyingAddressModel extends Model
{
    //
    public $table = 'pre_group_buying_address';
    public $primaryKey = 'id';
    public $timestamps = false;

    public static function save_address($name,$address,$telphone,$uid)
    {
        $ad = new self();
        $ad->name = $name;
        $ad->address = $address;
        $ad->telphone = $telphone;
        $ad->uid = $uid;
        $ad->save();
        return $ad;
    }
}
