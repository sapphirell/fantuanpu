@include('PC.Suki.SukiHeader')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<div class="wp" style="margin-top: 60px;">

    <nav aria-label="breadcrumb" style="margin: 0px 10px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page" >本期团购</li>
        </ol>
    </nav>
    <div style="justify-content: flex-start;">
        @foreach($data["items"] as $item)
            <div style="display: inline-block;width:165px;float: left;padding: 10px;background: #FFFFFF;margin: 10px;box-shadow: 0 0 10px #ececec;border-radius: 5px;">
                <p class="aline" style="width: 150px;font-weight: 900;color: #7B6164">{{$item["item_name"]}}</p>
                <img src="{{$item["item_image"][0]}}" style="width: 148px;height: 102px">
                <p>
                    <span style="color: #F28A96;font-size: 16px">￥{{$item["item_price"]}}</span>
                    <span style="color: #999999;font-size: 12px;float: right">{{$item["min_members"]}}个成团</span>
                </p>
                <p style="color: #999999;font-size: 12px;text-align: right">{{$item["follow"]}}人购买了 {{$item["item_count"]}} 个</p>

                <a href="/suki_group_buying_item_info?item_id={{$item["id"]}}" style="  border-radius: 5px;  margin-top: 10px;background: #f9c8c9;width: 100%;display: block;color: #fff;text-align: center;background-color: #ffb6c7;background-image: linear-gradient(90deg, #fbded9 0%, #ffa5b2 93%);">查看详情</a>
            </div>

        @endforeach
        <div class="clear"></div>
    </div>
</div>
@include('PC.Suki.SukiFooter')