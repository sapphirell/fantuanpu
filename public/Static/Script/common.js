Array.prototype.indexOf = function(val) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] == val) return i;
    }
    return -1;
};
Array.prototype.remove = function(val) {
    var index = this.indexOf(val);
    if (index > -1) {
        this.splice(index, 1);
    }
};
function html2ubb(str){
    str = str.replace(/(\r\n|\n|\r)/ig, '');
    str = str.replace(/<br[^>]*>/ig,'\n');
    str = str.replace(/<p[^>\/]*\/>/ig,'\n');
    str = str.replace(/\/p>/ig, '\/p>\r\n');
    //str = str.replace(/\[code\](.+?)\[\/code\]/ig, function($1, $2) {return phpcode($2);});
    str = str.replace(/\son[\w]{3,16}\s?=\s*([\'\"]).+?\1/ig,'');

    str = str.replace(/<hr[^>]*>/ig,'[hr]');
    str = str.replace(/<(sub|sup|u|strike|b|i|pre)>/ig,'[$1]');
    str = str.replace(/<\/(sub|sup|u|strike|b|i|pre)>/ig,'[/$1]');
    str = str.replace(/<(\/)?strong>/ig,'[$1b]');
    str = str.replace(/<(\/)?em>/ig,'[$1i]');
    str = str.replace(/<(\/)?blockquote([^>]*)>/ig,'[$1blockquote]');

    str = str.replace(/<img[^>]*smile=\"(\d+)\"[^>]*>/ig,'[s:$1]');
    str = str.replace(/<img[^>]*src=[\'\"\s]*([^\s\'\"]+)[^>]*>/ig,'[img]'+'$1'+'[/img]');
    str = str.replace(/<a[^>]*href=[\'\"\s]*([^\s\'\"]*)[^>]*>(.+?)<\/a>/ig,'[url=$1]'+'$2'+'[/url]');
    //str = str.replace(/<h([1-6]+)([^>]*)>(.*?)<\/h\1>/ig,function($1,$2,$3,$4){return h($3,$4,$2);});

    str = str.replace(/<[^>]*?>/ig, '');
    str = str.replace(/&amp;/ig, '&');
    str = str.replace(/&lt;/ig, '<');
    str = str.replace(/&gt;/ig, '>');

    return str;
}
$(function() {


    $("#alert_ajax_login").click(function (e) {
        e.preventDefault();
        layer.open({
            type: 2,
            title: false,
            closeBtn: 0, //不显示关闭按钮
            shade: 0.8,
            shadeClose: true,
            // title:'登录',
            area: ['280px', '360px'],
            offset: '100px',
            // skin: 'layui-layer-rim', //加上边框
            content: ['/login?form=layer', 'no']
        });
    })
    $("#alert_ajax_login_suki").click(function (e) {
        var smart_width = document.body.clientWidth > 440 ? 440 : document.body.clientWidth  * 0.8
        e.preventDefault();
        layer.open({
            type: 2,
            title: false,
            closeBtn: 0, //不显示关闭按钮
            shade: 0.8,
            shadeClose: true,
            // title:'登录',
            area: [smart_width + "px", '450px'],
            offset: '100px',
            // skin: 'layui-layer-rim', //加上边框
            content: ['/suki_login?form=layer', 'no']
        });
    })
    $("#alert_ajax_reg").click(function (e)
    {
        e.preventDefault();
        layer.open({
            type: 2,
            title:false,
            closeBtn: 0,
            shadeClose: true,
            area: ['460px', '428px'],
            offset: '100px',
            class : 'asd',
            // skin: 'layui-layer-rim', //加上边框
            content: ['/register', 'no']
        });
    })
    $("#old_user").click(function (e)
    {
        console.log(window.parent.clientWidth)
        var layer_smart_width = window.innerWidth > 650 ? "650px" : window.width + "px"
        e.preventDefault();
        parent.layer.open({
            type: 2,
            // title:'账号联想',
            title: false,
            closeBtn: 0, //不显示关闭按钮
            shade: 0.8,
            shadeClose: true,
            area: [layer_smart_width, '500px'],
            offset: '100px',
            // skin: 'layui-layer-rim', //加上边框
            content: ['/old-user', 'yes']
        });
    })
    
    $(".add-me").click(function () {
        layer.closeAll()
        var load = layer.load();
        //此处用setTimeout演示ajax的回调
        $.get("/get_my_message",null,function (event) {
            layer.close(load);
            layer.open({
                type: 2,
                title: 'iframe父子操作',
                maxmin: true,
                shadeClose: true, //点击遮罩关闭层
                area : ['800px' , '520px'],
                content: '<div>123</div>'
            });
        })

    })

    //签到
    $(".sign").click(function () {
        $(this).text('请等待...')
        $.get("/sign",function (e) {
           console.log(e);
        });
    })
    $(".window_gift_alert").click(function () {
        $(".window_gift_alert").hide("fast");
    })
    //返回
    $(".go_back").click(function () {
        window.location.href = "/index"
    })
});