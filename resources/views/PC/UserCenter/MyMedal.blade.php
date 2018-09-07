@include('PC.Common.HtmlHead')
<style>
    html {
        height: 600px;
    }
    .fourm_thread_items {
        padding: 5px 8px;
    }
    .toggle_list {display: none}
</style>
<div class="bm_h">我的勋章</div>
<div class="bm_c" style="background: #ffffff;height: 100%;overflow: hidden">
    @if(session('user_info')->sellmedal == 1)
        <div class="notice">尊贵的饭团扑老会员,您有<span style="color: #47d1ff;">{{count($data['my_old_medal'])}}</span>枚旧版勋章,它可以由您当初的购买价格兑换为
            @foreach($data['old_score'] as $key=>$value)
                <span>{{ $data['extcredits_name'][$key] }}</span>
                <span style="color: #47d1ff;">{{$value}}&nbsp;&nbsp;</span>
            @endforeach
            <a href="">我要兑换。</a>
            &nbsp;&nbsp;
            <a href="" class="toggle_list_btn">是哪些勋章?</a>
        </div>
        <div class="toggle_list">
            @foreach($data['my_old_medal'] as  $key => $value)
                <p class="fourm_thread_items" @if($key%2==0) style="background: #f5f5f5;" @endif >
                    {{$value->name}}
                    @if($value->price)
                        {{$data['extcredits_name'][$value->price['type']]}}
                        {{$value->price['num']}}
                    @endif
                </p>
            @endforeach
        </div>


    @endif
    <div style="float: right;margin: 15px;">

{{--        {{ $data['my_thread']->links() }}--}}
    </div>
</div>

<script>
    $(document).read(function () {
        $(".toggle_list_btn").click(function (e) {
            e.preventDefault();
            alert(1)
            $(".toggle_list").toggle();
        })
    })
</script>