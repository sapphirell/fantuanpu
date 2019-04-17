@include('PC.Admincp.AdminHeader')

<div class="wp admin" style="min-height: 200px;">
    <button class="btn  btn-default btn-danger settle_orders" style="margin-bottom: 10px" gid="{{$data["group_buying"]->id}}">结算订单</button>
    <table class="table">
        <tr>
            <td>品名</td>
            <td>略缩图</td>
            <td>参团人数</td>
            <td>参团品数</td>
            <td>最低成团</td>
            <td>公摊运费</td>
            <td>描述</td>
        </tr>
        @foreach($data["list"] as $value)
            <tr>
                <td>{{$value['item_name']}}</td>
                <td><img width="27px" src="{{explode("|",$value["item_image"])[0]}}"></td>
                <td>{{$value["follow"]}}</td>
                <td>{{$value["item_count"]}}</td>
                <td>{{$value["min_members"]}}</td>
                <td>{{$value["follow"] ? $value["item_freight"]/$value["follow"] : "-"}}元/每人</td>
                <td>{{$value["min_members"] > $value["item_count"] ? "流团" : "成团"}}</td>
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
            })
        })

    })
</script>