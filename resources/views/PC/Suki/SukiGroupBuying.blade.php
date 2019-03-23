@include('PC.Suki.SukiHeader')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<div class="wp" style="margin-top: 60px;">
    <h1>
        本期团购
    </h1>
    <div>
        @foreach($data["items"] as $item)
            <div style="border: 1px solid #dddddd;display: inline-block;float: left;padding: 10px;">
                <p>名称:{{$item["item_name"]}}</p>
                <p>最低成团数:{{$item["min_members"]}}个</p>
                <p>运费:{{$item["item_freight"]}}</p>
                <p>辛苦费/次:{{$item["premium"]}}</p>
                @foreach($item["item_image"] as $value)
                    <img src="{{$value}}" style="width: 200px;height: 200px">
                @endforeach
                <p>可选尺码</p>
                @foreach($item["item_size"] as $value)
                    <button>{{$value}}</button>
                @endforeach
                <p>可选颜色</p>
                @foreach($item["item_color"] as $value)
                    <button>{{$value}}</button>
                @endforeach
                <br>
                <a style="margin: 10px">查看详情</a>
            </div>

        @endforeach
        <div class="clear"></div>
    </div>
</div>
@include('PC.Suki.SukiFooter')