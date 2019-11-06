@include('PC.Admincp.AdminHeader')

<div class="wp admin" style="min-height: 200px;">
    @if($data["group_buying"]->status == 1)
        <a href="">开始活动</a>
    @elseif($data["group_buying"]->status == 2)
        <button class="btn  btn-default btn-danger settle_orders" style="margin-bottom: 10px" gid="{{$data["group_buying"]->id}}">结算订单</button>
        <a href="/admincp/participant?id={{$data["request"]["id"]}}" class="btn btn-info" style="color: #FFFFFF;margin-bottom: 10px">预览</a>
    @elseif($data["group_buying"]->status == 3)
        <a href="/admincp/participant?id={{$data["request"]["id"]}}" class="btn btn-info" style="color: #FFFFFF;margin-bottom: 10px">订单列表</a>
        <div class="btn-group show" style="margin-bottom: 10px;" role="group">
            <button style="border: 0px;color: #999999;box-shadow: 0 0 5px #f1f1f1;background-color: #fff;padding: 6px 15px;margin-left: 0px;" type="button" class="btn btn-secondary dropdown-toggle tb" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                切换表单
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; transform: translate3d(10px, 25px, 0px); top: 0px; left: 0px; will-change: transform;">
                <a href="/admincp/review_orders?id={{$data["request"]["id"]}}" class="dropdown-item setting_clock_alert">全部</a>
                <a href="/admincp/review_orders?id={{$data["request"]["id"]}}&l=ok" class="dropdown-item setting_clock_alert">只看成团</a>
            </div>
        </div>
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
            <td>操作</td>
            <td>复制</td>
        </tr>

        @foreach($data["list"] as $value)
            @if($data["request"]["l"] == "ok")
                @if($value["min_members"] > $value["item_count"])
                @else
                    <tr>
                        <td><a href="/suki_group_buying_item_info?item_id={{$value["id"]}}">{{$value['item_name']}}</a></td>
                        <td><img width="27px" src="{{explode("|",$value["item_image"])[0]}}"></td>
                        <td>{{$value["follow"]}}</td>
                        <td>{{$value["item_count"]}}</td>
                        <td>{{$value["min_members"]}}</td>
                        <td>{{$value["follow"] ? round($value["item_freight"]/$value["follow"],2): "-"}}元/每人</td>
                        <td>{{$value["min_members"] > $value["item_count"] ? "流团" : "成团"}}</td>
                        <td><a href="/admincp/items_participant?id={{$value["id"]}}">查看商品参团者</a></td>
                        <td>
                            @if($value["display"] == 1)
                            <a class="rm_item" href="/admincp/remove_group_buying_item?id={{$value["id"]}}">下架</a>
                            @else
                            <p>已下架</p>
                            @endif
                        </td>

                    </tr>
                @endif
            @else

            <tr>
                <td><a href="/suki_group_buying_item_info?item_id={{$value["id"]}}">{{$value['item_name']}}</a></td>
                <td><img width="27px" src="{{explode("|",$value["item_image"])[0]}}"></td>
                <td>{{$value["follow"]}}</td>
                <td>{{$value["item_count"]}}</td>
                <td>{{$value["min_members"]}}</td>
                <td>{{$value["follow"] ? round($value["item_freight"]/$value["follow"],2): "-"}}元/每人</td>
                <td>{{$value["min_members"] > $value["item_count"] ? "流团" : "成团"}}</td>
                <td><a href="/admincp/items_participant?id={{$value["id"]}}">查看商品参团者</a></td>
                <td>
                    @if($value["display"] == 1)
                        <a class="rm_item" href="/admincp/remove_group_buying_item?id={{$value["id"]}}">下架</a>
                        <form action="/admincp/update_price" method="post">
                            <input type="text" name="price" value="{{$value["item_price"]}}">
                            <input type="hidden" name="item_id" value="{{$value["id"]}}">
                            <input type="submit" value="改价">
                        </form>
                        <form action="/admincp/update_item_freight" method="post">
                            <input type="text" name="item_freight" value="{{$value["item_freight"]}}">
                            <input type="hidden" name="item_id" value="{{$value["id"]}}">
                            <input type="submit" value="改运费">
                        </form>
                    @else
                        <p>已下架</p>
                    @endif
                </td>
                <td><a href="/admincp/copy_item?group_id={{$data["now"]->id}}&item_id={{$value["id"]}}">复制</a></td>
            </tr>
            @endif
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
        $(".rm_item").click(function (e) {
            e.preventDefault();
            var href = $(this).attr("href");
            $.post(href,function (e) {
                alert(e.msg)
                window.location.reload()
            })
        })

    })
</script>