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
    .table td, .table th {
        border-top: 1px solid #ffd1cc!important;
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
    .rule li {
        padding: 5px 0px;
        color: #5a5a5a;
    }
</style>
<div class="wp" style="margin-top: 60px;    padding: 5px;">
    {{--{{dd(json_decode($data['my_order'][0]->order_info),true)}}--}}

    <table class="table" style="background: #fff;font-size: 12px;padding: 10px;color: #795353;border: 1px solid #fad4d0;background-color: white;border-radius: 5px;">
        <tr style="background-color: #fff5f5;;border-radius: 5px;overflow: hidden;">

            <td>详情</td>
            <td>公摊</td>
            <td>创建时间</td>
            <td style="width: 80px">状态</td>
            <td style="width: 70px">操作</td>

        </tr>
        @foreach($data['my_order'] as $value)
            <tr>
                <td>
                    {{$order_info = json_decode($value->order_info,true)}}
                    {{--{{dd($order_info)}}--}}
                    <?php unset($order_info["log_id"]); ?>
                    @foreach($order_info as $order)

                        {{$order["item_detail"]["item_name"]}}
                        @foreach($order["detail"] as $feature => $num)
                        {{$feature  . " : " . $num ."个"}}
                        @endforeach
                        <br>
                    @endforeach
                </td>
                <td>{{$value->true_private_freight ? : $value->private_freight}}</td>
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
                    {{-- status 1= 等待付款 2=等待收款确认 3=已发货 4=确认商品原价收款 5=逃单 6=已申请发货--}}
                    @if($value->status == 1)
                        <p>等待付款(原价)</p>
                    @elseif($value->status == 2)
                        <p>等待确认</p>
                    @elseif($value->status == 3)
                        <p>已发货</p>
                    @elseif($value->status == 4)
                        <p>已收款</p>
                    @elseif($value->status == 5)
                        <p>逃单</p>
                    @elseif($value->status == 6)
                        <p>已申请发货</p>
                    @endif
                </td>
                <td>
                    @if($value->status == 4)
                    <label>
                        勾选
                        <input type="checkbox">
                    </label>
                    @endif
                </td>

            </tr>

        @endforeach
        <td></td>
        <td></td>
        <td></td>

        <td  colspan="2" style="width: 70px">
            <a>
                申请发货勾选的
            </a>

        </td>
    </table>

    <ol class="rule">
        <li>您可以勾选您想要发货的快递,我们会以下面的地址计算邮费和发货(每个地区邮费不同)</li>
        <li>您可稍候一段时间,或通知QQ群内的群主查看您的发货申请,我们核对好邮费后,您需要根据此页面的邮费进行补款,我们收到付款后会通知快递来取件。</li>
        <li>如果您在一期团购中购买的数量较少,可以暂时囤货不发,但不宜囤过多,商品超过一公斤的快递超重还需付超重费用。</li>
    </ol>
    <div style="background-color: #ffb6c7;
                    background-image: linear-gradient(90deg, #fbd9d9 0%, #fff9f7 93%);
                color: #FFFFFF;
                font-size: 13px;
                padding: 6px 15px;

">
        您的收货地址

    </div>

    <div style="padding: 20px;background: #FFFFFF">
        <p style="font-size: 15px;margin-bottom: 10px;">操作说明:</p>

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

            <input type="button" class="submit_to_order"  value="提交" order_id="{{$data["order_info"]["id"]}}">
        </form>
    </div>


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