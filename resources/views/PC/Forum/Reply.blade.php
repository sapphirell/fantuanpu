@foreach($data['thread_post'] as $key=>$value)
    <div class="post_item">
        <?php $rand_border = ['#bbb0ff','#e7b0ff','#dbffb0','#b5ecff','#ffb5b5']; ?>
        <div class="post_msg"  style="z-index: 1; position: relative;    margin-right: 20px;
                border-bottom: 3px solid {{$rand_border[rand(0,4)]}};">

            <div style="width: 80px;display: inline-block;float: left">

                {{avatar($value->authorid,80,100,'post-avatar','normal')}}
                <span style="color: #5abdd4;width: 80px;text-align: center;display: inline-block;margin-top: 5px">{{$value->author}}</span>

            </div>
            <div style="width: 435px;display: inline-block;float:left;">
                <span style="color: #cccccc">{{date("Y m-d H:i:s",$value->dateline)}}</span>
                <div id="{{$value->pid}}" style="padding: 5px;">{!! bbcode2html($value->message) !!}</div>
                <div class="user_medal">
                    @foreach($value->medal['in_adorn'] as $medal_key=>$medal_value)
                        <div class="medal_info {{$key}}" id="{{$value->position .'_'. $medal_key}}">
                            <p style="border-left: 3px solid #00A0FF;line-height: 13px;padding-left: 5px">
                                {{$medal_value->medal_name}}
                            </p>
                            @foreach(json_decode($medal_value->medal_action,true) as $action_value)
                                <li style="    margin-left: 8px;">
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
                        </div>
                        <img class="trans medal_img {{$medal_value->rarity}}" style="width: 30px;height: 30px" src="{{$medal_value->medal_image}}" position="{{$value->position}}" key="{{$medal_key}}">

                    @endforeach
                </div>

            </div>
            <div class="clear"></div>

            <div style="    width: 100%;display: inline-block;float: left;position: absolute;bottom: 0;">
                {{--<img src="/Static/daimeng.gif">--}}

                <p onclick="reply({{$value->pid}})" class="reply" style="cursor: pointer;color: #ccc;position: absolute;right: 20px;bottom: 5px;">&lt;Reply&gt;</p>
            </div>

        </div>
        {{--<div class="post_userinfo trans" style="float: right;position: absolute;    left: 505px;background: #fff;padding: 8px;margin: 15px 15px 15px 0px;width: 17%;box-shadow: 2px 3px 3px #e4e4e4;z-index: 0;border-radius: 0px 5px 5px 0px;">--}}

        {{--<div style="float: left;width: 45px   ;">--}}
        {{--<a>加关注</a>--}}
        {{--<a>加好友</a>--}}
        {{--<a>发消息</a>--}}
        {{--</div>--}}
        {{--<div>--}}
        {{--{{avatar($value->authorid,50,100,'post-avatar','normal')}}--}}
        {{--</div>--}}
        {{----}}
        {{--</div>--}}
        <div class="clear"></div>
    </div>

@endforeach