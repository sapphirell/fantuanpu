$(function() {

    $('.banner').unslider({
        keys:true
    });

    $('.banner li').hover(function(){
        $(this).children(".push_title").fadeIn();
    },function(){
        $(this).children(".push_title").fadeOut();
    });

    $mod_tab    = $('.mod_tab li span');//滑块触点
    $tab_a      = $('.tab_a');
    $mod_tab.hover(function(){

        var mod_tab_index = $mod_tab.index(this);
        $mod_tab.removeClass("hover");
        $(this).addClass("hover");
        $tab_a.eq(mod_tab_index).show("normal").siblings().hide("normal");//这是原论坛效果
    });

});