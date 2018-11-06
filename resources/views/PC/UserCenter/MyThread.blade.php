<style>
    .fourm_thread_items {
        padding: 5px 8px;
    }
    .bm_c{
        height: 99.9%!important;
    }
</style>
<div class="bm_h">我发的帖子</div>
<div class="bm_c" style="background: #ffffff;height: 100%;overflow: hidden">
    @foreach($data['my_thread'] as  $key => $value)
        <p class="fourm_thread_items" @if($key%2==0) style="background: #f5f5f5;" @endif >
            <a href="thread-{{$value->tid}}-1-1.html"  target="_blank">
                {{$value->subject}}
                <span style="color: #000000">(+{{$value->replies}})</span>
                <span style="color: #000000">(view :{{$value->views}})</span>
            </a>
            <span style="float: right">

                    <span style="color: #ccc">
                        <span class="show_date" style="cursor: pointer;padding: 5px;">{{date('Y-m-d H:i:s',$value->dateline)}}</span>


                    </span>
                </span>


            {{--<a href="/" style="color: red;float: right" > 完全清理</a>--}}

        </p>
    @endforeach
        <div style="float: right;margin: 15px;">
            {{--{{ $data['list']->links() }}--}}
            {{ $data['my_thread']->links() }}
        </div>
</div>