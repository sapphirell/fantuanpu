@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">


<script src="/Static/Script/Web/forum.js"></script>
<script type="text/javascript" src="/Static/Script/wangEditor/wangEditor.js"></script>
<style>
    .fourm_thread_items {    padding: 5px 8px;background: #ffffff}
    .pstatus{
        display: block;
    }
    .wp {
        margin-top: 29px;
        /*box-shadow: 0 0 11px #e6e6e6;*/
        border-radius: 5px 5px 0px 0px;
        overflow: hidden;
        padding: 0px!important;
    }
    .wp .fourm_thread_items {
        margin: 0px;
    }
    .thread_position {
        background: #afd5e6;
        padding: 1px 6px;
        line-height: 4;
        color: #fff;
        border-radius: 5px;
        margin: 6px;
        cursor: pointer;
    }
    .post_tab
    {

    }
    .post_tab_add
    {
        border: 1px solid #8e8e8e;
        padding: 5px;
        border-radius: 5px;
        cursor: pointer;
        color: #000000;
    }
    .user_info {
        float: left;
        width:200px;
        position: relative;
    }
    .user_info > * {
        float: left;
    }
    .l{
        margin: 0px;
        border-top: 3px dashed #eee;
    }
    .post_item {
        position: relative;
    }
    .post_msg
    {
        background: #fff;
        padding: 8px;
        margin: 15px;
        box-shadow: 2px 3px 3px #e4e4e4;
        width: 641px;
        float: left;
        min-height: 100px;
        border-radius: 20px;
        padding-bottom: 20px;
    }
    .post_msg img {
        max-width: 100%;
    }
    .w-e-text-container{
        height:200px!important;
        border-color: #eee!important;
    }
    .w-e-toolbar{
        border-color: #eee!important;
    }
    #post-thread{
        cursor: pointer;
        border: 1px solid #ccc;
        padding: 5px 10px;
        box-sizing: border-box;
        margin: 15px 0px;
        display: inline-block;
        background: #fff;
    }
    .get_more_posts {
        padding: 0px;
        color: #afa1a1;
        border: 4px dashed;
        width: 643px;
        margin-left: 15px;
        text-align: center;
        font-size: 50px;
        display: inline-block;
        background: #ffffff29;
        text-decoration: none;
        cursor: pointer;
        border-radius: 5px;
        line-height: 50px;
        padding-bottom: 10px;
    }
    .get_more_posts:hover
    {
        color: #b3aae0!important;
        text-decoration: none;
    }
    .post-avatar {
        margin: 0 5px;
        display: block;
        width: 70px !important;
        height: 70px !important;
        border-radius: 50%;
        overflow: hidden;
        padding: 2px;
        box-shadow: 0 2px 5px #c3def7;
    }
    .user_medal {
        width: 200px;
        position: absolute;
        top: -5px;
        right: 10px;
        margin: 5px;
    }
    .user_medal img {
        opacity: 0.3;
        cursor: pointer;
        /*filter: blur(1px);*/
    }

    .user_medal img:hover
    {
        opacity: 1;
        /*filter: blur(0px);*/
    }

    .medal_img.N {
        border-radius: 100%;
        border: 1px solid #232831;
        box-shadow: 0 1px 4px #69c2ef;
    }
    .medal_img.R {
        border-radius: 100%;
        border: 1px solid #8da7ff;
        box-shadow: 0 1px 4px #8798b4;
    }
    .medal_img.SR {
        border-radius: 100%;
        border: 1px solid #9d79ad;
        box-shadow: 0 1px 4px #8da7ff;
    }
    .medal_img.UR {
        border-radius: 100%;
        border: 1px solid #ffb26f;
        box-shadow: 0 1px 4px #fde487;
    }
    .medal_info {
        display: none;
        position: absolute;
        top: 40px;
        background: #ffffffb5;
        color: #6fb4bd;
        border: 1px solid;
        padding: 10px;
        z-index: 1000;
        width: 300px;
        border-radius: 5px;
    }
    .author-avatar {
        border: 1px dashed #ddd;
        padding: 3px;
    }
</style>
<script>
    $(document).ready(function () {
        $(".show_date").mouseout(function () {
            $(this).hide().siblings('.show_time').show()

        })
        $(".show_time").hover(function(){
            $(this).hide().siblings('.show_date').show()
        });
        $(".post_item").hover(function () {
            $(this).children('.post_userinfo').css('left','550px')

        },function () {
            $(this).children('.post_userinfo').css('left','505px')

        })
    })
</script>
<body>

<div class="wp" style="margin-top: 50px;">
    <span style="    line-height: 12px;display: inline-block;padding-bottom: 5px;margin-left: 20px;font-weight: 900; text-shadow: 0 0 5px #adadad;">当前位置</span> ><a href="/forum-{{$data['fid']}}-1.html" class="thread_position">{{$data['forum']->name}}</a>
    <div style="background: #FFFFFF;margin: 15px;padding: 15px;border-radius: 5px;box-shadow: 2px 3px 3px #e4e4e4;position: relative;">
        <div>
            <span style="width: 150px;text-align: center;display: inline-block;font-size: 14px;font-weight: 900;margin-bottom: 10px;color: #6abdd6;">{{$data['thread']['thread_subject']->author}}</span>
            <a style="text-decoration-line: none;">
                <img src="/Static/image/common/collection.png" style="line-height: 12px;display: inline-block;padding-bottom: 5px;">
            </a>
            <h1 style="display:inline-block;font-size: 15px;font-family: 微软雅黑;font-weight: 900;text-align: left;">{{$data['thread']['thread_subject']->subject}}</h1>

        </div>
        <div class="user_info" style="display: inline-block;width: 160px">

            {{avatar($data['thread']['thread_subject']->authorid,150,5,'author-avatar','big')}}
            <p style="width: inherit;width: inherit;margin: 8px;color: #b7b7b7;">未设置用户签名</p>
            @foreach($data['thread']['thread_post'][0]->medal['in_adorn'] as $medal_key=>$medal_value)
                <div style="position: relative;margin-left: 5px">
                    <div class="medal_info {{$key}}" id="{{ '0_'. $medal_key}}" style="">
                        <p style="border-left: 3px solid #00A0FF;line-height: 13px;padding-left: 5px">
                            {{$medal_value->medal_name}}
                        </p>
                        @foreach(json_decode($medal_value->medal_action,true) as $action_value)
                            <li style="    margin-left: 8px;">
                                <?php
                                $act_info = \App\Http\DbModel\ActionModel::name($action_value['action_name']);
                                ?>
                                <span class="alert_span">{{ $act_info->action_name }}</span> 时,有
                                <span  class="alert_span">{{ $action_value['rate'] * 100}} %</span>
                                概率获得

                                <span  class="alert_span">{{ $action_value['score_value'] }}</span>
                                枚
                                <span  class="alert_span">{{ \App\Http\DbModel\CommonMemberCount::$extcredits[$action_value['score_type']] }}</span>
                            </li>
                        @endforeach
                    </div>
                    <img class="trans medal_img {{$medal_value->rarity}}" style="width: 30px;height: 30px" src="{{$medal_value->medal_image}}" position="0" key="{{$medal_key}}">

                </div>

            @endforeach
        </div>
        <div class="author_message" style="width: 700px;float:left;">
            <div class="bbcode_container">
            {!! bbcode2html($data['thread']['thread_post'][0]->message) !!}
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="thread_left" style="width: 70%;float: left">

        {{--<div class="forum_subject" style="    background: #FFFFFF;margin: 15px;padding: 15px;border-radius: 5px;box-shadow: 2px 3px 3px #e4e4e4;position: relative;padding-bottom: 200px;">--}}
            {{--<div>--}}
                {{--<p>--}}
                    {{--<span class="post_tab">帖子标签</span>--}}
                    {{--<a class="post_tab_add">添加标签 +</a>--}}
                {{--</p>--}}

            {{--</div>--}}
            {{--<h1 style="    font-size: 20px;font-family: 微软雅黑;font-weight: 500;text-align: left;">{{$data['thread']['thread_subject']->subject}}</h1>--}}

            {{--<div class="user_info"  style="">--}}
                {{--<div style="    position: relative;bottom: 73px;margin: 5px">--}}
                    {{--{{avatar($data['thread']['thread_subject']->authorid,100,5,'post-avatar','normal')}}--}}
                {{--</div>--}}
                {{--<div style="    position: relative;bottom: 73px;    margin-left: 15px;">--}}
                    {{--<p>--}}
                        {{--<span style="">{{$data['thread']['thread_subject']->author}}</span>--}}
                        {{--{{$data['thread']['thread_subject']->dateline}}--}}
                        {{--查看数 : {{$data['thread']['thread_subject']->views}}--}}
                        {{--回复数 : {{$data['thread']['thread_subject']->replies}}--}}
                    {{--</p>--}}
                    {{--<div style="background: #EEEEEE;color: black;height: 76px;width: 100%;text-align: center;color: #fff;">这里留着放签名档吧…</div>--}}
                {{--</div>--}}


            {{--</div>--}}
            {{--<div class="bbcode_container">--}}
                {{--{!! bbcode2html($data['thread']['thread_post'][0]->message) !!}--}}
            {{--</div>--}}
            {{--<div class="clear"></div>--}}
        {{--</div>--}}
        <div>


            @foreach($data['thread']['thread_post'] as $key=>$value)
                @if($key == 0)
                    {{--帖子一楼--}}
                @else
                    <div class="post_item">
                        <?php $rand_border = ['#bbb0ff','#e7b0ff','#dbffb0','#b5ecff','#ffb5b5']; ?>
                        <div class="post_msg"  style="z-index: 1; position: relative;    margin-right: 20px;
                                border-bottom: 3px solid {{$rand_border[rand(0,4)]}};">

                            <div style="width: 80px;display: inline-block;float: left">

                                {{avatar($value->authorid,80,100,'post-avatar','normal')}}
                                <span style="color: #5abdd4;width: 80px;text-align: center;display: inline-block;margin-top: 5px">{{$value->author}}</span>

                            </div>
                            <div style="width: 435px;display: inline-block;float:left;">
                                <span style="color: #cccccc;    padding-left: 5px;">{{date("Y m d H:i:s",$value->dateline)}}</span>
                                <div id="{{$value->pid}}" style="padding: 5px;">{!! bbcode2html($value->message) !!}</div>
                                <div class="user_medal">
                                    @foreach($value->medal['in_adorn'] as $medal_key=>$medal_value)
                                        <div class="medal_info {{$key}}" id="{{$value->position .'_'. $medal_key}}">
                                            <p style="border-left: 3px solid #00A0FF;line-height: 13px;padding-left: 5px">
                                                {{$medal_value->medal_name}}
                                            </p>
                                            @foreach(json_decode($medal_value->medal_action,true) as $action_value)
                                                <li style="    margin-left: 8px;">
                                                    <?php
                                                    $act_info = \App\Http\DbModel\ActionModel::name($action_value['action_name']);
                                                    ?>
                                                    <span class="alert_span">{{ $act_info->action_name }}</span> 时,有
                                                    <span  class="alert_span">{{ $action_value['rate'] * 100}} %</span>
                                                    概率获得

                                                    <span  class="alert_span">{{ $action_value['score_value'] }}</span>
                                                    枚
                                                    <span  class="alert_span">{{ \App\Http\DbModel\CommonMemberCount::$extcredits[$action_value['score_type']] }}</span>
                                                </li>
                                            @endforeach
                                        </div>
                                        <img class="trans medal_img {{$medal_value->rarity}}" style="width: 30px;height: 30px" src="{{$medal_value->medal_image}}" position="{{$value->position}}" key="{{$medal_key}}">

                                    @endforeach
                                </div>

                            </div>
                            <div class="clear"></div>

                            <div style="    width: 100%;display: inline-block;float: left;position: absolute;bottom: 0;">
                                {{--<img src="/Static/daimeng.gif">--}}

                                <p onclick="reply({{$value->pid}})" class="reply" style="cursor: pointer;color: #ccc;position: absolute;right: 20px;bottom: 5px;">&lt;Reply&gt;</p>
                            </div>

                        </div>
                        <div class="clear"></div>
                    </div>

                @endif
            @endforeach
            @if(count($data['thread']['thread_post']) < \App\Http\Controllers\System\CoreController::THREAD_REPLY_PAGE)
                <div style="    padding: 20px;color: #bfbfbf;border: 4px dashed;width: 538px;margin-left: 15px;text-align: center;">暂无更多</div>
            @else
                <span class="get_more_posts trans">+</span>
            @endif

            <form style="margin: 15px;">
                <textarea name="message" style="display: none"></textarea>

                <div id="repost" style="background-color: #fff;box-shadow: 0 0 5px #eee;"></div>
                <span id="post-thread">回复</span>
                <input type="hidden" id="fid" name="fid" value="{{$data['fid']}}">
                <input type="hidden" id="tid" name="tid" value="{{$data['tid']}}">
                <input type="hidden" id="subject" name="subject" value="{{$data['thread']['thread_subject']->subject}}">
                {{csrf_field('post_thread_token')}}
            </form>
        </div>
    </div>
    <div>
        <div style="    float: right;width: 250px;    background: #80f5ff;margin-top: 15px;box-shadow: 2px 3px 3px #e4e4e4;margin-right: 18px;">
            <a href="/app_download" style="    text-align: center;color: #ffffff;display: inline-block;cursor: pointer;width: inherit;text-decoration-line: none;">下载饭团扑App!</a>
            
        </div>
    </div>

</div>
<script>

    var E = window.wangEditor
    var editor = new E('#repost')
    editor.customConfig.menus = [
        'head',  // 标题
        'bold',  // 粗体
        'fontSize',  // 字号
        'fontName',  // 字体
        'italic',  // 斜体
//        'underline',  // 下划线
//        'strikeThrough',  // 删除线
//        'foreColor',  // 文字颜色
//        'backColor',  // 背景颜色
        'link',  // 插入链接
        'list',  // 列表
        'justify',  // 对齐方式
        'quote',  // 引用
//        'emoticon',  // 表情
        'image',  // 插入图片
//        'table',  // 表格
//        'video',  // 插入视频
        'code',  // 插入代码
        'undo',  // 撤销
        'redo'  // 重复
    ]
    editor.create();
    function reply(pid)
    {
        var str = $("#"+pid).html();
        console.log(str)
//        var quote = $("#"+pid+" .quote").html()
//        var blockquote = $("#"+pid+" blockquote").html()
//        console.log(quote)
//        var reg = new RegExp($("#"+pid+" .quote",blockquote).html());
//        var Html = str.replace(reg,"");
        var posts = "<blockquote>"+str+"</blockquote>";
        editor.txt.html(posts)
    }
    $(document).ready(function () {
        var subject = $('#subject').val()
        var fid     = $('#fid').val()
        var tid     = $('#tid').val()
        $('#post-thread').click(function () {
            var edHtml = html2ubb(editor.txt.html())

            var _token = $('#post_thread_token').val()

            var subject = $('#subject').val()
            var postData = {
                'message' : edHtml,
                '_token'  : _token ,
                'fid'     : fid,
                'tid'     : tid,
                'subject' : subject
            };
            console.log(postData)
            $.post('/post-thread',postData,function (event) {
                alert(event.msg);
                if (event.ret == 200)
                {
                    location.reload();
                }
            })

        });
        var next_page = 2;
        $(".get_more_posts").click(function (e) {
            $.post('/app/post_next_page',{page:next_page,tid:tid,need:"html"},function (event) {
                $(".post_item:last").append(event);
                console.log(event)
                next_page += 1;
            })
        })
        //勋章详情显示
        $(".medal_img").hover(function () {

            var key = $(this).attr('key');
            var position = $(this).attr('position');
            $("#"+position+"_"+key).show();

        })
        $(".medal_img").mouseleave(function () {
            $(".medal_info").hide();
        })
    })

</script>
@include('PC.Common.Footer')