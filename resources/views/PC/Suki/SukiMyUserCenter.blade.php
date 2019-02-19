@include('PC.Suki.SukiHeader')
<link rel="stylesheet" href="/Static/Style/switcher.css">
<mata></mata>
<style>
    .bm_h {
        background: #85a8ca;
    }
    .uc_table_left{    width: 100px;
        text-align: left;
        color: #6f6f6f;
        font-size: 15px;
        color: #dcc6c6;}
    .uc_table_right{}
    .uc_table_right p{
        font-size: 11px;
        font-weight: 900;
        padding: 10px;
        display: inline-block;
    }
    .code_form {
        display: none;
    }
    .user_info {    padding: 15px;margin: 0 auto ;
        width: 500px;margin: 0 auto;}
    .user_info_left {
        float: left;
        width: 30%;
        text-align: right;
        padding: 10px;
    }
    .user_info_right {
        float: left;
        width: 70%;
        text-align: center;
        padding: 10px;
    }
    .user_info_left > * ,.user_info_right > * {
        margin-bottom: 10px;
    }

    .user_info_right input,.user_info_right textarea{
        background: #f9f9f9;
    }
    .tab_m .cb-item_label {
        padding: 8px 10px;
        font-size: 14px;
        width: 150px;
        border-radius: 5px;
        border-color: white!important;
        width: 175px;
    }
    .tab_m .cb-item_marker_short-line {
        top: 7px;
        left: 1px;
    }
    .tab_m .cb-item_marker_long-line {
        top: 14px;
        left: 6px;
    }
    .tab_m .cb-item_animated-marker .cb-item_marker
    {
        width: 20px;
        height: 20px;
    }
    .cb-item_label{

    }
    .cb-item_animated-marker .cb-item_input:checked+.cb-item_label {
        background-color: #fdc8cc;
        background-image: linear-gradient(270deg, #fbded9 0%, #ffa5b2 93%);

    }
    .cb-item_animated-marker {
        --cb_bg-color_checked: #fdc8cc;
    }
    @media screen and (max-width: 960px) {

        .user_info {width: 100%}
        .user_info_left {padding: 2px}
        .user_info_left img {
            width: 40px!important;
            height: 40px!important;
            margin: 10px auto;
            display: block;
        }
        .user_info_right> span {display: none}
    }
</style>
<div class="wp" style="margin-top: 65px">
    <div class="bm_h white">
        <div class="tab_h">
            <div style="margin: 5px 10px;" class="onchange">个人信息</div>
            <div style="margin: 5px 10px;" >个人设置</div>
        </div>
    </div>
    <div class="bm_c">
        <div class="tab_m" style="background: #FFFFFF">
            <div class="user_info">


                @if(session("user_info")->group->groupid == 8)
                    <p class="mc_editor" style="    font-size: 14px;text-align: center" data="{{ $data['user_info']->email }}">注册邮箱
                        <span style="    color: #ffb0bb;font-weight: 900;">{{$data['user_info']->email}}</span>
                        等待验证
                    </p>
                    <p style="    font-size: 14px;text-align: center">在此之前无法发表主题和修改个人信息。</p>
                    <p style="text-align: center;margin-top: 20px;">
                        <a style="display: inline-block;padding: 0px 5px 0px 10px;border: 2px solid;border-radius: 10px;font-size: 12px;font-weight: 900;color: #6b5b5b;cursor: pointer;" class="send_code_mail">
                            验证邮件
                            <img width="25" src="/Static/image/common/next.png">
                        </a>
                    </p>
                    <div class="code_form">
                        <form action="/validate_email" method="get">
                            <input type="text" class="form-control score_value" name="code" id="code"  placeholder="验证码">

                            <input type="hidden" value="{{session('user_info')->email}}" id="email" name="email">
                            <input type="submit" class="enter_for_edit" style="margin: 10px auto;display: block;">
                        </form>
                    </div>
                @else
                    <div class="user_info_left">
                        {{avatar($data['user_info']->uid,80,100)}}
                        <p style="    margin-top: 45px;">设置新密码</p>
                        <p style="    margin-top: 100px;">登录邮箱</p>

                    </div>
                    <div class="user_info_right">
                        {{--<input type="text" class="form-control trans" value="{{$data['user_info']->username }}">--}}
                        <p style="text-align: left;    font-weight: 800;">{{$data['user_info']->username }}</p>
                        <textarea class="form-control trans sightml" style="    padding-bottom: 25px;">{{ $data['field_forum']->sightml }}</textarea>
                        <span style="    font-size: 11px;color: #e0e0e0;font-weight: 400;position: relative;     user-select:none;  left: 94px;bottom: 30px;">*最多显示72个字</span>
                        <input type="text" autocomplete="new-password" class="form-control trans old_password" value="" placeholder="请输入原密码">
                        <input type="text" autocomplete="new-password" class="form-control trans new_password" value="" placeholder="请输入新密码">
                        <input type="text" autocomplete="new-password" class="form-control trans repeat_password" value="" placeholder="请重复输入一次">
                        <input type="text" disabled class="form-control trans" value="{{ $data['user_info']->email }}">
                        <input type="submit" class="update_user_button" style="float: right;">
                    </div>
                @endif

                <div class="clear"></div>
            </div>
            <div style="border: 1px solid #FFFFFF">

                {{--<div class="cb-item_animated-marker" style="margin: 20px auto">--}}
                    {{--<div class="cb-item_animated-marker">--}}
                        {{--<input type="checkbox" id="cb-item_with-marker-2" class="cb-item_input" checked="">--}}
                        {{--<label for="cb-item_with-marker-2" class="cb-item_label">--}}
                            {{--<span class="cb-item_label-content">查看置顶帖</span>--}}
                            {{--<span class="cb-item_marker">--}}
                                {{--<span class="cb-item_marker_short-line"></span>--}}
                                {{--<span class="cb-item_marker_long-line"></span>--}}
                            {{--</span>--}}
                        {{--</label>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="clear"></div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function () {
        //申请获得邮箱验证码
        $(".send_code_mail").click(function (e) {
            $(".send_code_mail").text("请等待... "+" ");
            $(".send_code_mail").removeAttr('onclick');
            e.preventDefault();
            $.get("/send_validate_email?domain=suki",function (res) {
                alert(res.msg)
                $(".send_code_mail").remove()
                if (res.ret == 200)
                {
                    $(".code_form").slideDown();
                }
            })
        })
        //提交绑定邮箱验证码
        $(".enter_for_edit").click(function (e) {
            e.preventDefault();
            $.get("/validate_email",{
                email:$("#email").val(),
                code:$("#code").val()
            },function (res) {
                alert(res.msg)
                if (res.ret == 200)
                {
                    window.location.reload()
                }

            })
        })
        //提交修改
        $(".update_user_button").click(function (e) {
            e.preventDefault();

            var fd = {
                sightml:$(".sightml").val(),
                old_password : $(".old_password").val(),
                new_password : $(".new_password").val(),
                repeat_password : $(".repeat_password").val(),
            }
            $.post("/update_suki_user_info",fd,function (e) {
                alert(e.msg)
                if (e.ret == 200)
                {
                    location.reload()
                }
            })
        })
    })
</script>
@include('PC.Suki.SukiFooter')