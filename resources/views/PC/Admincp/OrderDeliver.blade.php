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

    <table class="table" style="width: 1300px">
        <tr>
            <td>用户名</td>
            <td>收货人</td>
            <td style="width: 100px">收货地址</td>
            <td style="width: 100px">应收款</td>
            <td>手机号</td>
            <td  style="width:80px ">勾选地域</td>
            <td>qq</td>
            <td>备注</td>
            <td style="    min-width: 400px;">订单</td>
            <td style="width: 130px">操作</td>
        </tr>

        @foreach($data["list"] as $value)
            <?php $user = get_user($value->uid) ?>
            <tr>
                <td>{{$user->username}}[{{$value->uid}}]</td>
                <td>{{$value["name"]}}</td>
                <td>{{$value["address"]}}</td>
                <td>{{round($value['private_freight'] + $value['price_difference']  + $value['freight'],2) }}</td>
                <td>{{$value["telphone"]}}</td>
                <td>
                    @if($value->freight == 5.5)
                        江浙沪
                    @elseif($value->freight == 7)
                        其它
                    @else
                        藏疆
                    @endif
                </td>
                <td>{{$user->qq}}</td>
                <td>{{$user->remark}}</td>
                <td>{!! $value->order_info !!}</td>
                <td>
                    @if($data["type"] == "1" || $data["type"] == "2")
                    <a class="order_delivers" expressid="{{$value->id}}" to_status="2">确认价格</a>
                    <br>
                    <a class="order_delivers" expressid="{{$value->id}}" to_status="3">确认收款</a>
                    <br>
                    <a class="chargeback"  expressid="{{$value->id}}">拒绝发货</a>
                    @endif
                    @if($data["type"] == "3")

                            <a href="#" class="deliver" orderId="{{$value->id}}"  style="color: #ff647c">发货</a>
                    @endif
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
        //发货
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
        $(".chargeback").click(function (e) {
            e.preventDefault();

            var id = $(this).attr("expressid");
            $.post("/admincp/chargeback",{id:id},function (e) {
                alert(e.msg)
                window.location.reload()
            })
        })
    })
</script>