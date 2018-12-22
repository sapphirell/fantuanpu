@include('PC.Suki.SukiHeader')
<style>
    .my_alert_list li{
        float: left;
        list-style: none;
        margin: 10px;
    }
</style>
<div class="wp" style="margin-top: 40px">
    <div>
        <ul class="my_alert_list">
            <li>
                <a href="" class="@if($data["request"]["type"]=="reply_me"){{"onchange"}}@endif">回复我的</a>
            </li>
            <li>
                <a href="" class="@if($data["request"]["type"]=="my_message"){{"onchange"}}@endif">我的私信</a>
            </li>
            <li>
                <a href="" class="@if($data["request"]["type"]=="call_me"){{"onchange"}}@endif">{{"@"}}我的</a>
            </li>
            <li>
                <a href="" class="@if($data["request"]["type"]=="friend_request"){{"onchange"}}@endif">好友申请</a>
            </li>
        </ul>
    </div>
    @if($data["request"]["type"]=="reply_me")
        @foreach($data["reply_me"] as $key => $value)
            <div>
                <a>
                    {{avatar($value->authorid)}}
                    {{$value->author}}
                </a>
                <p>
                    {{$value->message}}
                    {{--<a href="/suki-thread-{{$value->subject['thread_subject']->tid}}-1.html?pid={{$value->position->pid}}&floor={{$value->position->floor}}">--}}
                    <a href="/suki-thread-{{$value->subject['thread_subject']->tid}}-1.html#{{$value->position->pid}}">
                        {{$value->subject['thread_subject']->subject}}
                    </a>
                </p>

            </div>
        @endforeach
    @endif

</div>
@include('PC.Suki.SukiFooter')