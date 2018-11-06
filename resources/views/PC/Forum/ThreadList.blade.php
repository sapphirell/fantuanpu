@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<script src="/Static/Script/Web/forum.js"></script>
{{--<script type="text/javascript" src="/Static/Script/xheditor/xheditor-1.2.2.min.js"></script>--}}
{{--<script type="text/javascript" src="/Static/Script/xheditor/xheditor_lang/zh-cn.js"></script>--}}
<script type="text/javascript" src="/Static/Script/wangEditor/wangEditor.js"></script>
<style>
    .fourm_thread_items {    padding: 5px 8px;background: #ffffff;    box-shadow: 0 0 5px #ddd;}
    .avatar {float: left}
    .wp {
        margin-top: 29px;

        border-radius: 5px 5px 0px 0px;
        overflow: hidden;
        padding: 0px!important;
    }
    .wp .fourm_thread_items {
        margin: 10px;
        border-radius: 5px;
    }
    #new_thread
    {
        /*width: 95%;*/
        /*margin: 0px auto;*/
        background-color: #fff;
    }
    .pager li>a, .pager li>span
    {
        border:0px;
        padding: 6px 12px;
        margin: 5px;
        color: #ab5e5e;
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
<div class="wp web_body" style="padding: 5px;margin-top: 50px;    ">

    <!--头部banner-->
    <div class="3-1" >
        <div class="_3_1_left" style="
        /*box-shadow: 0 0 11px #e6e6e6;background: #ffffff;*/
        border-radius: 5px;overflow: hidden">
            @foreach($data['list'] as $key => $value)
                <div class="fourm_thread_items" style="
                @if($key%2==0)
                        background: #f9f9f9;
                @endif

                "  >

                    {{avatar($value->authorid,$size='50',30,'avatar',$type='small')}}
                    <div style="display: inline-block;float: left; margin-left: 20px;">
                        <a href="thread-{{$value->tid}}-1.html" style="font-size: 15px;margin-bottom: 3px;display: inline-block;"  target="_blank">
                            {{$value->subject}}
                            <span style="color: #000000">(+{{$value->replies}})</span>
                        </a>
                        <br>
                        <span style="">
                        <a class="no_attn"><?php echo "@";?>{{$value->author}}</a>
                        <span>view : {{$value->views}}</span>
                        <span style="color: #ccc">
                            <span class="show_date" style="display: none;cursor: pointer;padding: 5px;">{{date('Y-m-d',$value->dateline)}}</span>
                            <span class="show_time" style="cursor: pointer;padding: 5px;">{{date('H:i:s',$value->dateline)}}</span>

                        </span>
                    </span>
                    </div>
                    <div class="clear"></div>


                    {{--<a href="/" style="color: red;float: right" > 完全清理</a>--}}

                </div>
            @endforeach
            <div style="float: right;margin: 15px;">
                {{--{{ $data['list']->links() }}--}}
                {!! threadListPages(12,$data['fid'],$data['page']) !!}
            </div>
            <form action="/new-thread" style="margin: 10px 10px">
                <p style="margin: 10px 0px;">
                    <input type="text" name="subject" class="form-control" style="" name="subject" id="subject">
                </p>
                <input type="hidden" value="{{$data['fid']}}" id="fid">
                {{ csrf_field('new_thread_token') }}
                <div id="new_thread"></div>
                <textarea id="message" name="message" style="display:none;"></textarea>
                <span style="    cursor: pointer;border: 1px solid #ccc;padding: 5px 10px;box-sizing: border-box;margin: 15px 0px;display: inline-block;background: #fff;" id="post_thread">发新帖</span>
            </form>

        </div>
        <div class="_3_1_right">
            <div style="    text-align: center;    margin-bottom: 10px;">
                <a class="mod_btn"><span>关注</span></a>
                <a class="mod_btn go_back"><span>返回</span></a>

            </div>
            <div class="" style="    background-color: #fff;
    padding: 5px;
    box-shadow: 0 0 5px #ccc;
    margin-right: 5px;
    border-radius: 5px;">
                <h1 style="font-size: 15px;cursor:pointer;font-weight: 900;color: #f18fbe;text-shadow: 0 0 3px;">{{$data['forum']->name}}</h1>
                <img src="{{$data['forum']->forumimage}}" style="width: 100%;margin-bottom: 5px;margin-top: 5px;">
                <p></p>
            </div>
        </div>


    </div>
</div>

<script>
    $(document).ready(function () {
        var E = window.wangEditor
        var editor = new E('#new_thread')
        editor.customConfig.colors = [
            '#000000',
            '#eeece0',
            '#1c487f',
            '#4d80bf',
            '#c24f4a',
            '#8baa4a',
            '#7b5ba1',
            '#46acc8',
            '#f9963b',
            '#ffffff'
        ]
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
//        'image',  // 插入图片
//        'table',  // 表格
//        'video',  // 插入视频
            'code',  // 插入代码
            'undo',  // 撤销
            'redo'  // 重复
        ]
        editor.create();
        $('#post_thread').click(function () {
            var edHtml = html2ubb(editor.txt.html())
            var subject = $('#subject').val()
            var _token = $('#new_thread_token').val()
            var fid     = $('#fid').val()
            var postData = {
                'subject' : subject,
                'message' : edHtml,
                '_token'  : _token ,
                'fid'     : fid
            };
            console.log(postData)
            $.post('/new-thread',postData,function (event) {
                alert(event.msg);
                if (event.ret == 200)
                {
                    location.reload();
                }
            })
        })
    })
</script>
@include('PC.Common.Footer')