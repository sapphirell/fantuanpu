@include('PC.Suki.SukiHeader')
<style>
    .wp.index_body {
        margin-top: 50px;
    }
    .part_item {
        display: inline-block;
        float: left;
        margin:10px;
        cursor: pointer;
        background: #fbfbfb;
        padding: 10px;
        border: 3px solid #a8c3c1;
        border-radius: 5px;
        border: 3px solid #fbfbfb;
    }
    .part_item > div {
        width: 40px;
        height: 40px;
        background: #ffffff;
        box-shadow: 0 0 5px #afafaf;
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
        background: #d7edff;
        padding: 10px;
        border: 3px solid #a8c3c1;
        border-radius: 5px;
    }
    .w-e-text-container{
        height: 180px !important;/*!important是重点，因为原div是行内样式设置的高度300px*/
        border-color: #e6e2e2!important;
    }
    .w-e-toolbar {
        border: 1px solid #d8d8d8!important;
    }

</style>
<div class="wp index_body">
    <div class="part" style="    overflow-x: auto;white-space: nowrap;display: flex">

        @foreach($data['nodes'] as $value)
        <a href="/forum-{{$value['fid']}}-1.html"  class="part_item fid_{{$value["fid"]}}" fid="{{$value["fid"]}}">
            <div class=""></div>
            <p>{{$value["name"]}}</p>
        </a>
        @endforeach
    </div>
    <div class="list_container">
        @include('PC.Suki.SukiThreadList')
    </div>
    @include('PC.Suki.SukiPosterContent')
    <a style="position:fixed;bottom: 120px;right: 20px;" id="alert_poster">
        <img src="/Static/image/common/fatie.png" style="width: 40px">
    </a>
</div>
@include('PC.Suki.SukiFooter')
