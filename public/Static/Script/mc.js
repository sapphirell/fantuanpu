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
    $threeDiv = '<svg class="icon" width="20px" height="20px" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M511.999488 117.822452c45.237297 0 87.765903 17.616216 119.753431 49.603745 31.987528 31.987528 49.603745 74.517157 49.603745 119.753431s-17.616216 87.765903-49.603745 119.753431c-31.987528 31.987528-74.517157 49.603745-119.753431 49.603745s-87.765903-17.616216-119.753431-49.603745c-31.987528-31.987528-49.603745-74.517157-49.603745-119.753431s17.616216-87.765903 49.603745-119.753431C424.233586 135.438669 466.762191 117.822452 511.999488 117.822452M511.999488 62.563918c-124.051317 0-224.615711 100.56337-224.615711 224.615711s100.564393 224.615711 224.615711 224.615711c124.052341 0 224.615711-100.56337 224.615711-224.615711S636.050806 62.563918 511.999488 62.563918L511.999488 62.563918z" fill="#dbdbdb" /><path d="M919.453411 961.436082c-13.93743 0.001023-25.917276-10.512425-27.437909-24.684192-20.853957-194.366779-184.224792-340.940043-380.016013-340.940043-195.791222 0-359.162056 146.571217-380.016013 340.940043-1.627057 15.170514-15.248286 26.151613-30.4188 24.523533-15.172561-1.62808-26.151613-15.246239-24.524556-30.4188 11.444657-106.663298 61.760622-205.194382 141.67879-277.441846 80.508615-72.779583 184.66379-112.861464 293.28058-112.861464S724.771453 580.635193 805.279045 653.414777c79.919191 72.248488 130.235157 170.778548 141.67879 277.44287 1.62808 15.171538-9.351995 28.79072-24.524556 30.4188C921.433508 961.383894 920.437831 961.436082 919.453411 961.436082z" fill="#dbdbdb" /></svg>';
    $(".block_href").click(function (e) {
        e.preventDefault();
    })
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
            $(".web_body").addClass("blur8");
            $(".web_body a").click(function (e) {
                e.preventDefault();
            })

            mbtnNum++;
        }else{
            $('body').animate({"margin-left":"0px"});
            $across.css({"backgroundColor":"#444"});
            $active.animate({"left":"-235px"});
            $(".web_body").removeClass("blur8");
            $(".web_body a").prop("onclick",null).off("click");
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
