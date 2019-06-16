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
    @if(empty($data["active_logs"]))
        <p>暂无</p>
    @endif
    <?php $sum_price = 0; $private_freight = 0; ?>
    @foreach($data["active_logs"] as $value)
        {{--{{dd($value)}}--}}
        <?php $order_info = json_decode($value["order_info"],true); ?>
        <div class="my_items_log">
            <a href="/suki_group_buying_item_info?item_id={{$value->item_id}}" class="logs_image">
                <img src="{{$value["item_image"]}}" class="logs_image" style="">
            </a>
            <div class="my_log_info">
                <div class="my_log_detail" style="">
                    <p class="item_name">{{$value["item_name"]}}</p>
                    @foreach($order_info as $type => $num)
                        <p>{{$type}} </p>
                        <p>购买数量：{{$num}}个</p>
                    @endforeach

                </div>
                <?php $sum_price += in_array($value->status,[1,2,3,5,8])? $value["order_price"] : 0; ?>

                <?php $private_freight += in_array($value->status,[1,2,3,5,8])? $value["sum_private_freight"] : 0; ?>
                <div class="price_status" style="">
                    <p>
                        <span style="margin-top: 5px;margin-bottom: 5px;">价格</span>
                        <span class="price">￥{{$value["order_price"]}}</span>
                        <span> / </span>
                        @if($value->status == 1)
                            <span style="display: inline">等待拼团</span>
                            <a class="suki_group_buying_cancel_orders" onclick=""
                               href="/suki_group_buying_cancel_orders" orderId="{{$value->id}}">取消订单</a>
                        @elseif($value->status == 2)
                            等待确认付款
                        @elseif($value->status == 3)
                            已经付款,等待他人付款
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

    <div style="margin: 40px 30px 40px 10px;">
        <div class="tab_h">
            <span class="onchange trans">价格计算</span>
            <span class="trans">发货管理</span>
            <span class="trans">运单管理</span>
        </div>
        <div class="tab_m compute">
            <div>
                <div class="compute_item">
                    <span class="title">总价估算</span>
                    ￥
                    <span class="font-weight: 900;">{{$sum_price + $private_freight}}</span>
                </div>
                <div class="compute_item">
                    <span class="title">明细</span>
                </div>
                <div style="padding-left: 30px">
                    <p>
                        <span>本体 ￥</span><span class="font-weight: 900;">{{$sum_price}}</span>
                    </p>
                    <p>
                        <span>公摊 ￥</span><span class="font-weight: 900;">{{$private_freight}}</span>
                    </p>
                </div>

                <a class="go_to_pay">去付款</a>
            </div>
            <div>
                @if($data["address"])
                    <div>
                        <p>
                            当前收货地址:{{$data["address"]->address}}
                            <a href="/suki_group_buying_address_manager">修改</a>
                        </p>

                    </div>

                    <table style="width: 100%">
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
                                            <input type="checkbox" class="check" orderId="{{$value->id}}"
                                                   price="{{(
                                               $order->true_private_freight?:$order->private_freight)
                                               - $order->order_price
                                               + ($order->true_price?:$order->order_price)
                                           }}">
                                        </label>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div>
                        <select class="select_province" style="width: 100px;padding: 0px;font-size: 12px;height: 25px;padding-left: 15px">
                            <option value="0|0">请选择!!</option>
                            <option value="5.5|1">苏浙沪皖</option>
                            <option value="7|2">京津冀晋辽吉黑闽赣鲁豫鄂湘粤桂琼川贵滇渝陕甘青宁</option>
                            <option value="18|3">藏疆</option>
                        </select>

                        <span class="count_title">需支付</span>:
                        <span class="count_price">0</span>元

                        <a class="submit_check btn btn-info" style="float: right;color: #FFFFFF">
                            [申请发货勾选的]
                        </a>
                    </div>
                @else
                    <a href="/suki_group_buying_address_manager">还没有设置收货地址,现在去设置?</a>
                @endif




            </div>
            <div>3</div>
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
        $(".count_price").text(Math.abs(count_price+pf));
        $(".count_title").text(title);
    }
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
    $(".submit_check").click(function (e) {
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
        if (!orders || !pf || !name || !address ||  !telphone || !province_type)
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
</script>
@include('PC.Suki.SukiFooter')