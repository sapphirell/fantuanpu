<div class="thread_list" style="margin-top: 10px">
    <div class="thread_item">

        <div class="fourm_thread_items @if($value->top)top @endif" style="  margin: 10px;  box-shadow: 0 0 10px #f1f1f1;background: #ffffff;padding: 10px;border-radius: 5px;"  >
            <div style="     display: flex;    padding: 10px;">
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

            <div class="thread_image_list" style="width:100%;float: left;">
                <div style="width: 90px;height: 90px;float: left;background: #dddddd;margin: 10px"></div>
                <div style="width: 90px;height: 90px;float: left;background: #dddddd;margin: 10px"></div>
                <div style="width: 90px;height: 90px;float: left;background: #dddddd;margin: 10px"></div>



            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>