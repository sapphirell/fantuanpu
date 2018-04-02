<?php
$server = new swoole_websocket_server("0.0.0.0", 9501);

$server->on('open', function (swoole_websocket_server $server, $request) {
    $cnum = count($server->connections);
    var_dump('当前连接数'.$cnum);
    foreach($server->connections as $fd) {
        $server->push($fd, '当前连接数'.$cnum );
    }
});

$server->on('message', function (swoole_websocket_server $server, $frame) {
    $data = $frame->data;
    foreach($server->connections as $fd) {
        $server->push($fd, $data);
    }

});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();