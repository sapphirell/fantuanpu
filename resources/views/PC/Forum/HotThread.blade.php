<div class="node_father">
    @foreach($data['hot'] as $item)
        <div class="shadow" style="
        width: 712px;
        background: #ffffff;
        margin-bottom: 10px;
        border-radius: 5px;
        padding: 10px;
        ">
            {{avatar($item->authorid,'small',100)}}
            <a href="/thread-{{$item->tid}}-1.html" style="display: inline-block">{{$item->subject}}</a>
            <p style="display: inline-block">{{date("Y-m-d",$item->dateline)}}</p>
        </div>
    @endforeach
</div>
