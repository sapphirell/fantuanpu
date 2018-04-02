<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <script type="text/javascript">
        var exampleSocket = new WebSocket("ws://0.0.0.0:9501");
        exampleSocket.onopen = function (event) {
            exampleSocket.send("亲爱的服务器！我连上你啦！");
        };
        exampleSocket.onmessage = function (event) {
            console.log(event.data);
        }
    </script>
</head>
<body>
<input  type="text" id="content">
<button  onclick="exampleSocket.send( document.getElementById('content').value )">发送</button>
</body>
</html>