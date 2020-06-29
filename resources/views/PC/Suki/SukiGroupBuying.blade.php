@include('PC.Suki.SukiHeader')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<style>
    .items_list {
        padding: 10px;
        justify-content: space-between;
        display: flex;
        flex-wrap: wrap;
        padding-top: 0px;
    }
    .goods_item  {
        display: inline-block;
        width: 165px;
        float: left;
        padding: 10px;
        background: #FFFFFF;
        /*margin: 10px;*/
        box-shadow: 0 0 10px #ececec;
        border-radius: 5px;
        overflow: hidden;;
        margin: 11.5px;
    }
    .items_list:after {
        content: "";
        flex: auto;
        min-width: 165px;
    }
    @media screen and (max-width: 385px) {
        .goods_item {
            margin:0 0 10px 0;

        }

    }
    body{
        min-height:  500px;

    }
</style>
<div class="wp" style="margin-top: 60px;">

    <nav aria-label="breadcrumb" style="margin: 15px 10px;  padding:5px;border-radius: 5px;  background-color: #e9ecef;">
        <div class="btn-group" role="group">
            <button
                    style="    border: 0px;color: #70748c;background-color: #e9ecef;padding: 3px 15px;margin-left: 0px;"
                    id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if($data['type']=='stock')
                    现货
                @elseif($data["request"]["gid"] == "")
                    本期团购
                @elseif($data["request"]["gid"] == 5)
                    五期团购
                @elseif($data["request"]["gid"] == 6)
                    六期团购
                @elseif($data["request"]["gid"] == 7)
                    七期团购
                @elseif($data["request"]["gid"] == 8)
                    八期团购
                @elseif($data["request"]["gid"] == 9)
                    九期团购
                @endif
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <a href="/shop" class="dropdown-item" href="#">本期团购</a>
                <a href="/stocks_shop" class="dropdown-item" href="#">现货</a>
                {{--<a href="/suki_group_buying?gid=1" class="dropdown-item" href="#">一期团购</a>--}}
                {{--<a href="/suki_group_buying?gid=2" class="dropdown-item" href="#">二期团购</a>--}}
{{--                <a href="/shop?gid=4" class="dropdown-item" href="#">四期团购</a>--}}
                <a href="/shop?gid=5" class="dropdown-item" href="#">五期团购</a>
                <a href="/shop?gid=6" class="dropdown-item" href="#">六期团购</a>
                <a href="/shop?gid=7" class="dropdown-item" href="#">七期团购</a>
                <a href="/shop?gid=8" class="dropdown-item" href="#">八期团购</a>
                <a href="/shop?gid=9" class="dropdown-item" href="#">⑨期团购</a>
            </div>
        </div>
        {{--<ol class="breadcrumb">--}}
            {{--<li class="breadcrumb-item active" aria-current="page" >本期团购</li>--}}
        {{--</ol>--}}
    </nav>
    <div style="" class="items_list">
        @foreach($data["items"] as $item)
            <div class="goods_item">
                <p class="aline" style="width: 150px;font-weight: 900;color: #7B6164;margin-left: 0;">{{$item["item_name"]}}</p>
                <img src="{{$item["item_image"][0]}}" class="goods_item_image" style="width: 148px;height: 102px">
                <p style="margin: 8px 0 0 0;">
                    <span style="color: #F28A96;font-size: 16px">￥{{$item["item_price"] + $item["premium"]}}</span>
                    <span style="color: #999999;font-size: 12px;float: right">{{$item["min_members"]}}个成团</span>
                </p>
                <p style="color: #999999;font-size: 12px;text-align: right;margin: 0px;">
                    <span  style="">{{$item["follow"]}}</span>
                    人购买了
                    <span style="color: #f9b9c0">{{$item["item_count"]}}</span>
                    个
                </p>

                <a href="/shop/goods?item_id={{$item["id"]}}" style="  border-radius: 5px;  margin-top: 10px;background: #f9c8c9;width: 100%;display: block;color: #fff;text-align: center;background-color: #ffb6c7;background-image: linear-gradient(90deg, #fbded9 0%, #ffa5b2 93%);">查看详情</a>
            </div>

        @endforeach
        {{--<div class="clear"></div>--}}
    </div>
</div>
<script>
    function resizeWidth() {
        var body_width = window.innerWidth - 20; //body的总宽度
        var scaling_for_image =  (148-5)/(165); //item和内部图片的宽度比例
        var image_scaling = 360/260; //内部图片的宽高比例

        var goods_item_width = (body_width - 0) / 2 > 165 ? 165 : (body_width - 0) / 2 ;
        var goods_item_image_width = scaling_for_image * goods_item_width ;
        $(".goods_item").css({"width" : goods_item_width});
        $(".goods_item_image").css({"width" : goods_item_image_width});
    }
    $(document).ready(function () {
        resizeWidth();
        $(window).resize(function () {
            resizeWidth()
        });


    })
</script>
@include('PC.Suki.SukiFooter')