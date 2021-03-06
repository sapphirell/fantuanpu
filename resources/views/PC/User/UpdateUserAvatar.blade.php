{{--@include('PC.Common.Header')--}}
@include('PC.Common.HtmlHead')
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
        width:50%;
        margin: 0 auto;
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
    body {background: #ffffff}
    .croping:active {
        position: relative;
        top:2px;
        background: #eee;
    }
</style>
<div class="" style="background: #ffffff">
    <div>
        <div style="margin-top: 40px">
            <form action="/uc-do-upload-avatar" method="post" enctype="multipart/form-data" style="    margin: 0 auto;width: 200px;text-align: center;">
                <div style="width: inherit;height: 200px;box-shadow: 0px -1px 4px #ddd;">
                    {{avatar(session('user_info')->uid,200,0,'user_change_avatar','big')}}
                    {{--<img src="" id="user_change_avatar">--}}
                </div>
                <div style="margin-top: 20px;">
                    <label class="btn btn-primary btn-upload"  style="padding: 4px 12px;    margin: 0px;"  for="inputImage" title="Upload image file">
                        <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
                        <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="Import image with Blob URLs">
                        选择
                        <i class="fa fa-upload"></i>
                        </span>
                    </label>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" style="margin: 0px;" class="btn btn-default croping" value="裁切">
                    <input id="setCanvasData" type="hidden" name="position">
                </div>
                <p style="margin-top: 8px">* 请选择2MB以下的图片</p>
                <p>* 裁切满意后刷新网页即可。</p>
            </form>
        </div>
    </div>
    <div class="clear"></div>

</div>
<script src="/Static/Script/cropper/cropper.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $('.user_change_avatar').cropper({
            aspectRatio: 1/1,
            crop: function(e) {
                console.log(e.detail.height);
                //生成JSON字串
                var CanvasX = e.detail.x.toFixed(0);
                var CanvasY = e.detail.y.toFixed(0);
                var CanvasWidth = e.detail.width.toFixed(0);
                var CanvasHeight = e.detail.height.toFixed(0);

                $('#setCanvasData').val('{"x":"'+CanvasX+'","y":"'+CanvasY+'","width":"'+CanvasWidth+'","height":"'+CanvasHeight+'"}');
            }
        });

        $('.docs-tooltip').click(function () {
            var $image = $('.user_change_avatar');
            var $inputImage = $('#inputImage');
            var URL = window.URL || window.webkitURL;
            var blobURL;

            if (URL) {
                $inputImage.change(function () {
                    var files = this.files;
                    var file;

                    if (!$image.data('cropper')) {
                        return;
                    }

                    if (files && files.length) {
                        file = files[0];

                        if (/^image\/\w+$/.test(file.type)) {
                            blobURL = URL.createObjectURL(file);
                            $image.one('built.cropper', function () {
                                URL.revokeObjectURL(blobURL);
                            }).cropper('reset').cropper('replace', blobURL);

                        } else {
                            window.alert('请选择一个图片');
                        }
                    }
                })
            }

        })



    })

</script>