@include('PC.Admincp.AdminHeader')

<div class="wp admin" style="min-height: 200px;">
    @if($data["group_buying"]->status == 1)
        <a href="">开始活动</a>
    @elseif($data["group_buying"]->status == 2)
        <button class="btn  btn-default btn-danger settle_orders" style="margin-bottom: 10px" gid="{{$data["group_buying"]->id}}">结算订单</button>
    @elseif($data["group_buying"]->status == 3)
        <a href="/admincp/participant?id={{$data["request"]["id"]}}" class="btn btn-info" style="color: #FFFFFF;margin-bottom: 10px">订单列表</a>
    @endif
    <table class="table">
        <tr>
            <td>品名</td>
            <td>略缩图</td>
            <td>参团人数</td>
            <td>参团品数</td>
            <td>最低成团</td>
            <td>公摊运费</td>
            <td>描述</td>
            <td>详情</td>
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
                <td><a href="/admincp/items_participant?id={{$value["id"]}}">查看商品参团者</a></td>
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