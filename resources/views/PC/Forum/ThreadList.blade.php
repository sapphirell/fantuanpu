@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<script src="/Static/Script/Web/forum.js"></script>
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
        <div style="float: right;margin: 15px;">
            {{ $data['list']->links() }}
        </div>

    </div>
</div>
@include('PC.Common.Footer')