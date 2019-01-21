<p style="    color: #f99696;">根据您在Suki的设置,通知您这几个项目今天将要进行补款:</p>
@foreach($key["today"] as $value)
    <span style="width: 120px;display: inline-block">{{$value['clock_name']}}</span>
    <span style="width: 80px;display: inline-block">￥{{$value['clock_money']}}</span>
@endforeach
@if(!empty($key["tomorrow"]))
    <p style="    color: #f99696;">这几个项目明天将要进行补款:</p>
    @foreach($key["tomorrow"] as $value)
        <span style="width: 120px;display: inline-block">{{$value['clock_name']}}</span>
        <span style="width: 80px;display: inline-block">￥{{$value['clock_money']}}</span>
    @endforeach
@endif
@if(!empty($key["lastday"]))
    <p style="    color: #f99696;">这几个项目本日将是最后的补款日期:</p>
    @foreach($key["lastday"] as $value)
        <span style="width: 120px;display: inline-block">{{$value['clock_name']}}</span>
        <span style="width: 80px;display: inline-block">￥{{$value['clock_money']}}</span>
    @endforeach
@endif
