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
    .medal_swich{
        list-style: none;
        float: left;
        background: #fff;
        padding: 9px 4px;
        margin: 5px;
        border-radius: 5px;
        box-shadow: 1px 2px 1px #ccc;
        cursor: pointer;
        border: 2px dashed #ccc;
        padding: 4px 20px;
        border-radius: 8px;
        font-weight: 800;
    }
    .medal_body {
        display: none;
    }
    .display{
        display: inline-block;
        color: #00AFB0;
    }
    .medal_info_item {float: left;width: 155px;padding: 5px;border: 3px dashed #ddd;border-radius: 5px;margin: 5px}
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
    @else
        <div style="width: 100%;">
            <span class="medal_swich display">佩戴中</span>
            <span class="medal_swich">保管箱</span>
            <span class="medal_swich">寄售中</span>
            <div class="clear"></div>
        </div>
        <div style="margin: 15px;">
            <div class="medal_body display">
                @if(empty($data['my_medal']['in_adorn']))
                    <p class="notice">暂时没有佩戴中的勋章</p>
                @endif
                @foreach($data['my_medal']['in_adorn'] as $key => $value)
                    <div class="medal_info_item" style="">
                        <img style="margin: 0 auto;display: inherit;    width: 60px;border-radius: 100%;" src="{{$value->medal_image}}">
                        <p>
                            <span style="font-weight: 900;    text-align: center;display: inline-block;width: 100%">{{$value->medal_name}}</span>
                        </p>
                        <p style="    text-align: center;">
                            <a class="put-in-box" key="{{$key}}">放入保管箱</a>
                        </p>
                        <span style="width: 100%;text-align: center;display: inherit;">[稀有度 : {{$value->rarity}}]</span>
                        <ul style="margin-top: 10px">
                            @foreach(json_decode($value->medal_action,true) as $action_value)
                                <li style="    margin-left: 15px;">
                                    <?php
                                    $act_info = \App\Http\DbModel\ActionModel::name($action_value['action_name']);
                                    ?>
                                    <span class="alert_span">{{ $act_info->action_name }}</span> 时,有
                                    <span  class="alert_span">{{ $action_value['rate'] * 100}} %</span>
                                    概率获得

                                    <span  class="alert_span">{{ $action_value['score_value'] }}</span>
                                    枚
                                    <span  class="alert_span">{{ \App\Http\DbModel\CommonMemberCount::$extcredits[$action_value['score_type']] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach

            </div>

            <div class="medal_body">
                @if(empty($data['my_medal']['in_box']))
                    <p class="notice">家徒四壁。</p>
                @endif
                @foreach($data['my_medal']['in_box'] as $key => $value)
                    <div class="medal_info_item" style="">
                        <img style="margin: 0 auto;display: inherit; width: 60px;border-radius: 100%;" src="{{$value->medal_image}}">
                        <p>
                            <span style="font-weight: 900;    text-align: center;display: inline-block;width: 100%">{{$value->medal_name}}</span>
                        </p>
                        <p style="    text-align: center;">
                            <a class="adorn_mine" key="{{$key}}">佩戴</a> OR <a>黑市出售</a>
                        </p>
                        <span style="width: 100%;text-align: center;display: inherit;">[稀有度 : {{$value->rarity}}]</span>
                        <ul style="margin-top: 10px">
                            @foreach(json_decode($value->medal_action,true) as $action_value)
                                <li style="    margin-left: 15px;">
                                    <?php
                                    $act_info = \App\Http\DbModel\ActionModel::name($action_value['action_name']);
                                    ?>
                                    <span class="alert_span">{{ $act_info->action_name }}</span> 时,有
                                    <span  class="alert_span">{{ $action_value['rate'] * 100}} %</span>
                                    概率获得

                                    <span  class="alert_span">{{ $action_value['score_value'] }}</span>
                                    枚
                                    <span  class="alert_span">{{ \App\Http\DbModel\CommonMemberCount::$extcredits[$action_value['score_type']] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>

            <div class="medal_body">
                @if(empty($data['my_medal']['in_box']))
                    <p class="notice">没有出售中的勋章。</p>
                @endif
                @foreach($data['my_medal']['in_store'] as $value)
                    <div>
                        <img src="{{$value->medal_image}}" style=" width: 60px;border-radius: 100%;">
                        <p>
                            <span>[{{$value->rarity}}]</span>
                            <span>{{$value->medal_name}}</span>
                        </p>
                    </div>
                @endforeach
            </div>
            {{--        {{ $data['my_thread']->links() }}--}}
            {{csrf_field('csrf')}}
        </div>
    @endif

</div>

<script>
    $(document).ready(function () {
        var csrf = $("#csrf").val();
        $(".toggle_list_btn").click(function (e) {
            e.preventDefault();
            $(".toggle_list").toggle();
        })

        $(".now_sell").click(function () {
            $.get('/sell_old_medal','',function (e) {
                alert(e.msg)
            })
        })
        //切换显示
        $(".medal_swich").click(function () {
            var index = $(this).index();
            $(this).addClass('display').siblings().removeClass('display');
            $('.medal_body').eq(index).addClass('display').siblings().removeClass('display');
        })
        //佩戴保管箱中的勋章
        $(".adorn_mine").click(function (e) {
            e.preventDefault();
            var data = {
                'csrf'  : csrf,
                'mid'   : $(this).attr("key")
            };
//            console.log(data)
            $.post("/adorn_mine",data,function (e) {
                alert(e.msg);
                window.location.reload()
            })
        })
        //放入保管箱 put-in-box
        $(".put-in-box").click(function (e) {
            e.preventDefault();
            var data = {
                'csrf'  : csrf,
                'mid'   : $(this).attr("key")
            };
            $.post("/put_in_box",data,function (e) {
                alert(e.msg);
                window.location.reload()
            })
        })
    })
</script>