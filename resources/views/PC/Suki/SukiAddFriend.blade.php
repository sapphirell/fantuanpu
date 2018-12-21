@include('PC.Common.HtmlHead')
<style>
    body {
        background: #EEEEEE;
        padding: 10px;
    }
</style>
<h1 style="font-size: 13px;color: #000;font-weight: 200;margin-bottom: 10px;">申请添加为好友</h1>
<textarea class="form-control text"></textarea>
<input type="hidden" value="{{$data["request"]["friend_uid"]}}" class="friend_id">
<input type="submit" value="发送" class="submit">

<script>
    $(document).ready(function () {
        $(".submit").click(function (e) {
            e.preventDefault()
            var postData = {
                "message": $(".text").val(),
                "friend_id" : $(".friend_id").val()
            };

            $.post("/add_suki_friend",postData,function (event) {
                alert(event.msg)
                if (event.ret == 200)
                {
                    window.parent.location.reload()
                }
            })
        })

    });
</script>