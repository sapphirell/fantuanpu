
@include('PC.Common.HtmlHead')
<link rel="stylesheet" type="text/css" href="/Static/Script/live2d/waifu.css"/>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<style>
    td{border-color: #FFFFFF!important;}
    .talkingView {    position: fixed;
        width: inherit;
        background: #fff;

        bottom: 200px;
        top: 50px;
        overflow: scroll;
        border-radius: 5px;
        box-shadow: 0 0 5px #8e9fff;}
    .talkingView * {    font-size: 14px!important;}
</style>
<div class="wp" style="width: 960px">
    <p> 当前聊天房间人数: <span id="talking_num">0</span></p>
    <div class="talkingView">
        <table class="table">
            <tr>
                <td style="width: 280px">用户名</td>
                <td style="width: 190px">时间</td>
                <td>消息</td>
            </tr>

        </table>
    </div>


</div>

<div class="waifu">
    <!--<div class="waifu-tips"></div>-->
    <canvas id="live2d" width="280" height="250" class="live2d"></canvas>
    <div style="    position: fixed;bottom: 10px;left: 250px;width: 800px;">
        <input type="text" id="username" class="form-control" disabled value="{{$data['username']}}" style="width: 250px;margin-bottom: 5px;">
        <input type="hidden" id="uid" disabled value="{{$data['im_userid']}}">
        <input type="text" class="form-control" id="msg">
    </div>
</div>

<script src="/Static/Script/live2d/waifu-tips.js"></script>
<script src="/Static/Script/live2d/live2d.js"></script>
<script type="text/javascript">initModel("/Static/Script/live2d/")</script>
<script>
//    $(document).ready(function () {
        var exampleSocket = new WebSocket("ws://47.91.214.27:8002");
//        var exampleSocket = new WebSocket("ws://127.0.0.1:8001");
        var identify = {
            "type"      : "IM",
            "user_id"   : $('#uid').val(),
            "user_name" : $('#username').val(),
            "action"    : "identify"
        };

        exampleSocket.onopen = function (event) {
            exampleSocket.send(JSON.stringify(identify));
            $('#msg').bind('keypress',function(event)
            {
                if(event.keyCode == "13")
                {
                    $msg = {
                        "type"      : "IM",
                        "action"    : "talking",
                        "msg"       : $('#msg').val()
                    };
                    exampleSocket.send(JSON.stringify($msg));
                    $('#msg').val(' ');
                }

            });
        };
        exampleSocket.onmessage = function (event) {
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
                    $("#talking_num").text(wsMsg.data.talking_num)
                    break;
                case 10002:
                    $("tr:last").after("<tr> "+
                            "<td>"+wsMsg.data.username+"</td>"+
                            "<td>"+wsMsg.data.date+"</td>"+
                            "<td>"+wsMsg.data.msg+"</td>"+
                            "</tr>")
                    break;
                default:

            }
            console.log(wsMsg.data.talking_num);
        }
//    })

</script>
</body>
</html>