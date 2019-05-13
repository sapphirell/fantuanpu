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
        border-top: 1px solid #ffebe9;
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
    <table class="table" style="background: #fff;font-size: 12px;padding: 10px;color: #795353;border: 1px solid #fad4d0;background-color: white;border-radius: 5px;">
        <tr style="background-color: #fff5f5;;border-radius: 5px;overflow: hidden;">
            <td>名字</td>
            <td>详情</td>
            <td>创建时间</td>
            <td style="width: 80px">状态</td>

        </tr>
        @foreach($data['orders'] as $value)
            <tr>
                <td><a style="    color: #d4838e;" href="/suki_group_buying_item_info?item_id={{$value->item_id}}">{{$value->item_name}}</a></td>
                <td>
                    @foreach($value->order_info as $orderInfoKey =>  $orderInfoValue)
                        {{$type = explode("_",$orderInfoKey)}}
                        {{$type[0] ."码". $type[1]   . $orderInfoValue ."个"}} ,
                        <br>
                    @endforeach
                </td>
                <td>
                    {{date("m/d H:i",strtotime($value->create_date))}}
                </td>
                <td>
                    <?php
                        if($value->status !== 4 && $value->status !== 9)
                        {
                            $all_ori_price +=  $value->order_price;
                        }

                    ?>
                    @if($value->status == 1)
                        <p>等待拼团</p><br>
                        <p>{{$value->order_price}}元</p><br>
                         <a class="suki_group_buying_cancel_orders" onclick=""
                                href="/suki_group_buying_cancel_orders" orderId="{{$value->log_id}}">取消订单</a>
                    @elseif($value->status == 2)
                        <p>{{$value->order_price}}元</p><br>

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
                </td>


            </tr>

        @endforeach
    </table>

    @if($data["request"]["type"] == "last")
        <div style="background-color: #ffb6c7;
                        background-image: linear-gradient(90deg, #fbd9d9 0%, #fff9f7 93%);
                    color: #FFFFFF;
                    font-size: 13px;
                    padding: 6px 15px;

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
            @elseif($data['order_commit_status'] == 4)
                已经收到您的货款,等待全部人的货款收到后或超最晚付款时间后下单
            @endif

        </div>
        <table class="table" style="background: #FFFFFF">
            <tr>
                <td class="tb_title">商品原价总和</td>
                <td class="tb_msg"><span class="rmb">￥</span>
                    @if($data["order_info"]["all_price"])
                        {{$data["order_info"]["true_price"]}}
                    @else
                        {{$data["order_info"]["true_price"] ? : "暂未计算"}} (本次暂不需要转这个)
                    @endif
                    元</td>
            </tr>
            <tr>
                <td class="tb_title">预估公摊运费总和</td>
                <td class="tb_msg"><span class="rmb">￥</span>

                    @if($data["order_info"]["true_private_freight"])
                        {{$data["order_info"]["true_private_freight"]}}
                    @else
                        {{$data["order_info"]["private_freight"] ? : "暂未计算"}} (仅做预览)
                    @endif

                </td>
            </tr>
            <tr>
                <td class="tb_title">真实运费</td>
                <td class="tb_msg"><span class="rmb">￥</span>
                        {{$data["order_info"]["true_private_freight"] ? : "暂未计算"}}


                </td>
            </tr>
            <tr>
                <td class="tb_title">个人运费</td>
                <td class="tb_msg"><span class="rmb">￥</span></td>
            </tr>
            <tr>
                <td class="tb_title">本次需支付:(运费到货后补)</td>
                <td class="tb_msg"><span class="rmb">￥</span>{{$data["order_info"]["all_price"] ? $data["order_info"]["all_price"]  : "暂未计算"}}</td>
            </tr>

        </table>
        @if($data["order_commit_status"] == 1)
            <div style="padding: 20px;background: #FFFFFF">
                <p style="font-size: 15px;margin-bottom: 10px;">请确认您已经通过支付宝转账、填写收货信息、并点击下面的提交!</p>
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

                {{--<div class="input-group mb-3">--}}
                    {{--<div class="input-group-prepend">--}}
                        {{--<span class="input-group-text" >付款单号</span>--}}
                    {{--</div>--}}
                    {{--<input type="text" class="form-control alipay_order" placeholder="请确认您已经通过支付宝转账"  value="">--}}
                {{--</div>--}}
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
            var name = $(".name").val()
            var telphone =  $(".telphone").val()
            var qq = $(".qq").val()
            var orderId = $(".orderId").val()

            if (!name || !telphone || !qq || !orderId )
            {
                alert("须填写完整")
                return ;
            }
            $.post("/suki_group_buying_confirm_orders",{
                "name":$(".name").val(),
                "address" : $(".address").val(),
                "telphone" : $(".telphone").val(),
                "qq" : $(".qq").val(),
                "orderId" : $(".orderId").val(),
            },function (e) {
                alert(e.msg);
                window.location.reload()
            })
        });
    })
</script>
@include('PC.Suki.SukiFooter')