@include('PC.Common.HtmlHead')
<style>
    html {
        height: 612px;
    }
    .fourm_thread_items {
        padding: 5px 8px;
    }
    .toggle_list {display: none;    height: inherit;
        overflow: scroll;
        padding-bottom: 57px;}
    .bm_h {
        background: #85a8ca;
    }
    .bm_c{
        height: 99.9%!important;
    }
</style>
<div class="bm_h">我的勋章</div>
<div class="bm_c" style="background: #ffffff;height: 100%;overflow: hidden">
    @if(session('user_info')->sellmedal == 1)
        <div class="notice">&nbsp;尊贵的饭团扑老会员,您有<span style="color: #47d1ff;">{{count($data['my_old_medal'])}}</span>枚旧版勋章,它可以由您当初的购买价格兑换为
            @foreach($data['old_score'] as $key=>$value)
                <span>{{ $data['extcredits_name'][$key] }}</span>
                <span style="color: #47d1ff;">{{$value}}&nbsp;</span>
            @endforeach
            <br />
            <p>
                <span class="now_sell" href="" style="cursor: pointer">现在兑换。</span>
                &nbsp;&nbsp;
                <a class="toggle_list_btn" style="color: #00AA88;cursor: pointer" >是哪些勋章?</a>
            </p>

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
    $(document).ready(function () {
        $(".toggle_list_btn").click(function (e) {
            e.preventDefault();
            $(".toggle_list").toggle();
        })

        $(".now_sell").click(function () {
            $.get('/sell_old_medal','',function (e) {
                alert(e.msg)
            })
        })
    })
</script>