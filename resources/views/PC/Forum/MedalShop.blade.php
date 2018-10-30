@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<script src="/Static/Script/Web/forum.js"></script>
{{--<script type="text/javascript" src="/Static/Script/xheditor/xheditor-1.2.2.min.js"></script>--}}
{{--<script type="text/javascript" src="/Static/Script/xheditor/xheditor_lang/zh-cn.js"></script>--}}
<script type="text/javascript" src="/Static/Script/wangEditor/wangEditor.js"></script>
<style>
    .fourm_thread_items {    padding: 5px 8px;background: #ffffff;    box-shadow: 0 0 5px #ddd;}
    .medal_item *{    color: #36567d; font-size: 14px;}
    .avatar {float: left}
    .wp {
        margin-top: 29px;

        border-radius: 5px 5px 0px 0px;
        overflow: hidden;
        padding: 0px!important;
    }
    .wp .fourm_thread_items {
        margin: 10px;
        border-radius: 5px;
    }
    #new_thread
    {
        /*width: 95%;*/
        /*margin: 0px auto;*/
        background-color: #fff;
    }
    .pager li>a, .pager li>span
    {
        border:0px;
        padding: 6px 12px;
        margin: 8px;
        color: #ab5e5e;
    }
    .screen-boday > div {
        float: left;
        margin:5px;
    }
    .medal_info {
        margin:10px;
    }
    .alert_span {
        color: #00A0FF;
    }
    .medal_item {
        padding: 5px;
    }
    .medal_img.N {
        width: 50px;
        border-radius: 100%;
        border: 2px solid #232831;
        box-shadow: 0 2px 8px #69c2ef;
    }
    .medal_img.R {
        width: 50px;
        border-radius: 100%;
        border: 2px solid #8da7ff;
        box-shadow: 0 2px 8px #8798b4;
    }
    .medal_img.SR {
        width: 50px;
        border-radius: 100%;
        border: 2px solid #9d79ad;
        box-shadow: 0 2px 8px #8da7ff;
    }
    .medal_img.UR {
        width: 50px;
        border-radius: 100%;
        border: 2px solid #ffb26f;
        box-shadow: 0 2px 8px #fde487;
    }
    .N , .R , .SR ,.UR{
        font-weight: bold;
        text-shadow: 0 0 3px #0202024f;
        font-size: 15px;
    }
    .N {  color: #230f0e;}
    .R {  color: #8da7ff;}
    .SR { color: #ff7e7e;}
    .UR { color: #ffcd2a;}
</style>
<script>
    $(document).ready(function () {
        $(".show_date").mouseout(function () {
            $(this).hide().siblings('.show_time').show()
        })
        $(".show_time").hover(function(){
            $(this).hide().siblings('.show_date').show()
        });
    })
</script>
<div class="wp" style="padding: 5px;margin-top: 50px;    ">

    <!--头部banner-->
    <div class="3-1" >
        <div class="_3_1_left" style="
        /*box-shadow: 0 0 11px #e6e6e6;background: #ffffff;*/
        border-radius: 5px;overflow: hidden;padding: 8px">
            <div style="background: #eee;border: 1px solid #ccc;padding: 5px;    box-shadow: 0 0 11px #cacaca;margin-top: 5px;border: 2px solid #868686;border-radius: 5px;" class="screen-boday">
                <form>
                    <div style="float:left;">
                        <span class="screen-head">稀有度</span>
                        <select>
                            <option value="all">全部</option>
                            <option value="N">N</option>
                            <option value="N">R</option>
                            <option value="N">SR</option>
                            <option value="N">UR</option>
                        </select>
                    </div>
                    <div style="float:left;margin-left: 10px">
                        <span class="screen-head">库存</span>
                        <select>
                            <option>全部</option>
                            <option>只看在售有货</option>
                        </select>
                    </div>

                </form>

                <div class="clear"></div>

            </div>

            <div style="background: #ffffff;    box-shadow: 0 0 11px #cacaca;margin-top: 5px;border: 2px solid #868686;border-radius: 5px;">
                @foreach($data['medal'] as $value)
                    <div class="medal_item" style="float: left">
                        <p>
                            <img class="medal_img {{$value->rarity}}" src="{{$value->medal_image}}">
                            <span class="{{$value->rarity}}">{{$value->medal_name}}</span>
                            <a class="buy_medal" key="{{$value->id}}">购买</a>
                        </p>
                        {{ $action = json_decode($value->medal_action,true) }}
                        {{ $sell = json_decode($value->medal_sell,true) }}
                        <div class="medal_info">
                            <label style="    margin: 0px;">库存</label>
                            <p style="margin-left: 45px;">{{$value->limit}}</p>
                            <label>贩售日期</label>
                            <p style="margin-left: 45px;    ">{{$value->sell_start}} —— {{$value->sell_end}}</p>
                            <label>勋章售价</label>
                            <ul>
                                @foreach($sell as $sell_value)
                                    <li style="    margin-left: 45px;">
                                        <p>{{$sell_value['score_value']}}枚{{\App\Http\DbModel\CommonMemberCount::$extcredits[$sell_value['score_type']]}}</p>
                                    </li>
                                @endforeach
                            </ul>
                            <label>勋章属性</label>
                            <ul>
                                @foreach($action as $action_value)
                                    <li style="    margin-left: 45px;">
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


                    </div>

                @endforeach
                <div class="clear"></div>
            </div>
        </div>
        <div class="_3_1_right">

            <div class="bm">
                <div class="bm_h">勋章导购</div>
                <div class="bm_c" style="color: #545454;padding: 10px;">勋章可以消耗论坛币直接购买,也可以通过十连抽随机获取。(一些勋章只能通过抽取获得)。<br>勋章分为N R SR UR,
                    佩戴不同勋章可以在日常活动中概率获取不同的奖励,勋章也可以在黑市中二手出售。
                </div>
            </div>
        </div>
        {{csrf_field('csrf')}}

    </div>
</div>

<script>
    $(document).ready(function () {
        //放入保管箱 put-in-box
        var csrf = $("#csrf").val()
        $(".buy_medal").click(function (e) {
            e.preventDefault();
            var data = {
                "csrf"  : csrf,
                source   : "medal_shop",
                medal_id : $(this).attr('key')
            };
            console.log('data')
            $.post("/buy_medal",data,function (e) {
                alert(e.msg);
                window.location.reload()
            })
        })
    })
</script>
@include('PC.Common.Footer')