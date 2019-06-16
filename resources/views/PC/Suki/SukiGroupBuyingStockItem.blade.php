@include('PC.Suki.SukiHeader')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<style>
    .input-group-text {width: 80px}

    .item_info_ul {
        /*padding: 0px;*/
        /*display: inline-block;    float: left;*/
    }
    /*360 * 250*/
    .items_banner {width: 480px;height:333px;float: left;margin-right: 10px;position: relative;overflow: hidden;    border-radius: 5px;}
    .check_box{    margin-left: 15px;}
    .num {text-align: center}
    .spinner_div button{    -webkit-appearance: button;
        padding: 5px 10px;
        background: #f3f3f300;
        border: 0px;
        font-size: 20px;
        font-weight: 900;
        color: #847777;}
    .add_item,.submit_to_gb {
        background-color: #f9bfc4!important;
        border: 0px!important;
        color: #fff!important;
        box-shadow: 0 0 5px #f9bfc4;
        padding: 5px 10px!important;
        margin-right: 5px!important;
    }
    .item_info_ul {
        float: left;
        width: 400px;
        margin-left:20px;
    }
    .order_div {
        padding: 5px 12px;
        background: #eee;
        margin: 15px 0px;
        border-radius: 5px;
        box-shadow: 0 0 5px #ddd;
        color: #7B6164;
    }
    .item_info_num {
        color: #7B6164 ;
        font-weight: 600;
    }
    button:focus {
        outline : none;
    }
    @media screen and (max-width: 960px) {
        .item_info_ul {margin-top: 10px;}
        .items_banner {width: 100%;height:250px;float: left;margin-right: 10px}

        .check_box{    margin-left: 0px;    width: 100%; margin-bottom: 20px}
        .item_info_ul {
            float: left;
            width: 100%;
            margin-left: 0px;
        }
    }
</style>
<div class="wp" style="margin-top: 60px;    background: #fff;padding: 20px;">

    <div>
        {{--<nav aria-label="breadcrumb">--}}
            {{--<ol class="breadcrumb">--}}
                {{--<li class="breadcrumb-item active" aria-current="page">{{$data["item_info"]->item_name}}</li>--}}
            {{--</ol>--}}
        {{--</nav>--}}



        <div>
            <div id="carouselExampleControls" class="carousel slide items_banner" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($data["item_info"]->item_image as $key => $value)
                        <div class="carousel-item @if($key == 0) {{active}} @endif">
                            <img class="d-block w-100"  src="{{$value}}" class="" style="display: inline-block;float: left">
                        </div>
                    @endforeach

                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <div class="item_info_ul" style="float: left;">
                <h1 style="color: #7B6164;font-size: 18px;font-weight: 500;text-align: left">{{$data["item_info"]->item_name}}</h1>
                <div style="background: #fafafa;padding: 8px;margin-bottom: 10px">
                    <p>单价: <span class="item_info_num">{{$data["item_info"]->item_price + $data["item_info"]->premium}}</span>元</p>

                </div>
                <div style="margin-bottom: 10px">
                    <span for="size" style="color: #888a85;margin-right: 15px">可选尺码</span>
                    <select style="width: 200px;display: inline-block" class="size" name="size">
                        @foreach($data["item_info"]->item_size as $value)
                            <option>
                                <span>{{$value}}</span>
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <span for="size"  style="color: #888a85;margin-right: 15px">可选颜色</span>
                    <select style="width: 200px;display: inline-block" class="color" name="color">
                        @foreach($data["item_info"]->item_color as $value)
                            <option>
                                <span class="color" name="color">{{$value}}</span>
                            </option>
                        @endforeach
                    </select>

                </div>
                {{--<p>购买个数(填写负数为减少)</p>--}}
                {{--<div>--}}
                    {{--<input type="text" value="1" class="form-control num" placeholder="" style="width: 200px">--}}
                {{--</div>--}}



                <!-- // spinner plugin DOM -->
                <div style="margin-top: 20px">
                    <div data-trigger="spinner" class="spinner_div" style="display: inline-block">
                        <button type="button" data-spin="down">-</button>
                        <input type="text" value="1" data-ruler="quantity" class="form-control num" style="width: 35px;display: inline-block;">
                        <button type="button" data-spin="up">+</button>
                    </div>

                    <input type="submit" value="加入清单" class="add_item"  style="display: inline-block">


                    <input type="submit" value="提交拼团" class="submit_to_gb" style="display: none">

                </div>

            </div>
            <div class="clear"></div>
            <div class="order_div">
                <span style="">清单 :</span>
                <div style="display: inline-block" style="color: #7B6164;" class="order_info buying"></div>
            </div>

            @if(!$data["user_info"]->qq)
                <div class="input-group mb-3" style="margin-top: 20px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">您的qq</span>
                    </div>
                    <input type="text" class="form-control qq"  name="" >
                </div>
            @else
                <input type="hidden" value="{{$data["user_info"]->qq}}" class="qq">
            @endif
            <div class="clear"></div>
        </div>


        <input type="hidden" value="{{$data["item_info"]->item_price}}" id="items_price">
        <input type="hidden" value="{{$data["item_info"]->item_freight}}" id="item_freight">
        <input type="hidden" value="{{$data["item_info"]->min_members}}" id="min_members">
        <input type="hidden" value="{{$data["item_info"]->premium}}" id="premium">
        <input type="hidden" value="{{$data["item_info"]->id}}" id="item_id">
        <input type="hidden" value="15" id="private_freight">


        <p style="font-size: 16px;margin-top: 10px">购前须知:</p>
        <ul style="padding: 20px;padding-top: 0px;">
            <li>
                现货类商品不收取阿里邮费,无成团人数要求,可以和团购商品一并发货,或单独申请发货。
            </li>
        </ul>
    </div>
</div>
<script src="/Static/Script/spinner/jquery.spinner.min.js"></script>
<script>
    $(document).ready(function () {
        $("#spinner").spinner('delay', 200) //delay in ms
        .spinner('changed', function(e, newVal, oldVal) {
            // trigger lazed, depend on delay option.
        })
        .spinner('changing', function(e, newVal, oldVal) {
            // trigger immediately
        });
        $(".add_item").click(function () {
            @if(!$data["user_info"]->uid)
                alert("请先登录");
            return ;
            @endif
            var size = $(".size").val();
            var color = $(".color").val();
            var num =  parseInt($(".num").val());

            if (!size || !color || !num)
            {
                alert("参数不完整");
                return false;
            }

            var items = size + "_" + color
            var now_chat = $(".buying").text() ? JSON.parse($(".buying").text()) : {};

            $(".submit_to_gb").show()

            if (now_chat[items] === 0 &&  parseInt(num) < 0)
            {
                alert("该种类商品购买数量已经是0了")
                return false;
            }
            if (now_chat[items])
            {
                now_chat[items] += parseInt(num)
            }
            else
            {
                now_chat[items] = parseInt(num)
            }
            console.log(now_chat);
            console.log(JSON.stringify(now_chat));

            $(".buying").text(JSON.stringify(now_chat))
            var item_price = parseFloat($("#items_price").val());
            var premium = parseFloat($("#premium").val());
            var item_freight = parseFloat($("#item_freight").val());
            var min_members = parseFloat($("#min_members").val());
            var private_freight = parseFloat($("#private_freight").val());
            var price = 0

            for (var index in now_chat){
                price += now_chat[index] * item_price + now_chat[index]* premium
            }
//            price += item_freight /min_members + private_freight
            $(".your_pirce").val(price)

        });

        $(".submit_to_gb").click(function (e) {
            e.preventDefault();
            var name = $(".name").val()
            var address = $(".address").val()
            var telphone = $(".telphone").val()
            var order_info = $(".order_info").text()
            var item_id = $("#item_id").val()
            var qq = $(".qq").val();
            if (!order_info)
            {
                alert("请先添加商品")
            }
            if (!item_id )
            {
                alert("缺少参数")
                return false;
            }
            var fd = {
                order_info : $(".order_info").text(),
                item_id: $("#item_id").val(),
                qq:qq
            }
            console.log(fd);
            $.post("/suki_buy_stock_items",fd,function (e) {
                alert(e.msg)
                if (e.ret == 200)
                    window.location.href = "/suki_group_buying_myorders?type=last"
            })
        })





    })
</script>
@include('PC.Suki.SukiFooter')