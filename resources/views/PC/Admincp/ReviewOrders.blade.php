@include('PC.Admincp.AdminHeader')

<div class="wp admin" style="min-height: 200px;">
    <button class="btn  btn-default btn-danger">结算订单</button>
    <table class="table">
        <tr>
            <td>品名</td>
            <td>参团人数</td>
            <td>参团品数</td>
            <td>公摊运费</td>
        </tr>
        @foreach($data["list"] as $value)
            <tr>
                <td>{{$value->name}}</td>
                <td>{{$value->startdate}}</td>
                <td>{{$value->enddate}}</td>
                <td>
                    @if($value->status == 1)
                        未开始
                    @elseif($value->status == 2)
                        进行中
                    @elseif($value->status == 3)
                        已经结束
                    @endif
                </td>
                <td>
                    @if($value->status == 1)
                        <a href="">开始团购</a>
                    @elseif($value->status == 2)
                        <a href="/admincp/review_orders?id={{$value->id}}">进入结算页面</a>
                    @elseif($value->status == 3)
                        <a href="">回顾</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

</div>
