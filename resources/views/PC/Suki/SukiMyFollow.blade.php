@include('PC.Suki.SukiHeader')
<div class="wp" style="margin-top:50px;">
    <div>
        <div style="float: left;">{{avatar($data['user_info']->uid,80,"100")}}</div>
        <h2 style="float: left;display: inline-block">{{$data['user_info']->username}}</h2>
        <div class="clear"></div>
    </div>
    <div>
        <h4>我关注的用户</h4>
        <div>
            @foreach($data['my_follow'] as $value)
                <div>
                    <a style="display: inline-block;float: left" href="/suki-userhome-{{$value->uid}}.html">{{avatar($value->user->uid,50,"100")}}</a>
                    <div style="display: inline-block;float: left;">
                        <p>{{$value->user->username}}</p>
                        <a href="">取消关注</a>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>



@include('PC.Suki.SukiFooter')