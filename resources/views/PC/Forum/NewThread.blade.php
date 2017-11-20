@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<script src="/Static/Script/Web/forum.js"></script>
<script src="/Static/Script/wangEditor/wangEditor.min.js"></script>
<div class="wp" style="padding: 5px;margin-top: 29px;">
    <!--头部banner-->
    <form action="/post-thread" method="post">
        <textarea id="editor" >
            <p>欢迎使用 <b>wangEditor</b> 富文本编辑器</p>
        </textarea>
        {!! csrf_field() !!}
        <input type="submit">
    </form>
    <script type="text/javascript">
        var E = window.wangEditor
        var editor = new E('#editor')
        // 或者 var editor = new E( document.getElementById('#editor') )
        editor.customConfig.pasteFilterStyle = false
        editor.customConfig.uploadImgServer = '/upload'
        editor.customConfig.uploadImgMaxSize = 1.9 * 1024 * 1024
        editor.customConfig.uploadImgMaxLength = 5 // 一次可上传的图片数量
        editor.create()
    </script>
</div>
@include('PC.Common.Footer')