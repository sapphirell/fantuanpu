<?php

namespace App\Http\DbModel;

use Illuminate\Database\Eloquent\Model;

class GroupBuyingOrderModel extends Model
{
    public $table = "pre_group_buying_order";
    public $timestamps = false;
    // status 1= 等待付款 2=等待收款确认 3=已发货 4=确认商品原价收款 5=逃单 6=已申请发货

}
