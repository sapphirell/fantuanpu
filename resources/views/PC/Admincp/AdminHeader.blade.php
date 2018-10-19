<html>
<head>
    <title>饭团扑</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    @include('PC.Common.HtmlHead')
    <script src="/Static/Script/laydate/laydate.js"></script>
</head>
<style>
    header a{color: #fff;}
    body {background: #ffffff}
    .admin.wp {margin-top: 50px;    margin-left: 230px;}

</style>
<body>
<header class="navbar navbar-static-top bs-docs-nav" id="top" style="  position: fixed;width: 100%;  background-color: #000;box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>
        <nav id="bs-navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a  class=" trans" href="/admincp/">首页</a>
                </li>
                <li class="active">
                    <a  class=" trans" href="/admincp/user_manager">用户</a>
                </li>
                <li>
                    <a  class=" trans" href="">节点</a>
                </li>
                <li>
                    <a  class=" trans" href="">运营</a>
                </li>

            </ul>

        </nav>
    </div>
</header>
<div style="
    background: #000;
    width: 200px;
    height: 100%;
    top: 50px;
    position: fixed;
    color: #fff;
    z-index: 9;">
    <div class="operation">

        <ul>
            <li class="trans"><a href="">websocket管理<i class="fa fa-pencil-square-o fa-lg"></i></a></li>
            <li class="trans"><a href="">同步代码<i class="fa fa-sticky-note-o fa-lg"></i></a></li>
            <li class="trans"><a href="">备份静态资源<i class="fa fa-sticky-note-o fa-lg"></i></a></li>
            <li class="trans"><a href="/logout">离开<i class="fa fa-sign-in fa-lg"></i></a></li>
        </ul>
    </div>
</div>


{{--@include('PC.Common.Footer')--}}