{{--@include('PC.Common.Header')--}}
@include('PC.Common.HtmlHead')
@include('PC.Common.error')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/reg_login.style.css">
<style>
    body {
        background: #ffffff
    }
    .form-horizontal {
        margin: 30px;
    }
    .fi {
        font-size: 16px;  box-shadow: 0 0 9999px #fff inset;  border-radius: 10px 10px 0 0;border-bottom-width: 0px;padding: 20px;
    }
    .form-control:focus {
        border-color: #ffadb6 !important;
    }
    @media screen and (max-width: 440px) {
        .form-horizontal {
            margin: 10px;
        }

    }
</style>
<div class="wp">
    <div class="">
        {{--<div class="bm_h">登录</div>--}}
        {{--<div style="margin: 20px">--}}
        {{--<a id="old_user" style="    " href="/old-user">忘记账户 / 密码?</a>--}}
        {{--<a href="/register" style="float: right;    color: #fcadb9;">注册一个新账户</a>--}}
        {{--</div>--}}
        <img src="/Image/suki-pink.png" style="width: 120px;margin: 35px auto 15px auto;display: block;">
        <div class="bm_c">
            <form class="form-horizontal" role="form" action="/do-login" method="post" style="">
                <div style="">
                    <input type="email" class="form-control fi" style="" id="email" placeholder="邮箱,登录账号" name="email">
                </div>
                <div style="padding: 0px;">
                    <input type="email" class="form-control fi" style="" id="username" placeholder="用户名" name="username">
                </div>
                <div style="padding: 0px;">
                    <input type="password" class="form-control fi" style=""  id="password" placeholder="密码" name="password">
                </div>
                <div style="padding: 0px;">
                    <input type="password" class="form-control fi" style=""  id="repassword" placeholder="重复输入密码" name="repassword">
                </div>
                {{--<div style="padding: 10px;    padding-bottom: 0;">--}}
                    {{--<input type="email" class="form-control"--}}
                           {{--style="font-size: 16px;  box-shadow: 0 0 9999px #fff inset;  border-radius: 10px 10px 0 0;border-bottom-width: 0px;padding: 20px;"--}}
                           {{--id="inputEmail3" placeholder="请输入用户名" name="email">--}}
                {{--</div>--}}
                {{--<div style="    padding: 10px;padding-top: 0;">--}}
                    {{--<input type="password" class="form-control"--}}
                           {{--style="font-size: 16px;   box-shadow: 0 0 9999px #fff inset;  border-radius: 0 0 10px 10px;padding: 20px;"--}}
                           {{--id="inputPassword3" placeholder="请输入密码" name="password">--}}
                {{--</div>--}}
                <div style="margin: 12px;">
                    <a id="old_user" href="/old-user" style="color: #fcadb9;">忘记密码</a>
                    <a  href="/register"  style="color: #fcadb9;float: right">没有账号?点击注册</a>
                </div>
                <button type="submit" class="btn  btn-info" style="    background-color: #ffb6c7;
    background-image: linear-gradient(180deg, #fbded9 0%, #ffa5b2 93%);border: 0px;width: 65px;height: 65px;
    border-radius: 100%;box-shadow: 0 3px 5px #ffe1e1;margin: 50px auto;display: inherit;font-size: 18px;">登录
                </button>
                <input type="hidden" name="form" value="{{$data['form']}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

            </form>
        </div>
    </div>

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
{{--@include('PC.Common.Footer')--}}