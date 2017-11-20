<?php

namespace App\Http\Controllers\Forum;

use App\Http\DbModel\Forum_forum_model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ForumBaseController extends Controller
{
    public $forumModel;
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request){

        switch ($mod = $request->input('mod')){

            case 'viewthread':
                return $this->ViewThread($request); break;

            default:
                return $this->ForumIndex($request); break;
                break;
        }


    }


    public function ViewThread(Request $request){

    }
    public function ForumIndex(Request $request){
        $this->forumModel           =   New Forum_forum_model();
        $this->data['forumGroup']   =   $this->forumModel->GetForumGroup();

        return view('PC/Forum/Node')->with('data',$this->data);
    }
    public function talk(Request $request,Forum_forum_model $forum_model)
    {
        return view('PC/Forum/Talk')->with('data',$this->data);
    }
    public function about(){
        $txt= "关于新网站……前段时间好像很多网站都被搞了,饭团也没能幸免,一段时间经常被强制劫持跳转到别的博彩网站上,数据表也崩溃,实在是修的很烦,至今也没找到漏洞的位置,所以之前决定要做一个新的网站的计划还是被提了上来。新的域名fantuanpu.net和服务器都买好了,旧的账号将会可以登录新网站.但是帖子实在无法搬过来,实在抱歉。但是旧网站的数据还是保留着,可以通过旧的域名访问到。如果还有什么问题的话可以通过群来找我";
        dd($txt);
    }

}
