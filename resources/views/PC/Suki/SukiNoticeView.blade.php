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
        padding: 5px 10px 5px 0px;
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
                <a href="/suki_notice?type=reply_me" class="@if($data["request"]["type"]=="reply_me"){{"onchange"}}@endif">回复我的</a>
            </li>
            <li>
                <a href="/suki_notice?type=my_message" class="@if($data["request"]["type"]=="my_message"){{"onchange"}}@endif">我的私信</a>
            </li>
            <li>
                <a href="/suki_notice?type=call_me" class="@if($data["request"]["type"]=="call_me"){{"onchange"}}@endif">{{"@"}}我的</a>
            </li>
            <li>
                <a href="/suki_notice?type=friends_request" class="@if($data["request"]["type"]=="friends_request"){{"onchange"}}@endif">好友申请</a>
            </li>
            <li class="clear"></li>
        </ul>
    </div>
    <div style="float: left;    flex-grow: 1;">
        @if($data["request"]["type"]=="reply_me")
            @foreach($data["reply_me"] as $key => $value)
                <div style="display: flex;margin: 20px;border-bottom: 1px solid #f5f5f5;padding-bottom: 10px;">
                    <div class="" style="    display: inline-block;float: left;width: 100px;flex: none;">
                        <a href="/suki-userhome-{{$value->authorid}}.html" style="display: inline-block;margin: 5px 30px">
                            {{avatar($value->authorid,50,100)}}
                        </a>

                    </div>
                    <div style="float: left;display: inline-block;    flex-grow: 1;">
                        <div>
                            <div style="    margin-bottom: 5px;">
                                <a href="/suki-userhome-{{$value->authorid}}.html" style="font-weight: 900;color: #8e6262;">{{$value->author}}</a>
                                <span style="font: 13px/1.5 'PingFang SC', 'Helvetica Neue', 'Helvetica', 'STHeitiSC-Light', 'Arial', sans-serif; float: right;   color: #cccccc;padding-left: 5px;">
                                    {{format_time($value->notice_time,"Y·m·d")}}
                                </span>
                            </div>

                        </div>
                        <div style="display: flex;">
                            <div class="reply_me_content">
                                {!! bbcode2html($value->message) !!}
                            </div>
                            <a style="flex: none;color: #F09C9C" href="/suki-thread-{{$value->subject['thread_subject']->tid}}-1.html#{{$value->position->pid}}">回复</a>
                        </div>


                        {{--<a href="/suki-thread-{{$value->subject['thread_subject']->tid}}-1.html?pid={{$value->position->pid}}&floor={{$value->position->floor}}">--}}
                        <div class="origin_thread" href="/suki-thread-{{$value->subject['thread_subject']->tid}}-1.html">
                            <span style="color: #ae9c9e;">评论了您的主题 :  </span>
                            <a href="/suki-thread-{{$value->subject['thread_subject']->tid}}-1.html" style="color: #947b7e;">{{$value->subject['thread_subject']->subject}}</a>
                        </div>
                    </div>
                </div>
            @endforeach

        @elseif($data['request']['type'] == "friends_request")
            @foreach($data['friends_request'] as $value)
                <div style="margin: 10px 0px">
                    <a href="/suki-userhome-{{$value->uid}}.html" style="margin: 5px 10px 5px 30px;float:left;">{{avatar($value->uid,50,100)}}</a>
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
    </div>
    <div class="clear"></div>

</div>
@include('PC.Suki.SukiFooter')