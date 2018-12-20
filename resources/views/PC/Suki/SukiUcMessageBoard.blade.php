@foreach($data["message_board"] as $value)
    <div>
        {{avatar($value->authorid,50)}}
        <p>{{$value->message}}</p>
        <p>{{$value->user_info->username}}</p>
        <p>{{date("Y-m-d H:i",$value->send_time)}}</p>
    </div>
@endforeach