@include('PC.Suki.SukiHeader')
<style>
    .wp.index_body {
        margin-top: 50px;
        position: relative;
    }
    .part_item {
        display: inline-block;
        float: left;
        margin:10px;
        cursor: pointer;
        background: #fbfbfb;
        padding: 7px;
        border: 3px solid #a8c3c1;
        border-radius: 5px;
        border: 3px solid #fbfbfb;
        text-decoration: none;
        width: 60px;
        height: 80px;
    }
    .part_item:hover,.part_item:active{
        text-decoration: none;
    }
    .part_item > div {
        width: 40px;
        height: 40px;
        background: #ffffff;
        box-shadow: 2px 1px 9px 1px #ffdede;
        border-radius: 5px;
    }
    .part_item > p {
        text-align: center;
        color: #88b8d2;
        font-size: 11px;
    }
    .system_setting_checkbox {
        width: 45px;
        height: 45px;
        display: inline-block;
        background: #88ebff;
        font-size: 11px;
        color: #fff;
        text-align: center;
        cursor: pointer;
        border-radius: 100%;
        padding: 5px;
        box-shadow: 0 0 10px #64f8fb;
        margin: 5px;
        font-weight: 900;
        background-image: linear-gradient(176deg, #53def5 0%, #c0fff6 100%);
    }
    .selected_part_item {
        background: #fff2f1;
        padding: 7px;
        border: 3px solid #ffdcde;
        border-radius: 5px;
        width: 60px;
        height: 80px;
    }

    .w-e-toolbar{
        border-color: #e8e8e8!important;
        background-color: #ffffff!important;
    }
    .w-e-text-container {
        height: 180px !important;/*!important是重点，因为原div是行内样式设置的高度300px*/
        border-color: #e8e8e8!important;
    }
    .w-e-toolbar {
        border: 1px solid #d8d8d8!important;
    }
    .appimage img {
        width: inherit;
        margin: 5px;
        width: 30px;
        height: 30px;
        display: inline-block;
    }
    .suki_banner {

    }

    .add_more_threadlist{
        text-align: center;
        width: 100%;
        display: inline-block;
        font-size: 20px;
        color: #d2d2d2;
        /*text-shadow: 0 0 3px;*/
        text-decoration: none!important;
    }
    .add_more_threadlist:hover,.add_more_threadlist:active,.add_more_threadlist:focus {
        text-shadow: 0 0 6px;
        color: #ffb0b0;
        text-decoration: none;
    }

    .poster_button {
        display: inline-block;
        background: #febec1;
        border-radius: 5px;
        color: #fff;
        height: 40px;
        padding: 10px 20px;
        box-sizing: border-box;
        margin-top: 25px;
        position: absolute;
        right: 10px;
        padding-left: 40px;
        background-image: linear-gradient(0deg, #FEBCC6 0%, #fba3ad 14%, #ffb9c2 100%);
        font-weight: 900;
    }

    .poster_button .pos_add{
        position: absolute;
        width: 15px;
        left: 15px;
        top: 13px;
    }
    #alert_poster.mini .poster_button{
        width: 16px;
        padding: 25px 24px 18px 20px;
        border-radius: 100%;
        text-align: center;
        line-height: 38px;
        top: 200px;
        box-shadow: 0 0 5px #ff191942;
    }
    @media screen and (max-width: 575px) {
        .poster_button {     width: 16px;
            padding: 25px 24px 18px 20px;
            border-radius: 100%;
            text-align: center;
            line-height: 38px;
            top: 200px;
            box-shadow: 0 0 5px #ff191942;}
        .pos_text {display: none}
    }
</style>
<div class="wp index_body">

    <div class="suki_banner">
        {{--<img src="/Image/testbanner.jpg">--}}
    </div>
    <div class="part" style="    overflow-x: auto;white-space: nowrap;display: flex">

        @foreach($data['nodes'] as $value)
        <a href="/forum-{{$value['fid']}}-1.html"  class="trans part_item fid_{{$value["fid"]}}" fid="{{$value["fid"]}}">
            <div class="appimage">
                <img src="{{$value['appimage']}}">
            </div>
            <p>{{$value["name"]}}</p>
        </a>
        @endforeach

        <a style="" id="alert_poster" class="trans">
            <div class="poster_button trans">
                {{--<img src="/Static/image/common/fatie.png" style="width: 40px">--}}
                {{--<span class="pos_add">+</span>--}}
                <img src="/Image/plus.png" class="pos_add">
                <span class="pos_text">我要发帖</span>
            </div>
        </a>

    </div>
    <div class="list_container">
        @include('PC.Suki.SukiThreadList')
    </div>
    <a href="/" class="add_more_threadlist trans">加载更多</a>
    @include('PC.Suki.SukiPosterContent')

</div>
@include('PC.Suki.SukiFooter')
