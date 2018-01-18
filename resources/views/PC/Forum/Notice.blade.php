@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<script src="/Static/Script/Web/forum.js"></script>
<div class="wp" style="padding: 5px;margin-top: 29px;">
    <div class="bm">
        <div class="bm_h">告示</div>
        <div class="bm_c">
            前言:饭团扑动漫论坛于2013年1月使用discuz x2建站,共收录47282名会员。因疏忽大意,服务器被人提权黑掉了...
            无论如何也拿不回来数据,仅存一份数据库备份文件。故决定抛弃discuz,自己重写一份论坛程序出来;目前正逐步恢复论坛原有的功能和数据,
            并决定在之后会开发论坛app出来,现缺网站管理员、版主等数人,有意者加群192132637联系群主(我)
        </div>
    </div>

    <div class="bm">
        <div class="bm_h">留言</div>
        <div class="bm_c">
            <div style="padding: 5px">

            </div>
            <form action="/notice" method="post" >
                <p>名字:</p>
                <input type="text" name="username" class="form-control">
                <p>留言:</p>
                <textarea  class="form-control"></textarea>
                {{ csrf_field() }}
            </form>
        </div>
    </div>

</div>
@include('PC.Common.Footer')