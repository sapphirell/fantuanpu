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
        font-size: 14px;
    }
    .rmb {
        color: #000;
        font-size: 12px;
        margin-right: 5px;
    }
    .tb_msg {
        font-size: 14px;
    }
    .switch_order_view {

    }
    .mb-3, .my-3 {
        margin-bottom: 1.5rem!important;
    }
</style>
<div class="wp" style="margin-top: 60px;    padding: 5px;">

    <div class="btn-group show" style="margin-bottom: 10px;" role="group">
        <button style="border: 0px;color: #999999;box-shadow: 0 0 5px #f1f1f1;background-color: #fff;padding: 6px 15px;margin-left: 0px;" type="button" class="btn btn-secondary dropdown-toggle tb" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            切换表单
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; transform: translate3d(10px, 25px, 0px); top: 0px; left: 0px; will-change: transform;">
            <a href="/suki_group_buying_myorders" class="dropdown-item setting_clock_alert">全部</a>
            <a href="/suki_group_buying_myorders?type=last" class="dropdown-item setting_clock_alert">本期</a>
        </div>
    </div>
    <a href="suki_group_buying_myorders?type=" class="switch_order_view"></a>
    <table class="table" style="background: #fff;    font-size: 12px;padding: 10px;color: #795353;border: 1px solid #fad4d0;background-color: white;border-radius: 5px;">
        <tr style="background-color: #f9bec2;border-radius: 5px;overflow: hidden;">
            <td>名字</td>
            <td>详情</td>
            <td>创建时间</td>
            <td>截单日</td>
            <td>状态</td>

            <td>价格</td>
        </tr>
        @foreach($data['orders'] as $value)
            <tr>
                <td><a style="    color: #d4838e;" href="/suki_group_buying_item_info?item_id={{$value->item_id}}">{{$value->item_name}}</a></td>
                <td>
                    @foreach($value->order_info as $orderInfoKey =>  $orderInfoValue)
                        {{$type = explode("_",$orderInfoKey)}}
                        {{$type[0] ."码". $type[1]   . $orderInfoValue ."个"}} ,
                    @endforeach
                </td>
                <td>{{$value->create_date}}</td>
                <td>{{$value->end_date}}</td>
                <td>
                    @if($value->status == 1)
                        提交跟团 <a class="suki_group_buying_cancel_orders" onclick=""
                                href="/suki_group_buying_cancel_orders" orderId="{{$value->log_id}}">取消订单</a>
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
                    @endif
                </td>

                <td>{{$value->order_price}}</td>
            </tr>

        @endforeach
    </table>

    @if($data["request"]["type"] == "last")
        <div style="background-color: #ffb6c7;
                    background-image: linear-gradient(90deg, #fbded9 0%, #ffa5b2 93%);
                    color: #FFFFFF;
                    font-size: 13px;
                    padding: 3px 15px;
                    border-radius: 5px 5px 0px 0px;
">
            --
            @if($data['order_commit_status'] == -1)
                暂不可付款 --(预计 {{$data['orders'][0]->end_date}}可以付款)
            @elseif($data['order_commit_status'] == 1)
                请尽快补完信息并付款
            @elseif($data['order_commit_status'] == 2)
                等待收款确认
            @elseif($data['order_commit_status'] == 3)
                订单完成
            @endif

        </div>
        <table class="table" style="background: #FFFFFF">
            <tr>
                <td class="tb_title">商品原价总和</td>
                <td class="tb_msg"><span class="rmb">￥</span>{{$data["order_info"]["all_price"] ? : "暂未计算"}}</td>
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
                <td class="tb_msg"><span class="rmb">￥</span>{{$data["order_info"]["all_price"] ? $data["order_info"]["all_price"] + $data["order_info"]["private_freight"] + 10 : "暂未计算"}}</td>
            </tr>

        </table>
        @if($data["order_commit_status"] == 1)
            <div style="padding: 20px;background: #FFFFFF">
            <form>
                <input class="orderId" type="hidden" value="{{$data["order_info"]["id"]}}">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" >收件人</span>
                    </div>
                    <input type="text" class="form-control name" placeholder=""  name=""  value="{{$data["last"]->name}}">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" >收货地址</span>
                    </div>
                    <input type="text" class="form-control address" placeholder=""  name=""  value="">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" >收货手机号</span>
                    </div>
                    <input type="text" class="form-control telphone" placeholder="" name="" value="">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">您的qq号</span>
                    </div>
                    <input type="text" class="form-control qq" placeholder=""  value="{{$data["user_info"]->qq}}">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" >付款单号</span>
                    </div>
                    <input type="text" class="form-control alipay_order" placeholder="请确认您已经通过支付宝转账"  value="">
                </div>
                <input type="button" class="submit_to_order"  value="提交" order_id="{{$data["order_info"]["id"]}}">
            </form>
        </div>
        @endif
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
                    window.location.reload()
                })
            }
            else {
                return false;
            }
        })
        $(".submit_to_order").click(function (e) {
            $.post("/suki_group_buying_confirm_orders",{
                "name":$(".name").val(),
                "address" : $(".address").val(),
                "telphone" : $(".telphone").val(),
                "qq" : $(".qq").val(),
                "orderId" : $(".orderId").val(),
                "alipay_order" : $(".alipay_order").val(),
            },function (e) {
                alert(e.msg);
//                window.location.reload()
            })
        });
    })
</script>
@include('PC.Suki.SukiFooter')