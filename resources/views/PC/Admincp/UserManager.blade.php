@include('PC.Admincp.AdminHeader')

    <div class="wp" style="min-height: 200px;">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        用户管理
                    </div>
                    <form action="" style="padding: 15px">
                        <input type="text" class="form-control" placeholder="用户名" name="username" value="{{$data['request']['username']}}">
                        {{csrf_field()}}
                    </form>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>uid</th>
                                <th>用户名</th>
                                <th>组别</th>
                                <th>账户积分</th>
                                <th>操作</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['user_info'] as $key=>$value)
                                <tr class="odd gradeX">
                                    <td>{{$value->uid}}</td>
                                    <td>{{$value->username}}</td>
                                    <td>
                                        {{$value->grouptitle}}
                                    </td>

                                    <td>
                                        {{$value->coin}}
                                    </td>
                                    <td>
                                        <a href="/admincp/user-edit?uid={{$value->uid}}&type=closure">封禁</a>
                                        <a href="/admincp/user-edit?uid={{$value->uid}}&type=hidden">隐藏帖子</a>
                                        <a href="/admincp/user-edit?uid={{$value->uid}}&type=clear">清理用户</a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>


    </div>

@include('PC.Common.Footer')