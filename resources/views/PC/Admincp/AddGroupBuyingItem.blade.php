@include('PC.Admincp.AdminHeader')
<style>
    .price_group {
        margin-bottom:10px;
    }
</style>
<div class="wp admin" style="min-height: 200px;">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    添加商品
                </div>

                <!-- /.panel-heading -->
                <div class="panel-body" >
                    <div>
                        <label for="addImage" class="col-sm-2 control-label">上传图片</label>
                        <input type="file" class="remote_image" name="addImage">
                        <div class="addImage " style="cursor:pointer;border: 1px solid #ddd;display: inline-block">添加</div>
                    </div>
                    <form class="form-horizontal fm" action="/admincp/add_group_buying_item" method="post">

                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">商品名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control medal_name" name="item_name"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">图片链接,以 | 分割</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control medal_name image_urls" name="item_image"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">码数,以 | 分隔</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control medal_name" name="item_size"  placeholder="X|XL|XL">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">颜色,以 | 分隔</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control medal_name" name="item_color"  placeholder="红色|蓝色|白色">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">价格</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control item_price" name="item_price"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">辛苦费/次</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control premium" name="premium"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">原始商品运费</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control medal_name" name="item_freight"  placeholder="15">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">最低成团个数</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control medal_name" name="min_members"  value="10">
                            </div>
                        </div>
                        <div class="col-sm-2 control-label">
                            {{--<button type="button" class="submit">提交</button>--}}
                            <input type="submit" class="submit">
                        </div>
                        {{csrf_field('csrf')}}
                    </form>

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>


</div>

<script>
    $(document).ready(function () {

        $(".premium").on("click",function(){
            var item_price = $(".item_price").val();
            console.log(item_price)

            $(".premium").val(parseInt(item_price)*0.12+0.3);
        })
        $('.submit').keypress(function(e) {
            $(".fm").submit()
//            if (e.keyCode == 13) {
//                console.log("x")
//                e.preventDefault();
//            }
        });

        $(".addImage").click(function(e) {
            e.preventDefault();
            var im = $(".remote_image").prop('files');
            console.log(im);
            var fd = new FormData();
            fd.append("image", im[0]);
            $.ajax({
                url: 'http://image.fantuanpu.com/upload_file',
                type: 'POST',
                cache: false,
                data: fd,
                processData: false,
                contentType: false}).done(function(res) {
                var imagestring = $(".image_urls").val()
                imagestring += "http://image.fantuanpu.com" + res.data.url + "|";
                console.log(imagestring)
                $(".image_urls").val(imagestring)
            }).fail(function(res) {});
            // $.post('http://image.fantuanpu.com/upload_file',fd,function (res) {
            //     console.log(res)
            //     alert(res.msg)
            // });
        });
    });
</script>