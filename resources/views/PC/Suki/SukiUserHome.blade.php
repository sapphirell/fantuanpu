@include('PC.Suki.SukiHeader')
<style>

    body {
        background: #FFFFFF;
    }
    .w-e-text-container {
        height: 120px!important;
        border: 1px solid #ccc!important;
    }
</style>
<div class="wp" style="margin-top:70px;">
    <div style="border-bottom: 2px dashed #fdc6c7;padding-bottom: 20px;">
        <div style="margin: 0 auto;width: 120px">{{avatar($data['user']->uid,120,"100")}}</div>
        <h1 style="    text-align: center;margin: 20px;font-size: 16px;font-weight: 900;color: #524a4f;">{{$data['user']->username}}</h1>
        <div>
            <a  class="follow"
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
            <a href="">加为好友</a>
            <a href="">私信</a>
        </div>
    </div>
    <div style="float: left;    width: 70%;">
        @include('PC.Suki.SukiUcThreadlist')

        <a href="" page="2" uid="{{$data['user']->uid}}" class="uc_add_more_thread">加载更多</a>
    </div>
    <div style="float: right;width: 30%;">
        @include('PC.Suki.SukiUcMessageBoard')
        <textarea class="form-control board_message"></textarea>
        <input type="submit" class="form-control add_board_message" uid="{{$data['user']->uid}}" >

    </div>



</div>

@include('PC.Suki.SukiFooter')