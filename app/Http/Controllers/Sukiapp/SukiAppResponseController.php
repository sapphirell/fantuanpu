<?php

namespace App\Http\Controllers\Sukiapp;

use App\Http\Controllers\Forum\ThreadController;
use App\Http\DbModel\Forum_forum_model;
use App\Http\DbModel\ForumPostModel;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\UserSettingModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SukiAppResponseController extends Controller
{
    //suki 首页 homePage
    public function suki_home_page(Request $request)
    {
        //suki的板块
        $this->data["suki_forum"] = (new Forum_forum_model())->get_suki_nodes();
        //suki第一页帖子
        $this->data["suki_threads"] = ForumThreadModel::get_new_thread(
            json_decode(session("setting")->lolita_viewing_forum),
            $request->input("page")?:1
        );


        return self::response($this->data);
    }
    public function sukiapp_viewThread(ThreadController $threadController,Request $request)
    {

        if (!$request->input('tid') && !$request->input('pid'))
            return self::response([],40001,'缺少参数tid和pid,必须含有其中之一');

        if ($request->input('pid'))
            $tid = ForumPostModel::where('pid',$request->input('pid'))->first()->tid;
        else
            $tid = $request->input('tid');

        $data = $threadController->_viewThread($tid,$request->input('page')?:0);
        $data['thread']['thread_subject']->avatar =  config('app.online_url').\App\Http\Controllers\User\UserHelperController::GetAvatarUrl($data['thread']['thread_subject']->authorid);
        //对帖子ubb进行处理
        foreach ($data['thread']['thread_post'] as &$value)
        {
            $value->message = str_replace(array(
                '[/color]', '[/backcolor]', '[/size]', '[/font]', '[/align]', '[b]', '[/b]', '[s]', '[/s]', '[hr]', '[/p]',
                '[i=s]', '[i]', '[/i]', '[u]', '[/u]', '[list]', '[list=1]', '[list=a]',
                '[list=A]', "\r\n[*]", '[*]', '[/list]', '[indent]', '[/indent]' ,'[/float]',
            ), array(
                '', '', '', '', '', '', '', '', '', '', '', '', '',
                '', '', '', '', '', '',
                '', '', '', '', '', '',  ''
            ), preg_replace(array(
                "/\[color=([#\w]+?)\]/i",
                "/\[color=((rgb|rgba)\([\d\s,]+?\))\]/i",
                "/\[backcolor=([#\w]+?)\]/i",
                "/\[backcolor=((rgb|rgba)\([\d\s,]+?\))\]/i",
                "/\[size=(\d{1,2}?)\]/i",
                "/\[size=(\d{1,2}(\.\d{1,2}+)?(px|pt)+?)\]/i",
                "/\[font=([^\[\<]+?)\]/i",
                "/\[align=(left|center|right)\]/i",
                "/\[p=(\d{1,2}|null), (\d{1,2}|null), (left|center|right)\]/i",
                "/\[float=left\]/i",
                "/\[float=right\]/i",
                "/\[url=[\w\W]*?\][\w\W]*?\[\/url\]/i"

            ), array(
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                ""
            ), $value->message));
            //            dd( $value->message);
            $value->avatar = config('app.online_url').\App\Http\Controllers\User\UserHelperController::GetAvatarUrl($value->authorid);
            $value->postdate = date("m-d",$value->dateline);
        }


        return self::response($data);
    }
}
