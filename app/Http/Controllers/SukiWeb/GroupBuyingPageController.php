<?php

namespace App\Http\Controllers\SukiWeb;

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
        $this->data['lastGroupingInfo'] = GroupBuyingModel::getLastGroup();
        if ($this->data['lastGroupingInfo'])
        {
            $this->data['items'] = GroupBuyingItemModel::getListInfo($this->data['lastGroupingInfo']->id,false);
            foreach ($this->data['items'] as & $value)
            {
                $value['item_image'] = explode("|", $value['item_image']);
                $value['item_color'] = explode("|", $value['item_color']);
                $value['item_size'] = explode("|", $value['item_size']);
            }
        }


        return view('PC/Suki/SukiGroupBuying')->with('data', $this->data);
    }

    public function suki_group_buying_item_info(Request $request)
    {
        //        //上一次购买记录
        //        $this->data["last"] = GroupBuyingLogModel::where(["uid" => $this->data["user_info"]->uid])->orderBy(
        //            "create_date",
        //            "desc"
        //        )->first();


        $this->data["item_info"] = GroupBuyingItemModel::find($request->input("item_id"));
        $this->data["group_info"] = GroupBuyingModel::find($this->data["item_info"]->group_id);

        $this->data["item_info"]->item_image = explode("|", $this->data["item_info"]->item_image);
        $this->data["item_info"]->item_color = explode("|", $this->data["item_info"]->item_color);
        $this->data["item_info"]->item_size = explode("|", $this->data["item_info"]->item_size);
        $item_follow = GroupBuyingLogModel::getNotCancelItemsLog( $request->input("item_id"));
        $this->data["item_follow"] = $item_follow["item_count"];
        $this->data["item_member"] = $item_follow["member_count"];


        return view('PC/Suki/SukiGroupBuyingItemInfo')->with('data', $this->data);;
    }
    public function suki_group_buying_myorders(Request $request)
    {
        //取正在运营中的一期团购里,该用户买的所有商品
        $group_info = GroupBuyingModel::getLastGroup();
        if ($group_info)
        {
            $this->data["logs"] = GroupBuyingLogModel::getNotCancelLog($group_info->id,true,$this->data["user_info"]->uid);
        }
        dd(  $this->data["logs"]);
        return view('PC/Suki/SukiGroupBuyingMyOrders')->with('data', $this->data);
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

        return view('PC/Suki/SukiGroupBuyingPaying')->with('data', $this->data);
    }

    public function suki_group_buying_deliver(Request $request)
    {
        //        if ($request->input("debug") == "1")
        //        {
        //            $this->data["user_info"]->uid = 49294;
        //        }
        $this->data["type"] = $request->input("type") ? : 1;
        if ($this->data["type"] == 1){
            $this->data["my_order"] = GroupBuyingOrderModel::where(["uid" => $this->data["user_info"]->uid])->get();

            //        dd( $this->data["user_info"]);
            //查询用户的收货地址,如果没有取用户最后一次order的,并存储到用户的地址管理里

            $this->data["address"] = GroupBuyingAddressModel::where(["uid" => $this->data["user_info"]->uid])->select()->first();

            if (empty($this->data["address"]) && $this->data["my_order"][0]->address)
            {

                $this->data["address"] = GroupBuyingAddressModel::save_address(
                    $this->data["my_order"][0]->name,
                    $this->data["my_order"][0]->address,
                    $this->data["my_order"][0]->telphone,
                    $this->data["user_info"]->uid
                );

            }

        }
        else
        {
            $this->data["my_express"] = GroupBuyingExpressModel::where(["uid" => $this->data["user_info"]->uid])->get();
        }


        return view('PC/Suki/SukiGroupBuyingDeliver')->with('data', $this->data);
    }


}
