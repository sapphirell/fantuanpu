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

    // $threeDiv = "<div class='across'></div><div class='across'></div><div class='across'></div>";
    // $threeDiv = '<span class="glyphicon glyphicon-cog trans" aria-hidden="true" style="margin-left: 10px"></span>';
    $threeDiv = '<svg class="icon" style="width: 1.6em; height: 1.6em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" p-id="290"><path d="M959.36 920.96c-15.36-181.76-139.52-332.16-307.84-386.56 70.4-45.44 117.12-124.16 117.12-214.4 0-141.44-115.2-256-256.64-256C369.92 64 255.36 178.56 255.36 320c0 90.24 46.72 168.96 117.12 214.4-168.32 54.4-292.48 204.8-307.84 386.56 0 3.2-0.64 5.76 0 10.24C65.92 947.2 80 960 96 960 113.92 960 128 945.28 128 928 144.64 730.24 310.4 576 512 576s366.72 154.24 384 352c0 17.28 14.08 32 32 32 16 0 30.08-12.8 31.36-28.8C960 926.72 959.36 924.16 959.36 920.96zM319.36 320c0-106.24 86.4-192 192.64-192 106.24 0 192.64 85.76 192.64 192 0 106.24-86.4 192-192.64 192C405.76 512 319.36 426.24 319.36 320z" p-id="291"></path></svg>';
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
        $.layer.closeAll()
    });
    //选项卡
    $tab_h = $(".tab_h > *");
    $tab_m = $(".tab_m > *");
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
