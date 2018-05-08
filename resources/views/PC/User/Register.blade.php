@include('PC.Common.Header')
@include('PC.Common.error')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/reg_login.style.css">

<div class="wp" style="margin-top: 30px">
    <div class="bm">
        {{--<div class="bm_h">注册</div>--}}
        <div class="bm_c">

        </div>
        <div class="bm_c">
            <form class="form-horizontal" role="form" action="/do-reg" method="post">
                <div style="padding: 10px;">
                    <input type="email" class="form-control" style="" id="inputEmail3" placeholder="账号" name="email">
                </div>
                <div  style="padding: 10px;">
                    <input type="password" class="form-control" style=""  id="inputPassword3" placeholder="密码" name="password">
                </div>
                <p style="    float: left;width: 84%;padding: 5px;line-height: 23px;">动物饭团扑成立于2011年,并于2013年建立饭团扑动漫论坛,经历了七年多的时间,以前还是学生党的成员也大多已经成为了一只工作汪,
                    虽然现实工作中大家都忙了起来,但仍然要多抽出来时间在<span style="text-decoration: line-through;">网上冲浪</span>(好土啊),总之希望大家能在饭团扑玩的开心,和喜欢的人面基!
                    <label>哇嘎哒 (｡・`ω´･)—> <input type="checkbox"></label>
                </p>
                <div class="form-group" style="float: right;margin-right: 10px;">

                    <div class="col-sm-offset-2 col-sm-10">
                        <a id="old_user" href="/login">已有账号?</a>
                        <button type="submit" class="btn  btn-info">注册</button>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
    </div>

</div>
@include('PC.Common.Footer')