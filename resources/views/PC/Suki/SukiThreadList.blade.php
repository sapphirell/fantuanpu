<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<div class="thread_list" style="margin-top: 10px">
    @foreach($data["thread"] as $value)
        <div class="fourm_thread_items @if($value['top'])top @endif" style="  margin: 10px;  box-shadow: 0 0 10px #f1f1f1;background: #ffffff;padding: 10px;border-radius: 5px;"  >
            <div style="display: flex;flex-flow:row;    overflow: hidden; ">

                @if($value['anonymous'] == 2 )
                    <div class="news_author_avatar_cotainer" >
                        <span  style="display: block;margin: 0px auto 10px auto;">
                            {{avatar(0,50,50,"thread_author_avatar","big","margin: 0 auto;display: block;")}}
                        </span>
                        <span style="text-align: center;    width: inherit; display: inline-block;   color: #777;" class="no_attn">匿名</span>
                    </div>
                @else
                    <div class="news_author_avatar_cotainer" >
                        <a href="/suki-userhome-{{$value['authorid']}}.html" style="display: block;margin: 0px auto 10px auto;">
                            {{avatar($value['authorid'],50,50,"thread_author_avatar","big","margin: 0 auto;display: block;")}}
                        </a>
                        <a href="/suki-userhome-{{$value['authorid']}}.html" style="text-align: center;    width: inherit; display: inline-block;   color: #777;" class="no_attn">{{$value['author']}}</a>
                    </div>
                @endif
                <div style="display: inline-block;float: left; flex: 1;">
                    <div>
                        <a href="suki-thread-{{$value['tid']}}-1.html" style="font-size: 15px;color: #754242;margin-bottom: 3px;display: inline-block;font-weight: 700;"  target="_blank">{{$value['subject']}}</a>
                        <span style="color: #000000;">(+{{$value['replies']}})</span>
                        <span class="show_date" style="color: #ccc;cursor: pointer;padding: 5px;float: right;font-size: 12px">{{ format_time($value['lastpost']) }}</span>
                    </div>
                    <p>
                        <span style="color: #ccc;">{{$value['suki_fname']}} · </span>
                        <span style="color: #ccc;">查看  {{$value['views']}} · </span>
                        <span style="color: #ccc;">点赞  {{$value['star']}}</span>
                    </p>
                    {{--<br>--}}
                    <p style="display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 1;    padding-right: 50px;overflow: hidden;">{{$value['preview']}}</p>
                    @if(!empty($value['subject_images']))
                        <div class="thread_image_list" style="width:100%;float: left;">
                            @foreach($value['subject_images'] as $image)
                                <img  style="width: 90px;height: 90px;float: left;margin: 5px" src="{{$image}}">
                            @endforeach
                        </div>
                    @endif

                </div>
                <div class="clear"></div>
            </div>

            <div class="clear"></div>
        </div>
    @endforeach
</div>
