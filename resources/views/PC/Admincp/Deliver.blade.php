@include('PC.Common.HtmlHead')
<style>
    body {background: #FFFFFF}

</style>
<body style="padding: 20px">
    <div style="margin-bottom: 10px">订单号</div>
    <input type="hidden" value="{{$data["id"]}}" class="form-control id">
    <input type="text" class="form-control waybill_no"  >
    <input type="submit" value="提交" class ="submit">
</body>

<script>
    $(document).ready(function () {
        $(".submit").click(function (e) {
            e.preventDefault();
            var id = $(".id").val();
            var waybill_no = $(".waybill_no").val();
            pd = {id:id,waybill_no:waybill_no}
            $.post("/admincp/do_deliver",pd,function (e) {
                console.log(pd)
                alert(e.msg)
                layer.closeAll()
            })
        })
    })
</script>