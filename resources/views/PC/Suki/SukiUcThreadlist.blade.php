@foreach($data["thread"] as $value)
    <p class="uc_user_thread" style="padding: 5px">

        <a style="color: #000;    color: #ad7b7e;text-decoration: none" href="/suki-thread-{{$value->tid}}-1.html">{{$value->subject}}</a>
        <span style="float: right">{{ format_time($value->dateline)}}</span>
    </p>

@endforeach