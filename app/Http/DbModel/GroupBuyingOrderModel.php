<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class GroupBuyingOrderModel extends Model
{
    public $table = "pre_group_buying_order";
    public $timestamps = false;
    // status 1= 等待付款 2=等待收款确认 3=已发货 4=确认商品原价收款 5=逃单 6=已申请发货

    public static function createOrder($uid,$order_info,$usrPrivateFreight,$usrOrderPrice,$userSelectedTicket,$groupId)
    {
        $order                  = new GroupBuyingOrderModel();
        $order->uid             = $uid;
        $order->order_info      = json_encode($order_info,JSON_UNESCAPED_UNICODE);
        $order->status          = 1;
        $order->private_freight = $usrPrivateFreight;
        $order->order_price     = $usrOrderPrice;
        foreach ($userSelectedTicket as $userTicket)
        {
            if (
                $userTicket->uid == $uid &&
                $userTicket->need_value <= $usrOrderPrice &&
                ($userTicket->gid == $groupId || $userTicket->gid == 0)
            )
            {
                //优惠券生效
                if ($userTicket->off_value)
                {
                    //优惠金额
                    $order->use_ticket = $userTicket->user_ticket_id;
                    $order->ticket_id = $userTicket->ticket_id;
                    $order->off_value = $userTicket->off_value;
                    //优惠券标为已使用
                    $userTicket->status = 2;
                    $userTicket->save();
                }
                $gifts = json_decode($userTicket->gift_ids,true);
                if (!empty($gifts))
                {
                    //礼品券
                    foreach ($gifts as $gift_id => $num)
                    {
                        if (empty($stockItems[$gift_id]))
                        {
                            $stockItems[$gift_id] = GroupBuyingStockItemTypeModel::getOne($gift_id);
                        }
                        $userStockItemInfo = $stockItems[$gift_id];
                    }
                }


                break;
            }
        }
        $order->log_id          = json_encode($order_info["log_id"]);
        $order->group_id        = $groupId;
        $order->save();
        return $order;
    }

    public static function getUserOrder($uid, $gid)
    {
        return self::select()->where("uid", $uid)->where("gid", $gid)->first();
    }
}
