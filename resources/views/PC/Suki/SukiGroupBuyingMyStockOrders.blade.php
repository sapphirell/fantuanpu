@include('PC.Suki.SukiHeader')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<style>

    .logs_image {
        width: 120px;

    }
    .logs_image > img {
        width: 120px;
        border-radius: 5px;
        box-shadow: 0 0 5px #ffcfcf;
        border: 1px solid #ffd1d1;
        padding: 3px;
    }
    .my_items_log {
        margin: 10px;
        display: flex;
        flex-flow:row;
        padding-bottom: 15px;
        border-bottom: 1px dashed #ddd;
    }
    .my_items_log > * {
        float: left;
    }
    .item_name {
        font-size: 15px;
        font-weight: 900;
    }
    .price {
        color: #F28A96;
        font-size: 16px;
    }
    .my_log_info {
        float: left;
        flex:1;
        /*display: flex;*/
        /*flex-direction: row;*/
    }

    .my_log_detail {
        /*margin:0 20px;*/
        width: 340px;
        display:inline-block;
        float: left;
    }
    .price_status {
        display: inline-block;
        float: left;
        padding-left: 5px;
    }
    .my_log_info {
        padding: 0 0 0 20px;
    }
    .tab_h {
        z-index: 4;
        position: relative;
        cursor: pointer;
        border: 1px solid #fac6c8;
        border-width: 1px 1px 0px 1px;
        display: inline-block;
        float: left;
        border-radius: 5px 5px 0px 0px;
        overflow: hidden;
    }
    .tab_h span {
        background: #ffc6c5;
        float: left;
        color: #fdfdfd;
        padding: 8px 10px;
        background-image: linear-gradient(180deg, #fbded9 0%, #ffa5b2 93%);

    }
    .tab_h span.onchange {
        background: #f1d0b2;
        background-image: linear-gradient(180deg, #fff2f4 0%, #ffffff 93%);
        color: #bd6c6c;
    }
    .tab_m {
        border: 1px solid #fac6c8;
        position: relative;
        top: -1px;
        border-radius: 0px 5px 5px 5px;
        padding: 10px;
        float: left;
        width: 100%;
    }
    .compute_item {
        color: #F28A96;
        font-size: 16px;
        padding: 5px;
    }
    .compute .title {
        color: #777;
        font-size: 12px;
    }
    .compute p {
        color: #bbb;
    }
    .go_to_pay {    border-radius: 5px;
        margin-top: 10px;
        background: #f9c8c9;
        width: 100%;
        display: block;

        text-align: center;
        background-color: #ffb6c7;
        color: #FFFFFF!important;
        background-image: linear-gradient(90deg, #fbded9 0%, #ffa5b2 93%);}
    .my_order_detail {
        color: #777777;
    }
    .stock_tag {
        display: inline-block;
        position: absolute;
        background: #463f3fe0;
        color: #ffffff;
        padding: 3px;
        border-radius: 5px;
    }
    @media screen and (max-width: 960px) {
        .price_status {
            margin-top: 10px;
            padding-left: 0px;
        }
        .logs_image {
            width: 80px;
        }
        .logs_image > img {
            width: 80px;
        }
        .my_log_detail {
            width: auto;
        }

    }
</style>
<div class="wp" style="margin-top: 60px;    padding: 5px;background-color: #fff;">
    <div class="btn-group show" style="margin-bottom: 10px;box-shadow: none" role="group">
        <button style="border: 0px;color: #999999;background-color: #fff;padding: 6px 15px;margin-left: 0px;" type="button" class="btn btn-secondary dropdown-toggle tb" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            切换表单
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; transform: translate3d(10px, 25px, 0px); top: 0px; left: 0px; will-change: transform;">
            <a href="/suki_group_buying_myorders?type=last" class="dropdown-item setting_clock_alert">正在团购</a>
            <a href="/suki_group_buying_my_stock" class="dropdown-item setting_clock_alert">现货</a>
            <a href="/suki_group_buying_myorders" class="dropdown-item setting_clock_alert">历史订单</a>

        </div>
    </div>
    @if(empty($data["active_logs"]))
        <p>暂无</p>
    @endif
    <?php $sum_price = 0; $private_freight = 0; $stock_item_price = 0;?>
    <?php
        $group_id = [];
    ?>
    @foreach($data["active_logs"] as $value)

        {{--{{dd($value->id)}}--}}
        <?php
        if(!in_array($value->group_id,$group_id))
        {
            $group_id[] = $value->group_id;
        }

        ?>
        <?php $order_info = json_decode($value["order_info"],true); ?>
        <div class="my_items_log">

            <a href="/suki_group_buying_item_info?item_id={{$value->item_id}}" class="logs_image" style="overflow: hidden">

                    <span class="stock_tag">
                    现货
                </span>
                <?php $stock_item_price += $value["order_price"] ?: 0; ?>

                <img src="{{$value["item_image"]}}" class="logs_image" style="">
            </a>
            <?php $need_pay += in_array($value->status,[1,2])? $value["order_price"] : 0; ?>
            <?php $sum_price += in_array($value->status,[1,2,3,5,8])? $value["order_price"] : 0; ?>
            <?php $refund += in_array($value->status,[10])? $value["order_price"] : 0; ?>
            <?php $private_freight += in_array($value->status,[2,3,5,8])? $value["sum_private_freight"] : 0; ?>

            <div class="my_log_info">
                <div class="my_log_detail" style="">
                    <p class="item_name">{{$value["item_name"]}}</p>
                    @foreach($order_info as $type => $num)
                        <p>{{$type}} </p>
                        <p>购买数量：{{$num}}个</p>
                    @endforeach

                    <span style="color: #777;padding-left:5px">请在{{date("Y-m-d H:i:s",strtotime($value->create_date)+3600)}}前打包付款</span>
                </div>
                <div class="price_status" style="">
                    <p>
                        <span style="margin-top: 5px;margin-bottom: 5px;">价格</span>
                        <span class="price">￥{{$value["order_price"]}}</span>

                        <span> / </span>
                        @if($value->status == 1)
                            <span style="display: inline">等待付款</span>
                            <a class="suki_group_buying_cancel_orders"
                               href="/suki_group_buying_cancel_orders" orderId="{{$value->id}}">取消订单</a>
                        @elseif($value->status == 2)
                            等待确认付款
                        @elseif($value->status == 3)
                            已经付款
                        @elseif($value->status == 4)
                            取消
                        @elseif($value->status == 5)
                            等待商户发货
                        @elseif($value->status == 6)
                            平台已经发货
                        @elseif($value->status == 7)
                            流团
                        @elseif($value->status == 8)
                            等待确认到账
                        @elseif($value->status == 9)
                            商品下架
                        @elseif($value->status == 10)
                            受影响流团
                        @elseif($value->status == 11)
                            跑单
                        @endif
                    </p>
                </div>
                <div class="clear"></div>
            </div>

            <div class="clear"></div>
        </div>
    @endforeach
    <?php
    $ticket_status = !empty($data["tickets"]);
    if ((float)$sum_price < (float)$data["tickets"]->need_value)
        $ticket_status = false;
    if (count($group_id) !== 1 || $data["tickets"]->gid != $group_id[0])
        $ticket_status = false;


    ?>
    <?php unset($data["not_pay_order"]->order_info); ?>
    <div>

        @foreach($data["not_pay_order"] as $value)
            <div class="alert">您有未付款订单</div>
            <div style="padding: 5px">
                @foreach(json_decode($value->order_info,true) as $stock_type_id => $stock_item_list)
                    @if($stock_type_id != "log_id")
                        @foreach($stock_item_list as $stock_item_id => $buy_detail)
                            <p>
                                {{$buy_detail["detail"]["item_name"]}}
                                <span>{{$buy_detail["detail"]["size"]}}</span>
                                -
                                <span>{{$buy_detail["detail"]["color"]}}</span>
                                -
                                <span>{{$buy_detail["num"]}}个</span>
                            </p>


                        @endforeach
                    @endif
                @endforeach
                    <p>
                        共计 {{$value->order_price}} 元。请尽快付款,否则订单将被取消。
                        <a class="submit_pay" style="color: #0084B4;" orderId="{{$value->id}}">我已付款</a>
                    </p>
            </div>
        @endforeach

    </div>

    <div style="margin: 40px 30px 40px 10px;">
        <div class="tab_h">
            <span class="onchange trans">价格计算</span>
            <span class="trans">发货管理</span>
            <span class="trans">运单管理</span>
        </div>
        <div class="tab_m compute">
            <div>
                <div class="compute_item">

                    <span class="title">待付款</span>
                    ￥
                    <span class="font-weight: 900;">
                       @if($ticket_status)
                            <del>{{$need_pay}}</del>
                            {{$need_pay-($data["tickets"]->off_value?:0)}}
                        @else
                            {{$need_pay}}
                        @endif
                    </span>
                </div>
                <div class="compute_item">
                    <span class="title">优惠券</span>
                    <a style="    font-size: 13px;" href="/suki_group_buying_my_ticket?ori_route=suki_group_buying_myorders">
                        @if(empty($data["tickets"]))
                            [不使用优惠券]
                        @elseif(!$ticket_status)
                            {{$data["tickets"]->name}}--不可用
                        @else
                            {{$data["tickets"]->name}}
                        @endif
                    </a>
                    <span style="font-size: 13px;color: #BBBBBB;">(打包时自动结算价格)</span>
                </div>
                <div class="compute_item">
                    <span class="title">明细</span>
                </div>

                <div style="padding-left: 30px">
                    <p>
                        <span>现货 ￥</span><span class="font-weight: 900;">{{$stock_item_price}}</span>
                    </p>
                    <p>
                        <span>团购本体 ￥</span><span class="font-weight: 900;">{{$sum_price}}</span>
                    </p>
                    <p>
                        <span>团购公摊 ￥</span><span class="font-weight: 900;">{{$private_freight}}</span>
                    </p>
                    <p>
                        <span>团购退款 ￥</span><span class="font-weight: 900;">{{$refund}}</span>
                    </p>
                    <p>
                        <span>优惠券 ￥</span><span class="font-weight: 900;">
                            @if($ticket_status)
                                {{$data["tickets"]->off_value?:0}}
                            @else
                                优惠券不可用
                            @endif
                        </span>
                    </p>
                </div>

                <a class="go_to_pay">去付款打包</a>
            </div>
            <div>
                @if($data["address"])
                    <div>
                        <p>
                            收货地址:{{$data["address"]->address}}
                            <a href="/suki_group_buying_address_manager">修改</a>
                        </p>

                    </div>

                    <table style="width: 100%;    min-height: 50px;">

                        @foreach($data["my_order"] as $order)
                            {{--{{dd($order)}}--}}
                            <?php $order_info = json_decode($order->order_info,true); unset($order_info["log_id"]); ?>

                            <tr style="    font-size: 12px;">
                                <td style="width: 70px">
                                    @if($order->group_id > 0)
                                        <p>{{$order->group_id}}期团购</p>
                                    @else
                                        <p>现货商品</p>
                                    @endif
                                </td>
                                <td>
                                    {{--{{dd($order_info)}}--}}
                                    {{--<div>--}}
                                    {{--{{($order->true_private_freight?:$order->private_freight) - $order->order_price + ($order->true_price?:$order->order_price)}}--}}
                                    {{----}}
                                    {{--</div>--}}
                                    <div>
                                        <p>
                                            @foreach($order_info as $oi)
                                                <span>{{$oi["item_detail"]["item_name"]}}</span>
                                                <br>
                                                @foreach($oi["detail"] as $type => $num)
                                                    <span class="my_order_detail">{{$type}} {{$num}}个</span>
                                                    <br>
                                                @endforeach
                                            @endforeach
                                        </p>
                                    </div>


                                </td>
                                <td style="width: 30px;">
                                    @if($value->status == 4 || 1)
                                        <label>
                                            勾选
                                            <input type="checkbox" class="check" orderId="{{$order->id}}"
                                                   price="{{round((
                                               $order->true_private_freight?:$order->private_freight)
                                               - $order->order_price
                                               + ($order->true_price?:$order->order_price),2)
                                           }}">
                                        </label>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div>
                        <select class="select_province" style="width: 80px;padding: 0px;font-size: 12px;height: 25px;padding-left: 15px;display: inline-block">
                            <option value="0|0">请选择!!</option>
                            <option value="5.5|1">苏浙沪皖</option>
                            <option value="7|2">京津冀晋辽吉黑闽赣鲁豫鄂湘粤桂琼川贵滇渝陕甘青宁</option>
                            <option value="18|3">藏疆</option>
                        </select>

                        {{--<span class="count_title">需支付</span>:--}}
                        {{--<span class="count_price">0</span>元--}}

                        <a class="submit_check btn btn-info" style="float: right;color: #FFFFFF;background-color: #fdc2c5;border-color: #ffb2bb;">
                            [申请发货]
                        </a>
                    </div>
                @else
                    <a href="/suki_group_buying_address_manager">还没有设置收货地址,现在去设置?</a>
                @endif




            </div>
            <div>
                <table style="width: 100%">
                    <tr>
                        <td>收货地址/单号</td>
                        <td>
                            状态
                        </td>
                        <td>
                            <div class="detail" style="position: relative" message="">明细</div>
                        </td>
                    </tr>
                    @foreach($data["express"] as $value)
                        <tr  style="border-bottom: 1px solid #DDDDDD;">
                            <td>
                                {{$value->address}}<br />
                                {{--{{dd($value)}}--}}
                                {{$value->waybill_no}}
                            </td>
                            <td>
                                @if($value->status == 1)
                                    提交申请
                                @elseif ($value->status == 2)
                                    需要补邮费
                                @elseif ($value->status == 3)
                                    邮费已补
                                @elseif ($value->status == 4)
                                    <span style="color: #888888">已发货</span>
                                @elseif ($value->status == 5)
                                    <span style="">拒绝发货,请重新申请</span>
                                @endif
                            </td>
                            <td>
                                公摊:{{$value['private_freight']}},<br />
                                流团退款:{{$value['price_difference']}},<br />
                                个人运费:{{$value['freight']}}<br />
                                包含:
                                @foreach($value['groups'] as $n => $id)
                                    {{$id}} 团
                                    @if($n >0)
                                        、
                                    @endif
                                @endforeach
                                的货物<br />
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>

<script>
    var pf = 0;//邮费
    var count_price = 0;
    var title = "需要支付";
    var orders = [];
    var province_type;
    function change_count() {
        if (count_price < 0 )
        {
            title = "将退还"
        }
        else
        {
            title = "需支付"
        }
        $(".count_price").text(Math.round(Math.abs(count_price+pf)*100)/100);
        $(".count_title").text(title);
    }
    $(document).ready(function () {
        $(".go_to_pay").click(function (e) {

            e.preventDefault();
//        alert("暂未截团");
//        return ;
            window.location.href = "/suki_group_buying_paying?gid=0";
//        alert("支付宝:15658610102")
        })
        $(".check").change(function (e) {
            var orderId = $(this).attr("orderId");
            var price = parseFloat($(this).attr("price"))
            var check = $(this).is(':checked')
            if (check)
            {
//                console.log(price)
                count_price += price
                orders.push(orderId)
            }
            else
            {
                count_price -= price
                orders.remove(orderId)
            }

            change_count()

            console.log(orders)
        });
        $(".suki_group_buying_cancel_orders").click(function (e) {
            e.preventDefault();
            var orderId = $(this).attr("orderId")
            var r = window.confirm("确定取消吗?");
            if (r == true) {
                $.get("/suki_group_buying_cancel_orders?orderId=" + orderId, function (e) {
                    alert(e.msg)
                    window.location.reload()
                })
            }
            else {
                return false;
            }
        })
        $(".submit_check").click(function (e) {
//        alert("暂时不可发货");
//        return ;
            var address = $(".address").val();
            var telphone = $(".telphone").val();
            var name = $(".name").val();
            if(!province_type)
            {
                alert("请先选择发货地域")
                return ;
            }
            var fd = {
                "name":name,
                "address" : address,
                "telphone" : telphone,
                "orders" : orders,
                "province_type" :province_type
            }
            console.log(fd)
            if (!orders || !pf || !province_type)
            {
                alert("须填写完整")
                return ;
            }
            $.post("/suki_group_buying_do_deliver",fd,function (e) {
                alert(e.msg);
                if (e.ret == 200)
                {
                    window.location.href = "/suki_group_buying_deliver?type=2"
                }

            })
        });

        $(".select_province").change(function () {
            var s = $(this).val().split("|");

            pf = parseFloat(s[0]);
            province_type = s[1];
            change_count()
        });
        $("input:checkbox").trigger("click");
        //我已付款
        $(".submit_pay").click(function (e) {
            e.preventDefault()
            var postData = {
                "orderId" : $(this).attr("orderId")
            };

            $.post("/suki_group_buying_confirm_orders",postData,function (event) {
                alert(event.msg)
                if (event.ret == 200)
                {
                    window.parent.location.reload()
                }
            })
        })
    })

</script>
@include('PC.Suki.SukiFooter')