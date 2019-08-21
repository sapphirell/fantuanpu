<?php

namespace App\Http\Controllers\SukiWeb;

use App\Http\DbModel\GroupBuyingItemModel;
use App\Http\DbModel\GroupBuyingLogModel;
use App\Http\DbModel\GroupBuyingStockItemModel;
use App\Http\DbModel\GroupBuyingStockItemTypeModel;
use App\Http\DbModel\User_model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GroupBuyingCoreController extends Controller
{
    public static function buy_stock($uid, $item_id, $order_info)
    {
        $item = GroupBuyingStockItemTypeModel::getOne($item_id);

        if (empty($item))
        {
            return self::response([], 40002, "不存在该团购商品");
        }

        $order_info = json_decode($order_info, true);
        if (empty($order_info))
        {
            return self::response([], 40002, "订单详情为空");
        }


        $order_price = 0;
        $premium = 0;
        foreach ($order_info as $key => $buy_num)
        {
            if ($buy_num <= 0)
            {
                return self::response([], 40003, "欲购商品数量必须大于0");
            }

            //            dd($info);
            $colorSizeNotExistsFlag = true;
            foreach ($item["detail"] as $item_stock_detail)
            {
                if ($item_stock_detail->size."_".$item_stock_detail->color == $key)
                {
                    $colorSizeNotExistsFlag = false;
                    $order_price += $buy_num * $item_stock_detail->price;
                    $item_stock_detail->stock -= $buy_num;
                    $item_stock_detail->save();
                    break;
                }
            }

            if ($colorSizeNotExistsFlag)
            {
                return self::response([], 40003, "商品不存在该尺寸或颜色");
            }


        }

        $orderLog = new GroupBuyingLogModel();
        $orderLog->uid = $uid;
        $orderLog->item_id =  $item_id;
        $orderLog->status = 1;
        $orderLog->group_id = 0;
        //        $orderLog->address = $request->input("address");
        $orderLog->private_freight = 0;
        //        $orderLog->name = $request->input("name");
        //        $orderLog->telphone = $request->input("telphone");
        $orderLog->premium = $premium;
        $orderLog->create_date = date("Y-m-d H:i:s");
        $orderLog->end_date = 0;
        $orderLog->order_info = json_encode($order_info);
        $orderLog->order_price = $order_price;
        //        $orderLog->qq = $request->input("qq");
        $orderLog->save();


        return self::response();
    }
}
