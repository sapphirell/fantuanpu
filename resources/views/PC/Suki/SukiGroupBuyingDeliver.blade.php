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
    .detail {
        position: absolute;
        width: 125px;
        left: -32px;
        top: -40px;
        background: #fff;
        padding: 7px;
        box-shadow: 0 0 4px #ddd;
        display: none;
    }
</style>
<div class="wp" style="margin-top: 60px;    padding: 5px;">
    {{--{{dd(json_decode($data['my_order'][0]->order_info),true)}}--}}
    <div class="btn-group show" style="margin-bottom: 10px;" role="group">
        <button style="border: 0px;color: #999999;box-shadow: 0 0 5px #f1f1f1;background-color: #fff;padding: 6px 15px;margin-left: 0px;" type="button" class="btn btn-secondary dropdown-toggle tb" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            切换表单
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; transform: translate3d(10px, 25px, 0px); top: 0px; left: 0px; will-change: transform;">
            <a href="/suki_group_buying_deliver?type=1" class="dropdown-item setting_clock_alert">查看订单</a>
            <a href="/suki_group_buying_deliver?type=2" class="dropdown-item setting_clock_alert">发货申请</a>

        </div>
    </div>
    @if($data["type"] == 1)
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
                                <input type="checkbox" class="check"  orderId="{{$value->id}}" price="{{
                            ($value->true_private_freight
                            ?:$value->private_freight)
                            +
                            (($value->true_price ? ($value->true_price - $value->order_price):0))
                        }}">
                            </label>
                        @endif
                    </td>

                </tr>

            @endforeach

            <td>
                <select class="select_province" style="width: 100px;padding: 0px;font-size: 12px;height: 25px;">
                    <option value="0|0">请选择!!</option>
                    <option  value="5.5|1">苏浙沪皖</option>
                    <option   value="7|2">京津冀晋辽吉黑闽赣鲁豫鄂湘粤桂琼川贵滇渝陕甘青宁</option>
                    <option value="18|3">藏疆</option>
                </select>
            </td>
            <td  colspan="2" style="    padding-top: 12px;">
                <span class="count_title">需支付</span>:
                <span class="count_price">0</span>元
            </td>

            <td  colspan="2" style="width: 70px;    padding-top: 12px;">
                <a class="submit_check btn btn-info" style="float: right;color: #FFFFFF">
                    [申请发货勾选的]
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
                    <input type="text" class="form-control name" placeholder=""  name=""  value="{{$data["address"]->name}}">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" >收货地址</span>
                    </div>
                    <input type="text" class="form-control address" placeholder=""  name=""  value="{{$data["address"]->address}}">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" >收货手机号</span>
                    </div>
                    <input type="text" class="form-control telphone" placeholder="" name="" value="{{$data["address"]->telphone}}">
                </div>

            </form>
        </div>
    @else
        <table class="table" style="background: #fff;font-size: 12px;padding: 10px;color: #795353;border: 1px solid #fad4d0;background-color: white;border-radius: 5px;">
            <tr style="background-color: #fff5f5;;border-radius: 5px;overflow: hidden;">

                <td>申请发货的订单id</td>
                <td>物流单号</td>
                <td style="width: 80px">状态</td>
                <td>金额</td>
                <td style="width: 70px">操作</td>

            </tr>
            @foreach($data['my_express'] as $value)
                <tr >
                    <td>{{$value->orders}}</td>
                    <td>{{$value->waybill_no}}</td>
                    <td style="width: 80px">
                        @if($value["status"] == 1)
                            {{
                            ($value['private_freight'] + $value['price_difference']  + $value['freight'] > 0)?
                                "等待补邮费" :"等待退差额"
                             }}
                        @elseif($value["status"] == 2)
                            {{
                            ($value['private_freight'] + $value['price_difference']  + $value['freight'] > 0)?
                                "需要补邮费" :"等待退差额"
                             }}
                        @elseif($value["status"] == 3)
                            待发货
                        @elseif($value["status"] == 4)
                            已发货
                        @endif

                    </td>
                    <td style="position: relative">{{
                        abs($value['private_freight'] + $value['price_difference']  + $value['freight'])
                     }}元
                        <i class="fa-question-circle fa show_detail" for="{{$value->id}}" title="明细" style="margin: 5px;"></i>
                        <span id="{{$value->id}}" style="position: absolute;" class="detail">
                            公摊:{{$value['private_freight']}},
                            流团退款:{{$value['price_difference']}},
                            个人运费:{{$value['freight']}}
                        </span>
                    </td>
                    <td style="width: 70px">操作</td>
                </tr>
            @endforeach


        </table>
    @endif






</div>
<script>
//    Array.prototype.indexOf = function(val) {
//        for (var i = 0; i < this.length; i++) {
//            if (this[i] == val) return i;
//        }
//        return -1;
//    };
//    Array.prototype.remove = function(val) {
//        var index = this.indexOf(val);
//        if (index > -1) {
//            this.splice(index, 1);
//        }
//    };
    var pf = 0
    var count_price = 0
    var title = "需要支付"
    var orders = []
    var province_type
    function cancelOrder(e) {
        e.preventDefault()

    }
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
    $(document).ready(function () {


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
        })
        $(".submit_check").click(function (e) {
            var address = $(".address").val();
            var telphone = $(".telphone").val();
            var name = $(".name").val()
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
            var s = $(this).val().split("|")

            pf = parseFloat(s[0])
            province_type = s[1]
            change_count()
        })
        $("input:checkbox").trigger("click");

        $(".show_detail").click(function () {
            var id = $(this).attr("for")
            $("#"+id).show();
        })
        $("body").click(function () {
            
        })
    })
</script>
@include('PC.Suki.SukiFooter')