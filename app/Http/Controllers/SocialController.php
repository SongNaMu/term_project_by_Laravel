<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;

class SocialController extends Controller
{
    //
    public function redirectToProvider()
   {
       return \Socialite::driver('github')->redirect();
   }

   /**
    * Obtain the user information from GitHub.
    *
    * @return \Illuminate\Http\Response
    */
   public function handleProviderCallback()
   {
       $member = new Member;
       $user = \Socialite::driver('github')->user();

// All Providers
      echo "id : ".$user->getId().
      '<br>nickname : '.$user->getNickname().
      '<br>name : '.$user->getName().
      '<br>email : '.$user->getEmail().
      '<br> avartar : <img src="'.$user->getAvatar().'">';
       // $user->token;
       $name = Member::where('id', $user->getId())->value('name');
       if(isset($name)){

       }else{
         $member->id = $user->getId();
         $member->email = $user->getEmail();
         $member->name = $user->getNickname();
         $member->acc = 1;
         $member->save();
       }


       session(['id' => $user->getId()]);
       session(['name' => $user->getNickname()]);

       return redirect('/');
   }
}
