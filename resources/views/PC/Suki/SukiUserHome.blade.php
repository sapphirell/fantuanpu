@include('PC.Suki.SukiHeader')
<style>

    body {
        background: #FFFFFF;
    }
</style>
<div class="wp" style="margin-top:70px;">
    <div>
        <div style="margin: 0 auto;width: 120px">{{avatar($data['user']->uid,120,"100")}}</div>
        <h1 style="    text-align: center;margin: 20px;font-size: 16px;font-weight: 900;color: #524a4f;border-bottom: 2px dashed #fdc6c7;padding-bottom: 20px;">{{$data['user']->username}}</h1>
    </div>
</div>

@include('PC.Suki.SukiFooter')