@include('PC.Suki.SukiHeader')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<style>
    .input-group-text {
        width: 80px
    }

    .item_info_ul {
        /*padding: 0px;*/
        /*display: inline-block;    float: left;*/
    }

    /*360 * 250*/
    .items_banner {
        width: 480px;
        height: 333px;
        float: left;
        margin-right: 10px;
        position: relative;
        overflow: hidden;
        border-radius: 5px;
    }

    .check_box {
        margin-left: 15px;
    }

    .num {
        text-align: center
    }

    .spinner_div button {
        -webkit-appearance: button;
        padding: 5px 10px;
        background: #f3f3f300;
        border: 0px;
        font-size: 20px;
        font-weight: 900;
        color: #847777;
    }

    .add_item, .submit_to_gb {
        background-color: #f9bfc4 !important;
        border: 0px !important;
        color: #fff !important;
        box-shadow: 0 0 5px #f9bfc4;
        padding: 5px 10px !important;
        margin-right: 5px !important;
    }

    .item_info_ul {
        float: left;
        width: 400px;
        margin-left: 20px;
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
        color: #7B6164;
        font-weight: 600;
    }

    .user_ticket_id {
        margin-right: 10px;
    }
    button:focus {
        outline: none;
    }

    @media screen and (max-width: 960px) {
        .item_info_ul {
            margin-top: 10px;
        }

        .items_banner {
            width: 100%;
            height: 250px;
            float: left;
            margin-right: 10px
        }

        .check_box {
            margin-left: 0px;
            width: 100%;
            margin-bottom: 20px
        }

        .item_info_ul {
            float: left;
            width: 100%;
            margin-left: 0px;
        }
    }
</style>
<div class="wp" style="margin-top: 60px; text-align: center;   background: #fff;padding: 20px;">
    @if($data['my_ticket']->isEmpty())
        <span>暂无优惠券</span>
    @else
        <p style="color: #dddddd">选择希望使用的优惠券,付款时满足条件自动抵扣</p>
        <br />
        <form action="/suki_group_buying_select_ticket" method="post">
            <input type="hidden" name="route_to" value="{{$data["ori_route"]}}">
            @foreach($data['my_ticket'] as $value)
                {{--{{dd($value)}}--}}
                <div>
                    <input class="user_ticket_id" type="radio"
                           @if($value["status"] == 4)
                                   checked
                           @endif
                           id="{{$value["user_ticket_id"]}}" name="user_ticket_id" value="{{$value["user_ticket_id"]}}">
                    <label for="{{$value["user_ticket_id"]}}">
                        <span style="color: #f9b0b9;">{{$value["name"]}}</span>
                        <span>
                            @if($value["gid"])
                                在{{$value["gid"]+1}}团中
                            @endif
                            满足{{$value["need_value"]}}优惠{{$value["off_value"]}}
                        </span>
                    </label>

                </div>
            @endforeach
            <input type="submit" style="margin-top: 50px" value="提交">
        </form>

    @endif
</div>
<script src="/Static/Script/spinner/jquery.spinner.min.js"></script>
<script>



</script>
@include('PC.Suki.SukiFooter')