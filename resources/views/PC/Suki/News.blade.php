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
</style>
<div class="wp index_body">
    <div class="part">
        <div class="part_item">
            <div class=""></div>
            <p>讨论</p>
        </div>
        <div class="part_item">
            <div class=""></div>
            <p>同城</p>
        </div>
        <div class="part_item">
            <div class=""></div>
            <p>上新</p>
        </div>
        <div class="part_item">
            <div class=""></div>
            <p>开箱</p>
        </div>
        <div class="part_item">
            <div class=""></div>
            <p>闲聊</p>
        </div>
        <div class="part_item">
            <div class=""></div>
            <p>闲聊</p>
        </div>

        <div style="width: 200px;float:right;">
            <div class="system_setting_checkbox" check-arr= >
                浏览全部
            </div>
            <div class="system_setting_checkbox">
                图片展开
            </div>
        </div>

        <div class="clear"></div>
    </div>

    @include('PC.Suki.SukiThreadList')

</div>
@include('PC.Suki.SukiFooter')
