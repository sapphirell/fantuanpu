@include('PC.Suki.SukiHeader')

<style>
    label {
        font-weight: 900;
    }
</style>
<div class="wp" style="margin-top: 60px;background: #FFFFFF;padding: 20px;">
    <form action="/save_address" method="post">
        <div class="form-group">
            <label for="name">收货人</label>
            <input type="text" name="name" value="{{$data['my_address']->name}}" class="form-control name" id="name" placeholder="">
        </div>
        <div class="form-group">
            <label for="name">收货地址</label>
            <input type="text" name="address" value="{{$data['my_address']->address}}" class="form-control address" id="name" placeholder="">
        </div>
        <div class="form-group">
            <label for="name">收货手机号</label>
            <input type="text" name="telphone"  value="{{$data['my_address']->telphone}}" class="form-control telphone" id="name" placeholder="">
        </div>
        <button type="submit" class="btn btn-alert submit">提交</button>
    </form>
</div>
<script>

    $(document).ready(function () {
        $(".submit").click(function (e) {

            e.preventDefault();
            var data = {};
            data.name = $(".name").val();
            data.address = $(".address").val();
            data.telphone = $(".telphone").val();
            console.log(data)
            $.post("/save_address",data,function (e) {
                alert(e.msg);
                window.location.reload()
            })
        });

    })
</script>
@include('PC.Suki.SukiFooter')