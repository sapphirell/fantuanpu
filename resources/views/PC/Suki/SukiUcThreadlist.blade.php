@foreach($data["thread"] as $value)
    <p class="uc_user_thread">
        <span>{{date("Y-m-d",$value->dateline)}}</span>
        <a href="/suki-thread-{{$value->tid}}-1.html">{{$value->subject}}</a>
    </p>

@endforeach