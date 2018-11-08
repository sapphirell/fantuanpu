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
    .user_info {    padding: 15px;}
</style>
<div class="bm_h pink">编辑资料</div>
<div class="bm_c">
    <div class="user_info">
        <form action="">
            <div>
                <div class="uc_table_left">昵称</div>
                <div class="uc_table_right">
                    <p class="mc_editor" data="{{ $data['user_info']->username }}">{{$data['user_info']->username}}</p>
                    {{--<input type="text" class="form-control">--}}
                </div>
            </div>
            <div>
                <div class="uc_table_left">用户组</div>
                <div class="uc_table_right">
                    <p class="mc_editor" data="{{ $data['user_info']->group->grouptitle }}">{{$data['user_info']->group->grouptitle}}</p>
                    {{--<input type="text" class="form-control">--}}
                </div>
            </div>
            <div>
                <div class="uc_table_left">邮箱</div>
                <div class="uc_table_right">
                    <p class="mc_editor" data="{{ $data['user_info']->email }}">{{$data['user_info']->email}}</p>

                    @if(session("user_info")->group->groupid == 8)
                        <p>因未验证邮箱,当前无法发表主题,<a class="send_code_mail">点此发送</a>验证邮件</p>
                    @endif
                    <div class="code_form">
                        <form action="/validate_email" method="get">
                            <div class="form-group">
                                <div class="price_group">
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control score_value" name="code" id="code"  placeholder="验证码">
                                    </div>
                                    <input type="hidden" value="{{session('user_info')->email}}" id="email" name="email">
                                    <div class="col-sm-3">
                                        <input type="submit" class="enter_for_edit" style="margin: 0px">

                                    </div>
                                    {{--<div class="clear"></div>--}}
                                </div>

                            </div>
                        </form>
                    </div>
                    {{--<input type="text" class="form-control">--}}
                </div>
            </div>
            <div>

                <div class="uc_table_left">签名档</div>
                <div class="uc_table_right">
                    {!!  $data['field_forum']->sightml !!}
                    <span></span>
                </div>
            </div>

            <div style="margin-top: 20px">
                @foreach($data['user_count']['extcredits'] as $key=>$value)
                    <div style="float: left">
                        <p class="uc_table_left">{{ $value }}</p>
                        <p class="uc_table_right">
                            {{$data['user_count'][$key]}}
                        </p>
                    </div>
                @endforeach
                <div class="clear"></div>
            </div>



        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        //申请获得邮箱验证码
        $(".send_code_mail").click(function (e) {
            $(".send_code_mail").text("请等待...");
            $(".send_code_mail").removeAttr('onclick');
            e.preventDefault();
            $.get("/send_validate_email",function (res) {
                alert(res.msg)
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
    })
</script>