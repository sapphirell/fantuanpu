@include('PC.Suki.SukiHeader')
<style>
    .report_a {
        height: 24px;
        display: inline-block;
        margin: 0px 10px;
        text-decoration: none!important;
        vertical-align:middle;
    }
    .report_a span {
        color: #F09C9C;
    }
</style>
<div class="wp" style="margin-top: 60px;">
    <div>
        <div class="bm_h pink">关于 Suki! 社区</div>
        <div class="bm_c" style="padding: 10px;line-height: 25px;">
            这里是一个讨论Lolita服饰、JK制服穿搭、讨论日常生活的琐事的社区。
            目前网站由两个人开发和运营,是一个非公司运营、非商业化的兴趣使然的小众网站,
            所以不会因为公司破产之类的理由关闭网站...
            <br>
            "Suki!"是2018年12月份决定进行开发的,原本打算两个月内做完网站和App的开发,
            但是目前来看还是有些不现实,考虑到新年后换工作的事情可能会再拖久一点,
            但是可以保证的是我们会尽全力做好这个社区的!
            <br> <br>
            <p>反馈渠道:</p>
            <a href="/suki-userhome-2.html" class="report_a">
                {{avatar("2",20,100)}}
                <span style="font-size: 10px">运营沟通</span>
            </a>
            <a href="/suki-userhome-1.html" class="report_a">
                {{avatar("1",20,100)}}
                <span style="font-size: 10px;">功能性反馈</span>
            </a>
        </div>
    </div>
</div>
@include('PC.Suki.SukiFooter')
