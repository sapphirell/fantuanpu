{{--@include('PC.Common.Header')--}}
@include('PC.Common.HtmlHead')
@include('PC.Common.error')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/reg_login.style.css">

<div class="wp" ng-init="template=['PC','Common','User','Login']">
    <div class="bm">
        {{--<div class="bm_h">登录</div>--}}
        <div class="bm_c">
            <form class="form-horizontal" role="form" action="/do-repassword" method="post">
                <div style="padding: 10px;">
                    邮箱
                    <input type="email" value="{{$data['email']}}" class="form-control" style="" id="email" placeholder="Email" name="email" disabled>
                </div>
                <div  style="padding: 10px;">
                    密码
                    <input type="password" class="form-control" style=""  id="password" placeholder="Password" name="password">
                </div>
                <div  style="padding: 10px;">
                    重复输入密码
                    <input type="password" class="form-control" style=""  id="repassword" placeholder="Re-Password" name="re_password">
                </div>
                <div  style="padding: 10px;">
                    验证码
                    <input type="password" class="form-control" style=""  id="code" placeholder="Verification Code" name="code">
                </div>
                <div class="form-group" style="float: right;margin-right: 10px;">

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn  btn-info" id="post_reset">重置密码</button>
                    </div>
                </div>
                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
    </div>

</div>
<script>
    $(document).ready(function () {
        $("#post_reset").click(function (e) {
            e.preventDefault()
            var email       = $("#email").val();
            var password    = $("#password").val();
            var repassword  = $("#repassword").val();
            var code        = $("#code").val();
            var _token      = $("#token").val();
            if (!email || !password || !repassword || !code || !_token)
            {
                alert('缺少必填参数');
                return false;
            }
            if (password != repassword)
            {
                alert('两次输入密码不等');
                return false;
            }
            var data = {email:email,password:password,repassword:repassword,code:code,_token:_token}
            $.post('/do-repassword',data,function (event) {
                alert(event.msg)
                if (event.ret == 200)
                {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    $("#alert_ajax_login").trigger('click')
                }
                else
                {
                    alert(event.ret)
                }
            })
        })
    })
</script>
{{--@include('PC.Common.Footer')--}}