@include('PC.Admincp.AdminHeader')

<div class="wp admin" style="min-height: 200px;">


        <table class="table">
            <tr>
                <td>用户名</td>
                <td>订单详情</td>
                <td>总价</td>
                <td>qq</td>
                <td>操作</td>

            </tr>
            @foreach($data["not_pay_order"] as $key => $value)
                <?php $user = get_user($value->uid); ?>
                <tr>
                    <td>{{$user->username}}[{{$value->uid}}]</td>
                    <td>{!! $value->order_info !!}</td>
                    <td>{{$value->order_price}}/@if($value->status == 1){{"等待付款"}}@else{{"已付款"}}@endif</td>
                    <td>{{$user->qq}}</td>
                    <td>
                        <a href="">确认收款</a>
                        <a>取消</a>
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