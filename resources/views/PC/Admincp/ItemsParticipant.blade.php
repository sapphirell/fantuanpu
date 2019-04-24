@include('PC.Admincp.AdminHeader')

<div class="wp admin" style="min-height: 200px;">

    <table class="table">
        <tr>
            <td>时间</td>
            <td>用户名</td>
            <td>购买详情</td>
            <td>qq</td>
        </tr>
        @foreach($data["list"] as $value)
            <tr>
                <td>{{$value->create_date}}</td>
                <td>{{$value->username}}</td>
                <td>{{$value->order_info}}</td>
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
        })

    })
</script>