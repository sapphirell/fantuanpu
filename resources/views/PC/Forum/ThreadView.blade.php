@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<title>饭团扑-{{$data['thread_subject']->subject}}</title>

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
        width: 100%;
        position: absolute;
        bottom: -73px;}
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
        width: 80%;
        float: left;
        min-height: 100px;
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
        color: #EEEEEE;
        border: 4px dashed;
        width: 538px;
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

    <div class="thread_left" style="width: 70%;float: left">
        <div class="forum_subject" style="    background: #FFFFFF;margin: 15px;padding: 15px;border-radius: 5px;box-shadow: 2px 3px 3px #e4e4e4;position: relative;padding-bottom: 200px;">
            <div>
                <span>当前位置</span> > <a href="/forum-{{$data['fid']}}-1.html" class="thread_position">{{$data['forum']->name}}</a>
                <p>
                    <span class="post_tab">帖子标签</span>
                    <a class="post_tab_add">添加标签 +</a>
                </p>

            </div>
            <h1 style="    font-size: 20px;font-family: 微软雅黑;font-weight: 500;text-align: left;">{{$data['thread']['thread_subject']->subject}}</h1>

            <div class="user_info"  style="">
                <div style="    position: relative;bottom: 73px;margin: 5px">
                    {{avatar($data['thread']['thread_subject']->authorid,100,5,'post-avatar','normal')}}
                </div>
                <div style="    position: relative;bottom: 73px;    margin-left: 15px;">
                    <p>
                        <span style="">{{$data['thread']['thread_subject']->author}}</span>
                        {{$data['thread']['thread_subject']->dateline}}
                        查看数 : {{$data['thread']['thread_subject']->views}}
                        回复数 : {{$data['thread']['thread_subject']->replies}}
                    </p>
                    <div style="background: #EEEEEE;color: black;height: 76px;width: 100%;text-align: center;color: #fff;">这里留着放签名档吧…</div>
                </div>


            </div>
            <div class="bbcode_container">
                {!! bbcode2html($data['thread']['thread_post'][0]->message) !!}
            </div>
            <div class="clear"></div>
        </div>
        <div>


            @foreach($data['thread']['thread_post'] as $key=>$value)
                @if($key == 0)
                    {{--帖子一楼--}}
                @else
                    <div class="post_item">

                        <div class="post_msg"  style="z-index: 1   ; position: relative;">
                            <p> <span style="color: #5abdd4;">{{$value->author}}</span> <span style="color: #cccccc"></span>{{date("Y-m-d H:i:s",$value->dateline)}}</p>
                            <div id="{{$value->pid}}" style="padding: 5px;">{!! bbcode2html($value->message) !!}</div>
                            <p onclick="reply({{$value->pid}})" class="reply" style="cursor: pointer;color: #ccc;position: absolute;right: 20px;bottom: 5px;">&lt;Reply&gt;</p>
                        </div>
                        <div class="post_userinfo trans" style="float: right;position: absolute;    left: 505px;background: #fff;padding: 8px;margin: 15px 15px 15px 0px;width: 17%;box-shadow: 2px 3px 3px #e4e4e4;z-index: 0;border-radius: 0px 5px 5px 0px;">

                            <div style="float: left;width: 45px   ;">
                                <a>加关注</a>
                                <a>加好友</a>
                                <a>发消息</a>
                            </div>
                            <div>
                                {{avatar($value->authorid,50,100,'post-avatar','normal')}}
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
        <div style="    float: right;
    width: 260px;
    height: 400px;
    background: #fff;
    margin-top: 15px;
box-shadow: 2px 3px 3px #e4e4e4;">右边放点啥好呢</div>
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
    })

</script>
@include('PC.Common.Footer')