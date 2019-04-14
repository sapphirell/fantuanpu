<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class GroupBuyingLogModel extends Model
{
    public $table = "pre_group_buying_log";
    public $timestamps = false;

    //获取没有取消的付款人数和品数
    public static function getNotCancelItemsLog(int $itemId)
    {
        $log = self::where("item_id",'=',$itemId)->where("status","!=",4)->get();
        $member = [];
        $return = [
            "member_count" => 0,
            "item_count" => 0
        ];

        foreach ($log as $value)
        {
            !in_array($value->uid,$member) && array_push($member,$value->uid);
            foreach (json_decode($value->order_info,true) as $order_num)
            {
                $return["item_count"] += $order_num;
            }
        }
        $return["member_count"] = count($member);
        return $return;
    }
}
