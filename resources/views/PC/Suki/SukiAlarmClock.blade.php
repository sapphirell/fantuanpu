@include('PC.Suki.SukiHeader')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<style>
    .add_new_clock {
        display: inline-block;
        background: #eee;
        padding: 20px;
        color: #b3b3b3;
        font-size: 20px;
        border-radius: 10px;
        cursor: pointer;
        width: 70px;
        text-align: center;
    }
    .add_new_clock:hover {
        background: #888888;
        color: #fff;
    }
    .clock_container {
        margin: 10px 10px 10px 5px;
        background: #fff;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 0 15px #ddd;
    }
</style>
<div class="wp" style="margin-top: 60px;">
    <div class="alert">补款闹钟功能尚在测试中,功能确定后将同步开发到App中,如果有更好的功能建议,可以<a href="">点这里</a>提交意见反馈。</div>
        {{--<div><a href="/suki_alarm_clock?type=setting">去设置新的提醒</a></div>--}}
    <div class="3_1">
        <div class="_3_1_left">
            <div class="clock_container">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if($data['request']['view']=='month')
                                按月汇总
                            @else
                                查看全部
                            @endif
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="#">查看全部</a>
                            <a class="dropdown-item" href="#">按月分组</a>
                        </div>
                    </div>
                </div>
                @foreach($data['my_clock'] as $value)
                    <div style="font-size: 15px;color: #7d6565;    line-height: 25px;">

                        <span style="width: 120px;display: inline-block">{{$value['clock_name']}}</span>
                        <span style="width: 80px;display: inline-block">￥{{$value['sum']}}</span>
                        <span>{{date("Y·m·d",strtotime($value['clock_date']))}} - {{date("Y·m·d",strtotime($value['clock_end']))}}</span>
                    </div>
                @endforeach
            </div>

        </div>
        <div class="_3_1_right"></div>

    </div>


    {{--@elseif($data['request']['type'] == 'setting')--}}
        {{--<a href="/suki_alarm_clock?type=view">去预览已添加的</a>--}}
        {{--<div class="add_new_clock trans">+</div>--}}
    {{--@endif--}}

</div>
@include('PC.Suki.SukiFooter')
