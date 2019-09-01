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

                    <form class="form-horizontal" action="/admincp/push_stock" method="post">

                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">商品名称</label>
                            <div class="col-sm-10">
                                <input type="hidden" class="item_id" name="item_id" value="{{$data["type"]["info"]->id}}">
                                <input type="text" disabled class="form-control item_name" name="item_name" value="{{$data["type"]["info"]->item_name}}"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">尺码</label>
                            <div class="col-sm-10">
                                <input type="text"  value="均" class="form-control size" name="size"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">颜色</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control color" name="color"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">价格</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control price" name="price"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">增加多少个库存</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control stock" name="stock"  placeholder="">
                            </div>
                        </div>
                        <div class="col-sm-2 control-label">
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

        $(".submit").on("click",function(e){
            e.preventDefault()
            var price = $(".price").val();
            var item_id = $(".item_id").val();
            var item_name = $(".item_name").val();
            var size = $(".size").val();
            var color = $(".color").val();
            var stock = $(".stock").val();

            var pd =  {"item_id":item_id,"item_name":item_name,"size":size,"color":color,"price":price,"stock":stock}
            console.log(pd);
            $.post("/admincp/push_stock",pd,function (event) {
                alert(event.msg)
                if (event.ret == 200)
                {
                    window.parent.location.reload()
                }
            })

        })

    });
</script>