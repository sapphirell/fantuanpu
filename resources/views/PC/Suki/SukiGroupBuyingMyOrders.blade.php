@include('PC.Suki.SukiHeader')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<style>
    .input-group-text {width: 80px}
</style>
<div class="wp" style="margin-top: 60px;">
    <table class="table">
        <tr>
            <td>名字</td>
            <td>创建时间</td>
            <td>截单日</td>
            <td>状态</td>
            <td>详情</td>
            <td>价格</td>
        </tr>
        @foreach($data['orders'] as $value)
            <tr>
                <td>{{$value->name}}</td>
                <td>{{$value->create_date}}</td>
                <td>{{$value->end_date}}</td>
                <td>
                    @if($value->status == 1)
                        提交跟团 <a class="suki_group_buying_cancel_orders" onclick="" href="/suki_group_buying_cancel_orders" orderId="{{$value->id}}">取消订单</a>
                    @elseif($value->status == 2)
                        等待确认付款 <a class="suki_group_buying_paying " orderId="{{$value->id}}" href="/suki_group_buying_paying">提交付款证明</a>
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
</div>
<script>
    function cancelOrder(e) {
        e.preventDefault()

    }
    $(document).ready(function () {
        $(".suki_group_buying_cancel_orders").click(function (e) {
            e.preventDefault();
            var orderId = $(this).attr("orderId")
            var r=confirm("确定取消吗?")
            if (r==true)
            {
                $.get("/suki_group_buying_cancel_orders?orderId="+orderId,function (e) {
                    alert(e.msg)
                })
            }
            else
            {
                return false;
            }
        })
        $(".suki_group_buying_paying").click(function (e) {
            var orderId = $(this).attr("orderId")
            e.preventDefault();
            layer.open({
                type: 2,
                title:false,
                closeBtn: 0,
                shadeClose: true,
                area: ['460px', '400px'],
                offset: '100px',
                class : 'asd',
                // skin: 'layui-layer-rim', //加上边框
                content: ['/suki_group_buying_paying?order_id=' + orderId, 'no']
            });
        });
    })
</script>
@include('PC.Suki.SukiFooter')