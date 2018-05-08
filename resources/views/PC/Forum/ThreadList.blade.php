@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<script src="/Static/Script/Web/forum.js"></script>
{{--<script type="text/javascript" src="/Static/Script/xheditor/xheditor-1.2.2.min.js"></script>--}}
{{--<script type="text/javascript" src="/Static/Script/xheditor/xheditor_lang/zh-cn.js"></script>--}}
<script type="text/javascript" src="/Static/Script/wangEditor/wangEditor.js"></script>
<style>
    .fourm_thread_items {    padding: 5px 8px;background: #ffffff}
    .wp {
        margin-top: 29px;
        box-shadow: 0 0 11px #e6e6e6;
        border-radius: 5px 5px 0px 0px;
        overflow: hidden;
        padding: 0px!important;
    }
    .wp .fourm_thread_items {
        margin: 0px;
    }
    #new_thread
    {
        /*width: 95%;*/
        /*margin: 0px auto;*/
        background-color: #fff;
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
<div class="wp" style="padding: 5px;margin-top: 29px;    border: 1px solid #ddd;">
    <!--头部banner-->

    <div>
        @foreach($data['list'] as $key => $value)
            <p class="fourm_thread_items" @if($key%2==0) style="background: #f5f5f5;" @endif >
                <a href="thread-{{$value->tid}}-1-1.html">
                    {{$value->subject}}
                    <span style="color: #000000">(+{{$value->replies}})</span>
                </a>
                <span style="float: right">
                    <a class="no_attn"><?php echo "@";?>{{$value->author}}</a>
                    <span>view : {{$value->views}}</span>
                    <span style="color: #ccc">
                    <span class="show_date" style="display: none;cursor: pointer;padding: 5px;">{{date('Y-m-d',$value->dateline)}}</span>
                    <span class="show_time" style="cursor: pointer;padding: 5px;">{{date('H:i:s',$value->dateline)}}</span>

                </span>
                </span>


                {{--<a href="/" style="color: red;float: right" > 完全清理</a>--}}

            </p>
        @endforeach

        <form action="/new-thread" style="margin: 10px 10px">
            <p style="margin: 10px 0px;">
                <input type="text" name="subject" class="form-control" style="" name="subject">
            </p>
            {{ csrf_field('new_thread_token') }}
            <div id="new_thread"></div>
            <textarea id="message" name="message" style="display:none;"></textarea>
            <span style="    cursor: pointer;border: 1px solid #ccc;padding: 5px 10px;box-sizing: border-box;margin: 15px 0px;display: inline-block;background: #fff;" id="post_thread">发新帖</span>
        </form>

        <div style="float: right;margin: 15px;">
            {{--{{ $data['list']->links() }}--}}
            {!! pages(12,2,'forum',1) !!}
        </div>

    </div>
</div>

<script>
    $(document).ready(function () {
        var E = window.wangEditor
        var editor = new E('#new_thread')
        editor.create();
        $('#post_thread').click(function () {
            var edHtml = html2ubb(editor.txt.html())
            var subject = $('#subject').text()
            var _token = $('#new_thread_token').val()
            var postData = {
                'subject' : subject,
                'message' : edHtml,
                '_token'  : _token
            };
            console.log(postData)
            $.post('/new-thread',postData,function (data) {
                alert(data)
            })
        })
    })
</script>
@include('PC.Common.Footer')