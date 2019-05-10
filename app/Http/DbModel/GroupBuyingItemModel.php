<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupBuyingItemModel extends Model
{
    public $table = "pre_group_buying_item";
    public $timestamps = false;
    public $primaryKey = 'id';

    public static function getListInfo(int $id, bool $show_hidden = true) {

        $list = self
            ::leftJoin("pre_group_buying_log",function ($join) {
                //"pre_group_buying_log.item_id","=","pre_group_buying_item.id",""
                $join->on("pre_group_buying_log.item_id","=","pre_group_buying_item.id")->where("pre_group_buying_log.status","!=",4);
            })
            ->select(DB::raw("pre_group_buying_item.*,count(distinct pre_group_buying_log.uid) as follow,pre_group_buying_log.order_info"))
            ->where("pre_group_buying_item.group_id",$id);

//        dd($list);
        if (!$show_hidden){
            $list = $list->where(["display" => 1]);
        }
        $list = $list->groupBy("pre_group_buying_item.id")
            ->get()->toArray();
        //获取未group buy 前的数据
        foreach ($list as & $value)
        {
            $logCount = GroupBuyingLogModel::getNotCancelItemsLog($value["id"]);
            $value['item_count'] =  $logCount["item_count"];

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
