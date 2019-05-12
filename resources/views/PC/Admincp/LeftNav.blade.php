<div class="nav"
     style="
    background: #000;
    width: 200px;
    height: 100%;
    top: 50px;
    /*position: fixed;*/
    color: #fff;
    z-index: 9;">
    <div  class="operation" style="width: 100%">

        <ul>
            <li class="trans"><a href="" class="disabled_left">缩小<i class="fa fa-pencil-square-o fa-lg"></i></a></li>
            @foreach($data['left_nav'] as $key=>$value)
                <li class="trans"><a href="/admincp/{{$key}}">{{$value}}<i class="fa fa-pencil-square-o fa-lg"></i></a></li>
            @endforeach
        </ul>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".disabled_left").click(function (e) {
            e.preventDefault()
            $(".nav").hide()
        })
    })

</script>