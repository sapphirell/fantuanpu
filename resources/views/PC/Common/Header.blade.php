<html>
<head>
    <title>饭团扑.Net!-即使是做了上班族也想作个二次元啊喂</title>

    <meta name="keywords" content="饭团扑,二次元,动漫,Lolita,jk">
    <meta name="description" content="饭团扑,一个二次元社交社区">
    @include('PC.Common.HtmlHead')
</head>

<body>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="header">
    <div class="memuBtn"></div>
    <p class="title"><a href="/about" style="">饭团扑.net</a></p>
    <div class="wp">
        <h1 style="display: inline;margin:0px;float:right;"></h1>
        <div class="search">
            <a class="add-me"><i class="icon-plus"></i> Me</a>
            <from action="">
                <input type="text" name="" class="in_text" placeholder="Searching..">

            </from>

        </div>
        <ul class='hd'>
            <li><a href="/forum"  class="header_items"><p class="none_960">节点 <span>Nodes</span></p><i class="inline_block_960 fa fa-code-fork fa-2x"></i></a></li>

        </ul>



        <span class="clear"></span>
    </div>

</div>

<div id="active">
    <div class='ava_message'>

        {{--<img src="/Image/avatar/noavatar_big.gif" width="80px" style="border-radius:100%;overflow:hidden;" class="left_memu_ava can_set_ava">--}}
        {{ avatar(session('user_info')->uid,80,100,'left_memu_ava can_set_ava') }}
        <p style=''>
            @if(!session('user_info')->uid)
            请<a id='alert_ajax_login' href='/login' style='color: #F09C9C;'>登录</a>您的账号
            @else
            <p>{{session('user_info')->username}}</p>
            @endif

        </p>


        <div class="user_info">
            <span><i class="fa fa-info"></i><?php echo $this->_G['username'];?></span>
            <span><i class="fa fa-coffee"></i>[用户组]</span>
            <span style=" color: #909090;">签名档</span>
        </div>


        <div class='clear'></div>
    </div>


    <div class="operation">

        <ul >
            @if(session('user_info')->uid)
            <li class="trans"><a href="">设置资料<i class="fa fa-pencil-square-o fa-lg"></i></a></li>
            <li class="trans"><a href="">团菌动态<i class="fa fa-sticky-note-o fa-lg"></i></a></li>
            <li class="trans"><a href="/logout">离开<i class="fa fa-sign-in fa-lg"></i></a></li>
                @if(session('user_info')->gid > 0)
                    <li class="trans"><a href="/admincp">管理后台</a></li>
                @endif
            @else
            <li class="trans"><a href="">加入饭团扑?<i class="fa fa-sign-in fa-lg"></i></a></li>
            @endif
        </ul>
    </div>
    <div style="position: fixed;bottom: 0px;width: inherit">
        <p class="statement">Powered by Laravel ∈ PHP</p>
        <p class="statement">Thinks Ruri</p>
    </div>


</div>

<script>
    $(document).ready(function () {
        @if(!session('user_info')->id)
        layer.tips('点这里登录哦', '.memuBtn',{
            tips: [3, 'rgb(255, 136, 175)'],
            time: 4000
        });
        @endif
    })
</script>