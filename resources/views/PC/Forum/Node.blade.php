@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<script src="/Static/Script/Web/forum.js"></script>
<div class="wp" style="padding: 5px;margin-top: 29px;">
    <!--头部banner-->

    <div class="banner quick">
        <ul>
            <li>
                <img src="/Image/1.jpg">
                <div class="push_title">第一条推送消息</div>
            </li>
            <li>
                <img src="/Image/2.jpg">
                <div class="push_title">第二条推送消息</div>
            </li>
            <li>
                <img src="/Image/3.jpg">
                <div class="push_title">第三条推送消息</div>
            </li>
        </ul>


    </div>
    <div class="_3_1">
        <div class="_3_1_left">
            <div class="mod_tab">
                <ul>

                    <li><span>最新主题</span></li>
                    <li><span>最近回复</span></li>
                    <li><span>最热主题</span></li>
                    <li><span class="hover">节点列表</span></li>

                </ul>
            </div>
            <div class="clear"></div>
            <div class="tab_body">
                <div class="tab_a">最新主题</div>
                <div class="tab_a">最近回复</div>
                <div class="tab_a">最热主题</div>
                <div class="tab_a on">
                    <div>

                        @foreach($data['forumGroup'] as $value)
                            <div>
                                <p>{{$value->gname}}</p>
                            </div>
                        @endforeach

                    </div>
                    <!--节点列表-->
                </div>
            </div>
            <!--3-1-left-->
        </div>
        <div class="_3_1_right"></div>
        <div class="clear"></div>
        <!--3-1-->
    </div>

</div>
@include('PC.Common.Footer')