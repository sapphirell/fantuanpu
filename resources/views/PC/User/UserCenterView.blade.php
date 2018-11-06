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
        margin: 15px;
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
    .panel
    {
        border:0px;
        box-shadow: none;
    }
    .bm_h {
        background: #85a8ca;
    }
    .bm_c{
        height: 99.9%;
    }
</style>
<div class="center" style="margin-top: 35px;width: 960px;border-radius:5px;">
    <div style="background: url('/Image/transparent.png');height: 180px;margin-bottom: 20px" class="wp shadow ">

        <div class="my_avatar shadow" style="margin-top: 10px;    display: inline-block;">
            <div class="ava_glass" style="display:none;background: url('/Image/real-trans.png');width: 150px;height: 150px;position: absolute;border-radius: 100%;">
                <span style="position: absolute;bottom: 60px;width: 150px;display: inline-block;text-align: center;color: #fff;font-size: 16px;">更换</span>
            </div>
            {{avatar(session('user_info')->uid,150,100,' ','big')}}
        </div>

    </div>
    <div class="shadow " style="width: 250px;float: left;background: #ffffff;    border-bottom: 2px solid #00BCD4;border-radius: 0px 0px 5px 5px;">
        <div style="padding: 10px;">
            <div class="center" style="width: 20px">

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
    <div style="width:700px;float: right;">
        <div class="panel" style="display: block;">@include('PC.UserCenter.EditUserData')</div>
        <div class="panel" style="display: none;">@include('PC.UserCenter.MyThread')</div>
        <div class="panel" style="display: none;height: 100%">
            <div class="notice">功能暂缺</div>
        </div>
        <div class="panel" style="display: none;">
            @include('PC.UserCenter.MyMedal')
        </div>
    </div>
    <div class="clear"></div>
</div>
<script src="/Static/Script/cropper/cropper.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
//        window.setInterval(function () {
//            $("iframe").each(function() {
//                var index = $(this).index();
//                $("iframe").eq(index).height($(this).contents().find("body").height())
//            })
//        }, 200);

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
        //头像蒙版
        $(".my_avatar").hover(function (event) {
            console.log("hover1次")
            $(".ava_glass").fadeToggle("fast");
            event.stopPropagation();
        })
        //

    })

</script>
@include('PC.Common.Footer')