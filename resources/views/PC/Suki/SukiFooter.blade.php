{{--websocket弹窗--}}
<div class="window_gift_alert trans" style="display: none"></div>
{{--遮罩--}}
<div class="shade" style="display: none"></div>
<div class="wp footer_cut clear"></div>
<div class="wp" style="margin-bottom: 20px;margin-top: 10px;">
    <a href="https://github.com/sapphirell/fantuanpu" style="padding: 10px;padding-right:0px;color: #d0d0d0;">Suki of Utopia ,</a>
    <span style="color: #d0d0d0;font-size: 11px;padding: 5px;padding-left: 0px">Prowerd by Sap.</span>
    <p  style="color: #d0d0d0;font-size: 11px;padding: 5px;">{{date("Y")}} .</p>
</div>
<div>
    <input type="hidden" id="username" class="form-control" disabled value="{{$data['im_username']}}" style="width: 250px;margin-bottom: 5px;">
    <input type="hidden" id="uid" disabled value="{{session('user_info')->uid ? : session('access_id')}}">
    <input type="hidden" id="avatar" disabled value="{{$data['avatar']}}">
    <input type="hidden" id="setting" disabled value="{{$data['setting']}}">

</div>
<script>


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
        setting = JSON.parse($("#setting").val());
        setting.lolita_viewing_forum = JSON.parse(setting.lolita_viewing_forum);
//        console.log(setting.lolita_viewing_forum)
        reset_checkout_forum();
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
        editor.customConfig.uploadImgMaxSize = 1.9 * 1024 * 1024
        editor.customConfig.uploadImgMaxLength = 5 // 一次可上传的图片数量
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
            setting.lolita_viewing_forum.splice(index,1)

//        console.log(todo);
//        console.log(setting.lolita_viewing_forum);

        $("#setting").val(JSON.stringify(setting));

        return setting.lolita_viewing_forum
    }
    $(document).ready(function () {
        var user_panel = 1;
        var user_poster = 1;
        construct_setting();
        construct_edtior();

        console.log(setting);
        $(".user_info_btn").click(
            function () {
                if(user_panel % 2)
                    $(".user_info_panel").removeClass("zoomOutUp").css({display:"block"}).addClass("zoomInDown")
                else
                    $(".user_info_panel").removeClass("zoomInDown").addClass("zoomOutUp")

                user_panel ++;

            }
        );
        //切换加载帖子
        $(".part_item").click(function (e) {
            e.preventDefault();

            var fid = $(this).attr("fid");
            var todo = $(this).hasClass('selected_part_item') ? "del" : "add";
            var setting = setting_and_return(fid,todo);
            reset_checkout_forum();
            var thread_list = $.get("/suki-thread",{'view_forum':setting,'need' : "html"},function (e) {
//                console.log(e)
//                console.log(todo)
                $(".thread_list").remove();
                $(".list_container").append(e);
            });
        });
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
//        $(".setting_forum").click(function () {
//
//        });
//
//        $(".setting_thread").click(function () {
//
//        });
    })

</script>


</body>
</html>