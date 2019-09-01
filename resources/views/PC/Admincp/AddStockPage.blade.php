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
                            <td>颜色</td>
                            <td>尺寸</td>
                            <td>库存</td>
                            <td>+?</td>
                        </tr>
                        @foreach($data["stock"]["detail"] as $value)
                            <tr>
                                <td>{{$value->color}}</td>
                                <td>{{$value->size}}</td>
                                <td>{{$value->stock}}</td>
                                <td>
                                    <input type="text" class="form-control t_{{$value->id}}" tid="{{$value->id}}">
                                    <input type="submit" class="submit" tid="{{$value->id}}">
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

        $(".submit").on("click",function(){
            var tid = $(this).attr("tid")
            var num = $(".t_"+tid).val();
            $.post("/admincp/add_stock_item",{'id':tid,"num":num},function (e) {
                alert(e.msg)
                ""
//                window.location.reload()
            })
        })

    });
</script>