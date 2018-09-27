@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<script src="/Static/Script/Web/forum.js"></script>
<div class="wp" style="padding: 5px;margin-top: 50px;">
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
    <div class="_3_1" style="  min-height: 1200px;">
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
                <div class="tab_a">
                    @include('PC.Forum.TopNews')
                </div>
                <div class="tab_a">
                    @include('PC.Forum.TopPosts')
                </div>
                <div class="tab_a">
                    @include('PC.Forum.HotThread')
                </div>
                <div class="tab_a on">
                    <div class="node_father">
                        @foreach($data['forumGroup'] as $group)
                            <div>
                            <h3 style="    margin: 5px;font-size: 15px;font-weight: 300;color: #7d4a4a;text-shadow: 0 0 1px #bec7c4;">{{$group->name}}</h3>
                            {{--<div>分区版主:</div>--}}
                            </div>
                            <div class="forum_group">
                                @foreach($group->bottomforum as $nodes)
                                    @if($group->forumcolumns == '0')
                                        <div class="forum_block" style="display: inline-block;float: left;margin: 10px 30px 30px 30px;    width: 40%;">
                                            <a href="/forum-{{$nodes->fid}}-1.html"><h3 class="forum_title">{{$nodes->name}}</h3></a>
                                            <div class="forum_img"></div>
                                            <p class="forum_description trans">
                                                今日: <span>{{$nodes->todayposts}}</span> · 主题: <span>{{$nodes->threads}}</span> · 帖数: <span><?php echo round($nodes->posts/10000,2)."万"; ?></span>
                                            </p>
                                            <p>
                                                <a class="forum_lastpost"  href="thread-{{explode("\t",$nodes->lastpost)[0]}}-1.html">{{explode("\t",$nodes->lastpost)[1]}}</a>
                                            </p>
                                        </div>
                                    @elseif($group->forumcolumns == '2')

                                        <div class="forum_block" style="display: inline-block;float: left;margin: 10px 30px 30px 30px;    width: 40%;">
                                            <a href="/forum-{{$nodes->fid}}-1.html"><h3 class="forum_title">{{$nodes->name}}</h3></a>
                                            <div class="forum_img"></div>
                                            <p class="forum_description trans">
                                                今日: <span class="forum_today trans">{{$nodes->todayposts}}</span> · 主题: <span class="forum_threads trans">{{$nodes->threads}}</span> · 帖数: <span class="forum_posts trans"><?php echo round($nodes->posts/10000,2)."万"; ?></span>
                                            </p>
                                            <p>
                                                <a class="forum_lastpost"  href="thread-{{explode("\t",$nodes->lastpost)[0]}}-1.html">{{explode("\t",$nodes->lastpost)[1]}}</a>
                                            </p>
                                        </div>
                                    @elseif($group->forumcolumns == '3')
                                    @else
                                    @endif

                                    {{--<h3 class="forum_title"--}}
                                        {{--@if($group['forumcolumns'] == '2')--}}
                                        {{--style="display: inline-block;float: left;margin: 20px 90px 30px 30px;   "--}}
                                        {{--@elseif($group['forumcolumns'] == '3')--}}
                                        {{--style="display: inline-block;float: left;margin: 10px 30px 10px 30px;"--}}
                                        {{--@elseif($group['forumcolumns'] == '0')--}}
                                        {{--style="display: block;float: left;margin: 20px 90px 30px 30px;"--}}
                                        {{--@else--}}
                                        {{--style="display: block;float: left;min-width: 100%;"--}}
                                            {{--@endif>--}}
                                        {{--{{$nodes['name']}}--}}
                                    {{--</h3>--}}
                                    {{--<div class="forum_block"--}}
                                        {{--@if($group['forumcolumns'] == '2')--}}
                                            {{--style="display: inline-block;float: left;margin: 20px 90px 30px 30px;   "--}}
                                        {{--@elseif($group['forumcolumns'] == '3')--}}
                                            {{--style="display: inline-block;float: left;margin: 10px 30px 10px 30px;"--}}
                                        {{--@elseif($group['forumcolumns'] == '0')--}}
                                            {{--style="display: block;float: left;margin: 20px 90px 30px 30px;"--}}
                                        {{--@else--}}
                                            {{--style="display: block;float: left;min-width: 100%;"--}}
                                            {{--@endif--}}
                                    {{-->--}}

                                    {{--</div>--}}
                                    {{--<p>--}}
                                        {{--{{$nodes['']}}--}}
                                    {{--</p>--}}

                                @endforeach
                                <div class="clear"></div>
                            </div>
                        @endforeach
                        <div class="clear"></div>
                    </div>
                    <!--节点列表-->
                </div>
            </div>
            <!--3-1-left-->
        </div>
        <div class="_3_1_right">
            <div class="forum_group" style="width: 100%;height: 200px;background: #ffffff;margin-top: 77px;overflow:hidden">
                <a href="/app_download" style="width: inherit">
                    <img src="http://image.fantuanpu.com/upload/20180830/be00ce9d8724be6b370dd69e1090d535.png" style="width: inherit">
                </a>

            </div>
        </div>
        <div class="clear"></div>
        <!--3-1-->
    </div>

</div>
@include('PC.Common.Footer')