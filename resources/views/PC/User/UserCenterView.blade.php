@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<link rel="stylesheet" type="text/css" href="/Static/Script/cropper/cropper.css">

<script src="/Static/Script/Web/forum.js"></script>
<style>
    .avatar_block {
        overflow: hidden;
        text-align: center;
        padding: 25px 8px ;
        }
    .user_change_avatar {
        border: 3px solid #fff;
        box-shadow: 0 3px 5px #ccc;
    }
    .user_info_table {
        width:80%;

    }
    .user_info_table .tr {
        margin: 5px;
    }
    .uc_table_left {
        text-align: center;
    }
    td{
        border-color: #FFFFFF!important;
    }
    .my_avatar {
        cursor: pointer;
    }
    .user-score-block {
        width: 30%;
        float: left;
        margin-top: 10px;
        margin-left: 7px;
    }
    .user-score-block * {
        text-align: center;
    }
    .user-score-block h3 {
        font-size: 15px;
    }
    .uc_button {
        margin-top: 15px;
    }
    .uc_button li{
        list-style: none;
        border-bottom: 1px dashed #ddd;
        text-align: center;
        padding: 5px;
        margin: 10px;
    }
    .uc_button li a {
        font-size: 14px;
        color: #7ac9e6;
        display: inline-block;
        width: inherit;
    }
    tr {
        width: inherit;
    }
</style>
<div class="shadow center" style="margin-top: 70px;background: #ffffff;width: 960px;overflow: hidden;">
    <div style="width: 250px;float: left;">
        <div style="padding: 10px;">
            <div class="center" style="width: 150px">
                {{avatar(session('user_info')->uid,150,100,'shadow my_avatar','big')}}
            </div>
            <h1 style="font-size: 17px;color: #60bcc3;width: inherit;text-align: center;margin-top: 10px;font-weight: 500">{{$data['user_info']->username}}</h1>
            <div style="width: inherit">
                <div class="user-score-block">
                    <h3>{{$data['user_count']['extcredits2']}}</h3>
                    <p>扑币</p>
                </div>
                <div class="user-score-block">
                    <h3>{{$data['user_count']['oltime']}}</h3>
                    <p>在线</p>
                </div>
                <div class="user-score-block">
                    <h3>{{$data['user_count']['friends']}}</h3>
                    <p>好友</p>
                </div>
                <div class="clear"></div>
            </div>
            <div>
                <ul class="uc_button">
                    <li><a href="">个人资料</a> </li>
                    <li><a href="">我的动态</a> </li>
                    <li><a href="">修改密码</a> </li>
                    <li><a href="">我的勋章</a> </li>
                </ul>
            </div>
        </div>
    </div>
    <div style="width:700px;float: right;height: 100%;box-shadow: 0px 0 15px #e6e6e6;">
        <div class="panel" style="display: block;height: 100%">@include('PC.UserCenter.EditUserData')</div>
        <div class="panel" style="display: none;height: 100%"></div>
        <div class="panel" style="display: none;height: 100%"></div>
        <div class="panel" style="display: none;height: 100%"></div>
    </div>
    <div class="clear"></div>
    <script src="/Static/Script/cropper/cropper.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".my_avatar").click(function (e) {
                e.preventDefault();
                layer.open({
                    type: 2,
                    title: false,
                    closeBtn: 0, //不显示关闭按钮
                    shade: 0.8,
                    shadeClose: true,
                    // title:'登录',
                    area: ['200px', '260px'],
                    offset: '100px',
                    // skin: 'layui-layer-rim', //加上边框
                    content: ['/update_user_avatar', 'no']
                });
            })
            //切换表单
            $(".uc_button li a").click(function (e) {
                e.preventDefault();
                var index = $(this).parent().index();
//                alert(index)
                $(".panel").hide().eq(index).show()
            });

        })

    </script>
</div>
@include('PC.Common.Footer')