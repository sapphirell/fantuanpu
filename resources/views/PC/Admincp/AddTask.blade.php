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
                    新增任务
                </div>

                <!-- /.panel-heading -->
                <div class="panel-body" >

                    <form class="form-horizontal">

                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">任务名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control task_name"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="" style="margin-bottom: 10px">
                                <label for="inputPassword" class="col-sm-2 control-label">任务起止时间</label>

                                <div class="col-sm-3">
                                    <input type="text" id="start" class="form-control">
                                </div>
                                <br>
                                <div class="col-sm-3">
                                    <input type="text" id="end" class="form-control">

                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">任务奖励</label>
                            <ul>
                                <li>|分割类型和个数,复数奖励用,分割</li>
                                <li>支持类型:count_extcredits1~8/media_1/gbTicket_1</li>
                            </ul>
                            <div class="col-sm-10">
                                <input type="text" class="form-control task_gift"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">动作列表</label>
                            <ul>
                                <li>|分割类型和个数,复数动作用,分割</li>
                                <li>支持类型:SIG/PNT_1(在指定板块发主题)/RCT_1(在指定板块回复主题)</li>
                            </ul>
                            <div class="col-sm-10">
                                <input type="text" class="form-control task_action"  placeholder="">
                            </div>
                        </div>
                        <p>任务描述</p>
                        <textarea name="task_description" class="form-control"></textarea>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">任务图片</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control task_image"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">接取后的倒计时秒数（如果task_type =1)</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control task_time_limit"  placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">任务类型</label>
                            <p>1=倒计时任务 2=本日内完成 3=本周内完成 4=本月内完成 5 = 无时间限制</p>
                            <div class="col-sm-10">
                                <input type="text" class="form-control task_type"  placeholder="">
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
        laydate.render({
            elem: '#start',
        });
        laydate.render({
            elem: '#end',
        });

    });
</script>