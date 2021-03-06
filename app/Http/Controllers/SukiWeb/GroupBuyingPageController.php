<?php

namespace App\Http\Controllers\SukiWeb;

use App\Http\DbModel\GroupBuyingStockItemModel;
use App\Http\DbModel\GroupBuyingStockItemTypeModel;
use App\Http\DbModel\UserTicketModel;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\DbModel\CommonMemberCount;
use App\Http\DbModel\GroupBuyingAddressModel;
use App\Http\DbModel\GroupBuyingExpressModel;
use App\Http\DbModel\GroupBuyingItemModel;
use App\Http\DbModel\GroupBuyingLogModel;
use App\Http\DbModel\GroupBuyingModel;
use App\Http\DbModel\GroupBuyingOrderModel;
use App\Http\DbModel\User_model;

use Illuminate\Support\Facades\DB;

class GroupBuyingPageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data["count"] = CommonMemberCount::find($this->data['user_info']->uid);

    }

    //suki的团购
    public function suki_group_buying(Request $request)
    {
        if ($request->input("gid")) {
            $this->data['lastGroupingInfo'] = GroupBuyingModel::find($request->input("gid"));
        } else {
            $this->data['lastGroupingInfo'] = GroupBuyingModel::getLastGroup();

        }

        //        $group_id = $type == "stock" ? 0 : $this->data['lastGroupingInfo']->id;
        if ($this->data['lastGroupingInfo']) {
            $this->data['items'] = GroupBuyingItemModel::getListInfo($this->data['lastGroupingInfo']->id, false);
            foreach ($this->data['items'] as & $value) {
                $value['item_image'] = explode("|", $value['item_image']);
                $value['item_color'] = explode("|", $value['item_color']);
                $value['item_size']  = explode("|", $value['item_size']);
            }
        }


        return view('PC/Suki/SukiGroupBuying')->with('data', $this->data);
    }

    public function suki_group_buying_stock(Request $request)
    {
        $this->data["type"]  = "stock";
        $this->data['items'] = GroupBuyingStockItemTypeModel::getList();
        $this->data['items'] = [];

        return view('PC/Suki/SukiGroupBuyingStock')->with('data', $this->data);
    }

    public function suki_group_buying_stock_item(Request $request)
    {
        $this->data["item_info"]             = GroupBuyingStockItemTypeModel::find($request->input("item_id"));
        $this->data["item_info"]->item_image = explode("|", $this->data["item_info"]->item_image);
        $this->data["item_info"]->items      = GroupBuyingStockItemModel::getList($request->input("item_id"));

        return view('PC/Suki/SukiGroupBuyingStockItem')->with('data', $this->data);
    }

    public function suki_group_buying_item_info(Request $request)
    {
        $this->data["item_info"]  = GroupBuyingItemModel::find($request->input("item_id"));
        $this->data["group_info"] = GroupBuyingModel::find($this->data["item_info"]->group_id);

        $this->data["item_info"]->item_image = explode("|", rtrim($this->data["item_info"]->item_image, "|"));
        $this->data["item_info"]->item_color = explode("|", $this->data["item_info"]->item_color);
        $this->data["item_info"]->item_size  = explode("|", $this->data["item_info"]->item_size);
        $item_follow                         = GroupBuyingLogModel::getNotCancelItemsLog($request->input("item_id"));
        $this->data["item_follow"]           = $item_follow["item_count"];
        $this->data["item_member"]           = $item_follow["member_count"];


        return view('PC/Suki/SukiGroupBuyingItemInfo')->with('data', $this->data);
    }

    public function suki_group_buying_myorders(Request $request)
    {
        if ($request->input("debug")) {
            $this->data["user_info"]->uid = 51485;
        }
        if ($request->input("type") == 'last') {
            $filter             = [4, 6, 7, 9];
            $group              = [10];
            $this->data["type"] = "active";
        } else {
            $filter             = [];
            $group              = [];
            $this->data["type"] = "history";
        }
        //正在进行的
        $this->data["active_logs"] = GroupBuyingLogModel::getLogs($this->data["user_info"]->uid, $filter, $group);
        //        dd(    $this->data["active_logs"] );
        foreach ($this->data["active_logs"] as $value) {

            $value->sum_private_freight = round($value->item_freight / GroupBuyingLogModel::getNotCancelItemsLog($value["item_id"])['member_count'],
                2);


        }
        //待申请发货的列表
        $this->data["my_order"] = GroupBuyingOrderModel::where(["uid"    => $this->data["user_info"]->uid,
                                                                "status" => 4
        ])->get();
        foreach ($this->data["active_logs"] as &$value) {
            $value->item_image = explode("|", $value->item_image)[0];
        }
        //地址
        $this->data["address"] = GroupBuyingAddressModel::get_my_address($this->data["user_info"]->uid);
        //发货列表
        $this->data["express"] = GroupBuyingExpressModel::get_my_express($this->data["user_info"]->uid);
        //我在使用的优惠券
        $this->data["tickets"] = UserTicketModel::getWantToUseTicket($this->data["user_info"]->uid);

        //        dd( $this->data["express"]);

        return view('PC/Suki/SukiGroupBuyingMyOrders')->with('data', $this->data);
    }

    public function suki_group_buying_my_stock(Request $request)
    {
        if ($request->input("debug")) {
            $this->data["user_info"]->uid = 51485;
        }
        if ($request->input("type") == 'last') {
            $filter             = [4, 6, 7, 9];
            $group              = [0];
            $this->data["type"] = "active";
        } else {
            $filter             = [];
            $group              = [0];
            $this->data["type"] = "history";
        }
        //地址
        $this->data["address"] = GroupBuyingAddressModel::get_my_address($this->data["user_info"]->uid);
        //正在进行的
        $this->data["active_logs"] = GroupBuyingLogModel::getLogs($this->data["user_info"]->uid, $filter, $group);
        //我在使用的优惠券
        $this->data["tickets"] = UserTicketModel::getWantToUseTicket($this->data["user_info"]->uid);
        //未付款地订单
        $this->data["not_pay_order"] = GroupBuyingOrderModel::where(["uid"      => $this->data["user_info"]->uid,
                                                                     "status"   => 1,
                                                                     "group_id" => 0
            ])->get();
        //待申请发货的列表
        $this->data["my_order"] = GroupBuyingOrderModel::where(["uid"    => $this->data["user_info"]->uid,
                                                                "status" => 4
        ])->get();
        if ($request->input("debug")) {
            dd(($this->data["my_order"]));
        }
        return view('PC/Suki/SukiGroupBuyingMyStockOrders')->with('data', $this->data);
    }

    public function suki_group_buying_address_manager(Request $request)
    {
        $this->data["my_address"] = GroupBuyingAddressModel::get_my_address($this->data["user_info"]->uid);

        //        dd($this->data["my_address"] );
        return view('PC/Suki/SukiGroupBuyingAddressManager')->with('data', $this->data);
    }
    //    public function suki_group_buying_myorders(Request $request)
    //    {
    //        $type = $request->input("type") ?: "all";
    //        $my_orders = GroupBuyingLogModel::leftJoin("pre_group_buying_item","pre_group_buying_item.id","=","pre_group_buying_log.item_id")
    //            ->select(DB::raw("pre_group_buying_log.* ,pre_group_buying_item.*,pre_group_buying_log.id as log_id"))
    //            ->where(["pre_group_buying_log.uid" => $this->data['user_info']->uid]);
    //        $last_group = GroupBuyingModel::getLastGroup(false);
    //        $orderInfo = GroupBuyingOrderModel::where("uid",$this->data["user_info"]->uid)->where("group_id",$last_group->id)->orderBy("id","desc")->first();
    //        if ($type == "all")
    //        {
    //            $my_orders = $my_orders->orderBy("pre_group_buying_log.id", "desc")->get();
    //        }
    //        else
    //        {
    //
    //            $gid        = empty($last_group) ? 0 : $last_group->id;
    //            $my_orders  = $my_orders->where("pre_group_buying_log.group_id" ,$gid)->where("pre_group_buying_log.status","!=", "4")->get();
    //            //当前是否可以提交付款证明
    //
    //            $this->data["order_commit_status"] = empty($orderInfo->status) ? -1 : $orderInfo->status;
    //
    //        }
    //
    //        $this->data["orders"] = $my_orders;
    //        $this->data["order_info"]["status"] = 0;
    //        $this->data["order_info"]["private_freight"] = $orderInfo->private_freight;
    //        $this->data["order_info"]["all_price"] = $orderInfo->order_price;
    //        $this->data["order_info"]["true_private_freight"] = $orderInfo->true_private_freight;
    //        $this->data["order_info"]["true_price"] = $orderInfo->true_price;
    //        $this->data["order_info"]["id"] = $orderInfo->id;
    //
    //        foreach ($this->data["orders"] as & $value)
    //        {
    //            $value->order_info = json_decode($value->order_info, true);
    //            //订单的集合状态
    //            if (!$this->data["order_info"]["status"] || $this->data["order_info"]["status"] == $value->status)
    //                $this->data["order_info"]["status"] = $value->status ;
    //        }
    //
    //        //        dd($this->data["orders"] );
    //
    //        return view('PC/Suki/SukiGroupBuyingMyOrders')->with('data', $this->data);
    //    }

    public function suki_group_buying_paying(Request $request)
    {
        if (!$request->input("gid") && $request->input("gid") !== "0") {
            return self::response([], 40001, "缺少参数gid");
        }
        if ($request->input("gid") === "0") {
            //先查询是否还未付款的订单
            $notPayOrder = GroupBuyingOrderModel::where("uid", "=", $this->data["user_info"]->uid)->where("status", "=",
                "1")->get();

            if (!$notPayOrder->isEmpty()) {
                die("还有尚未付款的订单");
            }
            //stock items
            $submit_logs = GroupBuyingLogModel::getLogs($this->data["user_info"]->uid, [2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                [0]);
            //打包为order
            $order_info  = [
                "log_id" => [],
            ];
            $order_price = 0;
            //            dd($submit_logs);
            if ($submit_logs->isEmpty()) {
                die("暂无需要打包的订单");
            }
            foreach ($submit_logs as $submit_log) {
                $order_price += $submit_log->order_price;
                foreach ($submit_log->order_detail as $stock_item_id => $buy_detail) {
                    $order_info[$submit_log->item_id][$stock_item_id]["num"]                 += $buy_detail["buy_num"];
                    $order_info[$submit_log->item_id][$stock_item_id]["detail"]["size"]      = $buy_detail['item_size'];
                    $order_info[$submit_log->item_id][$stock_item_id]["detail"]["color"]     = $buy_detail['item_color'];
                    $order_info[$submit_log->item_id][$stock_item_id]["detail"]["item_name"] = $submit_log->item_name;
                    $order_info["log_id"][]                                                  = $submit_log->id;

                    $log         = GroupBuyingLogModel::find($submit_log->id);
                    $log->status = 2;
                    $log->save();
                }

            }
            $userSelectedTicket  = UserTicketModel::getWantToUseTicketList();
            $this->data["order"] = GroupBuyingOrderModel::createOrder($this->data["user_info"]->uid, $order_info, 0,
                $order_price, $userSelectedTicket, 0);

        } else {
            $this->data["order"] = GroupBuyingOrderModel::where(["uid"      => $this->data["user_info"]->uid,
                                                                 "group_id" => $request->input("gid")
                ])->first();
        }

        return view('PC/Suki/SukiGroupBuyingPaying')->with('data', $this->data);
    }

    public function suki_group_buying_deliver(Request $request)
    {
        $this->data["type"] = $request->input("type") ?: 1;
        if ($this->data["type"] == 1) {
            $this->data["my_order"] = GroupBuyingOrderModel::where(["uid" => $this->data["user_info"]->uid])->get();

            //        dd( $this->data["user_info"]);
            //查询用户的收货地址,如果没有取用户最后一次order的,并存储到用户的地址管理里

            $this->data["address"] = GroupBuyingAddressModel::where(["uid" => $this->data["user_info"]->uid])->select()->first();

            if (empty($this->data["address"]) && $this->data["my_order"][0]->address) {

                $this->data["address"] = GroupBuyingAddressModel::save_address($this->data["my_order"][0]->name,
                    $this->data["my_order"][0]->address, $this->data["my_order"][0]->telphone,
                    $this->data["user_info"]->uid);

            }

        } else {
            $this->data["my_express"] = GroupBuyingExpressModel::where(["uid" => $this->data["user_info"]->uid])->get();
        }


        return view('PC/Suki/SukiGroupBuyingDeliver')->with('data', $this->data);
    }

    public function suki_group_buying_my_ticket(Request $request)
    {
        $this->data["my_ticket"] = UserTicketModel::getActiveTicket($this->data["user_info"]->uid);
        $this->data["ori_route"] = $request->input("ori_route");

        return view('PC/Suki/SukiUserTicket')->with('data', $this->data);
    }



}
