<style>
    .bm_h {
        background: #85a8ca;
    }
    .uc_table_left{    width: 100px;
        text-align: left;
        font-size: 13px;
        color: #6f6f6f;}
    .uc_table_right{}
</style>
<div class="bm_h">编辑资料</div>
<div class="bm_c">
    <div class="user_info">
        <form action="">
            <table class="user_info_table table">
                <tr>
                    <td class="uc_table_left">昵称</td>
                    <td class="uc_table_right">
                        <p class="mc_editor" data="{{ $data['user_info']->username }}">{{$data['user_info']->username}}</p>
                        {{--<input type="text" class="form-control">--}}
                    </td>
                </tr>
                <tr>
                    <td class="uc_table_left">签名档</td>
                    <td class="uc_table_right">
                        {!!  $data['field_forum']->sightml !!}
                        <span></span>
                        {{--<textarea class="form-control">{!!  $data['field_forum']->sightml !!}</textarea>--}}
                    </td>
                </tr>
                {{--{{dd($data['user_count']['extcredits'])}}--}}
                @foreach($data['user_count']['extcredits'] as $key=>$value)
                <tr>
                    <td class="uc_table_left">{{ $value }}</td>
                    <td class="uc_table_right">
                        {{$data['user_count'][$key]}}
                        {{--<textarea class="form-control">{!!  $data['field_forum']->sightml !!}</textarea>--}}
                    </td>
                </tr>
                @endforeach
            </table>


        </form>
    </div>
</div>