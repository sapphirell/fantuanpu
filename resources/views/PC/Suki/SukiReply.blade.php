@foreach($data['thread_post'] as $key=>$value)
    @if($key == 0)
        {{--帖子一楼--}}
    @else
        <div class="post_item" name="{{$value->pid}}">
            <?php $rand_border = ['#bbb0ff','#e7b0ff','#dbffb0','#b5ecff','#ffb5b5']; ?>
            <div class="post_msg"  style="z-index: 1; position: relative;    margin-right: 20px;
                                    {{--border-bottom: 3px solid {{$rand_border[rand(0,4)]}};--}}
                    ">

                <div style="width: 80px;display: inline-block;float: left;    margin-right: 15px;">


                    @if($data['anonymous'])
                        {{avatar(0,80,100,'post-avatar','normal')}}
                        <p style="color: #544349;width: 80px;text-align: center;display: inline-block;margin-top: 5px">匿名</p>
                    @else
                        <a href="/suki-userhome-{{$value->authorid}}.html" style="cursor: pointer">
                            {{avatar($value->authorid,80,100,'post-avatar','normal')}}
                        </a>
                        <a href="suki-userhome-{{$value->authorid}}.html" style="color: #544349;width: 80px;text-align: center;display: inline-block;margin-top: 5px">{{$value->author}}</a>
                    @endif

                </div>
                <div class="post_content" style="width: 70%;display: inline-block;float:left;">
                    <div id="{{$value->pid}}" style="padding: 5px;">{!! bbcode2html($value->message) !!}</div>

                    <div style="    width: 100%;display: inline-block;float: left;position: absolute;     bottom: 28px;right: 3px;">
                        {{--<img src="/Static/daimeng.gif">--}}
                        <span style="color: #cccccc;padding-left: 5px;position: absolute;right: 10px;">
                                            {{$value->position}}楼 &nbsp;
                            {{date("Y·m·d H:i:s",$value->dateline)}}
                                        </span>
                        <span onclick="reply({{$value->pid}})" class="reply" style="cursor: pointer;color: #f5b3b5;position: absolute;    right: 9px;bottom: 0px;">回复</span>
                    </div>
                </div>
                <div class="clear"></div>



            </div>
            <div class="clear"></div>
        </div>

    @endif
@endforeach