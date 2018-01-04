{{--@include('PC.Common.Header')--}}
@include('PC.Common.HtmlHead')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/reg_login.style.css">

<div class="wp">
    <div class="bm">
        <div class="bm_h"><h1>账户寻回/回忆账号</h1></div>
        <div class="bm_c">
            <p>输入您用户名中包含的字符!</p>
            <form action="/get-old-user" method="get">
                <input type="text" name="name_str" class="form-control" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>

            <div>
                <table class="table table-striped">
                    <tr>
                        <td>#</td>
                        <td>头像</td>
                        <td>名字</td>
                        <td>邮箱</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

{{--@include('PC.Common.Footer')--}}