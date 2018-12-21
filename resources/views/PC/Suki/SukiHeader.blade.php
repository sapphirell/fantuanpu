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
            background: #ffb8b8;
            border: 0px;
            color: #fff2e9;
            height: 21px;
            font-size: 15px;
            font-family: 'PingFang SC', 'Helvetica Neue', 'Helvetica', 'STHeitiSC-Light', 'Arial', sans-serif;
            font-weight: 100;
            border: 1px solid #f4b8b7;
            margin-top: 5px;
            border-radius: 7px;
            padding: 13px;
            width: 120px;
            margin-right: 5px;
        }
        .search_box:hover ,.search_box:active,.search_box:focus {
            border-color: #ad8a98!important;
            box-shadow: 0 0 5px #ff7979;
        }
        .hd li {
            list-style: none;
            display: inline-block;
            padding: 5px 15px;
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
        .user_info_panel {
            background: #fff;
            position: fixed;
            width: 200px;
            height: 300px;
            top: 48px;
            left: 10px;
            box-shadow: 0 0 15px #00000012;
            display: none;
            z-index: 10002;
        }
        .user_info_item {
            width:100%;
        }
        .panel_btn_list li {
            list-style: none;

        }
        .panel_btn_list li a {
            padding: 3px;
            cursor: pointer;
            font-weight: 900;

        }
        .panel_btn_list li a:hover {
            color: #00A0FF;
        }
        .panel_btn_list li img {
            width: 25px;
            margin-right: 10px;

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


<div class="header pink_bg">

    <p class="title none_960">
        <a href="{{\App\Http\Controllers\Controller::LOLITA_DOMAIN}}" style="font-weight: 900;text-shadow: 0 0 3px #af2e2e;"><img style="width: 60px;margin: 4px;" src="/Image/SUKI.png"></a>
    </p>
    <div style="max-width: 960px;margin: 0 auto;">
        <h1 style="display: inline;margin:0px;float:right;"></h1>
        <div class="search">
            <from action="">
                <input type="text" name="" class="search_box trans" placeholder="Searching..">

            </from>

        </div>
        <ul class='hd'>
            @if(session("user_info")->uid)
                <li class="trans user_info_btn" style="">
                    {{avatar(session("user_info")->uid,30,50,"","big")}}
                </li>
            @else
                <li class="" id="alert_ajax_login">
                    <img src="/Image/denglu-copy.png" style="width: 30px;border: 2px solid #fff;padding: 2px;border-radius: 100%;">
                </li>
            @endif
            {{--<li class="trans">--}}
                {{--<a href="/"  class="header_items">--}}
                    {{--<i class="fa fa-home fa-fw fa-lg" style="color: #ffffff;line-height: 23px"></i>--}}
                    {{--<p class="none_960" style="color: #fff;display: inline-block">首页</p>--}}

                {{--</a>--}}
            {{--</li>--}}
            <li class="trans">
                <a href="/"  class="header_items">
                    <i class="fa fa-comments-o fa-fw fa-lg"  style="color: #ffffff;line-height: 23px"></i>
                    <p class="none_960" style="color: #fff;display: inline-block">交流</p>
                </a>
            </li>

        </ul>



        <span class="clear"></span>
    </div>

</div>
<div class="user_info_panel animated ">
    <div style="display: inline-block;float:left;margin: 10px">{{avatar($data["user_info"]->uid,50,50,"","big")}}</div>
    <div style="float:left;">
        <h2 style="    font-size: 15px;color: #6a6c7f;margin-top: 15px;">{{$data["user_info"]->username}}</h2>
        <p style="    width: 120px;font-size: 12px;color: #8e8e8e;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">签名档签名档签名档签名档签名档签名档签名档签名档签名档签名档</p>
    </div>
    <div class="clear"></div>
    <div class="user_info_item">
        <ul class="panel_btn_list">
            <li class="trans"><img style="width:25px;" src="/Image/tixing.png"><a href="suki-myfollow?like_type=1">关注的用户</a></li>
            <li class="trans"><img style="width:25px;" src="/Image/tixing.png">期待的商品</li>
            <li class="trans"><img style="width:25px;" src="/Image/tixing.png">收藏的帖子</li>
            <li class="trans"><img style="width:25px;" src="/Image/tixing.png">评论</li>
            <li class="trans"><img style="width:25px;" src="/Image/tixing.png">{{"@"}}我</li>
            <li class="trans"><img style="width:25px;" src="/Image/tixing.png">点赞</li>
        </ul>
    </div>

    <a style="    position: absolute;bottom: 0px;width: 100%;text-align: center" href="/logout">
        <span style="    font-size: 14px;color: #d95794;font-weight: 900;">LogOut</span>
        <img src="/Image/tuichu1.png" style="width: 14px;padding-bottom: 4px;" >
    </a>
</div>