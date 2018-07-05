{{--@include('PC.Common.Header')--}}
@include('PC.Common.HtmlHead')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/reg_login.style.css">
<style>
    body {    background: #fff;    padding: 8px;}
</style>
<div class="wp">
    <div>
        <div class="bm_h"><h3>账户寻回/回忆账号</h3></div>
        <div class="bm_c" style="padding: 8px">
            <p>输入您用户名中包含的字符! (*只显示30个相关用户)</p>
            <form action="/old-user" method="get">
                <input type="text" name="username" class="form-control" value="{{$data['search-username']}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>

            <div>
                <table class="table table-striped">
                    <tr>
                        <td>#</td>
                        <td>头像</td>
                        <td>名字</td>
                        <td>邮箱</td>
                    </tr>
                    @if(!empty($data['user-list']))
                        @foreach($data['user-list'] as $key=>$value)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{avatar($value['uid'],20,100,'avatar','small')}}</td>
                                <td>{{$value->username}}</td>
                                <td><a href="/get-email?email={{$value->email}}">{{$value->email}}</a></td>
                            </tr>
                        @endforeach
                    @endif

                </table>
            </div>
        </div>
    </div>

</div>

{{--@include('PC.Common.Footer')--}}