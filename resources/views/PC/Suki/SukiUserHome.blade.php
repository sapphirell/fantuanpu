@include('PC.Suki.SukiHeader')
<style>

    body {
        background: #FFFFFF;
    }
</style>
<div class="wp" style="margin-top:70px;">
    <div style="border-bottom: 2px dashed #fdc6c7;padding-bottom: 20px;">
        <div style="margin: 0 auto;width: 120px">{{avatar($data['user']->uid,120,"100")}}</div>
        <h1 style="    text-align: center;margin: 20px;font-size: 16px;font-weight: 900;color: #524a4f;">{{$data['user']->username}}</h1>
        <div>
            <a href="">关注中</a>
            <a href="">加为好友</a>
            <a href="">私信</a>
        </div>
    </div>

    <div>
        @include('PC.Suki.SukiUcThreadlist')

        <a href="" page="2" uid="{{$data['user']->uid}}" class="uc_add_more_thread">加载更多</a>
    </div>
</div>

@include('PC.Suki.SukiFooter')