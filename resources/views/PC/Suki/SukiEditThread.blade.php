<!doctype html>
@include('PC.Common.HtmlHead')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<script src="/Static/Script/wangEditor/wangEditor.min.js"></script>
<style>
    body {
        background: #fff;
        padding:20px;
    }
    input[type="button"], input[type="submit"] {
        border-color: #ef8a96;
        color: #ef8a96;
    }
    .return {
        color: #bcbcbc!important;
        border-color: #bcbcbc!important;
    }
</style>
<div id="editor">
    {!! bbcode2html($data["posts"]->message) !!}
</div>

<input type="hidden" value="{{$data["posts"]->tid}}" class="tid">
<input type="hidden" value="{{$data["posts"]->position}}" class="position">
<input type="submit" value="提交" class="submit" style="float: right;margin: 10px 10px 20px 0px;">
<input type="submit" value="取消" class="return" style="float: right;margin: 10px 10px 20px 0px;">
<script src="/Static/Script/Suki/Common.js"></script>
<script>
    $(document).ready(function () {
        $(".return").click(function (e) {
            e.preventDefault();
            parent.layer.closeAll();

        });
        $(".submit").click(function (e) {
            e.preventDefault()
            $(this).attr("disabled","disabled").css({"color":"#ddd","borderColor":"#ddd"});

            var edHtml = html2ubb(editor.txt.html())
            var postData = {
                "message": edHtml,
                "tid" : $(".tid").val(),
                "position" : $(".position").val(),
            };

            $.post("/update_suki_thread",postData,function (event) {

                alert(event.msg)
                if (event.ret == 200)
                {
                    window.parent.location.reload()
                }
                else{
                    $(".submit").removeAttr("disabled").css({"color":"#ef8a96","borderColor":"#ef8a96"});
                }
            })



        })

    });
</script>