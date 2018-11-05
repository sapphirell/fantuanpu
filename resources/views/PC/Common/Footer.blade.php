
<div class="window_gift_alert trans" style="display: none">
</div>
<div class="wp footer_cut"></div>
<div class="wp" style="margin-bottom: 10px">
    <p style="padding: 10px;color: #d0d0d0;">fantuanpu.com</p>
</div>
    <div>
        <input type="hidden" id="username" class="form-control" disabled value="{{$data['im_username']}}" style="width: 250px;margin-bottom: 5px;">
        <input type="hidden" id="uid" disabled value="{{session('user_info')->uid ? : session('access_id')}}">
        <input type="hidden" id="avatar" disabled value="{{$data['avatar']}}">
    </div>
    <script>
        $(document).ready(function () {


            window.fantuanpuSocket.onopen = function (event) {
                @if(session('user_info'))
                        //如果登录,鉴定一次论坛
                    var identify = {
                        "type"      : "Forum",
                        "user_id"   : $('#uid').val(),
                        "user_name" : $('#username').val(),
                        "action"    : "identify"
                    };
                    window.fantuanpuSocket.send(JSON.stringify(identify));
                @endif
                //当websocket连接时,可以签到
                $(".sign").show();
                $(".server-alert").hide("slow")
                if (window.socketPage == 'node_talk_room')
                {
                    //首页聊天室多发一次身份鉴定
                    var identify = {
                        "type"      : "IM",
                        "user_name" : $('#username').val(),
                        "action"    : "identify",
                        "user_id"   : $('#uid').val()
                    };
                    window.fantuanpuSocket.send(JSON.stringify(identify));
                }
                window.fantuanpuSocket.onmessage = function (event) {
                    wsMsg = JSON.parse(event.data);
                    switch(wsMsg.code)
                    {
                        case 200:
                            alert(wsMsg.data.msg)
                            break;
                        case 200:
                            alert(wsMsg.data.msg)
                            break;
                        case 10001: //首页聊天室
                            $(".talking_num").text(wsMsg.data.talking_num)

                            break;
                        case 10002: //首页聊天室

                            var html = "<div class='message-item'>";
                            if ( wsMsg.data.username != '\u7cfb\u7edf\u6d88\u606f')
                            {
                                html += "<p><img src='"+wsMsg.data.avatar+"' style='width: 30px;border-radius: 100%;'><span>"+wsMsg.data.username+"</span></p>";
                            }
                            html += "<span class='talk_message'>"+wsMsg.data.msg+"</span></div>";
                            $(".message-item:first").before(html);
                            break;
                        case 20001:
                            //有人回复帖子
                            layer.tips(wsMsg.data.msg, '.add-me', {
                                tips: [3, '#3595CC'],
                                fixed: true,
                                time: 6000
                            });
                            var num = parseInt($("#msg_num").text()) + 1 ;
                            $("#msg_num").text(num);
                            break;
                        case 30001:
                            //显示系统奖励提示
                            $(".window_gift_alert").text(wsMsg.data.msg).show().addClass("hover")
                            $(".sign").text("已签到");
                            break;

                    }
                }
            }
        })


    </script>


</body>
</html>