<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupBuyingExpressModel extends Model
{
    public $table = "pre_group_buying_express";
    public $timestamps = false;
    public $primaryKey = 'id';

    public static function get_my_express(int $uid)
    {
        $data = self::where("uid",'=',$uid)->orderBy("id","desc")->get();
        foreach ($data as &$value)
        {
            $orders = json_decode($value->orders,true);
            $groups = [];
            foreach ($orders as $orderId)
            {
                $orderTableData = GroupBuyingOrderModel::find($orderId);
                $groups[] = $orderTableData->group_id;
            }
            $value->groups = $groups;
        }
        return $data;
    }

}
