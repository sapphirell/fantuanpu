@include('PC.Suki.SukiHeader')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<style>
    .logs_image {
        width: 120px;
        border-radius: 5px;
        box-shadow: 0 0 5px #ffcfcf;
        border: 1px solid #ffd1d1;
        padding: 3px;
    }
</style>
<div class="wp" style="margin-top: 60px;    padding: 5px;background-color: #fff;">
    @foreach($data["active_logs"] as $value)
        <?php $order_info = json_decode($value["order_info"],true); ?>
        <div>
            <img src="{{$value["item_image"]}}" class="logs_image" style="">
            <div>
                @foreach($order_info as $type => $num)
                    <p>{{$type}} </p>
                    <p>{{$num}}个</p>
                @endforeach

            </div>
            <div>
                <span>价格</span>
                <span>￥{{$value["order_price"]}}</span>
            </div>
        </div>
    @endforeach
</div>


@include('PC.Suki.SukiFooter')