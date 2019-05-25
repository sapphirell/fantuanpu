{{--@include('PC.Common.Header')--}}
@include('PC.Common.HtmlHead')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/reg_login.style.css">
<style>
    body {    background: #fff;    padding: 8px;    overflow: scroll;}
    .username_input {
        border-color: #f8abb5;
        color: #7B6164;
        padding: 8px;
    }
    .username_input:hover ,.username_input:focus {
        border-color: #ffb2b2!important;
        box-shadow: 0 0 0 0.2rem rgba(255, 137, 137, 0.25);
    }
    .fa-chevron-right {
        position: absolute;
        top: 8px;
        right: 10px;
        background: #945959;
        color: #fff;
        width: 22px;
        height: 22px;
        text-align: center;
        padding: 5px;
        border-radius: 100%;
        font-size: 9px;
        padding-left: 6px;
    }
    td {
        color: #7B6164;
        text-align: center;
    }
    a {
        color: #927b7e;
    }
</style>
<div class="wp">
    <div>
        <img src="/Image/suki-pink.png" style="width: 120px;margin: 35px auto 15px auto;display: block;">
        <p style="color: #BBBBBB;font-size: 14px;margin: 10px auto 15px auto;display: block;text-align: center;">
            - - - - - - 找回密码 - - - - - -
        </p>
        <form action="/old-user" id="get_user" method="get" style="position: relative">
            <input placeholder="输入用户名或完整的邮箱地址" type="text" name="username" class="form-control username_input trans" value="{{$data['search-username']}}">
            <i class="fa fa-chevron-right " aria-hidden="true"></i>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
        <div style="height: 300px;overflow-y: scroll">
            <table class="table table-striped" style="border: 1px solid #ddd;border-radius: 5px;">
                <tr>
                    <td>名字</td>
                    <td>邮箱</td>
                </tr>
                @if(!empty($data['user-list']))
                    @foreach($data['user-list'] as $key=>$value)
                        <tr>
                            <td><a href="/get-email?email={{$value->email}}">{{$value->username}}</a></td>
                            <td><a href="/get-email?email={{$value->email}}">{{$value->email}}</a></td>
                        </tr>
                    @endforeach
                @endif

            </table>
        </div>

    </div>

</div>
<script>
    $(document).ready(function () {
        $(".fa-chevron-right").click(function () {
            $("#get_user").submit()
        })
    })

</script>
{{--@include('PC.Common.Footer')--}}