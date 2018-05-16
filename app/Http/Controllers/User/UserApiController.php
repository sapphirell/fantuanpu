<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\DbModel\UCenter_member_model;


class UserApiController extends Controller
    /*****
     * 该类用于被其它控制器调用,属于直接操作用户模型的类,对于功能仅执行不判断
     */
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function Api_DoLogin(Request $request){

        $User = UCenter_member_model::where('email','=',$request->input('email'))->select()->first();

        return $User->password == md5(md5( $request->input('password') ). $User->salt)

                                    ? UserHelperController::SetLoginStatus($User)

                                    : false ;

    }

}
