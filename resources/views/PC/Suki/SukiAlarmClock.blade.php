@include('PC.Suki.SukiHeader')
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
</style>
<div class="wp" style="margin-top: 60px;">
    <div class="alert">补款闹钟功能尚在测试中,功能确定后将同步开发到App中,如果有更好的功能建议,可以<a href="">点这里</a>提交意见反馈。</div>

    @if($data['request']['type'] == 'view')
        @if(empty($data['my_clock']))
        <div>尚无设置过提醒,<a href="/suki_alarm_clock?type=setting">现在去设置</a></div>
        @else
            <div><a href="/suki_alarm_clock?type=setting">去设置新的提醒</a></div>
            <div>
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
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                <label class="form-check-label" for="inlineRadio1">不要提醒我</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                <label class="form-check-label" for="inlineRadio2">补款日邮件提醒我</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" disabled>
                <label class="form-check-label" for="inlineRadio3">App横幅提醒 (disabled)</label>
            </div>
            @foreach($data['my_clock'] as $value)
                <div>
                    <span>价格:{{$value['sum']}}</span>
                    <span>名称:{{$value['clock_name']}}</span>
                    <span>日期:{{$value['clock_date']}}</span>
                </div>
            @endforeach
        @endif
    @elseif($data['request']['type'] == 'setting')
        <a href="/suki_alarm_clock?type=view">去预览已添加的</a>
        <div class="add_new_clock trans">+</div>
    @endif

</div>
@include('PC.Suki.SukiFooter')
