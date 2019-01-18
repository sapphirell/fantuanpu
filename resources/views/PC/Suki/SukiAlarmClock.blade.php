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
        border-radius: 5px;
        box-shadow: 0 0 15px #e8e8e8;
    }
    .input-group {
        margin: 10px 0px;
    }
    ._3_1_right .form-control {
        border: 1px solid #d6b7b7;
    }
    ._3_1_right .input-group-text
    {
        background-color: #efe9e9;
        border: 1px solid #d6b7b7;
    }
    .clock_line {
        margin:8px 0px;
    }
    .clock_line span {
        font-size:16px;
        text-shadow: 0 0 3px #d8c1c1;
    }
    .clock_line
</style>
<div class="wp" style="margin-top: 60px;">
    <div class="alert">补款闹钟功能尚在测试中,功能确定后将同步开发到App中,如果有更好的功能建议,可以<a href="">点这里</a>提交意见反馈。</div>
        {{--<div><a href="/suki_alarm_clock?type=setting">去设置新的提醒</a></div>--}}
    <div class="3_1">
        <div class="_3_1_left">
            <div class="clock_container">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

                    <div class="btn-group" role="group">
                        <button
                                style="border: 0px;color: #fff;background-color: #fdbec1;padding: 3px 15px;margin-left: 0px;margin-bottom: 15px;"
                                id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if($data['request']['group']=='ym')
                                按月汇总
                            @else
                                查看全部
                            @endif
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a href="/suki_alarm_clock" class="dropdown-item" href="#">查看全部</a>
                            <a href="/suki_alarm_clock?group=ym" class="dropdown-item" href="#">按月分组</a>
                        </div>
                    </div>
                </div>
                @if($data['my_clock']->isEmpty())
                    <br >
                    <img style="    margin: 0 auto;display: block;" src="/Static/image/common/none.png">
                @endif

                @if($data['request']['group'] == "ym")
                    {{--{{dd($data)}}--}}
                    @foreach($data['my_clock'] as $value)
                        <div class="clock_line">
                            <span style="width: 120px;display: inline-block">{{$value['ym']}}</span>
                            <span style="width: 120px;display: inline-block">{{$value['count']?:0}}个补款项</span>
                            <span style="width: 80px;display: inline-block">共计￥{{$value['sum']}}</span>
                        </div>
                    @endforeach
                @else
                    @foreach($data['my_clock'] as $value)
                        <div  class="clock_line" style="font-size: 15px;color: #7d6565;    line-height: 25px;">

                            <span style="width: 120px;display: inline-block">{{$value['clock_name']}}</span>
                            <span style="width: 80px;display: inline-block">￥{{$value['sum']}}</span>
                            <span>{{date("Y·m·d",strtotime($value['clock_date']))}} - {{date("Y·m·d",strtotime($value['clock_end']))}}</span>
                            <div class="btn-group" role="group">
                                <button style="border: 0px;color: #000;background-color: #fff;padding: 3px 15px;margin-left: 10px;"  type="button" class="btn btn-secondary dropdown-toggle tb" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if($value["alert_type"] == '1')
                                        <a >不要提醒</a>
                                    @elseif($value["alert_type"] == '2')
                                        邮件提醒
                                    @elseif($value["alert_type"] == '3')
                                        App提醒
                                    @endif
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <a href="/setting_clock_alert?id={{$value['cid']}}&alert_type=1" class="dropdown-item setting_clock_alert" >不要提醒</a>
                                    <a href="/setting_clock_alert?id={{$value['cid']}}&alert_type=2" class="dropdown-item setting_clock_alert" >邮件提醒</a>
                                    {{--<a href="/setting_clock_alert?id={{$value['cid']}}&alert_type=3" class="dropdown-item setting_clock_alert" >App提醒</a>--}}
                                    <p style="color: #bbb6b6;padding-left: 19px;margin: 0px" disabled href="/setting_clock_alert?id={{$value['cid']}}&alert_type=3" class="dropdown-item setting_clock_alert" >短信提醒
                                        <i class="fa-question-circle fa" title="意见征集中:启用该功能,需要自付短信费。如果用的人不多就不开发这个功能了..." style="float: right;margin: 5px;"></i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
        <div class="_3_1_right">
            <div style="background: #ffffff;padding: 10px;border-radius: 5px;box-shadow: 0 0 15px #e8e8e8;margin-top: 10px;">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">名称</div>
                    </div>
                    <input type="text" class="form-control set_name" placeholder="自定义的名称" aria-label="自定义的名称" aria-describedby="btnGroupAddon">
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text" >金额</div>
                    </div>
                    <input type="text" class="form-control set_money" placeholder="金额,不带小数点" aria-label="金额,不带小数点" aria-describedby="btnGroupAddon">
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text" >补款</div>
                    </div>
                    <input type="text" class="form-control set_date" id="pick_date_start" placeholder="选择日期" aria-label="选择日期" aria-describedby="btnGroupAddon">
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text" >截止</div>
                    </div>
                    <input type="text" class="form-control clock_end" id="pick_date_end" placeholder="选择日期" aria-label="选择日期" aria-describedby="btnGroupAddon">
                </div>
                <input type="submit" class="sub_clock" style="color: #000;    background: #fcbec3;border: 0px;width: 100%;">
            </div>

        </div>
        <div class="clear"></div>

    </div>


    {{--@elseif($data['request']['type'] == 'setting')--}}
        {{--<a href="/suki_alarm_clock?type=view">去预览已添加的</a>--}}
        {{--<div class="add_new_clock trans">+</div>--}}
    {{--@endif--}}

</div>

<script src="/Static/Script/laydate/laydate.js"></script>
<script>
    $(document).ready(function () {
        //执行一个laydate实例
        laydate.render({
            elem: '#pick_date_start' //指定元素
        });
        laydate.render({
            elem: '#pick_date_end'
        });
        $(".sub_clock").click(function (e) {
            e.preventDefault();
            var name = $(".set_name").val()
            var money = $(".set_money").val()
            var date = $(".set_date").val();
            var clock_end = $(".clock_end").val();
            var fd = {name:name,money:money,date:date,clock_end:clock_end}
            $.post("/setting_clock",fd,function (e) {
                alert(e.msg)
                console.log(fd)
                if (e.ret == 200)
                    location.reload()
            })
        })
        //修改suki闹钟提醒方式
        $("a.setting_clock_alert").click(function (e) {
            e.preventDefault();
            var this_setting = $(this).text()
            var hrefs = $(this).attr("href");
            $.get(hrefs,{},function (e) {
                $(".tb").text(this_setting+" ");
            });
        })
    })

</script>
@include('PC.Suki.SukiFooter')
