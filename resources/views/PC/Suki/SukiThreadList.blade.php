<style>
    .thread_author_avatar {
        display: block;
        margin: 0px auto 10px auto;
    }
</style>
<div class="thread_list" style="margin-top: 10px">
    @foreach($data["thread"] as $value)
        <div class="fourm_thread_items @if($value['top'])top @endif" style="  margin: 10px;  box-shadow: 0 0 10px #f1f1f1;background: #ffffff;padding: 10px;border-radius: 5px;"  >
            <div style="     display: flex;flex-flow:row; ">
                <div style="width: 100px">
                    {{avatar($value['authorid'],50,50,"thread_author_avatar","big")}}
                    <p style="text-align: center;" class="no_attn">{{$value['author']}}</p>
                </div>

                <div style="display: inline-block;float: left; flex: 1;">
                    <p>
                        <a href="thread-{{$value['tid']}}-1.html" style="font-size: 15px;margin-bottom: 3px;display: inline-block;"  target="_blank">{{$value['subject']}}</a>
                        <span style="color: #000000">(+{{$value['replies']}})</span>
                        <span>view : {{$value['views']}}</span>
                        <span class="show_date" style="color: #ccc;cursor: pointer;padding: 5px;">{{$value['last_post_date']}}</span>
                    </p>

                    <br>
                    <p style="display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 3;overflow: hidden;">{{$value['preview']}}</p>
                    @if(!empty($value['subject_images']))
                        <div class="thread_image_list" style="width:100%;float: left;">
                            @foreach($value['subject_images'] as $image)
                                <img  style="width: 90px;height: 90px;float: left;margin: 10px" src="{{$image}}">
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