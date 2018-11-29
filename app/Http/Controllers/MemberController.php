<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BoardController;
use App\Member;
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
      $password = $member->password;
      if(isset($id) && $password == $pw && $member->acc == 1 ){
        session_start();
        session(['id' => $id]);
        session(['name' => Member::where('id', $id)->value('name')]);

        return redirect('/board');
      }else if(isset($id) && $password == $pw && $member->acc == 0){//이메일 인증 아직 안함
        echo " 이메일 인증을 해주세요<br>";
        return redirect('/login');
      }
      else{
        echo "없는 아이디거나 틀린 비밀번호<br>";

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

      if(Member::where('id',$id)->value('id')){
        return redirect('/register');
      }else{
        $member->id = $id;
        $member->password = $pw;
        $member->name = $name;
        $member->email = $email;
        $member->save();

        return redirect('/board');
    }
  }
}
