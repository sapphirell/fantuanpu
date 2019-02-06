{{--websocket弹窗--}}
<div class="window_gift_alert trans" style="display: none"></div>
{{--遮罩--}}
<div class="shade" style="display: none"></div>
<div class="transparent_shade" style="  display: none;  position: fixed;background: #ffffff00;width: 100%;height: 100%;top: 0;z-index: 1000000;"></div>

<div class="wp" style="margin-bottom: 20px;margin-top: 10px;">
    <div class="wp footer_cut clear"></div>
    <a href="https://github.com/sapphirell/fantuanpu" style="padding: 10px;padding-right:0px;color: #d0d0d0;">Suki of Utopia ,</a>
    <span style="color: #d0d0d0;font-size: 11px;padding: 5px;padding-left: 0px">Prowerd by Sap.</span>
    <p  style="color: #d0d0d0;font-size: 11px;padding: 5px;">{{date("Y")}} . <a href="/about_suki" style="color: #d0d0d0;font-size: 11px;padding: 5px;padding-left: 0px;">About Suki?</a></p>
</div>
<div>
    <input type="hidden" id="username" class="form-control" disabled value="{{$data['im_username']}}" style="width: 250px;margin-bottom: 5px;">
    <input type="hidden" id="uid" disabled value="{{session('user_info')->uid ? : session('access_id')}}">
    <input type="hidden" id="avatar" disabled value="{{$data['avatar']}}">
    <input type="hidden" id="setting" disabled value="{{$data['setting']}}">

</div>
<script src="/Static/Script/Suki/Common.js"></script>


</body>
</html>