<!doctype html>
@include('PC.Common.HtmlHead')
<style>
    body {
        background: #FFFFFF;
    }
    .input-group {
        margin: 10px 0px;
    }
</style>

<div style="padding: 15px;">

    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">设定名称</div>
        </div>
        <input type="text" class="form-control set_name" placeholder="自定义的名称" aria-label="自定义的名称" aria-describedby="btnGroupAddon">
    </div>

    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text " >设定金额</div>
        </div>
        <input type="text" class="form-control set_money" placeholder="金额,不带小数点" aria-label="金额,不带小数点" aria-describedby="btnGroupAddon">
    </div>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text set_date" >补款日期</div>
        </div>
        <input type="text" class="form-control" id="pick_date" placeholder="选择日期" aria-label="选择日期" aria-describedby="btnGroupAddon">
    </div>
    <input type="submit" class="sub_clock">
</div>
<script src="/Static/Script/laydate/laydate.js"></script>
<script>
    $(document).ready(function () {
        //执行一个laydate实例
        laydate.render({
            elem: '#pick_date' //指定元素
        });

        $(".sub_clock").click(function (e) {
            e.preventDefault();
            var name = $(".set_name").val()
            var money = $(".set_money").val()
            var date = $(".set_date").val;
            $.post("/setting_clock",{name:name,money:money,date:date},function (e) {
                alert(e.msg)
            })
        })
    })

</script>