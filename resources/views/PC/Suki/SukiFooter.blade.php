
<div class="window_gift_alert trans" style="display: none">
</div>
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

//        console.log(index);
        $("#setting").val(JSON.stringify(setting));

        return setting.lolita_viewing_forum
    }
    $(document).ready(function () {
        var user_panel = 1;
        construct_setting();

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
            var thread_list = $.get("/suki-thread",{'view_forum':setting},function (e) {
                console.log(e)
                console.log(todo)

            });
        });
    })

</script>


</body>
</html>