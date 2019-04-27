@include('PC.Admincp.AdminHeader')

<div class="wp admin" style="min-height: 200px;">
    <table class="table">
        <tr>
            <td>团购名称</td>
            <td>开始日期</td>
            <td>结束日期</td>
            <td>状态</td>
            <td>操作</td>
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
                        <a href="/admincp/review_orders?id={{$value->id}}">回顾</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

</div>
