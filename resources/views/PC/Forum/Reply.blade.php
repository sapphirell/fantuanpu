@foreach($data['thread_post'] as $key=>$value)
    <div class="post_item">

        <div class="post_msg"  style="z-index: 1   ; position: relative;">
            <p> <span style="color: #5abdd4;">{{$value->author}}</span> <span style="color: #cccccc"></span>{{date("Y-m-d H:i:s",$value->dateline)}}</p>
            <div id="{{$value->pid}}" style="padding: 5px;">{!! bbcode2html($value->message) !!}</div>
            <p onclick="reply({{$value->pid}})" class="reply" style="cursor: pointer;color: #ccc;position: absolute;right: 20px;bottom: 5px;">&lt;Reply&gt;</p>
        </div>
        <div class="post_userinfo trans" style="float: right;position: absolute;    left: 505px;background: #fff;padding: 8px;margin: 15px 15px 15px 0px;width: 17%;box-shadow: 2px 3px 3px #e4e4e4;z-index: 0;border-radius: 0px 5px 5px 0px;">

            <div style="float: left;width: 45px   ;">
                <a>加关注</a>
                <a>加好友</a>
                <a>发消息</a>
            </div>
            <div>
                {{avatar($value->authorid,50,100,'post-avatar','normal')}}
            </div>

        </div>
        <div class="clear"></div>
    </div>

@endforeach