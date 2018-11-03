<html>
<head>
    <title>饭团扑 |
        @if($data['title'])
            {{$data['title']}}
        @else
            兴趣不再小众
        @endif
    </title>

    <meta name="keywords" content="饭团扑,二次元,动漫论坛,宅论坛">
    <meta name="description" content="饭团扑,一个二次元社交社区">
    @include('PC.Common.HtmlHead')
</head>

<body>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="header">
    <div class="memuBtn"></div>
    <p class="title"><a href="/" style="">饭团扑.com</a></p>
    <div style=" min-width: 900px ;  max-width: 960px;    margin: 0 auto;">
        <h1 style="display: inline;margin:0px;float:right;"></h1>
        <div class="search">
            {{--<a class="add-me"><i class="icon-plus"></i> <span id="msg_num">0</span> Message</a>--}}
            @if(session('user_info')->uid)
                @if($data['user_has_sign'])
                <span style="font-size: 12px;margin-right: 10px">已签到</span>
                @else
                <a class="sign" style="color: #ffffff;font-size: 12px;margin-right: 10px"> 签到 </a>
                @endif
            @endif
            <from action="">
                <input type="text" name="" class="in_text trans" placeholder="Searching..">

            </from>

        </div>
        <ul class='hd'>
            <li><a href="/index"  class="header_items"><p class="none_960" style="color: #fff;">板块 <span>Forums</span></p><i class="inline_block_960 fa fa-code-fork fa-2x"></i></a></li>
            <li><a href="/notice"  class="header_items"><p class="none_960" style="color: #ff9999;">公告/招募</p></a></li>
        </ul>



        <span class="clear"></span>
    </div>

</div>

<div id="active">
    <div class='ava_message'>

        {{--<img src="/Image/avatar/noavatar_big.gif" width="80px" style="border-radius:100%;overflow:hidden;" class="left_memu_ava can_set_ava">--}}
        {{ avatar(session('user_info')->uid,80,100,'left_memu_ava can_set_ava') }}
        <p style=''>
            @if(!session('user_info')->uid)
            请
                <a id='alert_ajax_login' href='/login' style='color: #F09C9C;'>登录</a>
                /
                <a id='alert_ajax_reg' href='/register' style='color: #F09C9C;'>注册</a>
                您的账号
            @else
            <p>{{session('user_info')->username}}</p>
            @endif

        </p>


        <div class="">
            @if(session('user_info')->uid)
            <span><i class="fa fa-coffee"></i>[{{session('user_info')->group->grouptitle}}]</span>
            <span style=" color: #909090;">签名档</span>
            @endif
        </div>


        <div class='clear'></div>
    </div>


    <div class="operation">

        <ul >
            @if(session('user_info')->uid)
            <li class="trans"><a href="/user-center?source=web">用户中心<i class="fa fa-pencil-square-o fa-lg"></i></a></li>
            <li class="trans"><a href="">团菌动态<i class="fa fa-sticky-note-o fa-lg"></i></a></li>
            <li class="trans"><a href="/medal_shop">勋章商城<i class="fa fa-sticky-note-o fa-lg"></i></a></li>
            <li class="trans"><a href="/logout">离开<i class="fa fa-sign-in fa-lg"></i></a></li>
                @if(session('user_info')->gid > 0)
                    <li class="trans"><a href="/admincp">管理后台</a></li>
                @endif
            @else
            <li class="trans"><a href="/register">加入饭团扑?<i class="fa fa-sign-in fa-lg"></i></a></li>
            @endif
        </ul>
    </div>
    <div style="position: fixed;bottom: 0px;width: inherit">
        <p class="statement">Powered by <a href="/fantuanpuDevelopers">FantuanpuDevelopers</a>.</p>
        <p class="statement">Used <a href="http://php.net">PHP</a> & <a href="https://laravel.com/docs/5.2">Laravel</a> & <a href="https://www.swoole.com">Swoole</a></p>
    </div>


</div>

<div class="server-alert trans" style="">
    <svg class="icon" style="display: inline-block;margin: 3px;float:left;"  width="20px" height="20px" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M473.8 607.4c6.4 19.1 19.1 31.8 38.2 31.8s31.8-12.7 38.2-31.8l25.4-349.9c0-38.2-31.8-63.6-63.6-63.6-38.2 0-63.6 31.8-63.6 70l25.4 343.5z m38.2 95.5c-38.2 0-63.6 25.4-63.6 63.6s25.4 63.6 63.6 63.6 63.6-25.4 63.6-63.6-25.4-63.6-63.6-63.6z" fill="#ffffff" /></svg>
    {{--<svg class="icon" style="display: inline-block" width="20px" height="20.00px" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M512 32C246.912 32 32 246.912 32 512c0 265.088 214.912 480 480 480 265.088 0 480-214.912 480-480 0-265.088-214.912-480-480-480z m0 896C282.24 928 96 741.76 96 512S282.24 96 512 96s416 186.24 416 416-186.24 416-416 416z" fill="#d44e89" /><path d="M512 384a32 32 0 0 0-32 32v352a32 32 0 0 0 64 0V416a32 32 0 0 0-32-32z" fill="#d44e89" /><path d="M512 272m-48 0a48 48 0 1 0 96 0 48 48 0 1 0-96 0Z" fill="#d44e89" /></svg>--}}
    <p style="display: inline-block;color: #ffffff;float: left;margin: 3px">即时通讯未建立</p>
</div>
<script>
    $(document).ready(function () {
        @if(!session('user_info')->uid)
        layer.tips('点这里登录哦', '.memuBtn',{
            tips: [3, 'rgb(255, 136, 175)'],
            time: 4000
        });
        @endif

        //全局连接websocket
        window.fantuanpuSocket = new WebSocket("wss://ws.fantuanpu.com:8002");//
    })
</script>