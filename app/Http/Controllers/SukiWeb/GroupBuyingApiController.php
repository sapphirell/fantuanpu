<?php

namespace App\Http\Controllers\SukiWeb;

use App\Http\DbModel\GroupBuyingAddressModel;
use App\Http\DbModel\GroupBuyingStockItemModel;
use App\Http\DbModel\GroupBuyingStockItemTypeModel;
use App\Http\DbModel\UserTicketModel;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\DbModel\CommonMemberCount;
use App\Http\DbModel\GroupBuyingExpressModel;
use App\Http\DbModel\GroupBuyingItemModel;
use App\Http\DbModel\GroupBuyingLogModel;
use App\Http\DbModel\GroupBuyingModel;
use App\Http\DbModel\GroupBuyingOrderModel;
use App\Http\DbModel\User_model;

class GroupBuyingApiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data["count"] = CommonMemberCount::find($this->data['user_info']->uid);
    }
    public function suki_group_buying_item(Request $request)
    {
        $this->data['lastGroupingInfo'] = GroupBuyingModel::getLastGroup();
        $chk = $this->checkRequest($request, ["order_info", "item_id", "qq"]);
        if ($chk !== true)
        {
            return self::response([], 40001, "缺少参数" . $chk);
        }

        $item = GroupBuyingItemModel::find($request->input("item_id"));
        $item->item_color = explode("|", $item->item_color);
//        var_dump( $item->item_size);
        $item->item_size = explode("|", $item->item_size);

        if (empty($item))
        {
            return self::response([], 40002, "不存在该团购商品");
        }

        $order_info = json_decode($request->input("order_info"), true);
        if (empty($order_info))
        {
            return self::response([], 40002, "订单详情为空");
        }

        $order_price = 0;
        $premium = 0;
        foreach ($order_info as $key => $value)
        {
            if ($value <= 0)
            {
                return self::response([], 40003, "欲购商品数量必须大于0");
            }
            $info = explode("_", $key);
            if (!in_array($info[0], $item->item_size))
            {
                return self::response([], 40003, "商品不存在该尺寸");
            }
            if (!in_array($info[1], $item->item_color))
            {
                return self::response([], 40003, "商品不存在该颜色" . var_export($info[1],true) . "只有" . var_export($item->item_color, true));
            }
            $premium += $value * $item->premium;
            $order_price += $value * $item->premium + $value * $item->item_price; // 辛苦费+商品原价
        }

        //        $order_price += $item->item_freight / $item->min_members  + 15; //公摊运费+私人运费

        $orderLog = new GroupBuyingLogModel();
        $orderLog->uid = $this->data['user_info']->uid;
        $orderLog->item_id = $item->id;
        $orderLog->status = 1;
        $orderLog->group_id = $item->group_id;
        //        $orderLog->address = $request->input("address");
        $orderLog->private_freight = 0;
        //        $orderLog->name = $request->input("name");
        //        $orderLog->telphone = $request->input("telphone");
        $orderLog->premium = $premium;
        $orderLog->create_date = date("Y-m-d H:i:s");
        $orderLog->end_date = $this->data['lastGroupingInfo']->enddate;
        $orderLog->order_info = $request->input("order_info");
        $orderLog->order_price = $order_price;
        //        $orderLog->qq = $request->input("qq");
        $orderLog->save();

        if (!$this->data['user_info']->qq)
        {

            $user = User_model::find($this->data['user_info']->uid);
            $user->qq = $request->input("qq");
            $user->save();
            User_model::flushUserCache($this->data['user_info']->uid);
        }
        return self::response();

    }
    public function suki_group_buying_do_deliver(Request $request)
    {
        $chk = $this->checkRequest($request,["orders","province_type"]);

        if ($chk !== true)
        {
            return self::response([], 40001, "缺少参数" . $chk);
        }

        $freight = 0;
        switch ($request->input("province_type"))
        {
            case 1 :
                $freight = 5.5;
                break;
            case 2 :
                $freight = 7;
                break;
            case 3 :
                $freight = 18;
                break;
        }
        //        dd($request->input("orders"));
        $address = GroupBuyingAddressModel::get_my_address($this->data["user_info"]->uid);
        //遍历订单获得价格
        $user_orders = GroupBuyingOrderModel::where("uid","=",$this->data["user_info"]->uid)->where("status","=",4)
            ->whereIn('id',$request->input("orders"))->get();
        if (empty($user_orders))
        {
            return self::response([],40002,"订单已经提交了");
        }
        $private_freight = 0;
        $price_difference = 0;
        $log_arr = [];
        foreach ($user_orders as $value)
        {
            $private_freight += ($value->true_private_freight?:$value->private_freight);
            $price_difference += (($value->true_price ? ($value->true_price - $value->order_price):0));
            $value->status = 6;
            $value->save();
            //合并要标记为发货的log_id
            $log_arr = array_merge($log_arr, json_decode($value->log_id,true));
        }
        $express = new GroupBuyingExpressModel();
        $express->freight = $freight;
        $express->private_freight = $private_freight;
        $express->price_difference = $price_difference;
        $express->name = $address->name;
        $express->telphone = $address->telphone;
        $express->address = $address->address;
        $express->freight = $freight;
        $express->uid = $this->data["user_info"]->uid;
        $express->orders = json_encode($request->input("orders"));
        $express->save();
        //把商品购买的信息都编辑为5

        foreach ($log_arr as $log_id)
        {
            $log = GroupBuyingLogModel::find($log_id);
            $log->status = 5;
            $log->save();
        }
        return self::response();
    }
    public function suki_group_buying_confirm_orders(Request $request)
    {
        $chk = $this->checkRequest($request,["orderId"]);
        if ($chk !== true)
        {
            return self::response([], 40001, "缺少参数" . $chk);
        }

        $this->data["orders"] = GroupBuyingOrderModel::where(["id" => $request->input("orderId")])->first();
        if (empty($this->data["orders"]))
        {
            return self::response([], 40002, "缺少orders");
        }
        if ($this->data["orders"]->status != 1)
        {
            return self::response([], 40003, "订单状态不对");
        }
        $this->data["orders"]->status = 2;
        $this->data["orders"]->name = $request->input("name");
        $this->data["orders"]->telphone = $request->input("telphone");
        $this->data["orders"]->qq = $request->input("qq");
        $this->data["orders"]->address = $request->input("address");
        $this->data["orders"]->save();
        foreach (json_decode($this->data["orders"]->log_id,true) as $lid)
        {
            $log = GroupBuyingLogModel::find($lid);
            $log->status = 8;
            $log->save();
        }
        return self::response();
    }
    public function suki_group_buying_cancel_orders(Request $request)
    {
        if (!$request->input("orderId"))
        {
            return self::response([], 40001, "缺少参数orderId");
        }
        $this->data["orders"] = GroupBuyingLogModel::where(["id" => $request->input("orderId")])->first();
        if (empty($this->data["orders"]))
        {
            return self::response([], 40002, "缺少orders");
        }

        if ($this->data["orders"]->status != 1 && $this->data["orders"]->status != 2)
        {
            return self::response([], 40003, "订单状态不对");
        }
        $this->data["orders"]->status = 4;
        $this->data["orders"]->save();

        return self::response();
    }

    public function save_address(Request $request)
    {
        if (!$request->input("name"))
        {
            return self::response([],40001,"缺少参数name");
        }
        if (!$request->input("address"))
        {
            return self::response([],40001,"缺少参数address");
        }
        if (!$request->input("telphone"))
        {
            return self::response([],40001,"缺少参数telphone");
        }

        GroupBuyingAddressModel::save_address(
            $request->input("name"),
            $request->input("address"),
            $request->input("telphone"),
            $this->data["user_info"]->uid
        );
        return self::response();
    }

    public function suki_buy_stock_items(Request $request)
    {
        $chk = $this->checkRequest($request, ["order_info", "item_id"]);
        if ($chk !== true)
        {
            return self::response([], 40001, "缺少参数" . $chk);
        }


    }

    public function suki_group_buying_select_ticket(Request $request)
    {
        $chk = $this->checkRequest($request, ["user_ticket_id"]);
        if ($chk !== true)
        {
            return self::response([], 40001, "缺少参数" . $chk);
        }
        $userTickets = UserTicketModel::getActiveTicket($this->data["user_info"]->uid);
        foreach ($userTickets as $ticket)
        {
            if ($ticket->user_ticket_id == $request->input("user_ticket_id"))
            {
                $ticket->status = 4;
            }
            else
            {
                $ticket->status = 1;
            }
            $ticket->save();
        }
        return redirect()->route("suki_group_buying_myorders");
    }
}
