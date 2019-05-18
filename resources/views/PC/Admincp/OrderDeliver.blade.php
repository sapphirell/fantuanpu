@include('PC.Admincp.AdminHeader')

<div class="wp admin" style="min-height: 200px;">
    <div class="btn-group show" style="margin-bottom: 10px;" role="group">
        <button style="border: 0px;color: #999999;box-shadow: 0 0 5px #f1f1f1;background-color: #fff;padding: 6px 15px;margin-left: 0px;" type="button" class="btn btn-secondary dropdown-toggle tb" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            切换表单
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; transform: translate3d(10px, 25px, 0px); top: 0px; left: 0px; will-change: transform;">
            <a href="/admincp/order_delivers?type=1" class="dropdown-item setting_clock_alert">提交申请</a>
            <a href="/admincp/order_delivers?type=2" class="dropdown-item setting_clock_alert">需要补邮费</a>
            <a href="/admincp/order_delivers?type=3" class="dropdown-item setting_clock_alert">待发货</a>
            <a href="/admincp/order_delivers?type=4" class="dropdown-item setting_clock_alert">已发货</a>
        </div>
    </div>

    <table class="table">
        <tr>
            <td>用户名</td>
            <td>收货人</td>
            <td>收货地址</td>
            {{--<td>费用</td>--}}
            <td>手机号</td>
            {{--<td>qq</td>--}}
            <td style="width: 130px">操作</td>
        </tr>

        @foreach($data["list"] as $value)
            <?php $user = get_user($value->uid) ?>
            <tr>
                <td>{{$user->username}}</td>
                <td>{{$value["name"]}}</td>
                <td>{{$value["address"]}}</td>
{{--                <td>{{$value['private_freight'] + $value['price_difference']  + $value['freight'] }}</td>--}}
                <td>{{$value["telphone"]}}</td>
                {{--<td>{{$user->qq}}</td>--}}
                <td>
                    <a class="order_delivers" expressid="{{$value->id}}" to_status="2">确认价格</a>
                    <br>
                    <a class="order_delivers" expressid="{{$value->id}}" to_status="3">确认收款</a>
                </td>
            </tr>
        @endforeach
    </table>

</div>

<script>
    $(document).ready(function (e) {
        $(".order_delivers").click(function (e) {
            e.preventDefault();
            var to_status = $(this).attr("to_status");
            var id = $(this).attr("expressid");
            $.post("/admincp/delivers_status",{'to_status':to_status,id:id},function (e) {
                alert(e.msg)
                window.location.reload()
            })
        })


    })
</script>