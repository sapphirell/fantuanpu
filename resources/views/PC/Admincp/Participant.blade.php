@include('PC.Admincp.AdminHeader')

<div class="wp admin" style="min-height: 200px;">
    @if($data["status"] == 2)
        <table class="table">
            <tr>
                <td>用户名</td>
                <td>订单详情</td>
                <td>总价</td>
                <td>赚取</td>
            </tr>
            @foreach($data["list"] as $key => $value)
                <tr>
                    <td>{{$key}}</td>
                    <td>{!! $value["item"] !!}</td>
                    <td>{{$value["price"]}}</td>
                    <td>{{$value["premium"]}}</td>
                    <?php $premium += $value["premium"]; ?>
                    <?php $count += 1;?>
                    <?php $price += $value["price"];?>
                </tr>
            @endforeach
        </table>
        <div>
            总价格:{{$price}}
            总赚取:{{$premium}}
            总人数: {{$count}}
        </div>
    @endif
    @if($data["status"] == 3)
    <table class="table" style="width: 1300px">
        <tr>

            <td>用户名</td>
            <td>购买详情</td>
            <td>应付款</td>
            <td>qq</td>
            <td style="width: 120px">状态</td>
            <td style="width: 120px">操作</td>

        </tr>
        @foreach($data["list"] as $value)
            <?php $user = get_user($value->uid); ?>
            <tr>
                <td>{{$user->username}}</td>
                <td>
                    {!! $value->order_info !!}
                </td>
                <td>{{$value->order_price}}</td>
                <td>
                    {{$value->qq ? : $user->qq}}
                </td>
                <td>
                    @if($value->status == 1)
                        <span style="color: #7d4a4a">等待付款</span>
                    @elseif($value->status == 2)
                        <span style="color: #8798b4">等待收款确认</span>
                    @elseif($value->status == 3)
                        <span>已发货</span>
                    @endif
                </td>
                <td>
                    @if($value->status == 1)
                        <span>无</span>
                    <br>
                        <a href="#" class="confirm" orderId="{{$value->id}}" msg="{{$user->username . "付款了" . $value->order_price}}" style="color: #00A0FF">[强制确认]</a>
                    <br>
                        <a href="/admincp/skip_orders" class="skip_orders" orderId="{{$value->id}}"style="color: #00A0FF">[跑]</a>
                    @elseif($value->status == 2)
                        <a href="#" class="confirm" orderId="{{$value->id}}" msg="{{$user->username . "付款了" . $value->order_price}}" style="color: #00A0FF">确认</a>
                    @elseif($value->status == 3)
                        <span>无</span>
                    @elseif($value->status == 4)
                        <a href="#" class="deliver" orderId="{{$value->id}}"  style="color: #ff647c">发货</a>
                    @elseif($value->status == 5)
                        <p>已跑单</p>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    @endif


</div>

<script>
    $(document).ready(function (e) {
        $(".deliver").click(function (e) {
            e.preventDefault();
            var id = $(this).attr("orderId");
            layer.open({
                type: 2,
                title: false,
                closeBtn: 0, //不显示关闭按钮
                shade: 0.8,
                shadeClose: true,
                area: ["900px", '405px'],
                offset: '100px',
                content: ['/admincp/deliver?id='+id,'no']
            });
        })
        $(".confirm").click(function (e) {
            e.preventDefault();
            var id = $(this).attr("orderId");
            var msg = $(this).attr("msg");
            var cof = confirm("要确定" + msg + "吗")
            if (cof) {
                $.post("/admincp/confirm_group_buying_user_order",{id:id},function (e) {
                    alert(e.msg);
                    window.location.reload()
                })
            }
        });
        $(".skip_orders").click(function (e) {
            e.preventDefault();
            var id = $(this).attr("orderId");
            var msg = $(this).attr("msg");
            var cof = confirm("要确定跑单吗")
            if (cof) {
                $.post("/admincp/skip_orders",{id:id},function (e) {
//                    alert(e.msg);
//                    window.location.reload()
                })
            }
        })
    })
</script>