<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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
}
