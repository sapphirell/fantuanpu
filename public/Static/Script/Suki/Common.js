
/**
 *
 */
function reset_checkout_forum() {
    $(".part_item").removeClass("selected_part_item");
    setting.lolita_viewing_forum.forEach(function (e) {
        $(".part_item.fid_"+e).addClass("selected_part_item");
    });
}
function construct_setting()
{
    var setting_input = $("#setting").val();
    if (setting_input)
    {
        setting = JSON.parse($("#setting").val());
        setting.lolita_viewing_forum = JSON.parse(setting.lolita_viewing_forum);
//        console.log(setting.lolita_viewing_forum)
        reset_checkout_forum();
    }
    else
    {
        console.log("初始化错误")
    }

}
function construct_edtior(id)
{
    var E = window.wangEditor
    editor = new E('#editor')
    editor.customConfig.colors = [
        '#000000',
        '#eeece0',
        '#1c487f',
        '#4d80bf',
        '#c24f4a',
        '#8baa4a',
        '#7b5ba1',
        '#46acc8',
        '#f9963b',
        '#ffffff'
    ]

    editor.customConfig.menus = [
        'bold',  // 粗体
        'fontSize',  // 字号
        'link',  // 插入链接
        'quote',  // 引用
//        'emoticon',  // 表情
        'image',  // 插入图片
    ]
    console.log(editor.customConfig);
    editor.customConfig.pasteFilterStyle = false
    editor.customConfig.uploadImgServer = 'https://image.fantuanpu.com/upload_file'
    editor.customConfig.uploadImgMaxSize = 8 * 1024 * 1024
    editor.customConfig.uploadImgMaxLength = 1 // 一次可上传的图片数量
    editor.customConfig.uploadImgParams = {
        form: 'editor'
    }
    editor.create()
}
/**
 *  增加或删除一个配置,并返回当前配置
 * @param fid
 * @param todo
 * @returns {*}
 */
function setting_and_return(fid,todo='add')
{
    fid = parseInt(fid);
    var index = setting.lolita_viewing_forum.indexOf(fid)
    if (todo == 'add' && index == -1)
        setting.lolita_viewing_forum.push(fid);
    else if (todo == 'del' && index > -1)
    {
        if (setting.lolita_viewing_forum.length > 1)
            setting.lolita_viewing_forum.splice(index,1)
        else
            alert("最少保留一个")
    }


//        console.log(todo);
//        console.log(setting.lolita_viewing_forum);

    $("#setting").val(JSON.stringify(setting));

    return setting.lolita_viewing_forum
}
$(document).ready(function () {
    var user_panel = 1;
    var user_poster = 1;
    var load_thread_nextpage = 2;
    construct_setting();
    construct_edtior();

    // console.log(setting);
    $(".user_info_btn").click(
        function () {
            if(user_panel % 2)
            {
                $(".transparent_shade").show();
                $(".user_info_panel").removeClass("zoomOutUp").css({display:"block"}).addClass("zoomInDown");
            }


            user_panel ++;

        }
    );
    $(".transparent_shade").click(function () {
        $(".transparent_shade").hide();
        $(".user_info_panel").removeClass("zoomInDown").addClass("zoomOutUp")
        user_panel ++;

    })
    //切换加载帖子
    $(".part_item").click(function (e) {
        e.preventDefault();

        var fid = $(this).attr("fid");
        var todo = $(this).hasClass('selected_part_item') ? "del" : "add";
//            console.log(fid,todo)
        var setting = setting_and_return(fid,todo);
        reset_checkout_forum();
        var thread_list = $.post("/suki-thread",{'view_forum':setting,'need' : "html"},function (e) {
//                console.log(e)
//                console.log(todo)
            $(".thread_list").remove();
            $(".list_container").append(e);
            load_thread_nextpage = 2;
        });
    });
    //点击加载更多
    $(".add_more_threadlist").click(function (e) {
        e.preventDefault();
        var fd = {'view_forum':setting.lolita_viewing_forum,'need' : "html","page":load_thread_nextpage}
        console.log(fd)
        $(".add_more_threadlist").text("加载中...")
        var thread_list = $.post("/suki-thread",fd,function (e) {
            console.log(e)
//                console.log(todo)
            if (e)
            {
                load_thread_nextpage++
                $(".list_container").append(e);
                $(".add_more_threadlist").text("加载更多")
            }
            else
            {
                $(".add_more_threadlist").text("已经到底啦~")
            }

        });
    })
    //弹出发帖框
    $("#alert_poster").click(function (e) {
        e.preventDefault();

        $(".shade").show()
        $(".poster_content").removeClass("zoomOutUp").css({display:"block"}).addClass("bounceIn")



    });
    $(".shade").click(function () {
        $(".shade").hide()
        $(".poster_content").removeClass("bounceIn").addClass("zoomOutUp")
    })
    //发一个新帖子
    $('#post_thread').click(function () {
        var edHtml = html2ubb(editor.txt.html())
        var subject = $('#subject').val()
        var _token = $('#new_thread_token').val()
        var fid     = $('#post_to_fid').val()
        var postData = {
            'subject' : subject,
            'message' : edHtml,
            '_token'  : _token ,
            'fid'     : fid
        };
        console.log(postData)
        $.post('/suki-new-thread',postData,function (event) {
            alert(event.msg);
            if (event.ret == 200)
            {
                location.reload();
            }
        })
    })

    //uc点击uc_add_more_thread加载更多该用户的帖子
    $(".uc_add_more_thread").click(function (e) {
        e.preventDefault();
        var page =  $(this).attr("page");
        var postData = {
            "uid": $(this).attr("uid"),
            "page": page,
            "need" : "html"
        };
        console.log(postData)
        $(this).attr("page",parseInt(page)+1)
        $.post("/suki_get_user_thread",postData,function (event) {
//                console.log(event)
            $(".suki_m .uc_user_thread:last").after(event)
            $(".suki_w .uc_user_thread:last").after(event)
            $(".suki_get_user_thread").attr("page",  page +1)
        })
    });
    //uc点击uc_add_more_thread加载更多该用户的帖子
    $(".suki_uc_add_more_thread").click(function (e) {
        e.preventDefault();
        var page =  $(this).attr("page");
        var postData = {
            "uid": $(this).attr("uid"),
            "page": page,
            "need" : "html"
        };
        $(this).attr("page",parseInt(page)+1)
        $.post("/suki_get_user_thread",postData,function (event) {
//                console.log(event)
            $(".uc_user_thread:last").after(event)
            $(".suki_get_user_thread").attr("page",  $(".suki_get_user_thread").attr("page")+1)
        })
    });
    //点击关注
    $(".follow").click(function (e) {
        e.preventDefault();
        var uid = $(this).attr("uid")
        var to_uid = $(this).attr("to_uid")
        var to_do = $(this).attr("to_do")
        var url = $(this).attr("href")
        var postData = {
            "uid": uid,
            "to_uid": to_uid,
            "to_do" : to_do
        };
        $.post(url,postData,function (event) {
//                console.log(event)
            alert(event.msg)
            if (event.ret == 200)
            {
                if (to_do == "follow")
                {
                    var follow_text = "关注中"
                    var next_to_do = "unfollow"
                }
                else
                {
                    var follow_text = "关注"
                    var next_to_do = "follow"
                }
                $(".follow").text(follow_text).attr("to_do",next_to_do)
            }

        })
    });
    //点击空间留言
    $(".add_board_message").click(function (e) {
        e.preventDefault();

        var board_message = $(".board_message").val();
        var postData = {
            "message": board_message,
            "uid" : $(".add_board_message").attr("uid")
        };

        $.post("/suki_reply_board",postData,function (event) {
            alert(event.msg)
            if (event.ret == 200)
            {
                window.location.reload();
            }
        })
    });
    //点击弹出申请好友窗口
    $(".add_suki_friend").click(function (e) {
        e.preventDefault();
        var friend_uid = $(this).attr("friend_uid");
        layer.open({
            type: 2,
            title: false,
            closeBtn: 0, //不显示关闭按钮
            shade: 0.8,
            shadeClose: true,
            area: ['300px', '160px'],
            offset: '100px',
            // skin: 'layui-layer-rim', //加上边框
            content: ['/add_suki_friend_view?friend_uid='+friend_uid, 'no']
        });
    })
    //toggle_search点击展开搜索框
    var toggle_search = 1;
    $(".toggle_search").click(function () {
        if (toggle_search % 2 == 1)
            $(".search_box").css({"width":"150px"})
        else
            $(".search_box").css({"width":"25px"})

        toggle_search++;
    });
    //头像蒙版
    $(".my_avatar").hover(function (event) {
        $(".ava_glass").fadeToggle("fast");
        event.stopPropagation();
    })
    //同意或拒绝好友申请
    $(".apply_suki_friends").click(function (e) {
        e.preventDefault();
        var apply_suki_friends_url = $(this).attr("href");
        var to_do = $(this).attr("to_do");
        var applicant_id = $(this).attr("applicant_id");
        var ship_id = $(this).attr("ship_id");
        $.post(apply_suki_friends_url,{to_do:to_do,applicant_id:applicant_id,ship_id:ship_id},function (res) {
            alert(res.msg);
//                window.location.reload();
        })
    })
    //弹出设置一个新的补款闹钟
    $(".add_new_clock").click(function (e) {
        layer.open({
            type: 2,
            title: false,
            closeBtn: 0, //不显示关闭按钮
            shade: 0.8,
            shadeClose: true,
            area: ['400px', '370px'],
            offset: '100px',
            // skin: 'layui-layer-rim', //加上边框
            content: ['/suki_clock_setting', 'no']
        });
    });
    var mini_alert_poster = $("#alert_poster").hasClass("mini")
    //宽度改变
    $(window).resize(function () {          //当浏览器大小变化时
        var height = $(window).width();
        if (height < 575 && !mini_alert_poster)
        {
            $("#alert_poster").addClass("mini");
            $("#alert_poster .pos_text").text("");
            mini_alert_poster = true;
        }
        if (height > 575 && mini_alert_poster)
        {
            $("#alert_poster").removeClass("mini");
            $("#alert_poster .pos_text").text("我要发帖");
            mini_alert_poster = false;
        }
    });
    //更换头像
    $(".my_avatar").click(function (e) {
        e.preventDefault();
        layer.open({
            type: 2,
            title: false,
            closeBtn: 2, //不显示关闭按钮
            shade: 0.8,
            shadeClose: true,
            // title:'登录',
            area: ['300px', '350px'],
            offset: '100px',
            // skin: 'layui-layer-rim', //加上边框
            content: ['/update_user_avatar', 'no']
        });
    })
})
