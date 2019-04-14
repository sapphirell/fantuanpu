@include('PC.Suki.SukiHeader')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<style>
    .input-group-text {
        width: 80px
    }

    .bs-callout {
        padding: 20px;
        margin: 20px 0;
        border: 1px solid #eee;
        border-left-width: 5px;
        border-radius: 3px;
        background: #FFFFFF;
        font-size: 17px;
    }

    .bs-callout-info {
        border-left-color: #1b809e;
    }
    .table td, .table th
    {
        border-top: 1px solid #fad4d1;
    }

    .tb_title {
        text-align: right;
        width: 200px;
        color: #ddd;
        font-size: 15px;
    }
    .rmb {
        color: #000;
        font-size: 12px;
        margin-right: 5px;
    }
    .tb_msg {
        font-size: 14px;
    }
</style>
<div class="wp" style="margin-top: 60px;">
    <table class="table" style="background: #fff;padding: 10px;color: #795353;border: 1px solid #fad4d0;background-color: white;border-radius: 5px;">
        <tr style="background-color: #ffb6c7;background-image: linear-gradient(90deg, #fbded9 0%, #ffa5b2 93%);border-radius: 5px;overflow: hidden;">
            <td>名字</td>
            <td>创建时间</td>
            <td>截单日</td>
            <td>状态</td>
            <td>详情</td>
            <td>价格</td>
        </tr>
        @foreach($data['orders'] as $value)
            <tr>
                <td><a style="    color: #d4838e;" href="/suki_group_buying_item_info?item_id={{$value->item_id}}">{{$value->name}}</a></td>
                <td>{{$value->create_date}}</td>
                <td>{{$value->end_date}}</td>
                <td>
                    @if($value->status == 1)
                        提交跟团 <a class="suki_group_buying_cancel_orders" onclick=""
                                href="/suki_group_buying_cancel_orders" orderId="{{$value->id}}">取消订单</a>
                    @elseif($value->status == 2)
                        等待确认付款 <a class="suki_group_buying_paying " orderId="{{$value->id}}"
                                  href="/suki_group_buying_paying">提交付款证明</a>
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
                    @endif
                </td>
                <td>
                    @foreach($value->order_info as $orderInfoKey =>  $orderInfoValue)
                        {{$type = explode("_",$orderInfoKey)}}
                        {{$type[0] ."码". $type[1]   . $orderInfoValue ."个"}}
                    @endforeach
                </td>
                <td>{{$value->order_price}}</td>
            </tr>

        @endforeach
    </table>

    @if($data["request"]["type"] == "last")
    <div style="background-color: #ffb6c7;
                background-image: linear-gradient(90deg, #fbded9 0%, #ffa5b2 93%);
                color: #FFFFFF;
                font-size: 15px;
                padding: 3px 15px;
                border-radius: 5px 5px 0px 0px;">
        订单
    </div>
    <table class="table" style="background: #FFFFFF">
        <tr>
            <td class="tb_title">商品原价总和</td>
            <td class="tb_msg"><span class="rmb">￥</span>{{$data["order_info"]["all_price"]}}</td>
        </tr>
        <tr>
            <td class="tb_title">公摊运费总和</td>
            <td class="tb_msg"><span class="rmb">￥</span>{{$data["order_info"]["private_freight"] ? : "暂未计算"}}</td>
        </tr>
        <tr>
            <td class="tb_title">个人运费</td>
            <td class="tb_msg"><span class="rmb">￥</span>10</td>
        </tr>
        <tr>
            <td class="tb_title">以上合计</td>
            <td class="tb_msg"><span class="rmb">￥</span>10</td>
        </tr>
    </table>
    @endif
</div>
<script>
    function cancelOrder(e) {
        e.preventDefault()

    }
    $(document).ready(function () {
        $(".suki_group_buying_cancel_orders").click(function (e) {
            e.preventDefault();
            var orderId = $(this).attr("orderId")
            var r = confirm("确定取消吗?")
            if (r == true) {
                $.get("/suki_group_buying_cancel_orders?orderId=" + orderId, function (e) {
                    alert(e.msg)
                })
            }
            else {
                return false;
            }
        })
        $(".suki_group_buying_paying").click(function (e) {
            var orderId = $(this).attr("orderId")
            e.preventDefault();
            layer.open({
                type: 2,
                title: false,
                closeBtn: 0,
                shadeClose: true,
                area: ['460px', '400px'],
                offset: '100px',
                class: 'asd',
                // skin: 'layui-layer-rim', //加上边框
                content: ['/suki_group_buying_paying?order_id=' + orderId, 'no']
            });
        });
    })
</script>
@include('PC.Suki.SukiFooter')