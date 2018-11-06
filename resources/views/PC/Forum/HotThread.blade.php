<div class="node_father">
    @foreach($data['hot'] as $item)
        <div class="shadow-purple" style="
        width: inherit;
        background: #ffffff;
        margin-bottom: 10px;
        border-radius: 5px;
        padding: 10px;
        ">
            {{avatar($item->authorid,'35',100,'avatar-tab','small')}}
            <a style="overflow: hidden;/*超出部分隐藏*/
white-space: nowrap;/*不换行*/
text-overflow:ellipsis;/*超出部分省略号显示*/" href="/thread-{{$item->tid}}-1.html" style="display: inline-block">{{$item->subject}}</a>
            <p style="display: inline-block">{{date("Y-m-d",$item->dateline)}}</p>
        </div>
    @endforeach
</div>
