<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class GroupBuyingStockItemTypeModel extends Model
{
    public $table = "pre_group_buying_stock_item_type";
    public $timestamps = false;
    public static function getList()
    {
        $data = self::select()->get();
        foreach ($data as $value)
        {
            $value->item_image = explode("|", $value->item_image );
            $value->items = GroupBuyingStockItemModel::getList($value->id);
            $value->min_price = 999999;
            foreach ($value->items as $item)
            {
                if ($item->price < $value->min_price)
                {
                    $value->min_price = $item->price;
                }
                if ($item->price > $value->min_price)
                {
                    $value->max_price = $item->price;
                }
            }
        }
        return $data;
    }

    public static function getOne($item_id)
    {
        $data["info"] = self::find($item_id);
        $data["detail"] = GroupBuyingStockItemModel::getList($item_id);
        return $data;
    }
}
