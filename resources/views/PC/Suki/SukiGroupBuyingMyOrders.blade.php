@include('PC.Suki.SukiHeader')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<style>

    .logs_image {
        width: 120px;

    }
    .logs_image > img {
        width: 120px;
        border-radius: 5px;
        box-shadow: 0 0 5px #ffcfcf;
        border: 1px solid #ffd1d1;
        padding: 3px;
    }
    .my_items_log {
        margin: 10px;
        display: flex;
        flex-flow:row;
    }
    .my_items_log > * {
        float: left;
    }
    .item_name {
        font-size: 15px;
        font-weight: 900;
    }
    .price {
        color: #F28A96;
        font-size: 16px;
    }
    .my_log_info {
        float: left;
        flex:1;
        /*display: flex;*/
        /*flex-direction: row;*/
    }

    .my_log_detail {
        /*margin:0 20px;*/
        width: 340px;
        display:inline-block;
        float: left;
    }
    .price_status {
        display: inline-block;
        float: left;
        padding-left: 5px;
    }
    .my_log_info {
        padding:0 10px;
    }
    .tab_h {
        z-index: 4;
        position: relative;
        cursor: pointer;
    }
    .tab_h span {
        background: #ffc6c5;
        float: left;
        color: #fdfdfd;
        padding: 5px 10px;
        background-image: linear-gradient(180deg, #fbded9 0%, #ffa5b2 93%);
    }
    .tab_h span.onchange {
        background: #f1d0b2;
        background-image: linear-gradient(180deg, #cec6ab 0%, #ffd3b4 93%);
    }
    .tab_m {
        border: 1px solid #fac6c8;
        position: relative;
        top: -1px;
        border-radius: 0px 5px 5px 5px;
        padding: 10px;
    }
    @media screen and (max-width: 960px) {
        .price_status {
            margin-top: 10px;
        }
        .logs_image {
            width: 80px;
        }
        .logs_image > img {
            width: 80px;
        }
        .my_log_detail {
            width: auto;
        }

    }
</style>
<div class="wp" style="margin-top: 60px;    padding: 5px;background-color: #fff;">
    @foreach($data["active_logs"] as $value)
        <?php $order_info = json_decode($value["order_info"],true); ?>
        <div class="my_items_log">
            <a href="/suki_group_buying_item_info?item_id={{$value->id}}" class="logs_image">
                <img src="{{$value["item_image"]}}" class="logs_image" style="">
            </a>
            <div class="my_log_info">
                <div class="my_log_detail" style="">
                    <p class="item_name">{{$value["item_name"]}}</p>
                    @foreach($order_info as $type => $num)
                        <p>{{$type}} </p>
                        <p>购买数量：{{$num}}个</p>
                    @endforeach

                </div>
                <div class="price_status" style="">
                    <span style="margin-top: 5px;margin-bottom: 5px;">价格</span>
                    <span class="price">￥{{$value["order_price"]}}</span>
                    <p>
                        @if($value->status == 1)
                            <span style="display: inline">等待拼团</span>
                            <a class="suki_group_buying_cancel_orders" onclick=""
                               href="/suki_group_buying_cancel_orders" orderId="{{$value->id}}">取消订单</a>
                        @elseif($value->status == 2)
                            等待确认付款
                        @elseif($value->status == 3)
                            已经付款,等待他人付款
                        @elseif($value->status == 4)
                            取消
                        @elseif($value->status == 5)
                            等待商户发货
                        @elseif($value->status == 6)
                            平台已经发货
                        @elseif($value->status == 7)
                            流团
                        @elseif($value->status == 8)
                            等待确认到账
                        @elseif($value->status == 9)
                            商品下架
                        @elseif($value->status == 10)
                            受影响流团
                        @elseif($value->status == 11)
                            跑单
                        @endif
                    </p>
                </div>
                <div class="clear"></div>
            </div>

            <div class="clear"></div>
        </div>
    @endforeach

    <div>
        <div class="tab_h">
            <span class="onchange trans">价格计算</span>
            <span class="trans">发货管理</span>
            <span class="trans">发货管理</span>
        </div>
        <div class="tab_m">
            <div>1</div>
            <div>2</div>
            <div>3</div>
        </div>
    </div>
</div>


@include('PC.Suki.SukiFooter')