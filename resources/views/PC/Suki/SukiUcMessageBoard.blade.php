@if(empty($data["message_board"][0]->id))
    <div style="margin: 10px 4px;color: #ccc;">还没有留言,快来留下第一条吧~</div>
@endif

@foreach($data["message_board"] as $value)
    <div style=" padding-left: 20px;">
        <div style="   ">
            <div style="float: left">
                <a href="/suki-userhome-{{$value->authorid}}.html">{{avatar($value->authorid,40,100)}}</a>
            </div>
            <div style="float:left;margin-left: 10px">
                <p>{{$value->user_info->username}}</p>
                <p style="font-size: 12px;color: #ddd;">{{format_time($value->send_time)}}</p>
            </div>
            <div class="clear"></div>
        </div>
        
        <p style="margin: 10px 0px;padding: 0px 5px;">{{$value->message}}</p>


    </div>
@endforeach