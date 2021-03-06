@include('PC.Suki.SukiHeader')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">


<script src="/Static/Script/Web/forum.js"></script>
<style>
    .fourm_thread_items {    padding: 5px 8px;background: #ffffff}
    .pstatus{
        display: block;
    }
    /*.wp {*/
        /*margin-top: 29px;*/
        /*!*box-shadow: 0 0 11px #e6e6e6;*!*/
        /*border-radius: 5px 5px 0px 0px;*/
        /*overflow: hidden;*/
        /*padding: 0px!important;*/
    /*}*/
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
        border: 2px dashed;
        width: 95%;
        margin-left: 15px;
        text-align: center;
        font-size: 35px;
        display: inline-block;
        background: #ffffff29;
        text-decoration: none;
        cursor: pointer;
        border-radius: 7px;
        line-height: 50px;
        padding-bottom: 5px;
        font-weight: 500;

    }
    .get_more_posts:hover
    {
        color: #b3aae0!important;
        text-decoration: none;
    }
    .post-avatar {
        margin: 5px 10px;
        display: block;
        width: 60px !important;
        height: 60px !important;
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
        border: 0px dashed #ddd;
        padding: 3px;
    }
    .author-name {
        width: 120px;
        text-align: center;
        display: inline-block;
        font-size: 14px;
        font-weight: 900;
        margin-bottom: 10px;
        color: #90718b;
        margin-right: 20px;
        font-size: 12px;
    }
    .author-message {
        display: flex;
    }
    .post_msg {
        padding-bottom: 7px;
        border-radius: 5px;
        box-shadow: 0px 1px 3px #d4d2d2;
        margin-bottom: 0px;
    }
    .post_content
    {
        padding-bottom: 35px;
    }
    .fa-angle-down:hover:before {
        color: #F09C9C;
    }
    .w-e-text blockquote {
        border:0px;
    }
    .title_container {
        position: relative;
    }
    .thread_action {
        position: absolute;
        right: 0px;
        background: #fff;
        z-index: 9;
        padding: 5px;
        box-shadow: 0 0 5px #ddd;
        border-radius: 5px;
        top: 23px;
    }
    .thread_action li {
        list-style: none;
        padding: 4px 19px;
    }
    .thread_action li a {
        color: #806767
    }
    .thread_action {
        display: none;
    }
    .thread_container {
        background: #FFFFFF;
        margin: 15px;
        padding: 15px;
        padding-bottom:0px;
        border-radius: 5px;
        box-shadow: 0px 1px 3px #e4e4e4;
        position: relative;
        margin-bottom: 0px;
        padding-top: 10px;
    }

    .thread_title {

    }

</style>
<script>
    function resize_window() {
        var width = $(".post_msg").width();
        $(".post_content").width(width-120);

        var title_container = $(".title_container").width()
        var author_width = $(".author-name").width() + 160;
        var title_max_width = title_container - author_width;
        $(".thread_title").width(title_max_width);
    }
    $(document).ready(function () {
        resize_window();
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
            resize_window();
        });
    })
</script>
<body>

<div class="wp web_body " style="margin-top: 10px;">
    <div class="thread_container" style="">
        <div class="title_container" style="">
            <div class="show_960 author-head-box">
                @if($data['thread']['thread_subject']->anonymous == 2)
                    <span >{{avatar(0,40,5,'author-avatar','big')}}</span>
                @else
                    <a  href="suki-userhome-{{$data['thread']['thread_subject']->authorid}}.html">{{avatar($data['thread']['thread_subject']->authorid,40,5,'author-avatar','big')}}</a>
                    <p class="author-sign trans" style="width: inherit;width: inherit;margin: 8px;color: #b7b7b7;width: 120px;">
                        {{$data['thread']['thread_subject']->anonymous == 2 ? "" : ($data['thread']['thread_subject']->sightml?:"暂未设置签名") }}
                    </p>
                @endif
            </div>

            <div class="author-name" style="">{{$data['thread']['thread_subject']->anonymous == 2 ? "匿名" : $data['thread']['thread_subject']->author}}</div>
            <div class="aline" style="display: inline-block;">
                <h1 class="thread_title aline" style="display:inline-block;font-size: 15px;font-family: 微软雅黑;font-weight: 900;text-align: left;">{{$data['thread']['thread_subject']->subject}}</h1>
            </div>
            <div style="display: inline-block;float:right;">
                <a  style="text-decoration-line: none;    margin-right: 10px;float: left;" class="do_follow"
                    status="@if($data['has_collection'] === true){{"unfollow"}}@else{{"follow"}}@endif"
                >@if($data['has_collection'] == true)
                        <img src="/Static/image/common/collection_pre.png" style="line-height: 12px;    width: 15px;display: inline-block;padding-bottom: 5px;">
                    @else
                        <img src="/Static/image/common/collection.png"  style="line-height: 12px;    width: 15px;display: inline-block;padding-bottom: 5px;">
                    @endif
                </a>
                <i style="float: right;font-size: 20px;color: #909090;" class="fa fa-angle-down trans action_down" down="0" aria-hidden="true"></i>
                <ul class="thread_action" id="down_0">
                    <li><a href="" class="report_thread" pid="{{$data['thread']['thread_post'][0]->pid}}">举报</a></li>
                    @if($data["auth_level"] == 3 || $data["user_info"]->uid == $data['thread']['thread_subject']->authorid )
                        <li><a class="editor_thread" href="" tid="{{$data['thread']['thread_subject']->tid}}" position="1">编辑</a></li>
                    @endif
                    @if($data["auth_level"] == 2 || $data["auth_level"] == 3 )
                        <li>
                            <a class="delthread" href="/del_thread?tid={{$data['thread']['thread_subject']->tid}}&todo={{$data['thread']['thread_subject']->isdel == 2 ? 1 : 2}}">
                                {{$data['thread']['thread_subject']->isdel == 2 ? "恢复" : "删除"}}
                            </a>
                        </li>
                    @endif
                    @if($data["auth_level"] == 3)
                        <li>
                            <a href="/suki_set_top_thread?tid={{$data['thread']['thread_subject']->tid}}&todo={{$data['thread']['thread_subject']->istop == 1 ? 2 : 1}}" class="set_top_thread">
                                {{$data['thread']['thread_subject']->istop == 2 ? "撤销置顶" : "置顶"}}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

        </div>
        <div class="author-message" style="">
            <div class="user_info author" style="display: inline-block;width: 160px">
                @if($data['thread']['thread_subject']->anonymous == 2)
                    <span >{{avatar(0,120,5,'author-avatar','big')}}</span>
                @else
                    <a  href="suki-userhome-{{$data['thread']['thread_subject']->authorid}}.html">{{avatar($data['thread']['thread_subject']->authorid,120,5,'author-avatar','big')}}</a>
                    <p class="author-sign trans" style="width: inherit;width: inherit;margin: 8px;color: #b7b7b7;width: 120px;">
                        {{$data['thread']['thread_subject']->anonymous == 2 ? "" : ($data['thread']['thread_subject']->sightml?:"暂未设置签名") }}
                    </p>
                @endif




            </div>
            <div class="author_message" style="width: 100%;float:left;flex-grow: 1;padding-left: 10px;position: relative;padding-bottom: 35px;">
                <div class="bbcode_container clear">


                    @if($data['thread']['thread_subject']->isdel == 2)
                        <p> 帖子已被删除</p>
                    @else
                        {!! bbcode2html($data['thread']['thread_post'][0]->message) !!}
                    @endif
                </div>
                <p style="    font-size: 12px;position: absolute;right: 8px;color: #ccc9c9;bottom: 5px">
                    {{$data['thread']['thread_subject']->dateline}}
                    查看
                    {{$data['thread']['thread_subject']->views}}
                    回复
                    {{$data['thread']['thread_subject']->replies}}
                </p>
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
                        @if($value->isdel == 1)
                        <div class="post_item" name="{{$value->pid}}">
                            <?php $rand_border = ['#bbb0ff','#e7b0ff','#dbffb0','#b5ecff','#ffb5b5']; ?>
                            <div class="post_msg"  style="z-index: 1; position: relative;    margin-right: 20px;
                                    {{--border-bottom: 3px solid {{$rand_border[rand(0,4)]}};--}}
                                    ">

                                <div style="width: 80px;display: inline-block;float: left;    margin-right: 15px;">


                                    @if($data['thread']['thread_subject']->anonymous == 2)
                                        <span>
                                            {{avatar(0,80,100,'post-avatar','normal')}}
                                        </span>
                                        </span>
                                        <p style="color: #544349;width: 80px;text-align: center;display: inline-block;margin-top: 5px">匿名</p>
                                    @else
                                        <a href="/suki-userhome-{{$value->authorid}}.html" style="cursor: pointer">
                                            {{avatar($value->authorid,80,100,'post-avatar','normal')}}
                                        </a>
                                        <a href="suki-userhome-{{$value->authorid}}.html" class="trans" style="color: #544349;width: 80px;text-align: center;display: inline-block;margin-top: 5px">{{$value->author}}</a>
                                    @endif

                                </div>
                                <i style="float: right;font-size: 20px;color: #909090;" class="fa fa-angle-down trans action_down" down="{{$value->pid}}" aria-hidden="true"></i>
                                <ul class="thread_action" id="down_{{$value->pid}}">
                                    <li><a href="" class="report_thread" pid="{{$value->pid}}">举报</a></li>
                                    @if($data["auth_level"] == 3 || $data["user_info"]->uid == $data['thread']['thread_subject']->authorid )
                                        <li><a class="editor_thread" href="" tid="{{$data['thread']['thread_subject']->tid}}" position="{{$value->position}}">编辑</a></li>
                                    @endif
                                    @if($data["auth_level"] == 2 || $data["auth_level"] == 3 )
                                        <li><a class="delthread" href="/del_post?pid={{$value->pid}}&todo={{$value->isdel == 2 ? 1 : 2}}">{{$value->isdel == 2 ? "恢复" : "删除"}}</a></li>
                                    @endif
                                </ul>
                                <div class="post_content" style="width: 70%;display: inline-block;float:left;">
                                    <div id="{{$value->pid}}" style="padding: 5px;">@if($value->isdel == 1){!! bbcode2html($value->message) !!}@else<span style="color: #2E2D3C">该回复已被删除</span>@endif</div>

                                    <div style="    width: 100%;display: inline-block;float: left;position: absolute;     bottom: 28px;right: 3px;">
                                        {{--<img src="/Static/daimeng.gif">--}}
                                        <span style="color: #cccccc;padding-left: 5px;position: absolute;right: 10px;">
                                            {{$value->position}}楼 &nbsp;
                                            {{date("Y·m·d H:i:s",$value->dateline)}}
                                        </span>
                                        <span onclick="reply({{$value->pid}})" class="reply" style="cursor: pointer;color: #f5b3b5;position: absolute;    right: 9px;bottom: 0px;">回复</span>
                                    </div>
                                </div>
                                <div class="clear"></div>



                            </div>
                            <div class="clear"></div>
                        </div>
                        @endif
                    @endif
                @endforeach
                @if(count($data['thread']['thread_post']) < \App\Http\Controllers\System\CoreController::THREAD_REPLY_PAGE)
                    <div class="" style="padding: 20px;color: #bfbfbf;border: 2px dashed;margin-top:20px;margin-left: 15px;margin-right: 17px;text-align: center;border-radius: 5px;">暂无更多</div>
                @else
                    <span style="margin-top:20px;" class="get_more_posts trans">+</span>
                @endif

                <form style="margin: 15px;margin-top: 20px;">
                    <textarea name="message" style="display: none"></textarea>

                    <div id="editor" style="background-color: #fff;box-shadow: 0 0 5px #eee;"></div>
                    <span id="post-thread">回复</span>
                    <input type="hidden" id="fid" name="fid" value="{{$data['fid']}}">
                    <input type="hidden" id="tid" name="tid" value="{{$data['tid']}}">
                    <input type="hidden" id="subject" name="subject" value="{{$data['thread']['thread_subject']->subject}}">
                    {{csrf_field('post_thread_token')}}
                </form>
            </div>
            <div class="clear"></div>
        </div>
        <div class="_3_1_right" style="margin-top: 15px;">
            {{--<div style="    float: right;width: 100%;    background: #80f5ff;margin-top: 15px;box-shadow: 2px 3px 3px #e4e4e4;margin-right: 18px;">--}}
                {{--<a href="/app_download" style="    text-align: center;color: #ffffff;display: inline-block;cursor: pointer;width: inherit;text-decoration-line: none;">--}}
                    {{--Suki!App开发中--}}
                {{--</a>--}}

            {{--</div>--}}
            <div class="bm" style="margin-right: 18px;">
                <div class="bm_h pink">
                    <a style=" color: #fff;" href="/suki_alarm_clock?type=setting">戳此自定义你的补款工具</a>
                </div>

            </div>
        </div>
        <div class="clear"></div>
    </div>


</div>
<script>
    /**
     * 点击回复帖子
     * @param pid
     */
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
        $("html,body").animate({scrollTop:$("#editor").offset().top-80},1000);
    }
    $(document).ready(function () {
        var layer_smart_width = window.innerWidth > 650 ? "650px" : window.width + "px"
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
            $.post('/suki_next_page',{page:next_page,tid:tid,need:"html"},function (event) {
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
        //关注帖子
        $(".do_follow").click(function (e) {
            e.preventDefault();
            var data = {
                tid : tid,
                todo : $(this).attr("status"),
            };
            $.post("/add_suki_like",data,function (e) {
//                alert(e.msg)
                if($(".do_follow").attr("status") == "follow")
                {
                    $(".do_follow").attr("status","unfollow")
                    $(".do_follow>img").attr("src","/Static/image/common/collection_pre.png")
                }
                else
                {
                    $(".do_follow").attr("status","follow")
                    $(".do_follow>img").attr("src","/Static/image/common/collection.png")
                }
            })
        });
        //重新编辑帖子
        $(".editor_thread").click(function (e) {

            e.preventDefault();
            var tid = $(this).attr("tid");
            var position = $(this).attr("position");
            layer.open({
                type: 2,
                title: false,
                closeBtn: 0, //不显示关闭按钮
                shade: 0.8,
//                shadeClose: true,
                area: [layer_smart_width, '405px'],
                offset: '100px',
                content: ['/suki_editor_post_view?tid='+tid+'&position='+position ,'no']
            });
        });
        //点击action_down展开操作面板
        $(".action_down").click(function (e) {
            var id = $(this).attr("down")
            if ($("#down_"+id).css("display") == "none")
            {
                $(".thread_action").slideUp();
                $("#down_"+id).slideDown();
            }
            else
            {
                $(".thread_action").slideUp();
            }


        })
        //点击report_thread弹出举报帖子面板
        $(".report_thread").click(function (e) {
            var layer_smart_width = window.innerWidth > 450 ? "450px" : window.width + "px"
            e.preventDefault()
            var origin = $(this).attr("pid")
            layer.open({
                type: 2,
                title: false,
                closeBtn: 0, //不显示关闭按钮
                shade: 0.8,
                shadeClose: true,
                area: [layer_smart_width, '405px'],
                offset: '100px',
                content: ['/suki_report?pid=' + origin ,'no']
            });
        })
        //点击删除,远程请求删除接口
        $(".delthread").click(function (e) {
            e.preventDefault();
            var link = $(this).attr("href");
            $.get(link,{},function (e) {
                alert(e.msg)
                location.reload();
            })
        })
        //设置帖子为置顶帖
        $(".set_top_thread").click(function (e) {
            e.preventDefault();
            var href = $(this).attr("href");
            $.get(href,{},function (e) {
                alert(e.msg);
                location.reload();
            });
        });
    })

</script>
@include('PC.Suki.SukiFooter')