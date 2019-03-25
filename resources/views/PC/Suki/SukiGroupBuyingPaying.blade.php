@include('PC.Common.HtmlHead')
<style>
    body {background: #FFFFFF}
</style>
<div style="padding: 10px">
    <h5>支付宝转账的流水号</h5>

    <input type="hidden" value="{{$data["request"]["order_id"]}}" class="orderId" >
    <input type="text" class="form-control alipay_order_sn" />
    <input type="submit" class="submit">
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