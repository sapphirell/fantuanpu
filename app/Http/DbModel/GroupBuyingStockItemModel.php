<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class GroupBuyingStockItemModel extends Model
{
    public $table = "pre_group_buying_stock_item";
    public $timestamps = false;
    public static function getList($item_id)
    {
        return self::where(["item_id" => $item_id])->get();
    }
}
