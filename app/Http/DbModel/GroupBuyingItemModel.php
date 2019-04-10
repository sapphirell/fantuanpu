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

        return self
            ::leftJoin("pre_group_buying_log","pre_group_buying_log.item_id","=","pre_group_buying_item.id")
            ->select(DB::raw("pre_group_buying_item.*,count(pre_group_buying_log.id) as count"))
            ->where("pre_group_buying_item.group_id",$id)
            ->groupBy("pre_group_buying_item.id")
            ->get()->toArray();
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
