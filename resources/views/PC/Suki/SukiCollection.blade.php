@include('PC.Suki.SukiHeader')
<style>
    .my_alert_list li{
        list-style: none;
        display: block;
    }
    .my_alert_list li a.onchange {
        box-shadow: 0 0 15px #0000001c;
    }
    .my_alert_list li a {
        color: #616161;
        width: 100%;
        display: inline-block;
        padding: 10px 30px;
    }
    .reply_me_content {
        padding: 5px 10px 5px 0px;
        flex-grow: 1;
    }
    .reply_me_content img{
        max-width: 60px;
        margin: 5px;
    }
    .reply_me_content blockquote{
        width: 60%;
        font-size: 12px;
        padding: 5px 10px;
        margin: 0 0 10px;
    }
    .origin_thread {
        background: #ffd3d3;
        border-width: 0px 3px 0px 3px;
        display: inline-block;
        width: 100%;
        padding: 9px 20px;
        border: 5px solid #f7c6cd;
        border-width: 0px 0px 0px 5px;
        color: #9a6363;
        background-color: #fdf5f5;
        /* background-image: linear-gradient(270deg, #f4f5f4 0%, #ffe8dd 93%); */
        border-radius: 3px;
    }
</style>
<div class="wp" style="    margin-top: 60px;
    background: #FFFFFF;
    display: flex;
    box-shadow: 0 0 15px #f7f7f7;
    border-radius: 3px;
    overflow: hidden;    border-top: 3px solid #fbcccc;">
    <div style="background:#FFFFFF;flex-grow: 1;">
        @foreach($data["my_collection"] as $value)
            <div style="display: flex;padding: 5px">
                <div style="float:left; padding: 5px 20px;">{{avatar($value->thread["thread_subject"]->authorid,50,100)}}</div>
                <div style="display: inline-block;float:left; flex: 1;">
                    <div style="margin-left: 5px;margin-bottom: 5px">
                        <h2 style="    margin: 0px;line-height: 15px;display: inline-block;"><a href="suki-thread-{{$value->thread["thread_subject"]->tid}}-1.html" style="font-size: 15px;color: #754242;margin-bottom: 3px;display: inline-block;font-weight: 700;"  target="_blank">{{$value->thread["thread_subject"]->subject}}</a></h2>
                        <span style="color: #000000;">(+{{$value->thread["thread_subject"]->replies}})</span>

                    </div>
                    <p>
                        <span style="color: #ccc;">{{\App\Http\DbModel\Forum_forum_model::$suki_forum[$value->thread["thread_subject"]->fid]}} · </span>
                        <span style="color: #ccc;">查看  {{$value->thread["thread_subject"]->views}} · </span>
                        <span style="color: #ccc;">点赞  {{$value->thread["thread_subject"]->star}}</span>
                    </p>
                    {{--<br>--}}
                    <p style="display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 1;    padding-right: 50px;overflow: hidden;">{{$value->thread["thread_subject"]->preview}}</p>


                </div>
                <div class="clear"></div>
            </div>
        @endforeach

    </div>
    <div class="clear"></div>

</div>
@include('PC.Suki.SukiFooter')