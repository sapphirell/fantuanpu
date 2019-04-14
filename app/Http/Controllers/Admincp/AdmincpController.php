<?php

namespace App\Http\Controllers\Admincp;

use App\Http\DbModel\ForumPostModel;
use App\Http\DbModel\ForumThreadModel;
use App\Http\DbModel\Thread_model;
use App\Http\DbModel\UCenter_member_model;
use App\Http\DbModel\User_model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AdmincpController extends Controller
{
    public function IndexCp()
    {
        $this->data['left_nav'] = ['websocket管理','同步代码','备份静态资源'];
        return view('PC/Admincp/Index')->with('data',$this->data);
    }
    public function webSocketManager()
    {}
    public function userManager(Request $request)
    {
        if ($request->input('username'))
        {
            $this->data['user_info'] = User_model
                ::leftjoin('pre_common_usergroup','pre_common_member.groupid','=','pre_common_usergroup.groupid')
                ->where('username','like',"%{$request->input('username')}%")->get();

        }

        return view('PC/Admincp/UserManager')->with('data',$this->data);
    }
    public function userEdit(Request $request)
    {

        $user = User_model::find($request->input('uid'));

        switch ($request->input('type'))
        {
            case 'closure' :
                if (!empty($user))
                {
                    $user->groupid = 4;
                    $user->save();
                }
                break;
            case  'hidden' :
                if (!empty($user))
                {
                    ForumThreadModel::where('authorid','=',$request->input('uid'))->update('closed',1);
                }
                break;
            case  'clear' :
                if (!empty($user))
                {
                    ForumPostModel::where('authorid','=',$request->input('uid'))->delete();
                    ForumThreadModel::where('authorid','=',$request->input('uid'))->delete();
                }
                break;
            default :
                break;
        }
        User_model::flushUserCache($request->input('uid'));
        return Redirect::back()->withInput();
    }

}
