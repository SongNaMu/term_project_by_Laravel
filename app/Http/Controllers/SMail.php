<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
class SMail extends Controller
{
    //
    function sendmail(){
      $user = array(
        'name' => '송주헌',
        'email' => 'jubal3863@naver.com',
        'code' => 'asdfasdfasdf'
      );

      $data = array(
        'detail' => '내용'
      );

      Mail::to('jubal3863@naver.com')->send(new SendMail($user));
      return 'submit!';
    }


}

//\Mail::send('auth.emails.confirm', compact('user') , function($message) use($user) {
  //          $message->to($user->email);
    //        $message->subject("RMarket 회원가입 확인");
      //  });
