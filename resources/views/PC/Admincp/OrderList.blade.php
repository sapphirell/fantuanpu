@include('PC.Admincp.AdminHeader')

<div class="wp admin" style="min-height: 200px;">


    <table class="table">
        <tr>
            <td>用户名</td>
            <td>订单详情</td>
            <td>总价</td>
            <td>qq</td>
            <td>group_id</td>


        </tr>
        @foreach($data["list"] as $key => $value)
            <?php $user = get_user($value->uid); ?>
            <tr>
                <td>{{$user->username}}<br>[{{$value->uid}}]<br>
                    @if(in_array($value->id,$data["err_id"]))
                        <span style="color: #8c3900">可能已经发货 <a class="check_package" href="/admincp/check_package?id={{$value->id}}">校准</a> </span>
                    @endif

                    {{--oid:{{$value->id}}--}}
                </td>
                <td>{!! $value->info !!}</td>
                <td>{{$value->order_price}}/@if($value->status == 1){{"等待付款"}}@else{{"已付款"}}@endif</td>
                <td>{{$user->qq}}</td>
                <td>{{$value->group_id}}团</td>


            </tr>
        @endforeach
    </table>




</div>

<script>
    $(document).ready(function (e) {
        $(".check_package").click(function (e) {
            e.preventDefault();
            var ref = $(this).attr("href");
            $.get(ref,function (e) {
                alert(e.msg);
                window.location.reload()
            })
        })
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

    })
</script>