@include('PC.Admincp.AdminHeader')

<div class="wp admin" style="min-height: 200px;">
    <table class="table">
        <tr>
            <td>类</td>
            <td>个</td>
        </tr>
        @foreach($data["count_info"] as $key => $value)
            <tr>
                <td>{{$key}}</td>
                <td>{{$value}}个</td>
            </tr>
        @endforeach
    </table>
    <table class="table">
        <tr>
            <td>id</td>
            <td>状态</td>
            <td>时间</td>
            <td>用户名</td>
            <td>购买详情</td>
            <td>qq</td>
        </tr>
        @foreach($data["list"] as $value)
            <tr>
                <td>{{$value->id}}</td>
                <td>[{{get_log_status($value->status)}}]</td>
                <td>{{$value->create_date}}</td>
                <td>{{$value->username}}</td>
                <td>{{$value->order_info}}</td>
                <td><a class="change_log_items" id="{{$value->id}}" href="/admincp/change_log_items?log_id={{$value->id}}">换</a></td>
                <td>{{$value->qq}}</td>
            </tr>
        @endforeach
    </table>

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
        //
        $(".change_log_items").click(function (e) {
            e.preventDefault();
            var id = $(this).attr("id");
            layer.open({
                type: 2,
                title: false,
                closeBtn: 0, //不显示关闭按钮
                shade: 0.8,
                shadeClose: true,
                area: ["900px", '405px'],
                offset: '100px',
                content: ['/admincp/change_log_items?id='+id,'no']
            });
        })
    })
</script>