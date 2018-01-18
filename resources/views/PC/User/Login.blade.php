{{--@include('PC.Common.Header')--}}
@include('PC.Common.HtmlHead')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/reg_login.style.css">

<div class="wp" ng-init="template=['PC','Common','User','Login']">
    <div class="bm">
        {{--<div class="bm_h">登录</div>--}}
        <div class="bm_c">
            <form class="form-horizontal" role="form" action="/do-login" method="post">
                <div style="padding: 10px;">
                    <input type="email" class="form-control" style="" id="inputEmail3" placeholder="Email" name="email">
                </div>
                <div  style="padding: 10px;">
                    <input type="password" class="form-control" style=""  id="inputPassword3" placeholder="Password" name="password">
                </div>
                <div class="form-group" style="float: right;margin-right: 10px;">

                    <div class="col-sm-offset-2 col-sm-10">
                        <a id="old_user" href="/old-user">老账户寻回</a>
                        <button type="submit" class="btn  btn-info">登录</button>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
    </div>

</div>

{{--@include('PC.Common.Footer')--}}