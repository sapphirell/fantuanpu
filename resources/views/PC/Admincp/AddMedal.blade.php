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
                    勋章上架
                </div>

                <!-- /.panel-heading -->
                <div class="panel-body" >

                    <form class="form-horizontal">

                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">勋章名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control medal_name"  placeholder="medal name ">
                            </div>
                        </div>
                        {{--选择购买消耗的积分--}}
                        <div class="form-group">
                            <div class="price_group">
                                <label for="inputPassword" class="col-sm-2 control-label">售价</label>
                                <div class="col-sm-3">
                                    <select class="form-control score_type" >
                                        <option>请选择</option>
                                        @foreach($data['reward_list'] as $key=>$value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control score_value"  placeholder="售价">
                                </div>
                                <div class="clear"></div>
                            </div>


                            <div class="col-sm-2 control-label">
                                <span type="button" class="btn btn-link add-price" style="font-size: 30px; float: right;   line-height: 13px;">+</span>
                            </div>
                        </div>
                        {{--选择触发的动作和相应的获得--}}
                        <div class="form-group">
                            <div class="action_group" style="margin-bottom: 10px">
                                <label for="inputPassword" class="col-sm-2 control-label">被触发</label>
                                <div class="col-sm-3">
                                    <select class="form-control action_name">
                                        <option>请选择</option>
                                        @foreach($data['action_list'] as $value)
                                            <option value="{{$value->action_key}}">{{$value->action_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control rate"  placeholder="概率" >
                                </div>

                                <label for="inputPassword" class="col-sm-1 control-label">获得</label>
                                <div class="col-sm-2">
                                    <select class="form-control score_type" >
                                        <option>请选择</option>
                                        @foreach($data['reward_list'] as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control score_value"  placeholder="数额">
                                </div>
                                <div class="clear"></div>
                            </div>


                            <div class="col-sm-2">
                                <span type="button" class="btn btn-link add-action" style="font-size: 30px;  float: right;   line-height: 13px;">+</span>
                            </div>
                        </div>
                        <div class="col-sm-2 control-label">
                            <span class="btn btn-primary submit">提交</span>
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

        $(".add-price").click(function () {
            var price = $(".price_group:first").clone();
            $(".price_group:last").after(price)
        });
        //add-action
        $(".add-action").click(function () {
            var price = $(".action_group:first").clone();
            $(".action_group:last").after(price)
        });
        $(".btn.submit").click(function () {
            var sendData = {
                medal_name : $('.medal_name').val(),
                csrf : $('#csrf').val()
            }
            var price_group = $(".price_group").length
            //售价
            var price = [];
            for (var i = 0; i<price_group ;i ++)
            {
                price.push({
                    score_type :  $(".price_group .score_type").eq(i).val(),
                    score_value : $(".price_group .score_value").eq(i).val(),
                })
            }
//            console.log(price)
            //触发
            var action_group = $(".action_group").length
            var action = [];
            for (i=0;i<action_group;i++)
            {
                action.push({
                    action_name :  $(".action_group .action_name").eq(i).val(),
                    rate        :  $(".action_group .rate").eq(i).val(),
                    score_type  :  $(".action_group .score_type").eq(i).val(),
                    score_value : $(".action_group .score_value").eq(i).val(),
                });
            }
//            console.log(action)
            sendData.action = action;
            sendData.price = price;
            console.log(sendData)

            $.post('')
        });
    });
</script>