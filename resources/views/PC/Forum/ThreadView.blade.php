@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<title>饭团扑动漫网-{{$data['thread_subject']->subject}}</title>

<script src="/Static/Script/Web/forum.js"></script>
<script>


</script>
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

<div class="wp" style="background: #fff;    margin-top: 20px;">
    <div>
        <span>饭团扑 > {{$data['forum']->name}}</span>
    </div>
    <div>
        <div class="user_info"  style="width: 20%;float: left;">
            {{avatar($data['thread']['thread_post'][0]->authorid,100,100,'post-avatar','normal')}}
            <p>用户名:{{$data['thread']['thread_subject']->author}}</p>
            <p>发帖时间:{{date("Y-m-d H:i:s",$data['thread']['thread_subject']->dateline)}}</p>
            <p>查看数:{{$data['thread']['thread_subject']->views}}</p>
            <p>回复数:{{$data['thread']['thread_subject']->replies}}</p>
        </div>
        <div style="width: 78%;float: right;">
            <h1 style="    font-size: 20px;">{{$data['thread']['thread_subject']->subject}}</h1>
            <p>{!! bbcode2html($data['thread']['thread_post'][0]->message) !!}</p>
        </div>
        <div class="clear"></div>
    </div>
    <div>


        @foreach($data['thread']['thread_post'] as $key=>$value)
            @if($key == 0)
                {{--帖子一楼--}}
            @else
                <div>
                    {{avatar($value->authorid,50,100,'post-avatar','normal')}}
                    <div>
                        <p>回帖时间:{{date("Y-m-d H:i:s",$value->dateline)}}</p>
                        {!! bbcode2html($value->message) !!}}
                    </div>
                </div>

            @endif
        @endforeach
    </div>

</div>

@include('PC.Common.Footer')