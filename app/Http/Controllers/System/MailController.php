<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //


    /**
     * @param $input ['email'=>'','toUser'=>'','subject'=>'','msg'=>''[,'view'=>'']]
     */
    public static function sendMail($input){

        if ($input['email']&&$input['toUser']&&$input['subject']&&$input['msg']){

            Mail::send("Mail.{$input['view']}", ['key' => $input['msg']], function($message) use ($input)
            {
                $message->to($input['email'], $input['toUser'])->subject($input['subject']);
            });
        }

    }


    /**
     * 发送邮件
     * @param       $email
     * @param       $blade
     * @param array $param
     */
    public static function email_to($email,$blade,array $param)
    {
        //检查用户60秒内有没有发送过邮件
        $cacheKey = CoreController::HAS_POST_MAIL_TO;
        $response = Cache::remember($cacheKey['key'].$email ,$cacheKey['time'],function () use ($email,$param,$blade)
        {
            $accessToken = md5($email.time());
            //发送邮件
            $data['url'] =  self::FANTUANPU_DOMAIN . "retrieve/?source=email&token=".$accessToken;
            $input = [
                'email'     => $email,
                'toUser'    => $email,
                'subject'   => $param["subject"],
                'msg'       => $param["msg"],
                'view'      => $blade
            ];
            self::sendMail($input);

            //添加缓存锁
            return time();
        });
        if ($response == time())
        {
            return self::response(['status'=>true],200,'发送成功');
        }
        else
        {
            return  self::response(['status'=>false],200,'发送失败,发送间隔为60秒');
        }
        //比较发送函数返回的时间戳和当前的时间戳,如果时间戳相等,则是发送成功
    }
}
