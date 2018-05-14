@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<script src="/Static/Script/Web/forum.js"></script>
<style>
    .avatar_block {
        overflow: hidden;
        text-align: center;
        padding: 25px 8px ;
        }
    .user_change_avatar {
        border: 3px solid #fff;
        box-shadow: 0 3px 5px #ccc;
    }
    .user_info_table {
        width:70%;
        margin: 0 auto;
    }
    .user_info_table .tr {
        margin: 5px;
    }
    .uc_table_left {
        text-align: center;
    }
</style>
<div class="wp" style="padding: 5px;margin-top: 29px;">
    <div class="bm">
        <div class="bm_h">编辑资料</div>
        <div class="bm_c">
            <div class="avatar_block">
                <div style="">
                    {{avatar(session('user_info')->uid,150,100,'user_change_avatar','big')}}
                </div>

            </div>
            <div class="user_info">
                <form action="">
                    <table class="user_info_table table">
                        <tr>
                            <td class="uc_table_left">昵称</td>
                            <td class="uc_table_right">
                                <input type="text" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td class="uc_table_left">签名档</td>
                            <td class="uc_table_right">
                                <textarea class="form-control"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="uc_table_left">扑币</td>
                            <td class="uc_table_right">
                                <input type="text" class="form-control" value="1000" disabled>
                            </td>
                        </tr>
                        <tr>
                            <td class="uc_table_left">项链</td>
                            <td class="uc_table_right">
                                <input type="text" class="form-control" value="1000" disabled>
                            </td>
                        </tr>
                    </table>

                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">

    </script>
</div>
@include('PC.Common.Footer')