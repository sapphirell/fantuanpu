@include('PC.Common.HtmlHead')
<style>
    body {background: #FFFFFF}
</style>
<div style="padding: 10px">
    <h5>请转账至支付宝{{$data["order"]->order_price}}元</h5>
    <p>15658610102</p>
    <p>麻酥幽卷儿</p>
    <p>转账请备注QQ号和网站ID</p>

    <input type="hidden" class="orderId" value="{{$data["order"]->id}}">
    <input type="submit" value="我已转账" class="submit">
</div>

<script>
    $(document).ready(function () {
        $(".submit").click(function (e) {
            e.preventDefault()
            var postData = {
                "alipay_order_sn": $(".alipay_order_sn").val(),
                "orderId" : $(".orderId").val()
            };

            $.post("/suki_group_buying_confirm_orders",postData,function (event) {
                alert(event.msg)
                if (event.ret == 200)
                {
                    window.parent.location.reload()
                }
            })
        })

    });
</script>