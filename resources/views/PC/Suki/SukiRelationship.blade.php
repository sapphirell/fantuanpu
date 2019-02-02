@include('PC.Suki.SukiHeader')
<style>
    a {
        text-decoration: none;
    }
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
                    <a href="/suki-userhome-{{$value->user->uid}}.html" style="display: inline-block;float:left;margin: 15px 20px;">{{avatar($value->user->uid,50,100)}}</a>
                    <div style="display: inline-block;float:left;">
                        <a  href="/suki-userhome-{{$value->user->uid}}.html" style="display: block;float:left;    width: 100%;line-height: 45px;">{{$value->user->username}}</a>
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
                    <a href="/suki-userhome-{{$value->user->uid}}.html" style="display: inline-block;float:left;margin: 15px 20px;">{{avatar($value->user->uid,50,100)}}</a>
                    <div style="display: inline-block;float:left;">
                        <a href="/suki-userhome-{{$value->user->uid}}.html" style="display: block;float:left;    width: 100%;line-height: 45px;">{{$value->user->username}}</a>
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
            @foreach($data['my_friends'] as $value)
                <div style="    width: 260px;float: left;">
                    <a href="/suki-userhome-{{$value->user->uid}}.html" style="display: inline-block;float:left;margin: 15px 20px;">{{avatar($value->user->uid,50,100)}}</a>
                    <div style="display: inline-block;float:left;">
                        <a href="/suki-userhome-{{$value->user->uid}}.html" style="display: block;float:left;    width: 100%;line-height: 45px;">{{$value->user->username}}</a>
                        <a  class="trans"
                            uid="{{$data['user_info']->uid}}"
                            to_uid="{{$value->user->uid}}"
                            style="margin-left: 5px"
                        >
                            私信
                        </a>
                        <a  class="trans"
                            uid="{{$data['user_info']->uid}}"
                            to_uid="{{$value->user->uid}}"
                            style="margin-left: 5px"
                        >
                            解除关系
                        </a>
                    </div>

                    <span class="clear"></span>
                </div>
            @endforeach

        @endif
        <div class="clear"></div>
    </div>
    <div class="clear"></div>

</div>
@include('PC.Suki.SukiFooter')