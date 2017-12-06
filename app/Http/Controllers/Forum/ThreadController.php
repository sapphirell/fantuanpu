<?php

namespace App\Http\Controllers\Forum;

use App\ForumThread;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ThreadController extends Controller
{
    //
    public function NewThreadView()
    {
        return view('PC/Forum/NewThread');
    }

    public function StorePosts(Request $request)
    {
        dd($request);
    }


    /**
     * @param $forumThread ForumThread;
     * @param $tid int 帖子id;
     * @param $page int 帖子页数;
     * @return Response
     * **/
    public function viewThread(ForumThread $forumThread,$tid,$page)
    {
        return $forumThread->findForumThreadByTId($tid,$page);

//        return view('PC.Forum.viewThread');
    }
}
