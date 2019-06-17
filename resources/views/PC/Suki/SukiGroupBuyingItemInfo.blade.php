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
                <div style="background: #efefef;padding: 8px;margin-bottom: 10px">
                    <p>单价: <span class="item_info_num">{{$data["item_info"]->item_price + $data["item_info"]->premium}}</span>元</p>
                    <p>最低成团: <span class="item_info_num">{{$data["item_info"]->min_members}}</span>个 (当前{{$data["item_member"] . "人购买了" . $data["item_follow"]}}个)</p>
                    <p>阿里运费: <span class="item_info_num">{{$data["item_info"]->item_freight}}</span>元 当前{{$data["item_member"] > 0 ? round($data["item_info"]->item_freight / $data["item_member"],2) : $data["item_info"]->item_freight }}元/每人</p>
                    <p >截团日: <span class="item_info_num">{{$data["group_info"]->enddate}}</span></p>
                </div>
                <div style="margin-bottom: 10px;padding-left: 13px;">
                    <span for="size" style="color: #888a85;margin-right: 15px">可选尺码</span>
                    <select style="width: 200px;display: inline-block" class="size" name="size">
                        @foreach($data["item_info"]->item_size as $value)
                            <option>
                                <span>{{$value}}</span>
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="padding-left: 13px;">
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

                    @if( $data["group_info"]->status == 2)
                        <input type="submit" value="提交拼团" class="submit_to_gb" style="display: none">
                    @endif
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

        @if( $this->data["last"]->status == 2)
            {{--<input type="submit" value="确认参与拼团" class="submit_to_gb">--}}
        @else
            <p>本次团购已结束</p>
        @endif
        <p style="font-size: 16px;margin-top: 10px">购前须知:</p>
        <ul style="padding: 20px;padding-top: 0px;">
            <li>商品在截团日前未凑够最低成团数或当天付清货款的人不足最低成团数的,以流团处理</li>
            <li>商品最终价格为:商品原价*购买份数+公摊运费+私人运费</li>
            <li>钱需要在最终截团前付清,方式为支付宝转账</li>
            <li>最终价格为(商品单价*购买数量) + 个人邮费 + 阿里邮费/真实成团数</li>
            <li style="color: #ff7272;">截团前可以无责取消订单,但截团后不可取消订单,如果执意取消订单,这将导致其他人的运费需要重新运算,
                并且有可能使其他人流团,这种行为一旦发生,我们会永久禁止您在我们这里参与团购!!!
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
            var size = $(".size").val()
            var color = $(".color").val()
            var num =  parseInt($(".num").val())

            if (!size || !color || !num)
            {
                alert("参数不完整")
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
            $.post("/suki_group_buying_item",fd,function (e) {
                alert(e.msg)
                if (e.ret == 200)
                    window.location.href = "/suki_group_buying_myorders?type=last"
            })
        })





    })
</script>
@include('PC.Suki.SukiFooter')