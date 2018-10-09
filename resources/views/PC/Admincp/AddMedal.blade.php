@include('PC.Admincp.AdminHeader')

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
                                <input type="text" class="form-control"  placeholder="medal name ">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">售价</label>
                            <div class="col-sm-3">
                                <select class="form-control">
                                    @foreach($data['reward_list'] as $value)
                                        <option>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control"  placeholder="售价">
                            </div>
                            <div class="col-sm-2">
                                <span type="button" class="btn btn-link" style="font-size: 30px;    line-height: 13px;">+</span>
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">被触发</label>
                            <div class="col-sm-3">
                                <select class="form-control">
                                    @foreach($data['action_list'] as $value)
                                        <option value="{{$value->action_key}}">{{$value->action_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-2">
                                <span type="button" class="btn btn-link" style="font-size: 30px;    line-height: 13px;">+</span>
                            </div>
                        </div>
                    </form>

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>


</div>

