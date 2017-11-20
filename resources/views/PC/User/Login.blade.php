@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/reg_login.style.css">

<div class="wp" ng-init="template=['PC','Common','User','Login']">
    <div class="bm login_form">
        <div class="bm_h">登录</div>
        <div class="bm_c">
            <form class="form-horizontal" role="form" action="/do-login" method="post">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">邮箱</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label" name="password">密码</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="password">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn  btn-info">登录</button>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
    </div>

</div>

@include('PC.Common.Footer')