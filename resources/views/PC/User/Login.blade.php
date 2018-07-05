{{--@include('PC.Common.Header')--}}
@include('PC.Common.HtmlHead')
@include('PC.Common.error')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/reg_login.style.css">
<style>
    body { background: #ffffff}
</style>
<div class="wp">
    <div class="">
        {{--<div class="bm_h">登录</div>--}}
        <div style="margin: 20px">
            <a id="old_user" href="/old-user">忘记账户 / 密码?</a>
        </div>

        <div class="bm_c">
            <form class="form-horizontal" role="form" action="/do-login" method="post">
                <div style="padding: 10px;    padding-bottom: 0;">
                    <input type="email" class="form-control" style="    border-radius: 5px 5px 0 0;border-bottom-width: 0px;padding: 20px;" id="inputEmail3" placeholder="请输入邮箱" name="email">
                </div>
                <div  style="    padding: 10px;padding-top: 0;">
                    <input type="password" class="form-control" style="    border-radius: 0 0 5px 5px;padding: 20px;"  id="inputPassword3" placeholder="请输入密码" name="password">
                </div>
                <button type="submit" class="btn  btn-info" style="width: 55px;height: 55px;border-radius: 100%;box-shadow: 0 3px 5px #ccc;margin: 50 auto;    display: inherit;">登录</button>
                {{--<div class="form-group" style="float: right;margin-right: 10px;">--}}

                    {{--<div class="col-sm-offset-2 col-sm-10">--}}

                        {{--<button type="submit" class="btn  btn-info" style="">登录</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <input type="hidden" name="form" value="{{$data['form']}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <span style="    position: relative;color: #b1a1a1; top: 12px;margin-left: 94px;">使用第三方账号登录</span>
                <hr style="margin-top: 0px">
            </form>
        </div>
    </div>

</div>

{{--@include('PC.Common.Footer')--}}