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


                <!-- /.panel-heading -->
                <div class="panel-body" >

                    <table class="table">
                        <tr>
                            <td>品名</td>
                            <td>略缩图</td>
                            <td>操作</td>
                        </tr>
                        @foreach($data["list"] as $value)
                            <tr>
                                <td>{{$value->item_name}}</td>
                                <td><img width="27px" src="{{explode("|",$value->item_image)[0]}}" ></td>
                                <td>
                                    <a href="/admincp/push_stock_page?tid={{$value->id}}">上架</a>
                                    <a href="/admincp/add_stock_page?item_id={{$value->id}}">补货</a>
                                    <a href="/admincp/disable_stock?item_id={{$value->id}}">下架</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
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