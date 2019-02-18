@include('PC.Suki.SukiHeader')
<style>

    body {
        background: #fafafa;
    }
    .w-e-text-container {
        height: 120px!important;
        border: 1px solid #ccc!important;
    }
    .follow {
        background: #fcc;
        color: #fff;
        padding: 5px 15px;
        display: inline-block;
        border-radius: 3px;
        text-decoration:  none!important;
        float: right;
    }
    .add_suki_friend {
        background: #fcc;
        color: #fff;
        padding: 5px 15px;
        display: inline-block;
        border-radius: 3px;
        text-decoration: none!important;
        float: right;
        margin-left: 10px;
        text-align: center;
    }
    .post_letter {
        background: #fcc;
        color: #fff;
        padding: 5px 15px;
        display: inline-block;
        border-radius: 3px;
        text-decoration: none!important;
        float: right;
        margin-left: 10px;
        text-align: center;
    }
    .user_info_content a {
        text-decoration: none!important;
    }
    .follow:hover ,.add_suki_friend:hover ,.post_letter:hover{
        color: #a57d7d;
    }
    .uc_add_more_thread {
        float: right;
        margin: 20px 10px;
    }

    .tab_h > div {
         border: 0px;
        float: none;
        margin: 0px 20px;
    }
    .tab_h div span {
        color: #7B6164;
        font-size: 15px;
    }
    .tab_h div.onchange span {
        color: #EF8A96;
        font-size: 15px;
    }
    .tab_h {
        /*border:0px;*/
        padding:10px 20px;
        align-items: center;
        justify-content: center;
        display: flex;
        border-color: #FBFBFB;
    }
    .tab_h > div:last-child
    {
        border: 0px;
    }
</style>
<div class="wp none_960" style="margin-top:70px;margin-bottom: 20px">
    <div style="padding-bottom: 20px;background: #FFFFFF;box-shadow: 0 0 5px #eee;padding: 20px;margin-bottom: 10px;">
        <div style="width: 70%;float:left;">
            <div style="width: 120px ; padding: 3px;border-radius: 28px;float: left;">{{avatar($data['user']->uid,110,"20")}}</div>
            <div style="    float: left;margin-left: 20px;">
                <h1 style=" display: inline-block ; text-align: left;font-size: 16px;font-weight: 900;color: #524a4f;">{{$data['user']->username}}</h1>
                <p style="margin: 10px 5px;">{{$data["field_forum"]->sightml}}</p>
            </div>
            <div class="clear"></div>
        </div>

        <div style="float: left;width: 30% ">
            @if($data["user_info"]->uid != $data['user']->uid)
            <div>
                <a href="" class="post_letter trans">私信</a>
                <a href="/add_suki_friend_view" class="add_suki_friend trans" friend_uid="{{$data['user']->uid}}">加好友</a>
                <a  class="follow trans"
                    uid="{{$data['user_info']->uid}}"
                    to_uid="{{$data['user']->uid}}"
                    to_do="{{$data["has_follow"]?"unfollow":"follow"}}"
                    href="/suki_follow_user">
                    @if($data["has_follow"])
                        关注中
                    @else
                        关注
                    @endif
                </a>
                <div class="clear"></div>
            </div>
            @endif
            <div class="user_info_content" style="border: 0px;margin: 30px 5px 0px 0px;float: right;width: 200px;">
                <div>
                    <p href="/suki-myfollow?like_type=1" class="user_info_content_value trans">{{$data['user_relation']["sukifollow"]}}</p>
                    <p href="/suki-myfollow?like_type=1" class="user_info_content_description trans">关注</p>
                </div>
                <div>
                    <p href="/suki-myfollow?like_type=1" class="user_info_content_value trans">{{$data['user_relation']["followsuki"]}}</p>
                    <p href="/suki-myfollow?like_type=1" class="user_info_content_description trans">粉丝</p>
                </div>
            </div>
        </div>

        <div class="clear"></div>
    </div>
    <div style="float: left;    width: 70%;">
        <div class="suki_w" style="margin: 10px 20px 0px 0px;background: #fff;padding: 10px;box-shadow: 0 0 5px #eee;border-radius: 5px;">
            <h2 style="font-size: 16px;font-weight: 900;color: #866767;">我的帖子</h2>
            @include('PC.Suki.SukiUcThreadlist')
            <a href="" page="2" uid="{{$data['user']->uid}}" class="uc_add_more_thread">加载更多</a>
            <div class="clear"></div>
        </div>

    </div>
    <div style="float: right;width: 30%;background: #FFFFFF;margin-top: 10px;padding: 10px;box-shadow: 0 0 5px #eee;border-radius: 5px;">
        <h3 style="font-size: 16px;font-weight: 900;color: #866767;margin-bottom: 20px;margin-left: 10px;">留言板</h3>
        @include('PC.Suki.SukiUcMessageBoard')
        <textarea class="form-control board_message" style="margin-bottom: 10px;background: #fafafa;margin-left: 10px;margin-right: 10px;width: 100%;width: 250px;border: 0px;"></textarea>
        <input type="submit" class="form-control add_board_message" style="margin-left: 10px;width: 100px" uid="{{$data['user']->uid}}" >

    </div>

    <div class="clear"></div>

</div>
<div class="wp show_960 " style="margin-top:70px;margin-bottom: 20px">
    <div style="background:#FFFFFF;display: flex;padding-bottom: 20px">
        <div class="this_user_info" style="float:left;width:200px ">
            <div style="    width: 90px;padding: 5px;border-radius: 100%;display: block;margin: 0 auto;box-shadow: 0 0 5px #ffc9c9;background: #fff;margin-top:20px;">{{avatar($data['user']->uid,80,"100")}}</div>
            @if($data["user_info"]->uid != $data['user']->uid)
                <div>

                    <a  class="follow trans"
                        style="    float: none;margin: 10px auto;display: block;width: 70px;text-align: center;"
                        uid="{{$data['user_info']->uid}}"
                        to_uid="{{$data['user']->uid}}"
                        to_do="{{$data["has_follow"]?"unfollow":"follow"}}"
                        href="/suki_follow_user">
                        @if($data["has_follow"])
                            关注中
                        @else
                            关注
                        @endif
                    </a>
                    <div style="    justify-content: center;display: flex;">
                        <a href="" class="post_letter trans" style="    background: #fff;color: #ffb0b0;border: 1px solid #f7cccb;">发私信</a>
                        <a href="/add_suki_friend_view" class="add_suki_friend trans" friend_uid="{{$data['user']->uid}}"
                           style="    background: #fff;color: #ffb0b0;border: 1px solid #f7cccb;">加好友</a>

                    </div>

                    <div class="clear"></div>
                </div>
            @endif
        </div>
        <div class="this_user_description" style="flex-grow: 1;padding: 10px 23px;">
            <h1 style="font-size: 16px;font-weight: 500;color: #a58181;text-align: right;">{{$data['user']->username}}</h1>
            <p style="margin: 10px 5px;">{{$data["field_forum"]->sightml}}</p>
            <div class="user_info_content" style="border: 0px;margin: 30px 5px 0px 0px;float: right;width: 200px;">
                <div>
                    <p href="/suki-myfollow?like_type=1" class="user_info_content_value trans">{{$data['user_relation']["sukifollow"]}}</p>
                    <p href="/suki-myfollow?like_type=1" class="user_info_content_description trans">关注</p>
                </div>
                <div>
                    <p href="/suki-myfollow?like_type=1" class="user_info_content_value trans">{{$data['user_relation']["followsuki"]}}</p>
                    <p href="/suki-myfollow?like_type=1" class="user_info_content_description trans">粉丝</p>
                </div>
            </div>
        </div>
    </div>
    {{--用户内容--}}
    <div style="margin-top: 10px;background: #FFFFFF;">
        <div class="tab_h">
            <div class="onchange">
                <span>帖子</span>

            </div>
            <div>
                <span>留言</span>
            </div>
        </div>
        <div class="tab_m">
            <div class="suki_m">
                @if($data["thread"]->isEmpty())
                    <p style="color: #ddd;text-align: center;margin: 20px;">ta还没有发帖子哦</p>
                @endif
                @include('PC.Suki.SukiUcThreadlist')
                <a href="" style="    margin: 20px 10px;display: block;float:none;text-align: center;color: #866c6f;" page="2" uid="{{$data['user']->uid}}" class="uc_add_more_thread">加载更多</a>
                <div class="clear"></div>
            </div>
            <div>
                <div style="margin-top: 10px;padding: 10px;border-radius: 5px;">
                    @include('PC.Suki.SukiUcMessageBoard')
                    <textarea class="form-control board_message" style="margin-bottom: 10px;background: #fafafa;margin-left: 10px;margin-right: 10px;width: 100%;width: 250px;border: 0px;"></textarea>
                    <input type="submit" class="form-control add_board_message" style="margin-left: 10px;width: 100px" uid="{{$data['user']->uid}}" >

                </div>
            </div>
        </div>
    </div>
</div>
@include('PC.Suki.SukiFooter')