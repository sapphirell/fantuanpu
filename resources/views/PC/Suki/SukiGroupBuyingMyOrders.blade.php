@include('PC.Suki.SukiHeader')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<style>
    .input-group-text {width: 80px}
</style>
<div class="wp" style="margin-top: 60px;">
    <table class="table">
        <tr>
            <td>名字</td>
            <td>创建时间</td>
            <td>截单日</td>
            <td>状态</td>
            <td>详情</td>
        </tr>
        @foreach($data['orders'] as $value)
            <td>{{$value->name}}</td>
            <td>{{$value->create_date}}</td>
            <td>{{$value->end_date}}</td>
            <td>
                @if($value->status == 1)
                    提交跟团
                @elseif($value->status == 2)
                    等待确认付款
                @elseif($value->status == 3)
                    已经付款
                @elseif($value->status == 4)
                    取消
                @elseif($value->status == 5)
                    等待商户发货
                @elseif($value->status == 6)
                    平台已经发货
                @endif
            </td>
            <td>
                @foreach($value->order_info as $key =>  $value)
                    {{$type = explode("_",$key)}}
                    {{$type[0] ."码". $type[1]   . $value ."个"}}
                @endforeach
            </td>
        @endforeach
    </table>
</div>
<script>
    $(document).ready(function () {

    })
</script>
@include('PC.Suki.SukiFooter')