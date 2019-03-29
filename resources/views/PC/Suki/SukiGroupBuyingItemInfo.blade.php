@include('PC.Suki.SukiHeader')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<style>
    .input-group-text {width: 80px}
</style>
<div class="wp" style="margin-top: 60px;    background: #fff;padding: 20px;">

    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">{{$data["item_info"]->item_name}}</li>
            </ol>
        </nav>



        <div>

            <div id="carouselExampleControls" style="width: 420px;height:250px;float: left;margin-right: 10px" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($data["item_info"]->item_image as $value)
                        <div class="carousel-item active">
                            {{--<img class="d-block w-100" src="...">--}}
                            <img class="d-block w-100"  src="{{$value}}" style="width: 420px;height: 250px;display: inline-block;float: left">
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
            <ul class="list-group col-lg-4" style="float: left;width: 265px;">
                <li class="list-group-item"><kbd class="">最低成团数:</kbd> {{$data["item_info"]->min_members}}个 (当前{{$data["item_info"]->count?:0}}个)</li>
                <li class="list-group-item"><kbd class="">单价:</kbd> {{$data["item_info"]->item_price }}元</li>
                <li class="list-group-item"><kbd class="">运费:</kbd> {{$data["item_info"]->item_freight}}</li>
                <li class="list-group-item"><kbd class="">辛苦费/次:</kbd> {{$data["item_info"]->premium}}元</li>
                <li class="list-group-item"><kbd class="">截团日期:</kbd> {{   $data["group_info"]->enddate }}</li>
                <li class="list-group-item"><kbd class="">预收邮费:</kbd>  15元</li>


            </ul>
            <div style="padding: 11px;    border: 1px dashed #ff8686;background: #fff;display: inline-block;float: left">
                <p>可选尺码</p>
                <select style="width: 200px"  class="size" name="size" >
                    @foreach($data["item_info"]->item_size as $value)
                        <option>
                            <span>{{$value}}</span>
                            {{--<input type="radio" value="{{$value}}">--}}
                        </option>

                    @endforeach
                </select>

                <p  class="text-info">可选颜色</p>
                <select style="width: 200px"  class="color" name="color" >
                    @foreach($data["item_info"]->item_color as $value)
                        <option>
                            <span class="color" name="color">{{$value}}</span>
                        </option>
                    @endforeach
                </select>
                <br>
                <p>购买个数(填写负数为减少)</p>
                <div>
                    <input type="text" value="0" class="form-control num" placeholder="" style="width: 200px">
                </div>
                <input type="submit" value="添加至待购清单" class="add_item">
            </div>

            <div class="clear"></div>
        </div>


        <input type="hidden" value="{{$data["item_info"]->item_price}}" id="items_price">
        <input type="hidden" value="{{$data["item_info"]->item_freight}}" id="item_freight">
        <input type="hidden" value="{{$data["item_info"]->min_members}}" id="min_members">
        <input type="hidden" value="{{$data["item_info"]->premium}}" id="premium">
        <input type="hidden" value="{{$data["item_info"]->id}}" id="item_id">
        <input type="hidden" value="15" id="private_freight">


        <div style="border: 1px solid #ccc;padding: 10px">
            <form>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">收件人</span>
                    </div>
                    <input type="text" class="form-control name" placeholder=""  name=""  value="{{$data["last"]->name}}">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">收货地址</span>
                    </div>
                    <input type="text" class="form-control address" placeholder=""  name=""  value="{{$data["last"]->address}}">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">收货手机号</span>
                    </div>
                    <input type="text" class="form-control telphone" placeholder="" name="" value="{{$data["last"]->telphone}}">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">您的qq号</span>
                    </div>
                    <input type="text" class="form-control qq" placeholder=""  value="">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">订单详情</span>
                    </div>
                    <input type="text" class="form-control buying order_info" placeholder=""  readonly="readonly" name="" >
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">您的费用</span>
                    </div>
                    <input type="text" class="form-control your_pirce" placeholder=""  readonly="readonly" value="0">
                </div>

                <input type="submit" value="确认参与拼团" class="submit_to_gb">
            </form>
        </div>
        <p style="font-size: 16px;margin-top: 10px">购前须知:</p>
        <ul style="padding: 20px;padding-top: 0px;">
            <li>商品在截团日前未凑够最低成团数或当天付清货款的人不足最低成团数的,会流团</li>
            <li>商品最终价格为:商品原价*购买份数+公摊运费+私人运费</li>
            <li>截团前可以取消订单,截团后不可取消订单</li>
            <li>钱需要在最终截团前付清,方式为支付宝转账</li>
            <li>统一预收个人邮费15元,费用计算为预收金额,公摊邮费和私人邮费多退少补。</li>
            <li>最终价格为(商品单价*购买数量) + 个人邮费 + 阿里邮费/真实成团数</li>

        </ul>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".add_item").click(function () {
            var size = $(".size").val()
            var color = $(".color").val()
            var num =  parseInt($(".num").val())

            if (!size || !color || !num)
            {
                alert("参数不完整")
                return false;
            }

            var items = size + "_" + color
            var now_chat = $(".buying").val() ? JSON.parse($(".buying").val()) : {};

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

            $(".buying").val(JSON.stringify(now_chat))
            var item_price = parseFloat($("#items_price").val());
            var premium = parseFloat($("#premium").val());
            var item_freight = parseFloat($("#item_freight").val());
            var min_members = parseFloat($("#min_members").val());
            var private_freight = parseFloat($("#private_freight").val());
            var price = 0

            for (var index in now_chat){
                price += now_chat[index] * item_price + now_chat[index]* premium
            }
            price += item_freight /min_members + private_freight
            $(".your_pirce").val(price)

        });

        $(".submit_to_gb").click(function (e) {
            e.preventDefault();
            var name = $(".name").val()
            var address = $(".address").val()
            var telphone = $(".telphone").val()
            var order_info = $(".order_info").val()
            var item_id = $("#item_id").val()
            var qq = $(".qq").val();

            if (!name || !address || !telphone || !order_info || !item_id || !qq)
            {
                alert("缺少参数")
                return false;
            }
            var fd = {
                name : $(".name").val(),
                address : $(".address").val(),
                telphone : $(".telphone").val(),
                order_info : $(".order_info").val(),
                item_id: $("#item_id").val(),
                qq : $(".qq").val()
            }
            console.log(fd);
            $.post("/suki_group_buying_item",fd,function (e) {
                alert(e.msg)
                if (e.ret == 200)
                    window.location.reload()
            })
        })
    })
</script>
@include('PC.Suki.SukiFooter')