<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupBuyingAddressModel extends Model
{
    public $table = "pre_group_buying_address";
    public $timestamps = false;
    public $primaryKey = 'id';

    public static function save_address(string $name,string $address,string $phone,int $uid)
    {
        $ad = new self();
        $ad->name = $name;
        $ad->address = $address;
        $ad->phone = $phone;
        $ad->uid = $uid;
        $ad->save();
        return $ad;
    }

}
