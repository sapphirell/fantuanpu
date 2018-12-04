<div class="poster_content animated " style=" animation-duration: 0.35s; z-index: 10999999;  background: #ffffff;width: 70%;height: 350px;position: fixed;display: none;top: 100px;left: 0px;right: 0px;margin: 0 auto;box-shadow: 0 0 15px #00000026; padding: 10px;">
    <div class="form-group">
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