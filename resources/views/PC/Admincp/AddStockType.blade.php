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

                    <form class="form-horizontal" action="/admincp/add_stock_type" method="post">

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

        $(".premium").on("click",function(){
            var item_price = $(".item_price").val();
            console.log(item_price)

            $(".premium").val(parseInt(item_price)*0.12+0.3);
        })

    });
</script>