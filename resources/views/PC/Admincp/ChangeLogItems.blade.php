{{--@include('PC.Admincp.AdminHeader')--}}
<style>
    body,html {background: #FFFFFF!important;}
</style>
@include('PC.Common.HtmlHead')
<div class="wp admin" style="min-height: 200px;">
    <textarea class="form-control order_info">{{$data["log"]->order_info}}</textarea>
    <p>可选尺寸</p>
    <p>{{$data["item"]->item_size}}</p>
    <p>可选颜色</p>
    <p>{{$data["item"]->item_color}}</p>
    <p class="log_id">{{$data["log"]->id}}</p>
    <a class="button">提交</a>
</div>

<script>
    $(document).ready(function (e) {
        $(".button").click(function (e) {
            e.preventDefault();
            var id = $(this).attr("gid");
            var order_info = $(this).text("order_info");
            $.post("/admincp/settle_orders",{'id':id},function (e) {
                alert(e.msg)
                window.location.reload()
            })
        });

    })
</script>