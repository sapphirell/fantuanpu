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
</style>
<div class="wp shadow" style="padding: 5px;margin-top: 70px;background: #ffffff">
    <div style="width: 250px;float: left;">
        <div style="padding: 10px;">
            <div class="center" style="width: 150px">
                {{avatar(session('user_info')->uid,150,100,'shadow my_avatar','big')}}
            </div>

            <h1 style="font-size: 17px;width: inherit;text-align: center;margin-top: 10;">{{$data['user_info']->username}}</h1>
        </div>
    </div>
    <div style="width:600px;float: right;">
        <div class="bm_h">编辑资料</div>
        <div class="bm_c">
            <div class="avatar_block">

                <form action="/uc-do-upload-avatar" method="post" enctype="multipart/form-data" style="    margin: 0 auto;width: 200px;text-align: center;">
                    <div style="width: inherit;height: 200px;margin: 5px;box-shadow: 0px -1px 4px #ddd;">
                        {{avatar(session('user_info')->uid,150,0,'user_change_avatar','big')}}
                        {{--<img src="" id="user_change_avatar">--}}
                    </div>
                    <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                        <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
                        <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="Import image with Blob URLs">
                        选择
                        <span class="fa fa-upload"></span>
                        </span>
                    </label>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-default" value="确定头像">
                    <input id="setCanvasData" type="hidden" name="position">
                </form>
            </div>
            <div class="user_info">
                <form action="">
                    <table class="user_info_table table">
                        <tr>
                            <td class="uc_table_left">昵称</td>
                            <td class="uc_table_right">
                                <input type="text" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td class="uc_table_left">签名档</td>
                            <td class="uc_table_right">
                                <textarea class="form-control"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="uc_table_left">扑币</td>
                            <td class="uc_table_right">
                                <input type="text" class="form-control" value="1000" disabled>
                            </td>
                        </tr>
                        <tr>
                            <td class="uc_table_left">项链</td>
                            <td class="uc_table_right">
                                <input type="text" class="form-control" value="1000" disabled>
                            </td>
                        </tr>
                    </table>


                </form>
            </div>
        </div>
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
                    area: ['300px', '460px'],
                    offset: '100px',
                    // skin: 'layui-layer-rim', //加上边框
                    content: ['/update_user_avatar', 'no']
                });
            })

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
</div>
@include('PC.Common.Footer')