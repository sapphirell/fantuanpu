{{--@include('PC.Common.Header')--}}
@include('PC.Common.HtmlHead')

@include('PC.Common.error')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/reg_login.style.css">
<style>
    body {    background: #fff;    padding: 8px;}
</style>
<div class="wp" style="margin-top: 10px;min-height: 550px">

            <form class="form-horizontal" role="form" action="/do-reg" method="post">
                <div style="padding: 10px;">
                    <input type="email" class="form-control" style="" id="email" placeholder="邮箱,登录账号" name="email">
                </div>
                <div style="padding: 10px;">
                    <input type="email" class="form-control" style="" id="username" placeholder="用户名" name="username">
                </div>
                <div  style="padding: 10px;">
                    <input type="password" class="form-control" style=""  id="password" placeholder="密码" name="password">
                </div>
                <div  style="padding: 10px;">
                    <input type="password" class="form-control" style=""  id="repassword" placeholder="重复输入密码" name="repassword">
                </div>
                {!! $data['reg_message'] !!}
                {{csrf_field("reg_csrf")}}
                <div class="form-group" style="float: right;margin-right: 10px;position: absolute;bottom: 0px;right: 0px;">

                    <div class="col-sm-offset-2 col-sm-10">
                        <a id="old_user" href="/login">忘记账号?</a>
                        <button type="submit" class="btn  btn-info" id="do_reg">注册</button>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>


</div>
<script>
    $(document).ready(function () {
        var csrf = $("#reg_csrf").val();
        $("#username").blur(function () {
            var username = $(this).val()
            $.post("/do-checkUsername",{_token:csrf,username:username},function (e) {
                if (e.data.exists == false)
                {
                    $("#username").removeClass('false_input').addClass('true_input')
                }
                else if(e.data.exists == true)
                {
                    $("#username").removeClass('true_input').addClass('false_input')
                }
            })
        })
        $("#email").blur(function () {
            var email = $("#email").val()
            if(!email)
            {
                $("#email").removeClass('true_input').addClass('false_input')
                return false;
            }
            $.post("/do-checkEmail",{_token:csrf,email:email},function (e) {
                if (e.data.exists == false)
                {
                    $("#email").removeClass('false_input').addClass('true_input')
                }
                else if(e.data.exists == true)
                {
                    $("#email").removeClass('true_input').addClass('false_input')
                }
            })
        })
        $("#password").blur(function () {
            var password = $("#password").val()
            var repassword = $("#repassword").val()
            if (password == repassword)
            {
                $("#repassword").removeClass('false_input').addClass('true_input')
                $("#password").removeClass('false_input').addClass('true_input')
            }
            else
            {
                $("#repassword").removeClass('true_input').addClass('false_input')
                $("#password").removeClass('true_input').addClass('false_input')
            }
        })
        $("#repassword").blur(function () {
            var password = $("#password").val()
            var repassword = $("#repassword").val()
            if (password == repassword)
            {
                $("#repassword").removeClass('false_input').addClass('true_input')
                $("#password").removeClass('false_input').addClass('true_input')
            }
            else
            {
                $("#repassword").removeClass('true_input').addClass('false_input')
                $("#password").removeClass('true_input').addClass('false_input')
            }
        })
        $("#do_reg").click(function (event) {
            event.preventDefault()
            email       =  $("#email").val();
            password    =  $("#password").val();
            repassword  =  $("#repassword").val();
            username    =  $("#username").val();
            data = {_token:csrf,email:email,password:password,repassword:repassword,username:username};
            console.log(data)
            $.post('/do-reg',data,function (e) {
                alert(e.msg)
                parent.location.reload();
            })
        })
    })
</script>
@include('PC.Common.Footer')