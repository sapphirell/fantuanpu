<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupBuyingLogModel extends Model
{
    public $table = "pre_group_buying_log";
    public $timestamps = false;

    //获取没有取消的付款人数和品数
    public static function getNotCancelItemsLog(int $itemId)
    {
        $log = self::where("item_id",'=',$itemId)
            ->where("status","!=",4)
            ->where("status","!=",10)
            ->where("status","!=",11)
            ->get();
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
    //[4,6,7,9,10,11]
    public static function getLogs($uid,$filter_option,$group=[])
    {
        $log = self::leftJoin("pre_group_buying_item",function ($join) {
            $join->on("pre_group_buying_log.item_id","=","pre_group_buying_item.id");
        })
            ->select(DB::raw("pre_group_buying_item.*,pre_group_buying_log.*,pre_group_buying_log.premium as order_premium"))
            ->where("uid", $uid);

        foreach ($filter_option as $status)
        {
            $log = $log
                ->where("status","!=",$status);
        }
        if (!empty($group))
        {
            $log = $log->whereIn("pre_group_buying_log.group_id",$group);

        }
        $data = $log->get();
        foreach ($data as &$value)
        {
            //对现货商品进行处理
            if ($value->group_id == 0)
            {
                $stock_item_info = GroupBuyingStockItemTypeModel::getOne($value->item_id);

                $value->item_name = $stock_item_info["info"]->item_name;
                $value->item_image = $stock_item_info["info"]->item_image;
                $value->item_freight = 0;
                $detail_arr = [];

                foreach ($stock_item_info["detail"] as $d)
                {

                    foreach (json_decode($value->order_info,true) as $tp => $num)
                    {
                        if ($d->size."_".$d->color == $tp)
                        {
                            $tp_arr = explode("_",$tp);
                            $detail_arr[$d->id]["stock_id"] = $d->id;
                            $detail_arr[$d->id]["item_size"] =  $tp_arr[0];
                            $detail_arr[$d->id]["item_color"] =  $tp_arr[1];
                            $detail_arr[$d->id]["buy_num"] =  $num;
                            break;
                        }
                    }
                }
                $value->order_detail = $detail_arr;
            }
        }
        return $data;
//        $log = $log
//            ->where("status","!=",4)//取消
//            ->where("status","!=",7)//流团
//            ->where("status","!=",9)//下架
//            ->where("status","!=",10)//受影响流团
//            ->where("status","!=",11)//跑单
//            ->get();
    }

    public static function getNotCancelLog($group_id, $counter = true, $uid = 0)
    {
        $log = self::leftJoin("pre_group_buying_item",function ($join) {
                $join->on("pre_group_buying_log.item_id","=","pre_group_buying_item.id");
            })
            ->select(DB::raw("pre_group_buying_item.*,pre_group_buying_log.*,pre_group_buying_log.premium as order_premium"))
            ->where("pre_group_buying_log.group_id",$group_id);

        if ($uid)
        {
            $log = $log->where("uid", $uid);
        }
        $log = $log
            ->where("status","!=",4)//取消
            ->where("status","!=",7)//流团
            ->where("status","!=",9)//下架
            ->where("status","!=",10)//受影响流团
            ->where("status","!=",11)//跑单
            ->get();
        $data = [];
        if (!$counter)
        {
            return $log;
        }

        foreach ($log as $value)
        {
            $data[User_model::find($value->uid)->username]["item"] .= $value->item_name . $value->order_info . "<br />";
            $data[User_model::find($value->uid)->username]["price"] += $value->order_price;
            $data[User_model::find($value->uid)->username]["premium"] += $value->order_premium;
            $data[User_model::find($value->uid)->username]["uid"] = $value->uid;
            !in_array($value->item_name,$data[User_model::find($value->uid)->username]["item_type"]) && $data[User_model::find($value->uid)->username]["item_type"][] = $value->item_name;
            foreach (json_decode($value->order_info,true) as $type => $num)
            {
                $data[User_model::find($value->uid)->username]["shopping_num"] += $num;
            }
        }

        return $data;
    }
}
