<?php

namespace App\Http\Controllers\Admincp;

use App\Http\DbModel\GroupBuyingItemModel;
use App\Http\DbModel\GroupBuyingLogModel;
use App\Http\DbModel\GroupBuyingModel;
use App\Http\DbModel\GroupBuyingOrderModel;
use App\Http\DbModel\User_model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GroupBuyingController extends Controller
{
    public function __construct()
    {
        $this->data['left_nav'] = [
            'add_group_buying_item'  => '添加商品',
            'show_group_buying_list' => '团购管理',
        ];
    }

    public function add_group_buying_item()
    {

        return view('PC/Admincp/AddGroupBuyingItem')->with('data', $this->data);
    }

    public function show_group_buying_list()
    {
        $this->data["list"] = GroupBuyingModel::get();

        //        dd( $this->data["list"]);
        return view('PC/Admincp/ShowGroupBuyingList')->with('data', $this->data);
    }

    public function review_orders(Request $request)
    {
        $this->data["group_buying"] = GroupBuyingModel::find($request->input("id"));

        $this->data["list"] = GroupBuyingItemModel::getListInfo($request->input("id"));

        return view('PC/Admincp/ReviewOrders')->with('data', $this->data);
    }

    public function add_action(Request $request)
    {
        $chk = $this->checkRequest(
            $request,
            [
                "item_name",
                "item_image",
                "item_size",
                "item_color",
                "item_price",
                "premium",
                "min_members",
                "item_freight",
            ]
        );
        if ($chk !== true)
        {
            return self::response([], 40001, "缺少参数");
        }

        $groupInfo = GroupBuyingModel::getLastGroup();


        $item               = new GroupBuyingItemModel();
        $item->item_name    = $request->input("item_name");
        $item->item_image   = $request->input("item_image");
        $item->item_price   = $request->input("item_price");
        $item->item_freight = $request->input("item_freight");
        $item->group_id     = $groupInfo->id;
        $item->premium      = $request->input("premium");
        $item->item_color   = $request->input("item_color");
        $item->item_size    = $request->input("item_size");
        $item->min_members  = $request->input("min_members");
        $item->save();

        return self::response();
    }

    //清算本期订单
    public function settle_orders(Request $request)
    {
        $groupId = $request->input("id");
        if (!$groupId)
        {
            return self::response([], 40001, "缺少参数id");
        }
        $this->data["list"] = GroupBuyingItemModel::getListInfo($groupId);


        foreach ($this->data["list"] as $items)
        {
            if ($items["item_count"] >= $items["min_members"])    //成团
            {
                //获取该商品都有哪些人买了
                $logs = GroupBuyingLogModel::where(["item_id" => $items["id"], "status" => 1])->get();
                GroupBuyingLogModel::where(["item_id" => $items["id"], "status" => 1])->update(["status" => 2]);

                $insertOrder = [];

                foreach ($logs as $log)
                {
                    //对订单依照uid进行分组
                    foreach (json_decode($log->order_info, true) as $key => $item_feature)
                    {
                        $insertOrder[ $log->uid ][ $log->item_id ]["detail"][ $key ] += $item_feature;
                        $insertOrder[ $log->uid ][ $log->item_id ]["private_freight"] = $items["item_freight"] / $items["follow"];

                    }
                    $insertOrder[ $log->uid ]["log_id"][] = $log->id;
                    $insertOrder[ $log->uid ][ $log->item_id ]["order_price"] += $log->order_price;
                }

                //对订单进行分批入库,生成订单
                foreach ($insertOrder as $uid => $insert_item)
                {
                    $usrPrivateFreight = 0;
                    $usrOrderPrice     = 0;
                    //                    dd($insert_item);
                    foreach ($insert_item as $item_order_detail)
                    {
                        $usrPrivateFreight += $item_order_detail["private_freight"];
                        $usrOrderPrice += $item_order_detail["order_price"];
                    }
                    //                    dd($usrOrderPrice);
                    $order                  = new GroupBuyingOrderModel();
                    $order->uid             = $uid;
                    $order->order_info      = json_encode($insert_item);
                    $order->status          = 1;
                    $order->private_freight = $usrPrivateFreight;
                    $order->order_price     = $usrOrderPrice;
                    $order->log_id          = json_encode($insert_item["log_id"]);
                    $order->group_id        = $groupId;
                    $order->save();
                }

            }
            else //流团
            {
                GroupBuyingLogModel::where(["item_id" => $items["id"], "status" => 1])->update(["status" => 7]);
            }

        }

        $g         = GroupBuyingModel::find($groupId);
        $g->status = 3;
        $g->save();

        return self::response();
    }

    //查看一个商品的参团者
    public function items_participant(Request $request)
    {
        $this->data["list"] = GroupBuyingLogModel::where(["item_id" => $request->input("id")])->where("status", "<>", 4)->get();
        foreach ($this->data["list"] as &$value)
        {
            $user_info         = User_model::find($value->uid);
            $value["username"] = $user_info->username;
            $value["qq"] = $user_info->qq;

        }

        //        dd($this->data);
        return view('PC/Admincp/ItemsParticipant')->with('data', $this->data);
    }

    public function participant(Request $request)
    {
        $this->data["list"] = GroupBuyingOrderModel::where(["group_id"=>$request->input("id")])->get();
        return view('PC/Admincp/Participant')->with('data', $this->data);
    }
}
