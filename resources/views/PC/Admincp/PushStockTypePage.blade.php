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
                                <input type="hidden" value="{{$data["type"]["info"]->id}}">
                                <input type="text" disabled class="form-control " name="item_name" value="{{$data["type"]["info"]->item_name}}"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">尺码</label>
                            <div class="col-sm-10">
                                <input type="text"  value="均" class="form-control medal_name" name="size"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">颜色</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control medal_name" name="color"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">价格</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control medal_name" name="color"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">增加多少个库存</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control medal_name" name="color"  placeholder="">
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