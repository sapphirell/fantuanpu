@include('PC.Suki.SukiHeader')
<style>
    .wp.index_body {
        margin-top: 50px;
    }
    .part_item {
        display: inline-block;
        float: left;
        margin:10px;
        cursor: pointer;
        background: #fbfbfb;
        padding: 10px;
        border: 3px solid #a8c3c1;
        border-radius: 5px;
        border: 3px solid #fbfbfb;
    }
    .part_item > div {
        width: 40px;
        height: 40px;
        background: #ffffff;
        box-shadow: 0 0 5px #afafaf;
        border-radius: 5px;
    }
    .part_item > p {
        text-align: center;
        color: #88b8d2;
        font-size: 11px;
    }
    .system_setting_checkbox {
        width: 45px;
        height: 45px;
        display: inline-block;
        background: #88ebff;
        font-size: 11px;
        color: #fff;
        text-align: center;
        cursor: pointer;
        border-radius: 100%;
        padding: 5px;
        box-shadow: 0 0 10px #64f8fb;
        margin: 5px;
        font-weight: 900;
        background-image: linear-gradient(176deg, #53def5 0%, #c0fff6 100%);
    }
    .selected_part_item {
        background: #d7edff;
        padding: 10px;
        border: 3px solid #a8c3c1;
        border-radius: 5px;
    }
    .w-e-text-container{
        height: 180px !important;/*!important是重点，因为原div是行内样式设置的高度300px*/
        border-color: #e6e2e2!important;
    }
    .w-e-toolbar {
        border: 1px solid #d8d8d8!important;
    }

</style>
<div class="wp index_body">
    <div class="part" style="    overflow-x: auto;white-space: nowrap;display: flex">

        @foreach($data['nodes'] as $value)
        <a href="/forum-{{$value['fid']}}-1.html"  class="part_item fid_{{$value["fid"]}}" fid="{{$value["fid"]}}">
            <div class=""></div>
            <p>{{$value["name"]}}</p>
        </a>
        @endforeach


        {{--<div style="width: 200px;float:right;">--}}
            {{--<div class="system_setting_checkbox" check-arr= >--}}
                {{--浏览全部--}}
            {{--</div>--}}
            {{--<div class="system_setting_checkbox">--}}
                {{--图片展开--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="clear"></div>--}}
    </div>
    <div class="list_container">
        @include('PC.Suki.SukiThreadList')
    </div>
    <div style="    background: #ffffff;
    width: 70%;
    height: 350px;
    position: fixed;
    display: none;
    top: 100px;
    left: 0px;
    right: 0px;
    margin: 0 auto;box-shadow: 0 0 15px #00000026; padding: 10px;">
        <div class="form-group">
            {{--<label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>--}}
            <div class="input-group">
                <div class="input-group-addon" style="    padding: 0px 10px;">
                    <select style="      border-color: #e6e2e2;  height: 30px;border-radius: 0px!important;background: #eee;border: 0px;box-shadow: none!important;" id="post_to_fid">
                        <option>请选择分类</option>

                        @foreach($data['nodes'] as $value)
                            <option value="{{$value["fid"]}}">{{$value["name"]}}</option>
                        @endforeach
                    </select>
                </div>
                <input type="text" class="form-control" id="subject" placeholder="帖子主题" style="border-color: #e6e2e2;">
            </div>
        </div>

        <div id="editor" style="max-height:250px;"></div>
            {!! csrf_field() !!}
            <input type="submit" id="post_thread">
        </form>

    </div>
    <a style="position:fixed;bottom: 120px;right: 20px;">
        <img src="/Static/Image/common/fatie.png" style="width: 40px">
    </a>
</div>
@include('PC.Suki.SukiFooter')
