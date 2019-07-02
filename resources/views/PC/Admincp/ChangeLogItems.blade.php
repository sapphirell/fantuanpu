{{--@include('PC.Admincp.AdminHeader')--}}
<style>
    body,html {background: #FFFFFF!important;}
</style>
@include('PC.Common.HtmlHead')
<div class="wp admin" style="min-height: 200px;">
    <input value="{{$data["log"]->order_info}}">
    <p>可选尺寸</p>
    <p>{{$data["item"]->item_size}}</p>
    <p>可选颜色</p>
    <p>{{$data["item"]->item_color}}</p>
</div>

<script>
    $(document).ready(function (e) {
        $(".settle_orders").click(function (e) {
            e.preventDefault();
            var id = $(this).attr("gid");
            $.post("/admincp/settle_orders",{'id':id},function (e) {
                alert(e.msg)
                window.location.reload()
            })
        });

    })
</script>