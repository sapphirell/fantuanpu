$(function() {

    $("#alert_ajax_login").click(function (e) {
        e.preventDefault();
        layer.open({
            type: 2,
            title:'登录',
            area: ['460px', '300px'],
            offset: '100px',
            skin: 'layui-layer-rim', //加上边框
            content: ['/login', 'no']
        });
    })
});