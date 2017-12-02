@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<script src="/Static/Script/Web/forum.js"></script>
<style>
    .fourm_thread_items {    padding: 5px 8px;background: #ffffff}
</style>
<div class="wp" style="padding: 5px;margin-top: 29px;">
    <!--头部banner-->

    <div>
        @foreach($data['list'] as $value)
            <p class="fourm_thread_items">
                <span>阅读数:{{$value->views}}</span>
                <span>回复数:{{$value->replies}}</span>
                <span>{{date('m-d H:i:s',$value->dateline)}}</span>
                <a href="thread-{{$value->tid}}-{{$page}}-1.html">{{$value->subject}}</a>
                <span>{{$value->author}}</span>
                <a href="/" style="color: red;float: right" > 完全清理</a>

            </p>
        @endforeach
            {{ $data['list']->links() }}
    </div>
</div>
@include('PC.Common.Footer')