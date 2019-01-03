@include('PC.Suki.SukiHeader')
<style>
    .my_alert_list li{
        list-style: none;
        display: block;
    }
    .my_alert_list li a.onchange {
        box-shadow: 0 0 15px #0000001c;
    }
    .my_alert_list li a {
        color: #616161;
        width: 100%;
        display: inline-block;
        padding: 10px 30px;
    }
    .reply_me_content {
        padding: 5px 10 5px 0px;
        flex-grow: 1;
    }
    .reply_me_content img{
        max-width: 60px;
        margin: 5px;
    }
    .reply_me_content blockquote{
        width: 60%;
        font-size: 12px;
        padding: 5px 10px;
        margin: 0 0 10px;
    }
    .origin_thread {
        background: #ffd3d3;
        border-width: 0px 3px 0px 3px;
        display: inline-block;
        width: 100%;
        padding: 9px 20px;
        border: 5px solid #f7c6cd;
        border-width: 0px 0px 0px 5px;
        color: #9a6363;
        background-color: #fdf5f5;
        /* background-image: linear-gradient(270deg, #f4f5f4 0%, #ffe8dd 93%); */
        border-radius: 3px;
    }
</style>
<div class="wp" style="    margin-top: 60px;
    background: #FFFFFF;
    display: flex;
    box-shadow: 0 0 15px #f7f7f7;
    border-radius: 3px;
    overflow: hidden;    border-top: 3px solid #fbcccc;">
    <div style="width: 180px;float: left;   background: #eee;
        background-image: linear-gradient(0deg, #f5f5f5 0%, #ffffff 100%);flex: none;">
        <ul class="my_alert_list" style="    overflow: hidden;">
            <li>
                <a href="/suki_relationship?type=my_follow" class="@if($data["request"]["type"]=="my_follow"){{"onchange"}}@endif">我关注的</a>
            </li>
            <li>
                <a href="/suki_relationship?type=follow_me" class="@if($data["request"]["type"]=="follow_me"){{"onchange"}}@endif">关注我的</a>
            </li>
            <li>
                <a href="/suki_relationship?type=friends" class="@if($data["request"]["type"]=="friends"){{"onchange"}}@endif">我的好友</a>
            </li>
            <li>
                <a href="/suki_relationship?type=friends_request" class="@if($data["request"]["type"]=="friends_request"){{"onchange"}}@endif">好友申请</a>
            </li>
            <li class="clear"></li>
        </ul>
    </div>

    <div style="float: left;    flex-grow: 1;">
        @if($data['request']['type'] == "my_follow")
            @if($data['my_follow']->isEmpty())
                <p style="padding: 20px 50px;">还没有关注~</p>
            @endif
            @foreach($data['my_follow'] as $value)

                <div style="    width: 260px;float: left;">
                    <div style="display: inline-block;float:left;margin: 15px 20px;">{{avatar($value->user->uid,50,100)}}</div>
                    <div style="display: inline-block;float:left;">
                        <p style="display: block;float:left;    width: 100%;line-height: 45px;">{{$value->user->username}}</p>
                        <a  class="follow trans"
                            uid="{{$data['user_info']->uid}}"
                            to_uid="{{$value->user->uid}}"
                            to_do="unfollow"
                            href="/suki_follow_user"
                            style="margin-left: 5px"
                        >
                            取消关注
                        </a>
                    </div>

                    <span class="clear"></span>
                </div>
            @endforeach

        @elseif($data['request']['type'] == "follow_me")
            @if($data['follow_me']->isEmpty())
                <p style="padding: 20px 50px;">还没有关注~</p>
            @endif
            @foreach($data['follow_me'] as $value)
                <div style="    width: 260px;float: left;">
                    <div style="display: inline-block;float:left;margin: 15px 20px;">{{avatar($value->user->uid,50,100)}}</div>
                    <div style="display: inline-block;float:left;">
                        <p style="display: block;float:left;    width: 100%;line-height: 45px;">{{$value->user->username}}</p>
                        <a  class="follow trans"
                            uid="{{$data['user_info']->uid}}"
                            to_uid="{{$value->user->uid}}"
                            to_do="unfollow"
                            href="/suki_follow_user"
                            style="margin-left: 5px"
                        >
                            @if($value->has_follow)
                                关注中
                            @else
                                关注
                            @endif
                        </a>
                    </div>

                    <span class="clear"></span>
                </div>
            @endforeach
        @elseif($data['request']['type'] == "friends")
        @elseif($data['request']['type'] == "friends_request")
            @foreach($data['friends_request'] as $value)
                <div style="margin: 10px 0px">
                    <div style="margin: 5px 10px 5px 30px;float:left;">{{avatar($value->uid,50,100)}}</div>
                    <div style="margin: 5px;float:left;">
                        <p>
                            <span>{{$value->nickname}}</span>
                            在
                            <span>{{format_time($value->time)}}</span>
                            <span>请求加你为好友,并说:</span>
                            <span>{{$value->message}}</span>
                        </p>
                        <p>
                            {{--1=正在等待反馈 2=已经同意 3=已经拒绝--}}
                            @if($value->result == 1)
                                <a class="apply_suki_friends" href="/apply_suki_friends" to_do="2" applicant_id="{{$value->uid}}" ship_id="{{$data["user_info"]->uid}}">同意</a>
                                <a class="apply_suki_friends"  href="/apply_suki_friends" to_do="3" applicant_id="{{$value->uid}}" ship_id="{{$data["user_info"]->uid}}">拒绝</a>

                            @elseif($value->result == 2)
                                <p>已同意</p>
                            @elseif($value->result == 3)
                                <p>已拒绝</p>
                            @endif
                        </p>
                    </div>
                    <div class="clear"></div>


                </div>
            @endforeach
        @endif
        <div class="clear"></div>
    </div>
    <div class="clear"></div>

</div>
@include('PC.Suki.SukiFooter')