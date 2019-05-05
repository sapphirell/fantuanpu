<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class GroupBuyingModel extends Model
{
    public $table = "pre_group_buying";
    public $timestamps = false;

    public static function getLastGroup($active=true)
    {
        $data = self::orderBy("id","DESC")->offset(0)->limit(1);
        if ($active)
        {
            $data = $data->where(["status"=>2]);
        }
        return $data->first();
    }
}
