$(document).ready(function(){
    //获取窗口高度
    var getHeight = $(window).height();
    $active = $("#active");
    $(window).resize(function(){
        var getHeight = $(window).height();
        $active.css({"height":getHeight});
    });

    //title
    $('.detail').hover(function(){
        randthis = Math.floor(Math.random()*100000+1);
        indexnum = $('.detail').index(this);
        var $titles = $(this).attr("title");
        var $contents = $(this).attr("message")? $(this).attr("message") :$titles;
        var xy = $(this).offset();
        var hei = $(this).height();
        var tops = xy.top + hei + 3;
        var $position = "top:"+tops+"px;left:"+xy.left+"px;";
        var $app = "<div class='about' id='"+randthis+"' style='"+$position+"'><div class='ab'></div><p>"+$contents+"</p></div>";

        t = setTimeout(function(){
            $('.detail').eq(indexnum).after($app);
            //操作css渐显
            $("#"+randthis).stop(true).animate({filter:'alpha(opacity=100)',opacity:'1'},"fast");
        },200);
    },function(){
        clearTimeout(t);

        $("#"+randthis).stop(true).animate({filter:'alpha(opacity=0)',opacity:'0'},function(){
            $(this).remove();
        });

    });
    //表单必填项控件
    $("input:text,input:submit,input:checkbox,textarea").click(function(){

        $(".input_required").removeClass("input_required");

    });

    $(".mc_form").find("input:submit").click(function(e){
        $isRequired = $(this).parents(".mc_form").find(".required").filter(function(){
            return $(this).val()=='';
        });
        if ($isRequired.length) {

            $isRequired.addClass("input_required");

            e.preventDefault();
        };


    });

    //input表单placeholder兼容ie
    //展开菜单
    $(".ul .ul_h").click(function(){
        var key_index = $(this).index(".ul_h");
        $(".ul").find( $(".li") ).eq(key_index).slideDown().siblings(".li").slideUp();
    });
    $(".ul > .ul_h:last,.li:last").css("border-bottom","0px");
    //$ul.wrap("<div class='glassCase'></div>");//为手风琴菜单创建外壳
    //radio触发范围
    //memuBtn

    $threeDiv = "<div class='across'></div><div class='across'></div><div class='across'></div>";
    $threeDiv = '<span class="glyphicon glyphicon-cog trans" aria-hidden="true" style="margin-left: 10px"></span>';
    $memuBtn = $(".memuBtn");
    $memuBtn.append($threeDiv);
    var mbtnNum = '0';
    $active.css({"height":getHeight});
    $memuBtn.click(function(){
        $across = $('.across');
        //memubtn被点击后将展开一个菜单，并缩小wp的宽度。
        if (mbtnNum=='0') {
            $('body').animate({"margin-left":"235px"});
            $across.css({"backgroundColor":"#eee"});
            $active.animate({"left":"0"});
            mbtnNum++;
        }else{
            $('body').animate({"margin-left":"0px"});
            $across.css({"backgroundColor":"#444"});
            $active.animate({"left":"-235px"});
            mbtnNum--;
        };

    });
    //选项卡
    $tab_h = $(".tab_h > div");
    $tab_m = $(".tab_m > div");
    $tab_h.click(function(){
        var tab_h_num = $tab_h.index(this);
        $(this).addClass("onchange").siblings().removeClass("onchange");
        $tab_m.eq(tab_h_num).show().siblings().hide();
    });

    //弹出是否选项 event.preventDefault();

    ///对class="no-follow"添加不跟随跳转的事件
    $(".no-follow").click(function(e){
        e.preventDefault();
    });
    //can_set_ava
    $(".can_set_ava").hover(function(){

    });



});
