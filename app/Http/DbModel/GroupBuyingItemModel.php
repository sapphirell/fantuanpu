<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupBuyingItemModel extends Model
{
    public $table = "pre_group_buying_item";
    public $timestamps = false;
    public $primaryKey = 'id';

    public static function getListInfo(int $id) {

        $list = self
            ::leftJoin("pre_group_buying_log",function ($join) {
                //"pre_group_buying_log.item_id","=","pre_group_buying_item.id",""
                $join->on("pre_group_buying_log.item_id","=","pre_group_buying_item.id")->where("pre_group_buying_log.status","!=",4);
            })
            ->select(DB::raw("pre_group_buying_item.*,count(distinct pre_group_buying_log.uid) as follow,pre_group_buying_log.order_info"))
            ->where("pre_group_buying_item.group_id",$id)
            ->groupBy("pre_group_buying_item.id")
            ->get()->toArray();
//        dd($list);
        foreach ($list as & $value)
        {
            $value['buy_num'] = 0;


            foreach (json_decode($value['order_info'],true) as $num)
            {
                $value['buy_num'] += $num;
            }

        }
        return $list;
    }


    public static function find(int $id)
    {
        return self
            ::leftJoin("pre_group_buying_log","pre_group_buying_log.item_id","=","pre_group_buying_item.id")
            ->select(DB::raw("pre_group_buying_item.*,count(pre_group_buying_log.id) as count"))
            ->where("pre_group_buying_item.id",$id)
            ->groupBy("pre_group_buying_item.id")
            ->first();
    }
}
