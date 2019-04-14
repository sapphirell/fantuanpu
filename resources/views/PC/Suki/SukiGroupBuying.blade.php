@include('PC.Suki.SukiHeader')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<div class="wp" style="margin-top: 60px;">

    <nav aria-label="breadcrumb" style="margin: 0px 10px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page" >本期团购</li>
        </ol>
    </nav>
    <div style="display: flex;justify-content: flex-start;">
        @foreach($data["items"] as $item)
            <div style="display: inline-block;float: left;padding: 10px;background: #FFFFFF;margin: 10px;box-shadow: 0 0 10px #ececec;border-radius: 5px;">
                <p>名称:{{$item["item_name"]}}</p>
                <p>最低成团数:{{$item["buy_num"]}} / {{$item["min_members"]}}个</p>
                <p>当前团购人数:{{$item["follow"]}} 人</p>
                <p>运费:{{$item["item_freight"]}}</p>
                <p>辛苦费/次:{{$item["premium"]}}</p>
                @foreach($item["item_image"] as $value)
                    <img src="{{$value}}" style="width: 140px;height: 140px">
                @endforeach
                <p>可选尺码</p>
                @foreach($item["item_size"] as $value)
                    <span>{{$value}}</span>
                @endforeach
                <p>可选颜色</p>
                @foreach($item["item_color"] as $value)
                    <span>{{$value}}</span>
                @endforeach
                <br>
                <a href="/suki_group_buying_item_info?item_id={{$item["id"]}}" style="    margin-top: 10px;background: #f9c8c9;width: 100%;display: block;color: #fff;text-align: center;background-color: #ffb6c7;background-image: linear-gradient(90deg, #fbded9 0%, #ffa5b2 93%);">查看详情</a>
            </div>

        @endforeach
        <div class="clear"></div>
    </div>
</div>
@include('PC.Suki.SukiFooter')