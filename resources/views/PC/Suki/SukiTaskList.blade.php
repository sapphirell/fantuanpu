@include('PC.Suki.SukiHeader')
<link rel="stylesheet" href="/Static/Style/switcher.css">
<style>
    .take_task {
        border-radius: 5px;
        margin-top: 10px;
        background: #f9c8c9;
        width: 60px;
        display: block;
        color: #fff!important;
        text-align: center;
        background-color: #ffb6c7;
        background-image: linear-gradient(90deg, #fbded9 0%, #ffa5b2 93%);
    }

    @media screen and (max-width: 960px) {

    }
</style>
<div class="wp" style="margin-top: 65px">
    <nav aria-label="breadcrumb" style="margin: 15px 10px;  padding:5px;border-radius: 5px;  background-color: #e9ecef;">
        <div class="btn-group" role="group">
            <button
                    style="    border: 0px;color: #70748c;background-color: #e9ecef;padding: 3px 15px;margin-left: 0px;"
                    id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if($data['request']['type'] =='active')
                    正在进行
                @else
                    接取任务
                @endif
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <a href="/suki_show_task_list" class="dropdown-item" href="#">接取任务</a>
                <a href="/suki_show_task_list?type=active" class="dropdown-item" href="#">我的任务</a>
            </div>
        </div>

    </nav>
    <div style="margin-left: 8px;margin-right: 8px">
        <div>
            @if($data["request"]["type"] == "active")
                @foreach($data["my_task"] as $value)
                    <div>
                        <p>
                            <span style="font-weight: 800;">{{$value->task_name}} []</span>
                        </p>
                        <p style="padding-left: 5px;">
                            <span class="content_box_title">任务描述</span>
                            <span class="content_box_body">{{$value->task_description}}</span>
                        </p>
                        <p style="padding-left: 5px;">
                            <span class="content_box_title">奖励</span>
                            <span class="content_box_body"  style="color: #F28A96;font-size: 14px;">

                                @foreach($value->task_gift as $key => $gift)
                                    {{$gift}}{{\App\Http\DbModel\CommonMemberCount::$extcredits[$key]}}
                                @endforeach
                            </span>
                        </p>
                    </div>
                @endforeach
            @else
                @foreach($data["task_list"] as $task)
                    <div style="border-bottom: 1px dashed #e4e4e4;padding-bottom: 5px;padding-top: 5px">
                        <p>
                            <span style="font-weight: 800;">{{$task["task_name"]}}</span>
                        </p>
                        <p style="padding-left: 5px;">
                            <span class="content_box_title">任务描述</span>
                            <span class="content_box_body">{{$task["task_description"]}}</span>
                        </p>
                        <p style="padding-left: 5px;padding-bottom: 5px;">
                        <span class="content_box_body" style="color: #F28A96;font-size: 14px;">
                            @foreach($task["task_gift"] as $key => $num)
                                {{$key}}+{{$num}}
                            @endforeach
                        </span>
                        </p>
                        @if($task->is_receive)
                            <span>已经领取过</span>
                        @else
                            <a class="take_task" task_id="{{$task->id}}" style="">领取</a>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>

    </div>

</div>

<script>
    $(document).ready(function () {
        $(".take_task").click(function (e) {
            e.preventDefault();
            var task_id = $(this).attr("task_id");
            $.post("/take_task",{"task_id":task_id},function (res) {
                console.log(res)
                alert(res.msg)
            });
        });
    })
</script>
@include('PC.Suki.SukiFooter')