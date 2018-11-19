
<div class="window_gift_alert trans" style="display: none">
</div>
<div class="wp footer_cut clear"></div>
<div class="wp" style="margin-bottom: 20px;margin-top: 10px;">
    <a href="https://github.com/sapphirell/fantuanpu" style="padding: 10px;padding-right:0px;color: #d0d0d0;">Suki of Utopia ,</a>
    <span style="color: #d0d0d0;font-size: 11px;padding: 5px;padding-left: 0px">Prowerd by Sap.</span>
    <p  style="color: #d0d0d0;font-size: 11px;padding: 5px;">{{date("Y")}} .</p>
</div>
<div>
    <input type="hidden" id="username" class="form-control" disabled value="{{$data['im_username']}}" style="width: 250px;margin-bottom: 5px;">
    <input type="hidden" id="uid" disabled value="{{session('user_info')->uid ? : session('access_id')}}">
    <input type="hidden" id="avatar" disabled value="{{$data['avatar']}}">
</div>
<script>



</script>


</body>
</html>