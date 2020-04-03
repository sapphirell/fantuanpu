<?php

namespace App\Http\Controllers\Admincp;

use App\Http\Controllers\System\TestController;
use App\Http\DbModel\GroupBuyingExpressModel;
use App\Http\DbModel\GroupBuyingItemModel;
use App\Http\DbModel\GroupBuyingLogModel;
use App\Http\DbModel\GroupBuyingModel;
use App\Http\DbModel\GroupBuyingOrderModel;
use App\Http\DbModel\GroupBuyingStockItemModel;
use App\Http\DbModel\GroupBuyingStockItemTypeModel;
use App\Http\DbModel\User_model;
use App\Http\DbModel\UserTicketModel;
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
            'order_delivers'         => '发货管理',
            'stock_item'             => '现货收款',
            'add_stock'              => '新增现货种类',
            'stock_list'             => '现货列表',
            'orders_list'            => '未打包列表',
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

        $this->data["list"]          = GroupBuyingItemModel::getListInfo($request->input("id"));
        $this->data["request"]["id"] = $request->input("id");
        $this->data["request"]["l"]  = $request->input("l");
        $this->data["now"]           = GroupBuyingModel::getLastGroup("active");

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
        $groupId    = $request->input("id");
        $stockItems = [];
        if (!$groupId)
        {
            return self::response([], 40001, "缺少参数id");
        }
        $this->data["list"] = GroupBuyingItemModel::getListInfo($groupId, false);

        $insertOrder = [];
        foreach ($this->data["list"] as $items)
        {
            if ($items["item_count"] >= $items["min_members"])    //成团
            {

                //获取该商品都有哪些人买了
                $logs = GroupBuyingLogModel::where(["item_id" => $items["id"], "status" => 1])->get();
                GroupBuyingLogModel::where(["item_id" => $items["id"], "status" => 1])->update(["status" => 2]);

                foreach ($logs as $log)
                {
                    //对订单依照uid进行分组
                    foreach (json_decode($log->order_info, true) as $key => $item_feature)
                    {
                        $insertOrder[ $log->uid ][ $log->item_id ] ["item_detail"] = $items;
                        $insertOrder[ $log->uid ][ $log->item_id ]["detail"][ $key ] += $item_feature;
                        $insertOrder[ $log->uid ][ $log->item_id ]["private_freight"] = $items["item_freight"] / $items["follow"];

                    }
                    $insertOrder[ $log->uid ]["log_id"][] = $log->id;
                    $insertOrder[ $log->uid ][ $log->item_id ]["order_price"] += $log->order_price;
                }

            }
            else //流团
            {
                GroupBuyingLogModel::where(["item_id" => $items["id"], "status" => 1])->update(["status" => 7]);
            }

        }
        //        dd($insertOrder);
        //查询用户所选择的对应的优惠券
        $userSelectedTicket = UserTicketModel::getWantToUseTicketList();
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
            GroupBuyingOrderModel::createOrder(
                $uid,
                $insert_item,
                $usrPrivateFreight,
                $usrOrderPrice,
                $userSelectedTicket,
                $groupId
            );
        }
        //                    dd($usrOrderPrice);


        $g         = GroupBuyingModel::find($groupId);
        $g->status = 3;
        $g->save();

        return self::response();
    }

    //查看一个商品的参团者
    public function items_participant(Request $request)
    {
        $this->data["list"] = GroupBuyingLogModel::where("item_id" ,$request->input("id"))->where("group_id", "!=", 0)
            ->where("status", "<>", 4)
            //            ->where("status", "<>", 10)
            ->where("status", "<>", 11)
            ->get();

        $this->data["count_info"] = [];
        foreach ($this->data["list"] as &$value)
        {
            $user_info         = User_model::find($value->uid);
            $value["username"] = $user_info->username;
            $value["qq"]       = $user_info->qq;


            foreach (json_decode($value->order_info, true) as $k => $num)
            {
                $this->data["count_info"][ $k ] += $num;
            }

        }

        //        dd($this->data);
        return view('PC/Admincp/ItemsParticipant')->with('data', $this->data);
    }

    public function participant(Request $request)
    {
        $groupBuying          = GroupBuyingModel::find($request->input("id"));
        $this->data["status"] = $groupBuying->status;
        if ($groupBuying->status == 2)
        {
            $this->data["list"] = GroupBuyingLogModel::getNotCancelLog($request->input("id"));
        }

        if ($groupBuying->status == 3)
        {
            $this->data["list"] = GroupBuyingOrderModel::where(["group_id" => $request->input("id")])->get();
            foreach ($this->data["list"] as &$value)
            {
                $tmp = json_decode($value->order_info, true);
                unset($tmp ["log_id"]);
                $value->order_info = "";
                foreach ($tmp as $item_id => $detail)
                {

                    $value->order_info .= "<a href='/suki_group_buying_item_info?item_id=" . $item_id . " target='_blank' style='color: #00A0FF'>" . $detail["item_detail"]["item_name"] . "</a>" . ":";
                    foreach ($detail["detail"] as $fe => $num)
                    {
                        $value->order_info .= $fe . " " . $num . " 个,";
                    }
                }

            }
        }

        return view('PC/Admincp/Participant')->with('data', $this->data);
    }

    public function deliver(Request $request)
    {
        $this->data["id"] = $request->input("id");

        return view('PC/Admincp/Deliver')->with('data', $this->data);
    }

    public function do_deliver(Request $request)
    {
        $exps = GroupBuyingExpressModel::where("id", "=", $request->input("id"))->where("status", "=", "3")->first();


        if (empty($exps))
        {
            return self::response([], 40002, "订单不存在");
        }

        $exps->waybill_no = $request->input("waybill_no");
        $exps->status     = 4;
        $exps->save();
        $orders = json_decode($exps->orders, true);
        foreach ($orders as $orderId)
        {
            $order         = GroupBuyingOrderModel::find($orderId);
            $order->status = 3;
            $order->save();
            $logids = json_decode($order->log_id, true);
            foreach ($logids as $logid)
            {
                $lg         = GroupBuyingLogModel::find($logid);
                $lg->status = 6;
                $lg->save();
            }

        }

        return self::response();
    }

    public function remove_group_buying_item(Request $request)
    {
        $item          = GroupBuyingItemModel::find($request->input('id'));
        $item->display = 2;
        $item->save();
        //根据item拿团购状态,如果团购正在进行中
        $group_buying = GroupBuyingModel::find($item->group_id);
        if ($group_buying->status == 2)
        {
            $log = GroupBuyingLogModel::where(["item_id" => $request->input('id')])->get();
            foreach ($log as $value)
            {
                $value->status = 9;
                $value->save();
            }
        } //如果已经结束
        else if ($group_buying->status == 3)
        {

            $item_id = $request->input('id');
            //所有人的订单取出
            $all_order = GroupBuyingOrderModel::where(["group_id" => $group_buying->id])->get();
            foreach ($all_order as $user_order)
            {
                $user_buy_log_id       = json_decode($user_order->log_id, true);
                $other_user_order_info = json_decode($user_order->order_info, true);
                $tmp_log_id            = $other_user_order_info["log_id"]; //这个东西还要再装回去
                unset($other_user_order_info["log_id"]);
                $user_buy_items_id = [];
                foreach ($other_user_order_info as $key => $value)
                {
                    $user_buy_items_id[] = $key;
                }
                //                echo json_encode($user_buy_items_id);
                //                continue;
                if (in_array($item_id, $user_buy_items_id))
                {
                    //                    echo $user_order->uid."<br>";
                    //                    continue;
                    //为避免出错,存储原始id
                    if (!$user_order->ori_order_data)
                    {
                        $user_order->ori_order_data = $user_order->order_info;
                    }
                    if (!$user_order->true_price)
                    {
                        $user_order->true_price = $user_order->order_price;
                    }
                    if (!$user_order->true_private_freight)
                    {
                        $user_order->true_private_freight = $user_order->private_freight;
                    }
                    if (!$user_order->ori_log_id)
                    {
                        $user_order->ori_log_id = $user_order->log_id;
                    }

                    //找到他们的log,标记流团
                    $log = GroupBuyingLogModel::where(["uid" => $user_order->uid, "item_id" => $item_id])->where(
                        "status",
                        "!=",
                        4
                    )
                        ->get();
                    //                    dd($log);

                    //                    GroupBuyingLogModel::where(["uid"=>$user_order->uid,"item_id"=>$item_id])->where("status","!=",4)
                    //                        ->update(["status" => 10,"update_time" => date("Y-m-d H:i:s",time())]);

                    //价格减去,计算true_price,计算运费,order_info遍历后修改
                    $user_order->true_price -= $other_user_order_info[ $item_id ]["order_price"];
                    $user_order->true_private_freight -= $other_user_order_info[ $item_id ]["private_freight"];


                    unset($other_user_order_info[ $item_id ]);
                    //去除log_id
                    foreach ($log as $value)
                    {
                        $value->status      = 10;
                        $value->update_time = date("Y-m-d H:i:s", time());
                        $value->save();
                        foreach ($tmp_log_id as $log_id_key => $id)
                        {
                            if ($value->id == $id)
                            {
                                unset($tmp_log_id[ $log_id_key ]);
                            }

                        }
                    }
                    $tmp_log_id = array_values($tmp_log_id);

                    $other_user_order_info["log_id"] = $tmp_log_id;

                    $user_order->order_info = json_encode($other_user_order_info);
                    $user_order->log_id     = json_encode($tmp_log_id);

                    $user_order->save();


                }
            }
        }

        return self::response();
    }

    public function confirm_group_buying_user_order(Request $request)
    {
        $order         = GroupBuyingOrderModel::find($request->input("id"));
        $order->status = 4;
        $order->save();
        foreach (json_decode($order->log_id, true) as $id)
        {
            $log         = GroupBuyingLogModel::find($id);
            $log->status = 3;
            $log->save();
        }

        return self::response();
    }

    public function skip_orders(Request $request)
    {
        if (!$request->input("id"))
        {
            return self::response([], 40001, "缺少参数id");
        }
        //取跑单的订单详情
        $order = GroupBuyingOrderModel::find($request->input("id"));
        if ($order->status != 1 && $order->status != 2)
        {
            return self::response([], 40002, "状态不对" . $order->status);
        }
        //所有人的订单取出
        $all_order = GroupBuyingOrderModel::where(["group_id" => $order->group_id])->get();
        $info      = json_decode($order->order_info, true);


        //遍历他买的商品
        foreach ($info as $item_id => $order_detail)
        {
            foreach ($all_order as $user_order)
            {
                $user_buy_log_id       = json_decode($user_order->log_id, true);
                $other_user_order_info = json_decode($user_order->order_info, true);
                $tmp_log_id            = $other_user_order_info["log_id"]; //这个东西还要再装回去
                unset($other_user_order_info["log_id"]);
                $user_buy_items_id = [];
                foreach ($other_user_order_info as $key => $value)
                {
                    $user_buy_items_id[] = $key;
                }

                if (in_array($item_id, $user_buy_items_id))
                {
                    //获得跑单用户买了几个
                    $user_buy = 0;
                    foreach ($order_detail["detail"] as $v)
                    {
                        $user_buy += $v;
                    }

                    $true_private_freight = $order_detail["item_detail"]["follow"] == 1
                        ? $order_detail["item_detail"]["item_freight"]  //如果就一个人买(他自己)那运费要避免被除数为0
                        : $order_detail["item_detail"]["item_freight"] / ($order_detail["item_detail"]["follow"] - 1);


                    //为避免出错,存储原始id
                    if (!$user_order->ori_order_data)
                    {
                        $user_order->ori_order_data = $user_order->order_info;
                    }
                    if (!$user_order->true_price)
                    {
                        $user_order->true_price = $user_order->order_price;
                    }
                    if (!$user_order->true_private_freight)
                    {
                        $user_order->true_private_freight = $user_order->private_freight;
                    }
                    if (!$user_order->ori_log_id)
                    {
                        $user_order->ori_log_id = $user_order->log_id;
                    }

                    if ($order_detail["item_detail"]["min_members"] <= $order_detail["item_detail"]["item_count"] - $user_buy)
                    {

                        //如果还成团,其它人的运费重新生成
                        $user_order->true_private_freight = $user_order->true_private_freight + ($true_private_freight - $other_user_order_info[ $item_id ]["private_freight"]);
                        //                        dd($other_user_order_info[$item_id]);
                        //其它人的order_info需要修改:follow减少,item_count减少,private_freight增加,follow减少1
                        $other_user_order_info[ $item_id ]["private_freight"] = $true_private_freight;

                        $other_user_order_info[ $item_id ]["item_detail"]["item_count"] -= $user_buy;
                        $other_user_order_info[ $item_id ]["item_detail"]["follow"] -= 1;
                        $other_user_order_info["log_id"] = $tmp_log_id;


                        $user_order->order_info = json_encode($other_user_order_info);
                        //订单金额不变
                        $user_order->save();


                    }
                    else
                    {

                        //如果不成团,找到他们的log,标记流团
                        $log = GroupBuyingLogModel::where(["uid" => $user_order->uid, "item_id" => $item_id])->where(
                            "status",
                            "!=",
                            4
                        )
                            ->get();
                        GroupBuyingLogModel::where(["uid" => $user_order->uid, "item_id" => $item_id])->where(
                            "status",
                            "!=",
                            4
                        )
                            ->update(["status" => 10, "update_time" => date("Y-m-d H:i:s", time())]);
                        //价格减去,计算true_price,计算运费,order_info遍历后修改
                        $user_order->true_price -= $other_user_order_info[ $item_id ]["order_price"];
                        $user_order->true_private_freight -= $other_user_order_info[ $item_id ]["private_freight"];


                        unset($other_user_order_info[ $item_id ]);
                        //去除log_id
                        foreach ($log as $value)
                        {
                            foreach ($tmp_log_id as $log_id_key => $id)
                            {
                                if ($value->id == $id)
                                {
                                    unset($tmp_log_id[ $log_id_key ]);
                                }

                            }
                        }
                        $tmp_log_id = array_values($tmp_log_id);

                        $other_user_order_info["log_id"] = $tmp_log_id;

                        $user_order->order_info = json_encode($other_user_order_info);
                        $user_order->log_id     = json_encode($tmp_log_id);

                        $user_order->save();
                    }

                }
            }
        }

        $log_id_arr     = json_decode($order->log_id, true) ?: [];
        $ori_log_id_arr = json_decode("", true) ?: [];
        //        dd($ori_log_id_arr);
        $log_id_arr = array_merge($log_id_arr, $ori_log_id_arr);
        //        dd($log_id_arr);
        //跑单人标记为跑单
        foreach ($log_id_arr as $log_id)
        {

            $log = GroupBuyingLogModel::find($log_id);

            $log->status = 11;
            $log->save();
        }
        $order->status = 5;
        $order->save();

        return self::response();
    }

    public function order_delivers(Request $request)
    {
        $this->data['type'] = $request->input("type") ?: 1;
        $this->data["list"] = GroupBuyingExpressModel::where("status", "=", $this->data['type']);

        if ($this->data['type'] == 1 || $this->data['type'] == 3)
        {
            $this->data["list"] = $this->data["list"]->orderBy("uid", "DESC")->get();
        }
        else
        {
            $this->data["list"] = $this->data["list"]->orderBy("id", "DESC")->get();

        }
        foreach ($this->data["list"] as $value)
        {

            $value->order_info = "";
            foreach (json_decode($value->orders, true) as $order_id)
            {
                $order = GroupBuyingOrderModel::find($order_id);
                //                $value->order_id[] = $order_id;
                $value->order_info .= "{$order->group_id}团货物<br>";
                if ($order->group_id == 0)
                {
                    $order_info = json_decode($order->order_info, true);
                    unset($order_info["log_id"]);
                    foreach ($order_info as $stock_item_type_id => $stock_detail)
                    {

                        //                        dd($order_info);
                        foreach ($stock_detail as $detail)
                        {
                            $value->order_info .= "<a style='color: #f75950;' href='/suki_group_buying_stock_item?item_id=" . $stock_item_type_id . "' >{$detail["detail"]["item_name"]}</a>:<span>{$detail["detail"]["size"]}_{$detail["detail"]["color"]} {$detail["num"]}个</span><br>";
                        }

                    }
                }
                else
                {
                    $tmp = json_decode($order->order_info, true);
                    unset($tmp ["log_id"]);
                    foreach ($tmp as $item_id => $detail)
                    {

                        $value->order_info .= "<a href='/suki_group_buying_item_info?item_id=" . $item_id . " target='_blank' style='color: #00A0FF'>" . $detail["item_detail"]["item_name"] . "</a>" . ":";
                        foreach ($detail["detail"] as $fe => $num)
                        {
                            $value->order_info .= $fe . " " . $num . " 个,";
                        }
                        $value->order_info .= "<br>";
                    }
                    $value->order_info .= "<br>";
                }


            }
            //            dd($value);
            //            $value->orders_info =
        }

        return view('PC/Admincp/OrderDeliver')->with('data', $this->data);
    }

    public function delivers_status(Request $request)
    {
        //        return [$request->input("id"),$request->input("to_status")];
        $delivers         = GroupBuyingExpressModel::find($request->input("id"));
        $delivers->status = $request->input("to_status");
        $delivers->save();

        return self::response();
    }

    public function change_log_items(Request $request)
    {
        $this->data["log"] = GroupBuyingLogModel::find($request->input("id"));
        //        $this->data["log"]->order_info = json_decode($this->data["log"]->order_info,true);


        $this->data["item"] = GroupBuyingItemModel::find($this->data["log"]->item_id);

        //        dd($this->data["item"] );

        return view('PC/Admincp/ChangeLogItems')->with('data', $this->data);
    }

    public function change_log(Request $request)
    {

    }

    public function do_change_item(Request $request)
    {
        //校验
        $log_order_info = $request->input("log_order_info");
        $id             = $request->input("id");
        if (!$log_order_info || !$id)
        {
            return self::response([], 40001, "缺少参数");
        }
        $log = GroupBuyingLogModel::find($id);
        if (empty($log))
        {
            return self::response([], 40001, "log不存在");
        }

        $log->order_info = json_decode($log->order_info, true);
        $log_order_info  = json_decode($log_order_info, true);
        $ori_num         = 0;
        $new_num         = 0;

        foreach ($log->order_info as $num)
        {
            $ori_num += $num;
        }
        foreach ($log_order_info as $num)
        {
            $new_num += $num;
        }
        if ($new_num != $ori_num)
        {
            return self::response([], 40002, "数目不相等");
        }

        if ($new_num == 0 || $ori_num == 0)
        {
            return self::response([], 40003, "数据异常");
        }
        $order = GroupBuyingOrderModel::where("group_id", "=", $log->group_id)->where("uid", "=", $log->uid)
            ->first();
        if (empty($order->id))
        {
            return self::response([], 40004, "order 不见了");
        }
        if (!$order->ori_log_id)
        {
            $order->ori_log_id = $order->log_id;
        }
        if (!$order->ori_order_data)
        {
            $order->ori_order_data = $order->order_info;
        }
        $order->order_info = json_decode($order->order_info, true);

        foreach ($order->order_info[ $order->item_id ]["detail"] as $features => $num)
        {
            //            $feature = explode("|",$features);
            foreach ($log->order_info as $type => $log_num)
            {
                //                if ()
            }

        }


        $log->order_info = json_encode($log_order_info);
        $log->save();


    }

    public function copy_item(Request $request)
    {
        $item_id  = $request->input("item_id");
        $group_id = $request->input("group_id");

        $item                   = GroupBuyingItemModel::find($item_id);
        $new_item               = new GroupBuyingItemModel();
        $new_item->item_name    = $item->item_name;
        $new_item->item_image   = $item->item_image;
        $new_item->item_price   = $item->item_price;
        $new_item->item_freight = $item->item_freight;
        $new_item->group_id     = $group_id;
        $new_item->premium      = $item->premium;
        $new_item->item_color   = $item->item_color;
        $new_item->item_size    = $item->item_size;
        $new_item->min_members  = $item->min_members;
        $new_item->save();

        return self::response();
    }

    //拒绝发货
    public function chargeback(Request $request)
    {
        $delivers         = GroupBuyingExpressModel::find($request->input("id"));
        $delivers->status = 5;
        $delivers->save();
        $orders = json_decode($delivers->orders, true);
        foreach ($orders as $order_id)
        {
            $order = GroupBuyingOrderModel::find($order_id);
            if ($order->status != 6)
            {
                return self::response([], 40002, "订单状态不对,当前为:" . $order->status);
            }


        }
        foreach ($orders as $order_id)
        {
            $order         = GroupBuyingOrderModel::find($order_id);
            $order->status = 4;
            $order->save();
            $log_id = json_decode($order->log_id, true);
            foreach ($log_id as $lid)
            {
                $log = GroupBuyingLogModel::find($lid);
                if ($log->status = 5 && $log->group_id != 0)
                {
                    $log->status = 3;
                    $log->save();
                }
                if ($log->status = 5 && $log->group_id == 0)
                {
                    $log->status = 8;
                    $log->save();
                }
            }
        }

        return self::response();
    }

    public function stock_item(Request $request)
    {
        $this->data["not_pay_order"] = GroupBuyingOrderModel::where("group_id", "=", "0")
            ->whereIn("status", [1,2])
            ->get();

        foreach ($this->data["not_pay_order"] as &$value)
        {
            $order_info = json_decode($value->order_info, true);
            unset($order_info["log_id"]);
            $value->order_info = "";
            foreach ($order_info as $stock_item_type_id => $stock_detail)
            {
                foreach ($stock_detail as $detail)
                {
                    $value->order_info .= "<a href=''>{$detail["detail"]["item_name"]}</a>:<span>{$detail["detail"]["size"]}_{$detail["detail"]["color"]} {$detail["num"]}个</span>";
                }

            }
            //            dd($order_info);
        }

        //       dd( $this->data["not_pay_order"]);
        return view('PC/Admincp/StockItemOrder')->with('data', $this->data);
    }

    public function add_stock(Request $request)
    {

        return view('PC/Admincp/AddStockType')->with('data', $this->data);
    }

    public function add_stock_type(Request $request)
    {
        $st             = new GroupBuyingStockItemTypeModel();
        $st->item_name  = $request->input("item_name");
        $st->item_image = $request->input("item_image");
        $st->save();

        return self::response();
    }

    public function push_stock_page(Request $request)
    {
        $tid                = $request->input("tid");
        $this->data["type"] = GroupBuyingStockItemTypeModel::getOne($tid);

        return view('PC/Admincp/PushStockTypePage')->with('data', $this->data);
    }

    public function stock_list()
    {
        $this->data["list"] = GroupBuyingStockItemTypeModel::get();

        return view('PC/Admincp/StockListPage')->with('data', $this->data);
    }

    public function push_stock(Request $request)
    {
        $item_id = $request->input("item_id");
        $size    = $request->input("size");
        $color   = $request->input("color");

        $stock = GroupBuyingStockItemModel::where(["item_id" => $item_id, "size" => $size, "color" => $color])->first();
        if (empty($stock))
        {
            $stock            = new GroupBuyingStockItemModel();
            $stock->item_id   = $item_id;
            $stock->item_name = $request->input("item_name");
            $stock->size      = $request->input("size");
            $stock->color     = $request->input("color");
            $stock->price     = $request->input("price");
        }
        $stock->stock += $request->input("stock");
        $stock->save();

        return self::response();
    }

    public function add_stock_page(Request $request)
    {
        $this->data["stock"] = GroupBuyingStockItemTypeModel::getOne($request->input("item_id"));

        return view('PC/Admincp/AddStockPage')->with('data', $this->data);
    }

    public function add_stock_item(Request $request)
    {
        $item = GroupBuyingStockItemModel::find($request->input("id"));
        $item->stock += $request->input("num");
        $item->save();

        return self::response();
    }

    public function orders_list(Request $request)
    {
        //1= 等待付款 2=等待收款确认 3=已发货 4=确认收款 5=逃单6=已申请发货7=已取消
        $this->data["list"]   = GroupBuyingOrderModel::where("status", "=", "4")->get();
        $this->data["err_id"] = TestController::checkNotCancelPackage();
        foreach ($this->data["list"] as $value)
        {
            $value->info = "";
            $order_info  = json_decode($value->order_info, true);
            unset($order_info["log_id"]);
            if ($value->group_id == 0)
            {
                foreach ($order_info as $stock_item_type_id => $stock_detail)
                {
                    foreach ($stock_detail as $detail)
                    {
                        $value->info .= "<a href=''>{$detail["detail"]["item_name"]}</a>:<span>{$detail["detail"]["size"]}_{$detail["detail"]["color"]} {$detail["num"]}个</span>";
                    }
                }
            }
            else
            {
                foreach ($order_info as $item_id => $detail)
                {
                    $value->info .= "<a href='/suki_group_buying_item_info?item_id=" . $item_id . " target='_blank' style='color: #00A0FF'>" . $detail["item_detail"]["item_name"] . "</a>" . ":";
                    foreach ($detail["detail"] as $fe => $num)
                    {
                        $value->info .= $fe . " " . $num . " 个,";
                    }
                    $value->info .= "<br>";
                }
            }

        }

        //        dd($this->data["list"]);
        return view('PC/Admincp/OrderList')->with('data', $this->data);
    }

    public function cancel_stock_order(Request $request)
    {
        $order         = GroupBuyingOrderModel::find($request->input("id"));
        $order->status = 7;
        $order->save();
        foreach (json_decode($order->log_id, true) as $id)
        {
            $log              = GroupBuyingLogModel::find($id);
            $log->status      = 4;
            $log->update_time = date("Y-m-d H:i:s");
            $log->save();
            $details = json_decode($log->order_info, true);
            foreach ($details as $detail => $num)
            {
                $cs = explode("_", $detail);

                $stock_item = GroupBuyingStockItemModel::where("size", "=", $cs[0])
                    ->where("color", "=", $cs[1])
                    ->select()->first();
                $stock_item->stock += $num;
                $stock_item->save();
            }
        }

        return self::response();
    }

    public function disable_stock(Request $request)
    {
        $id          = $request->input("item_id");
        $display     = $request->input("display");
        $st          = GroupBuyingStockItemTypeModel::find($id);
        $st->display = $display;
        $st->save();

        return self::response();
    }

    public function update_price(Request $request)
    {
        $item_id          = $request->input("item_id");
        $price            = $request->input("price");
        $item             = GroupBuyingItemModel::find($item_id);
        $item->item_price = $price;
        $item->save();
        if (empty($item))
        {
            return self::response([], 40001, "item不存在");
        }


        $logs = GroupBuyingLogModel
            ::where("item_id", "=", $item_id)
            ->where("group_id", "=", $item->group_id)
            ->get();

        foreach ($logs as $log)
        {
            $info = json_decode($log->order_info, true);
            $num  = 0;
            foreach ($info as $value)
            {
                $num += $value;
            }
            $log->order_price = ($price + $item->premium) * $num;
            $log->save();
        }

        return self::response();
    }

    public function update_item_freight(Request $request)
    {
        $item_id      = $request->input("item_id");
        $item_freight = $request->input("item_freight");
        $item         = GroupBuyingItemModel::find($item_id);

        if (empty($item))
        {
            return self::response([], 40001, "item不存在");
        }

        $ori_freight        = $item->item_freight;
        $item->item_freight = $item_freight;

        $group_buying = GroupBuyingModel::find($item->group_id);

        $item->save();
        if ($group_buying->status != 3)
        {
            return self::response([],200, "update success(opening)");
        }


        //如果团购已经截团:
        //查找所有购买成功的log
        $uidsResult = GroupBuyingLogModel::select(['id','status','uid',"group_id"])
                    ->where("item_id", "=", $item_id)
                    ->whereIn("status",[2,3,4,5,6])
                    ->get();

        $uids       = [];
        foreach ($uidsResult as $uid)
        {
            //检查是否有存在2(等待确认付款)和5已经申请发货的,如果有,则需要手工处理完这些订单才可以改价
            if ($uid->status ==2 || $uid->status == 5 || $uid->status == 6)
            {
                return self::response([],40005,"修改失败,id:".$uid->id."状态为".$uid->status.",必须手动修改完成后才可以改运费");
            }
            if (!in_array($uid->uid, $uids) && $uid->status == 3)
            {
                $uids[] = $uid->uid;
            }
        }


        $group_id = $uid->group_id;
        //记录这些uid
        //查找他们这一团的order
        $orders = GroupBuyingOrderModel::select()->whereIn("uid", $uids)->where("group_id",$group_id)->get();
        foreach ($orders as $value)
        {
            if (!$value->ori_order_data)
            {
                $value->ori_order_data = $value->order_info;
            }
            $user_freight_price = 0;
            //order_info 备份,然后修改
            $order_info = json_decode($value->order_info, true);
            foreach ($order_info as $iid => &$idtal)
            {
                if ($iid == "log_id")
                {
                    continue;
                }
                $user_freight_price += $idtal["private_freight"];
                if ($iid == $item_id)
                {
                    $idtal["item_detail"]["item_freight"] = $item_freight;
                    $idtal["private_freight"]             = ($item_freight / count($uids));
               }

            }


            $value->order_info = json_encode($order_info);
            $value->true_private_freight = $user_freight_price;

            $value->save();
        }

        return self::response();

    }

    public function cancel_overtime_log()
    {
        $logs = GroupBuyingLogModel::select()->where("group_id", "=", 0)->where("status", "=", 1)->where(
            "create_date",
            "<",
            date("Y-m-d H:i:s", time() - 7200)
        )->get();
        foreach ($logs as $log)
        {
            $log->status      = 4;
            $log->update_time = date("Y-m-d H:i:s");
            $log->save();
            $details = json_decode($log->order_info, true);
            foreach ($details as $detail => $num)
            {
                $cs = explode("_", $detail);

                $stock_item = GroupBuyingStockItemModel::where("size", "=", $cs[0])
                    ->where("color", "=", $cs[1])
                    ->select()->first();
                $stock_item->stock += $num;
                $stock_item->save();
            }
        }
        //        $log              = GroupBuyingLogModel::find($id);
        return self::response(["rm"=>count($logs)]);
    }

    public function set_change_log(Request $request)
    {
        $requestLogOrderData = json_decode($request->input("order_info"), true);
        if (empty($requestLogOrderData))
        {
            return self::response([], 40001, "orderinfo空");
        }
        $log = GroupBuyingLogModel::find($request->input("log_id"));
        if (empty($log))
        {
            return self::response([], 40001, "log不存在");
        }
        $logOrderData = json_decode($log->order_info, true);

        //比较新旧差异
        $diff = [];
        //检测原来有的订单的变化
        foreach ($logOrderData as $old_key => $old_value)
        {
            foreach ($requestLogOrderData as $new_key => $new_value)
            {
                if ($old_key == $new_key)
                {
                    if ($new_value != $old_value)
                    {
                        $logOrderData[$old_key] = $new_value;
                        $diff[$new_key] = $new_value - $old_value;
                    }
                }
            }
        }
        //如果没有什么要修改的
        if (empty($diff))
        {
            return self::response([], 40001, "需要修改的值为空");
        }
        $allZeroFlag = true;
        foreach ($logOrderData as $val)
        {
             if ($val > 0)
             {
                 $allZeroFlag = false;
             }
        }
        //用户的本期订单
        $order = GroupBuyingOrderModel::getUserOrder($request->input("uid"), $request->input("gid"));
        $order_detail = json_decode($order->ori_order_data, true);
        if ($allZeroFlag)
        {
            //整个订单被砍,该用户的公摊运费需要重新运算,其它买了的用户的公摊也要重新运算
            //砍单不会造成流团,因为如果不满成团就应该手动去点流团

            if (!$order->true_private_freight)
            {
                $order->true_private_freight = $order->private_freight - $log->private_freight;
            } else
            {
                $order->true_private_freight -=  $order->private_freight;
            }
            $log->private_freight = 0;
        }
        //计算被砍的金额
        foreach ($diff as $diff_key => $diff_value)
        {

        }
    }

    public function sale_log(Request $request)
    {
        $this->data["list"] = GroupBuyingLogModel::where("item_id" ,$request->input("item_id"))->where("group_id", 0)
            ->orderBy("id", "desc")
            ->get();

        $this->data["count_info"] = [];
        foreach ($this->data["list"] as &$value)
        {
            $user_info         = User_model::find($value->uid);
            $value["username"] = $user_info->username;
            $value["qq"]       = $user_info->qq;


            foreach (json_decode($value->order_info, true) as $k => $num)
            {
                if ($value->status != 4)
                {
                    $this->data["count_info"][ $k ] += $num;
                }

            }

        }

        return view('PC/Admincp/SaleLog')->with('data', $this->data);
    }

    public function check_package(Request $request)
    {
        $order = GroupBuyingOrderModel::find($request->input("id"));
        if (empty($order)) {
            return self::response([], 40001, "订单不存在");
        }

        if ($order->status != 4) {
            return self::response([], 40002, "订单状态不是确认收款状态(4)");
        }

        GroupBuyingOrderModel::changeOrderStatus($request->input("id"));

        return self::response();
    }

}
