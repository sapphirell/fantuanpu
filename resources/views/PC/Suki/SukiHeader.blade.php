<!doctype html>
<html>
<head>
    <title>Suki! -@if($data['title']){{$data['title']}}@else 小裙子交流社区 @endif</title>
    <meta name="keywords" content="SUKI,lolita服饰,jk制服,Lolita开箱推荐,软妹服装社区,{{$data["keywords"]}}">
    <meta name="description" content="SUKI,一个小众服饰社交社区">
    @include('PC.Common.HtmlHead')
    <script src="/Static/Script/wangEditor/wangEditor.min.js"></script>
    <style>
        .header {
            box-shadow: 0 0 19px #ff00004f;
            border-top: 0px solid #de9cb2;
        }
        body {
            background: #fafafa;
        }
        .search_box {
            background: #ffffff;
            border: 0px;
            color: #353331;
            height: 12px;
            font-size: 12px;
            font-family: 'PingFang SC', 'Helvetica Neue', 'Helvetica', 'STHeitiSC-Light', 'Arial', sans-serif;
            font-weight: 200;
            border: 0px solid #fff;
            margin-top: 8px;
            margin-right: 5px;
            border-radius: 2px;
            padding: 12px;
            display: inline-block;
            border-radius: 50px;
            width: 25px;
            padding-left: 20px;
            box-shadow: 0 0 5px #ffcaca;

        }
        .search_box:hover ,.search_box:active,.search_box:focus {
            border-color: #FFFFFF!important;
            border-radius: 20px;
            border:0px !important;
            /*box-shadow: 0 0 5px #ff7979;*/
            /*border-style:dashed!important;*/
        }
        .hd li {
            list-style: none;
            display: inline-block;
            padding: 6px 10px 11px 10px;
            color: #464646;
            font-size: 13px;
            cursor: pointer;
            height: 100%;
            margin: 0px;
            float: left;
        }
        .hd li:hover {
            box-shadow: 0 -25px 21px inset #e68a9d;

        }
        .hd li a:hover {
            text-decoration: none;
            text-shadow: 0 0 4px;
        }
        .user_info_panel a {

        }
        .user_info_panel a:hover {
            color: #F09C9C!important;
        }
        .user_info_panel_box {
            position: fixed;
            margin: 0 auto;
            display: block;
            width: 960px;
            z-index: 1000001;
        }
        .user_info_panel {
            background: #fff;
            position: absolute;
            width: 250px;
            height: 320px;
            top: 48px;
            right: 10px;
            box-shadow: 0 0 15px #0000001c;
            display: none;

            animation-duration: 0.55s;
            /*display: block;*/
            border-radius: 13px;
            /*overflow: hidden;*/
            padding-top: 5px;
            margin-left: 5px;
        }
        .user_info_item {
            width:100%;
            margin-top: 10px;
        }
        .panel_btn_list {
            padding-left: 25px;
        }
        .panel_btn_list li {
            list-style: none;
            float: left;
            box-sizing: border-box;
            width: 110px;
            position: relative;
        }
        .panel_btn_list li a {
            padding: 3px;
            cursor: pointer;
            color: #927979;
            margin: 1px;
            display: inline-block;
            text-decoration: none;
        }
        .user_info_content a {
            text-decoration: none;
        }
        .panel_btn_list li a:hover {
            color: #00A0FF;
        }
        .panel_btn_list li img {
            width: 14px;
            margin-right: 10px;

        }
        .user_info_content {
            display: flex;
            justify-content: space-around;
            margin: 0px 10px;
            border-bottom: 1px solid #efeeee;
            padding-bottom: 10px;
            border-bottom: 1px dashed #efeeee;
        }
        .user_info_content div {
            float: left;
            /*flex-grow: 1;*/
        }
        .user_info_content_value {
            font-size: 22px;
            color: #967777;
            font-weight: 900;
            width: 100%;
            text-align: center;
            margin: 0px;
            display: inline-block;
        }
        .user_info_content_description{
            color: #9e8484;
            display: inline-block;
            width: 100%;
            text-align: center;
            margin: 0px;
            font-size: 11px;
        }
        .panel_btn_list li.rough > a{
            color:#ccc;
        }
        .panel_btn_list li.rough > a:hover
        {
            color: #cccccc !important;
        }
        .user_info_btn:hover {
            box-shadow: 0 -25px 21px inset #f3abba!important;
        }
        .triangle_border_up{
            width: 0;
            height: 0;
            border-width: 0px 12px 10px;
            border-style: solid;
            border-color: transparent transparent #fff;
            margin: 7px auto;
            position: absolute;
            top: -15px;
            right: 20px;
        }
        .layui-layer-setwin .layui-layer-close2 {
            position: absolute;
            right: -10px!important;
            top: -8px!important;
            width: 30px;
        }
        .head_sig {
            overflow:hidden;
            text-overflow:ellipsis;
            display:-webkit-box;
            -webkit-box-orient:vertical;
            -webkit-line-clamp:2;
            width: 100px;
            font-size: 11px;
            line-height: 17px;
        }
        .alert_pointer {
            border-radius: 100%;
            width: 8px;
            height: 8px;
            background: #ff5a5a;
            display: inline-block;
            position: absolute;
            box-shadow: 0 0 7px #ff5a5a;
        }
        .low_browser {
            display: none;
            text-align: center;
            background: #c1d7fc;
            position: fixed;
            color: #fff;
            width:100%;
            z-index: 99999;
        }
        @media screen and (max-width: 960px) {
            .user_info_panel {
                position: fixed;
                right: 10px;
            }

        }
    </style>
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

<div class="low_browser">
    浏览器版本低,建议换一个。
</div>
<div class="header pink_bg">

    <div style="max-width: 960px;margin: 0 auto;">
        <p class="title none_960">
            <a href="{{\App\Http\Controllers\Controller::LOLITA_DOMAIN}}" style="font-weight: 900;text-shadow: 0 0 3px #af2e2e;"><img style="width: 60px;margin: 4px;" src="/Image/SUKI.png"></a>
        </p>
        {{--<h1 style="display: inline;margin:0px;float:right;"></h1>--}}

        <ul style="float: right;" class='hd'>
            @if(session("user_info")->uid)
                <li class="trans user_info_btn" style="position:relative;    padding: 5px;border-radius: 100%;margin-right: 20px">
                    {{avatar($data["user_info"]->uid,30,50,"","big")}}
                    @if(!empty($data["user_info"]->useralert["suki"]["reply"])|| !empty($data["user_info"]->useralert["suki"]["friend_request"]))
                    <span class="alert_pointer" style="right: 3px;bottom: 3px;"></span>
                    @endif
                </li>
            @else
                <li id="alert_ajax_login_suki" class="trans">
                    <img src="/Image/denglu-copy.png" style="    width: 25px;border: 2px solid #fff;padding: 2px;border-radius: 100%;margin-top: 2px;">
                </li>
            @endif
        </ul>
        <div class="search">
            <from action="">
                <input type="text" name="" class="search_box trans" placeholder="Searching..">
                <i style="color: #fcd4d1;position: relative;left: -34px;top: -1.3px;font-size: 14px;text-shadow: 0 0 3px #f7dfdc;" class="fa fa-search fa-fw fa-lg toggle_search"></i>
            </from>
        </div>
        <ul class='hd'>

            {{--<li class="trans">--}}
                {{--<a href="/"  class="header_items">--}}
                    {{--<i class="fa fa-home fa-fw fa-lg" style="color: #ffffff;line-height: 23px"></i>--}}
                    {{--<p class="none_960" style="color: #fff;display: inline-block">首页</p>--}}

                {{--</a>--}}
            {{--</li>--}}
            <li class="trans">
                <a href="/"  class="header_items">
                    {{--<i class="fa fa-comments-o fa-fw fa-lg"  style="color: #ffffff;line-height: 23px"></i>--}}
                    <img src="/Image/home.png" style="width: 20px;">
                    <p class="none_960" style="color: #fff;display: inline-block">交流</p>
                </a>
            </li>
            <li class="trans">
                <a href="/suki_tribunal"  class="header_items">
                    {{--<i class="fa  fa-gavel fa-fw fa-lg"  style="color: #ffffff;line-height: 23px"></i>--}}
                    <img src="/Image/xinyu.png" style="width: 20px;">
                    <p class="none_960" style="color: #fff;display: inline-block">信誉墙</p>
                </a>
            </li>
            <li class="trans">
                <a href="/suki_group_buying"  class="header_items">
                    {{--<i class="fa  fa-gavel fa-fw fa-lg"  style="color: #ffffff;line-height: 23px"></i>--}}
                    <img src="/Image/tuangou2.png" style="width: 20px;">
                    <p class="none_960" style="color: #fff;display: inline-block">团购</p>
                </a>
            </li>
        </ul>



        <span class="clear"></span>
    </div>

</div>
<div class="wp">
    <div class="user_info_panel_box">

        <div class="user_info_panel animated ">
            <div class="triangle_border_up">
                <span></span>
            </div>
            <div class="my_avatar shadow" style="    margin-top: 10px;display: inline-block;float: left;width: 60px;height: 60px; border-radius: 100%;overflow: hidden;position: relative;margin: 12px 20px 12px 32px;">
                <div class="ava_glass" style="    display: inline-block;float: left;width: 60px;height: 60px;position: absolute;background: url(/Image/real-trans.png);display: none;cursor: pointer;">
                    <span style="    position: absolute;bottom: 5px;width: 60px;display: inline-block;text-align: center;color: #fff;font-size: 12px;">更换</span>
                </div>
                {{avatar($data["user_info"]->uid,60,50,"","big")}}
            </div>
            {{--<div style="display: inline-block;float:left;      margin: 10px 20px 12px 20px;"></div>--}}
            <div style="float:left;">
                <a style="text-decoration: none;max-width: 130px" href="/suki-userhome-{{$data["user_info"]->uid}}.html"><h2 style="     font-size: 17px;color: #6a6c7f;margin-top: 15px;">{{$data["user_info"]->username}}</h2></a>
                <p class="head_sig">{{ $data['field_forum']->sightml ?: "暂未设置签名档" }}</p>
            </div>
            <div class="clear"></div>
            <div class="user_info_content">

                <div>
                    <a href="/suki-userhome-{{$data["user_info"]->uid}}.html" class="user_info_content_value trans">{{$data["count"]["sukithreads"]?:0}}</a>
                    <a href="/suki-userhome-{{$data["user_info"]->uid}}.html"  class="user_info_content_description trans">帖子</a>
                </div>
                <div>
                    <a href="/suki_relationship?type=my_follow" class="user_info_content_value trans">{{$data["count"]["followsuki"]?:0}}</a>
                    <a href="/suki_relationship?type=my_follow" class="user_info_content_description trans">关注</a>
                </div>
                <div>
                    <a href="/suki_relationship?type=follow_me"  class="user_info_content_value trans">{{$data["count"]['sukifollow']?:0}}</a>
                    <a href="/suki_relationship?type=follow_me"  class="user_info_content_description trans" >粉丝</a>
                </div>
            </div>
            <div class="user_info_item">
                <ul class="panel_btn_list">
                    <li class="trans"><a href="/suki_user_info" class="trans"><img style="" src="/Image/print.png">个人信息</a></li>
                    <li class="trans">
                        <a href="/suki_notice?type=reply_me" class="trans">
                            <img style="" src="/Image/tixing2.png">站内消息
                        </a>
                        @if(!empty($data["user_info"]->useralert["suki"]["reply"])|| !empty($data["user_info"]->useralert["suki"]["friend_request"]))
                            <span class="alert_pointer" style="right: 23px;bottom: 15px;"></span>
                        @endif
                    </li>
                    <li class="trans"><a href="/suki_collection" class="trans"><img style="" src="/Image/star-pink.png">我的收藏</a></li>
                    <li class="trans rough"><a href="" class="trans"><img style="" src="/Image/history.png">浏览历史</a></li>
                    <li class="trans"><a href="/suki_relationship?type=friends" class="trans"><img style="" src="/Image/friends.png">通讯录</a></li>
                    <li class="trans rough"><a href="" class="trans"><img style="" src="/Image/nearby.png">附近同好</a></li>


                    <li class="trans">
                        <a href="/suki_alarm_clock?type=view" class="trans"><img style="" src="/Image/tixing2.png">补款闹钟</a>
                        <span style="    font-size: 10px;font-weight: 400;color: #bf0000;position: absolute;" title="...这个new似乎没有意义">new</span>
                    </li>
                    <li class="trans">
                        <a href="/suki_group_buying_myorders?type=last" class="trans"><img style="" src="/Image/tixing2.png">团购列表</a>
                    </li>

                </ul>
            </div>

            <a style="    position: absolute;bottom: 0px;width: 100%;text-align: center;    background: #f3f2f2;padding: 5px;text-decoration: none" href="/logout">
                <span style="font-size: 14px;color: #a99595;font-weight: 900;border-radius: 0 0 13px 13px;font-size: 12px;">退出登录</span>
                <img src="/Image/tuichu1.png" style="width: 14px;padding-bottom: 4px;" >
            </a>
        </div>
    </div>

</div>
