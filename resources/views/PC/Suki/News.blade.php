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
        <div class="clear"></div>
    </div>

    <div class="thread_list">
        <div class="thread_item">

            <div class="fourm_thread_items @if($value->top)top @endif" style="
                    display: flex;
                    background: #ffffff;
                    padding: 10px;
                    border-radius: 5px;
            "  >

                {{avatar(1,50,50,"","big")}}
                <div style="display: inline-block;float: left; margin-left: 20px;flex-grow: 1">
                    <a href="thread-{{$value->tid}}-1.html" style="font-size: 15px;margin-bottom: 3px;display: inline-block;"  target="_blank">
                        {{$value->subject}}
                        <span style="color: #000000">(+{{$value->replies}})</span>
                    </a>
                    <br>
                    <span style="">
                            <a class="no_attn"><?php echo "@";?>{{$value->author}}</a>
                            <span>view : {{$value->views}}</span>
                            <span style="color: #ccc">
                                <span class="show_date" style="display: none;cursor: pointer;padding: 5px;">{{date('Y-m-d',$value->dateline)}}</span>
                                <span class="show_time" style="cursor: pointer;padding: 5px;">{{date('H:i:s',$value->dateline)}}</span>
                            </span>
                        </span>

                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>

</div>