@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<script src="/Static/Script/Web/forum.js"></script>
<div class="wp" style="padding: 5px;margin-top: 50px;">
    <div class="bm">
        <div class="bm_h">告示</div>
        <div class="bm_c" style="padding: 8px">
            饭团扑重新开张啦,旧版功能将会不断地开发恢复出来,目前人手紧缺,急需掌握以下超能力的强者帮助!!<br>
            * 版主<br />
            * UI设计(帮设计整体的页面布局)<br />
            * 画师 (重新绘制站娘形象以及表情包)<br />
            <br /><br />
            如果你对web开发技术有所了解,也可以加入我们。<br />
            * 我们使用社区内的前沿技术进行开发,例如php7,swoole扩展,Facebook推广的react-native等<br />

            https://github.com/sapphirell
            联系方式 QQ :363387628<br />
            如果有更多意见反馈请留言
        </div>
    </div>

    <div class="bm" style="margin-top: 8px">
        <div style="padding: 8px">
            @foreach($data['notice'] as $value)
                <p>{{$value->username}}说 : {{$value->message}}</p>
            @endforeach
        </div>
        <div class="bm_h">留言</div>
        <div class="bm_c" style="padding: 8px">
            <div >

            </div>
            <form action="/dopost-notice" method="post" >
                <p>名字:</p>
                <input type="text" name="username" class="form-control">
                <p>留言:</p>
                <textarea  class="form-control" name="message"></textarea>
                <input type="submit">
                {{ csrf_field() }}
            </form>
        </div>
    </div>

</div>
@include('PC.Common.Footer')