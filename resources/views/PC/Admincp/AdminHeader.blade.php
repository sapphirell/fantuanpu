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
    .navbar-nav ul {
        display: block;
    }
    .navbar-nav li {    list-style: none;
        display: inline-block;
        padding: 6px 10px 11px 10px;
        color: #464646;
        font-size: 13px;
        cursor: pointer;
        height: 100%;
        margin: 0px;
        float: left;}
</style>
<body>
<header class="navbar navbar-static-top bs-docs-nav" id="top" style="    z-index: 999;  position: fixed;width: 100%;  background-color: #000;box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);">
    <div class="container">
        <ul class="nav navbar-nav" style="display: block">
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
            <li>
                <a  class=" trans" href="/admincp/add_group_buying_item">团购</a>
            </li>
        </ul>
    </div>
</header>


@include('PC.Admincp.LeftNav')