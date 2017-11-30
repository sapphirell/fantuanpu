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
    public function __construct(Forum_forum_model $forum_model)
    {
        parent::__construct();
        $this->forumModel = $forum_model;
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


    public function ViewThread(Request $request,$fid,$page){
        echo $fid;
        echo $page;
    }
    public function ForumIndex(Request $request){

        $this->data['forumGroup']   =   $this->forumModel->get_nodes();
//        var_dump($this->data['forumGroup'] );
        return view('PC/Forum/Node')->with('data',$this->data);
    }
    public function talk(Request $request,Forum_forum_model $forum_model)
    {
        return view('PC/Forum/Talk')->with('data',$this->data);
    }


}
