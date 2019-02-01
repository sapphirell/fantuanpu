<!doctype html>
@include('PC.Common.HtmlHead')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
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
    label {
        margin: 10px;
        display: inline-block;
    }
    label span {
        margin: 0px 8px;
        color: #7B6164;
    }
    textarea {
        background:rgba(245,245,245,1)!important;
        border-radius:5px;
        border:0px!important;
    }
</style>
<div>
    <input type="hidden" value="{{$data['origin']}}" class="origin">
    <label>
        <input type="radio" name="type" value="色情">
        <span>色情</span>
    </label>
    <label>
        <input type="radio" name="type" value="广告">
        <span>广告</span>
    </label>
    <label>
        <input type="radio" name="type" value="诈骗">
        <span>诈骗</span>
    </label>
    <label>
        <input type="radio" name="type" value="辱骂">
        <span>辱骂</span>
    </label>
    <label>
        <input type="radio" name="type" value="暴露我的隐私">
        <span>暴露我的隐私</span>
    </label>
    <label>
        <input type="radio" name="type" value="其它">
        <span>其它</span>
    </label>
    <textarea class="form-control message"></textarea>
</div>




<input type="hidden" value="{{$data["posts"]->tid}}" class="tid">
<input type="hidden" value="{{$data["posts"]->position}}" class="position">
<input type="submit" value="提交" class="submit" style="float: right;margin: 10px 0px 20px 0px;">
<input type="submit" value="取消" class="return" style="float: right;margin: 10px 10px 20px 0px;">
<script>
    $(document).ready(function () {
        $(".return").click(function (e) {
            e.preventDefault();
            parent.layer.closeAll();

        });
        $(".submit").click(function (e) {
            e.preventDefault()
            var type = $(":radio:checked").val()
            var message = $(".message").val();
            var origin = $(".origin").val();
            var postData = {
                message : message,
                type : type,
                origin : origin
            };
            console.log(postData)
            $.post("/suki_post_report",postData,function (event) {
                alert(event.msg)
                if (event.ret == 200)
                {
                    window.parent.location.reload()
                }
            })



        })

    });
</script>