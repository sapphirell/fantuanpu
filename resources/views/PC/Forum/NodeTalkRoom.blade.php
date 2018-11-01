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
</div>

<script>
$(document).ready(function () {
    window.socketPage = 'node_talk_room'
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
            window.fantuanpuSocket.send(JSON.stringify(msg));
            $('#msg').val(' ');
        }
    });

})

</script>