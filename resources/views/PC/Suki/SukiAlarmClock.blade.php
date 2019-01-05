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
        <div>尚无设置过提醒,<a href="/suki_alarm_clock?type=setting">现在去设置</a></div>
    @elseif($data['request']['type'] == 'setting')
        <div class="add_new_clock trans">+</div>
    @endif
</div>
@include('PC.Suki.SukiFooter')
