<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BoardController;
use Illuminate\Support\Facades\Validator;
use App\Member;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class MemberController extends Controller
{
    //redirect() -> intended('bbs');
    // 요청 하던중 로그인으로 넘어가서 로그인 하면 아까 요청한 걸로 가고 요청한게 없으면 bbs로 보낸다.

    public function insertMember(){

    }
    public function memberList(){

      $list = Member::get();

      return view('index')->with($list);
    }
    //아이디 비번 확인후 로그인
    public function logintest(Request $request){

      $id = $request->input('id');
      $pw = $request->input('pw');
      $member = Member::where('id', $id)->first();
    if(isset($member)){
      $password = $member->password;
      if($password == $pw && $member->acc == 1 ){
        session_start();
        session(['id' => $id]);
        session(['name' => Member::where('id', $id)->value('name')]);

        return redirect('/board');
      }else if(isset($id) && $password == $pw && $member->acc == 0){//이메일 인증 아직 안함
  
        session(['message'=>'이메일 인증을 해주세요']);
        return redirect('/');
      }else{//비밀번호 틀림
        session(['message'=>'비밀번호를 틀리셨습니다.']);
        return redirect('/login');
      }
    }
      else{
        echo "없는 아이디<br>";
        session(['message'=>'없는 아이디 입니다.']);
        return redirect('/login');
      }
    }

    public function logout(){
      session_start();
      session()->forget('id');
      session()->forget('name');

      return redirect('/board');
    }

    public function createMember(Request $request){
      $member = new Member;

      $id = $request->input('id');
      $pw = $request->input('pw');
      $name = $request->input('name');
      $email = $request->input('email');
      $confirmCode = str_random(60);
      //$this->validate($request, [
      //  'email' => 'required|string|email|max:255|unique:users'
      //]);

      $v = Validator::make($request->all(), [
        'email' => 'required|string|email|max:255|unique:users'
      ]);

      if ($v->fails())
    {
      session(['message'=>'이메일 형식을 확인해 주세요.']);
      return redirect('/register');
    }

      if(Member::where('id',$id)->value('id')){
        session(['message'=>'이미 있는 아이디 입니다.']);
        return redirect('/register');
      }else{
        $member->id = $id;
        $member->password = $pw;
        $member->name = $name;
        $member->email = $email;
        $member->confirm = $confirmCode;
        $member->save();

        $order = ['name' => $name,
                  'email' => $email,
                  'code' => $confirmCode];

        Mail::to("$email")->send(new SendMail($order));

        return redirect('/board');
    }
  }

  function checkConfirmCode($code){
    $member = Member::where('confirm', $code)->first();
    if(isset($member)){
      $member->acc = 1;
      $member->save();
      session(['message'=>'이메일 인증이 완료되었습니다.']);

      return redirect('/');
    }
  }
}
