<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\User\UserHelperController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class PictureController extends Controller
{
    //Picture
    public function __construct(){

        parent::__construct();
    }
    //
    public static function AvaCut($position,$imageURL){
        /**
         *  传递过来URL->检查用户是新上传头像还是第二次上传头像,第二次上传头像的话检查是原头像修改还是重新上传的头像
         *
         */
        $uid = session('user_info')->uid;
        $canvas         = json_decode($position);

        foreach (['big'=>200, 'middle'=>120, 'small'=>48] as $key => $value)
        {
            $dir = public_path("Image/user_ava/images/".UserHelperController::GetAvatarDir($uid));
            if (!file_exists($dir))
            {
                mkdir($dir,0777,true);
            }
            $toSizeUrl      = public_path("Image/user_ava/images/".UserHelperController::GetAvatarPath($uid,$key));

            $img            = Image::make($imageURL);

//            $img = \Intervention\Image\Image::make($imageURL);
            //删除已有的
            unlink($toSizeUrl);
//            dd($toSizeUrl);
            //宽度、高度、起点x、起点y
            $img->crop($canvas->width, $canvas->height, $canvas->x, $canvas->y)->resize($value, $value)->save($toSizeUrl);
        }
        unlink($imageURL);
        return true;
    }
}
