


<div class="wp footer_cut"></div>
{{--@if(session('user_info'))--}}
    {{--<div>--}}
        {{--<input type="hidden" id="uid" value="{{session('user_info')->uid}}">--}}
        {{--<input type="hidden" id="username" value="{{session('user_info')->username}}">--}}
    {{--</div>--}}
    {{--<script>--}}
        {{--var exampleSocket = new WebSocket("ws://47.91.214.27:8002");--}}
        {{--var identify = {--}}
            {{--"type"      : "Forum",--}}
            {{--"user_id"   : $('#uid').val(),--}}
            {{--"user_name" : $('#username').val(),--}}
            {{--"action"    : "identify"--}}
        {{--};--}}

        {{--exampleSocket.onopen = function (event) {--}}
            {{--exampleSocket.send(JSON.stringify(identify));--}}
{{--//            $('#msg').bind('keypress',function(event)--}}
{{--//            {--}}
{{--//                if(event.keyCode == "13")--}}
{{--//                {--}}
{{--//                    $msg = {--}}
{{--//                        "type"      : "IM",--}}
{{--//                        "action"    : "talking",--}}
{{--//                        "msg"       : $('#msg').val()--}}
{{--//                    };--}}
{{--//                    exampleSocket.send(JSON.stringify($msg));--}}
{{--//                    $('#msg').val(' ');--}}
{{--//                }--}}
{{--//--}}
{{--//            });--}}
        {{--};--}}
        {{--exampleSocket.onmessage = function (event) {--}}
            {{--wsMsg = JSON.parse(event.data);--}}
            {{--switch(wsMsg.code)--}}
            {{--{--}}
                {{--case 200:--}}
                    {{--alert(wsMsg.data.msg)--}}
                    {{--break;--}}
                {{--case 20001:--}}
                    {{--//有人回复帖子--}}
                    {{--layer.tips(wsMsg.data.msg, '.add-me', {--}}
                        {{--tips: [3, '#3595CC'],--}}
                        {{--fixed: true,--}}
                        {{--time: 6000--}}
                    {{--});--}}
                    {{--var num = parseInt($("#msg_num").text()) + 1 ;--}}
                    {{--$("#msg_num").text(num);--}}
                    {{--break;--}}
                {{--case 10002:--}}
                    {{--$("tr:last").after("<tr> "+--}}
                            {{--"<td>"+wsMsg.data.username+"</td>"+--}}
                            {{--"<td>"+wsMsg.data.date+"</td>"+--}}
                            {{--"<td>"+wsMsg.data.msg+"</td>"+--}}
                            {{--"</tr>")--}}
                    {{--break;--}}
                {{--default:--}}

            {{--}--}}
{{--//            console.log(wsMsg.data.talking_num);--}}
        {{--}--}}

    {{--</script>--}}
{{--@endif--}}

</body>
</html>