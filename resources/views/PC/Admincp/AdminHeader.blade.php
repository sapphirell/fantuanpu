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
    .admin.wp {margin-top:90px;    margin-left: 230px;}

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
                    <a  class=" trans" href="/admincp/medal_list">运营</a>
                </li>

            </ul>

        </nav>
    </div>
</header>


@include('PC.Admincp.LeftNav')