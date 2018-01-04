@include('PC.Common.Header')
<link rel="stylesheet" type="text/css" href="/Static/Style/Web/forum.css">
<script src="/Static/Script/Web/forum.js"></script>
<style>
    .fourm_thread_items {    padding: 5px 8px;background: #ffffff}
    .wp {
        margin-top: 29px;
        box-shadow: 0 0 11px #e6e6e6;
        border-radius: 5px 5px 0px 0px;
        overflow: hidden;
        padding: 0px!important;
    }
    .wp .fourm_thread_items {
        margin: 0px;
    }
</style>
<script>
    $(document).ready(function () {
        $(".show_date").mouseout(function () {
            $(this).hide().siblings('.show_time').show()
        })
        $(".show_time").hover(function(){
            $(this).hide().siblings('.show_date').show()
        });
    })
</script>
<body>

<div class="wp">
    <div class="theme">
        <h1 class="thread_title"><?php echo $data['subject'] ;?></h1>
        <time class="thread_time">Released time : <?php echo date("F d  - Y  , H:i:s",$thread_subject['dateline'])?></time>
        <p class="message">{{$thread_party[0]['message']}}</p>
    </div>


</div>

@include('PC.Common.Footer')