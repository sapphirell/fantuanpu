@include('PC.Suki.SukiHeader')
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
    .author-medal > * {
        float: left;
    }
    .l{
        margin: 0px;
        border-top: 3px dashed #eee;
    }
    .post_item {
        position: relative;
        padding-right: 50px;
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
        width: 90%;
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
        margin: 5px 5px;
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
    .author-name {
        width: 150px;text-align: center;display: inline-block;font-size: 14px;font-weight: 900;margin-bottom: 10px;color: #6abdd6;
    }
    .author-message {
        display: flex
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
        //窗口宽度改变的时候修改post_item以及内部的宽度
        $(window).resize(function(){
            var width = $(".post_msg").width();
            $(".post_content").width(width-100);
        });
    })
</script>
<body>

<div class="wp web_body " style="margin-top: 50px;">
    <div style="background: #FFFFFF;margin: 15px;padding: 15px;border-radius: 5px;box-shadow: 2px 3px 3px #e4e4e4;position: relative;">
        <div>
            <span class="author-name" style="">{{$data['thread']['thread_subject']->author}}</span>
            <a style="text-decoration-line: none;">
                <img src="/Static/image/common/collection.png" style="line-height: 12px;display: inline-block;padding-bottom: 5px;">
            </a>
            <h1 style="display:inline-block;font-size: 15px;font-family: 微软雅黑;font-weight: 900;text-align: left;">{{$data['thread']['thread_subject']->subject}}</h1>

        </div>
        <div class="author-message" style="">
            <div class="user_info author" style="display: inline-block;width: 160px">

                <a href="">{{avatar($data['thread']['thread_subject']->authorid,150,5,'author-avatar','big')}}</a>
                <a href=""><p class="author-sign" style="width: inherit;width: inherit;margin: 8px;color: #b7b7b7;">未设置用户签名</p></a>




            </div>
            <div class="author_message" style="width: 100%;float:left;flex-grow: 1;">
                <div class="bbcode_container">
                    {!! bbcode2html($data['thread']['thread_post'][0]->message) !!}
                </div>
            </div>
        </div>

        <div class="clear"></div>
    </div>
    <div class="3-1">
        <div class="_3_1_left" >
            <div>
                @foreach($data['thread']['thread_post'] as $key=>$value)
                    @if($key == 0)
                        {{--帖子一楼--}}
                    @else
                        <div class="post_item">
                            <?php $rand_border = ['#bbb0ff','#e7b0ff','#dbffb0','#b5ecff','#ffb5b5']; ?>
                            <div class="post_msg"  style="z-index: 1; position: relative;    margin-right: 20px;
                                    border-bottom: 3px solid {{$rand_border[rand(0,4)]}};">

                                <div style="width: 80px;display: inline-block;float: left;    margin-right: 15px;">

                                    <a href="/suki-userhome-{{$value->authorid}}.html" style="cursor: pointer">
                                        {{avatar($value->authorid,80,100,'post-avatar','normal')}}
                                    </a>

                                        <a style="color: #5abdd4;width: 80px;text-align: center;display: inline-block;margin-top: 5px">{{$value->author}}</a>


                                </div>
                                <div class="post_content" style="width: 70%;display: inline-block;float:left;">
                                    <span style="color: #cccccc;    padding-left: 5px;">{{date("Y·m·d H:i:s",$value->dateline)}}</span>
                                    <div id="{{$value->pid}}" style="padding: 5px;">{!! bbcode2html($value->message) !!}</div>


                                </div>
                                <div class="clear"></div>

                                <div style="    width: 100%;display: inline-block;float: left;position: absolute;bottom: 0;">
                                    {{--<img src="/Static/daimeng.gif">--}}

                                    <p onclick="reply({{$value->pid}})" class="reply" style="cursor: pointer;color: #ccc;position: absolute;right: 20px;bottom: 5px;">&lt; Reply &gt;</p>
                                </div>

                            </div>
                            <div class="clear"></div>
                        </div>

                    @endif
                @endforeach
                @if(count($data['thread']['thread_post']) < \App\Http\Controllers\System\CoreController::THREAD_REPLY_PAGE)
                    <div style="    padding: 20px;color: #bfbfbf;border: 4px dashed;    width: 90%;margin-left: 15px;text-align: center;">暂无更多</div>
                @else
                    <span class="get_more_posts trans">+</span>
                @endif

                <form style="margin: 15px;">
                    <textarea name="message" style="display: none"></textarea>

                    <div id="editor" style="background-color: #fff;box-shadow: 0 0 5px #eee;"></div>
                    <span id="post-thread">回复</span>
                    <input type="hidden" id="fid" name="fid" value="{{$data['fid']}}">
                    <input type="hidden" id="tid" name="tid" value="{{$data['tid']}}">
                    <input type="hidden" id="subject" name="subject" value="{{$data['thread']['thread_subject']->subject}}">
                    {{csrf_field('post_thread_token')}}
                </form>
            </div>
        </div>
        <div class="_3_1_right">
            <div style="    float: right;width: 100%;    background: #80f5ff;margin-top: 15px;box-shadow: 2px 3px 3px #e4e4e4;margin-right: 18px;">
                <a href="/app_download" style="    text-align: center;color: #ffffff;display: inline-block;cursor: pointer;width: inherit;text-decoration-line: none;">下载Suki! App</a>

            </div>
        </div>
    </div>


</div>
<script>
    function reply(pid)
    {
        var str = $("#"+pid).html();
        console.log(str)
//        var quote = $("#"+pid+" .quote").html()
//        var blockquote = $("#"+pid+" blockquote").html()
//        console.log(quote)
//        var reg = new RegExp($("#"+pid+" .quote",blockquote).html());
//        var Html = str.replace(reg,"");
        var posts = "<blockquote>"+str+"</blockquote><br/>";
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
            $.post('/suki_reply_thread',postData,function (event) {
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
                $(".post_item:last").after(event);
                console.log(event)
                if (!event)
                {
                    alert("没有更多了");
                }
                else
                {
                    next_page += 1;
                }

            })
        })

    })

</script>
@include('PC.Suki.SukiFooter')