@include('PC.Admincp.AdminHeader')

<div class="wp admin" style="min-height: 200px;">

    <table class="table">
        <tr>
            <td>时间</td>
            <td>用户名</td>
            <td>购买详情</td>
            <td>应付款</td>
            <td>qq交谈</td>
            <td>状态</td>
            <td>操作</td>

        </tr>
        @foreach($data["list"] as $value)
            <?php $user = get_user($value->uid); ?>
            <tr>
                <td>时间</td>
                <td>{{$user->username}}</td>
                <td>
                    {!! $value->order_info !!}
                </td>
                <td>{{$value->order_price + $value->private_freight + 10}}</td>
                <td>
                    <a href="http://sighttp.qq.com/msgrd?v=1&uin={{$value->qq ? : $user->qq}}">交谈</a>
                </td>
                <td>
                    @if($value->status == 1)
                        <span>等待付款</span>
                    @elseif($value->status == 2)
                        <span>等待收款确认</span>
                    @elseif($value->status == 3)
                        <span>已发货</span>
                    @endif
                </td>
                <td>
                    @if($value->status == 1)
                        <span>无</span>
                    @elseif($value->status == 2)
                        <a href="#" class="deliver" orderId="{{$value->id}}">发货</a>
                    @elseif($value->status == 3)
                        <span>无</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

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

    })
</script>