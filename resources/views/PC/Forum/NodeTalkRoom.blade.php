<div class="forum_group">
    <p style="    color: #dabbbb;">
        当前
        <span class="talking_num">0</span>
        人在线
    </p>

    <div style="max-height: 200px;overflow: scroll">
        @foreach($data['msg'] as $value)
            <div class="message-item">
                <p>
                    {{avatar($value->uid,30,100)}}
                    <span class="talker_name" style="">{{$value->username}}</span>
                </p>

                <span class="talk_message">{{$value->message}}</span>
            </div>

        @endforeach
    </div>
    <div>
        <span></span>
        <input type="text" id="msg" style="width: 100%;border: 0px;padding: 10px;color: #4288a7;box-shadow: 0 3px 5px #cadaef inset;
           border-top: 1px solid #919191;">
    </div>
    <input type="hidden" id="username" class="form-control" disabled value="{{$data['im_username']}}" style="width: 250px;margin-bottom: 5px;">
    <input type="hidden" id="uid" disabled value="{{session('user_info')->uid ? : session('access_id')}}">
    <input type="hidden" id="avatar" disabled value="{{$data['avatar']}}">
</div>

<script>
$(document).ready(function () {
    fantuanpuSocket = new WebSocket("wss://ws.fantuanpu.com:8002");//http://testgua.fantuanpu.com:8002
//    fantuanpuSocket = new WebSocket("ws://47.91.214.27:8002");//http://testgua.fantuanpu.com:8002
    var identify = {
        "type"      : "IM",
        "user_name" : $('#username').val(),
        "action"    : "identify",
        "user_id"   : $('#uid').val()
    };

    fantuanpuSocket.onopen = function (event) {
        fantuanpuSocket.send(JSON.stringify(identify));
        $('#msg').bind('keypress',function(event)
        {
            if(event.keyCode == "13")
            {
                var msg = {
                    "type"      : "IM",
                    "action"    : "talking",
                    "msg"       : $('#msg').val(),
                    'avatar'    : $('#avatar').val(),
                };
                @if(session('user_info')->uid)
                        msg.user_id  = $('#uid').val()
                @endif
                fantuanpuSocket.send(JSON.stringify(msg));
                $('#msg').val(' ');
            }
        });
    };
    fantuanpuSocket.onmessage = function (event) {
        wsMsg = JSON.parse(event.data);
//            if (data.indexOf('heart') > 0) {
//                exampleSocket.send(data);
//            }
        switch(wsMsg.code)
        {
            case 200:
                alert(wsMsg.data.msg)
                break;
            case 10001:
                $(".talking_num").text(wsMsg.data.talking_num)

                break;
            case 10002:

                var html = "<div class='message-item'>";
                if ( wsMsg.data.username != '\u7cfb\u7edf\u6d88\u606f')
                {
                    html += "<p><img src='"+wsMsg.data.avatar+"' style='width: 30px;border-radius: 100%;'><span>"+wsMsg.data.username+"</span></p>";
                }
                html += "<span class='talk_message'>"+wsMsg.data.msg+"</span></div>";
                $(".message-item:first").before(html);
                break;
            default:

        }
        console.log(wsMsg.data.talking_num);
    }
})

</script>