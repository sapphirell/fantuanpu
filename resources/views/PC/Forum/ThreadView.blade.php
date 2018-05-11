@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<title>饭团扑动漫网-{{$data['thread_subject']->subject}}</title>

<script src="/Static/Script/Web/forum.js"></script>
<script>


</script>
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

    }
    .post_msg
    {
        background: #fff;
        padding: 8px;
        margin: 15px;
        box-shadow: 2px 3px 3px #e4e4e4;
        width: 70%;
        float: left;
        min-height: 100px;
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
    })
</script>
<body>

<div class="wp" style="margin-top: 20px;">

    <div class="thread_left" style="width: 70%;float: left">
        <div class="forum_subject" style="    background: #FFFFFF;margin: 15px;padding: 15px;border-radius: 5px;box-shadow: 2px 3px 3px #e4e4e4;position: relative;padding-bottom: 200px;">
            <div>
                <span>当前位置</span> > <span class="thread_position">{{$data['forum']->name}}</span>
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
                        用户名:{{$data['thread']['thread_subject']->author}}
                        发帖时间:{{date("Y-m-d H:i:s",$data['thread']['thread_subject']->dateline)}}
                        查看数:{{$data['thread']['thread_subject']->views}}
                        回复数:{{$data['thread']['thread_subject']->replies}}
                    </p>
                    <div style="background: #EEEEEE;color: black;height: 76px;width: 100%;text-align: center;color: #fff;">这里留着放签名档吧…</div>
                </div>


            </div>
            <div style="">

                <p>{!! bbcode2html($data['thread']['thread_post'][0]->message) !!}</p>
            </div>
            <div class="clear"></div>
        </div>
        <div>


            @foreach($data['thread']['thread_post'] as $key=>$value)
                @if($key == 0)
                    {{--帖子一楼--}}
                @else
                    <div class="post_item" style="">

                        <div class="post_msg">
                            <p>{{$value->author}}回帖回复于:{{date("Y-m-d H:i:s",$value->dateline)}}</p>
                            {!! bbcode2html($value->message) !!}
                        </div>
                        <div class="post_userinfo" style="float: right;background: #fff;padding: 8px;    margin: 15px 15px 15px 0px;width: 21%;box-shadow: 2px 3px 3px #e4e4e4;">
                            {{avatar($value->authorid,50,100,'post-avatar','normal')}}
                            <div style="float: right;width: 45px">
                                <a>加关注</a>
                                <a>加好友</a>
                                <a>发消息</a>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>

                @endif
            @endforeach
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

@include('PC.Common.Footer')