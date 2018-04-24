{{--@include('PC.Common.Header')--}}
@include('PC.Common.HtmlHead')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/reg_login.style.css">

<div class="wp" style="min-height: 500px;">
    <div class="bm" style="background: #ffffff">
        {{--<div class="bm_h">登录</div>--}}
        <div class="bm_c">
            <form class="form-horizontal" role="form" action="/get-email" method="post">
                <div style="padding: 10px;">
                    <input type="email" class="form-control" style="" id="inputEmail3" placeholder="Email" name="email" value="{{$data['by-email']}}">
                </div>
                <div class="form-group" style="float: right;margin-right: 10px;">
                    <div class="col-sm-offset-2 col-sm-10">
                        @if(empty($data['backUrl']))
                        <a href="{{$data['backUrl']}}">返回</a>
                        @endif
                        <button type="submit" class="btn  btn-info" style="margin: 10px;box-sizing: border-box;float: right;">给上述email发送验证邮件</button>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
    </div>

</div>

{{--@include('PC.Common.Footer')--}}