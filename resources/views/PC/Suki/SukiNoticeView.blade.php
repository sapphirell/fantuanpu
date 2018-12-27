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
                <a href="/suki_notice?type=reply_me" class="@if($data["request"]["type"]=="reply_me"){{"onchange"}}@endif">回复我的</a>
            </li>
            <li>
                <a href="/suki_notice?type=my_message" class="@if($data["request"]["type"]=="my_message"){{"onchange"}}@endif">我的私信</a>
            </li>
            <li>
                <a href="/suki_notice?type=call_me" class="@if($data["request"]["type"]=="call_me"){{"onchange"}}@endif">{{"@"}}我的</a>
            </li>
            <li>
                <a href="/suki_notice?type=friend_request" class="@if($data["request"]["type"]=="friend_request"){{"onchange"}}@endif">好友申请</a>
            </li>
            <li class="clear"></li>
        </ul>
    </div>
    <div style="float: left;    flex-grow: 1;">
        @if($data["request"]["type"]=="reply_me")
            @foreach($data["reply_me"] as $key => $value)
                <div style="    display: flex;
    margin: 20px;
    border-bottom: 1px solid #f5f5f5;
    padding-bottom: 10px;">
                    <div class="" style="    display: inline-block;float: left;width: 100px;flex: none;">
                        <a href="" style="display: inline-block;margin: 5px 30px">
                            {{avatar($value->authorid,50,100)}}
                        </a>

                    </div>
                    <div style="float: left;display: inline-block;    flex-grow: 1;">
                        <div>
                            <div style="    margin-bottom: 5px;">
                                <a href="" style="font-weight: 900;color: #8e6262;">{{$value->author}}</a>
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
        @endif
    </div>
    <div class="clear"></div>

</div>
@include('PC.Suki.SukiFooter')