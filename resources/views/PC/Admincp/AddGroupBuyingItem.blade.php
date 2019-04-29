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

                    <form class="form-horizontal" action="/admincp/add_group_buying_item" method="post">

                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">商品名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control medal_name" name="item_name"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">图片链接,以 | 分割</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control medal_name" name="item_image"  placeholder="">
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
                                <input type="text" class="form-control medal_name" name="item_price"  placeholder="100.23">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">辛苦费/次</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control medal_name" name="premium"  placeholder="1.53">
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
                                <input type="text" class="form-control medal_name" name="min_members"  placeholder="100">
                            </div>
                        </div>
                        <div class="col-sm-2 control-label">
                            <input type="submit">
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

    });
</script>