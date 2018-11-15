<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BoardController;
use App\Member;
class MemberController extends Controller
{
    //

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

      $password = Member::where('id', $id)->value('password');
      if(isset($id) && $password == $pw){
        session_start();
        session(['id' => $id]);
        session(['name' => Member::where('id', $id)->value('name')]);

        return redirect('/board');
      }else{
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

      if(Member::where('id',$id)->value('id')){
        return redirect('/register');
      }else{
        $member->id = $id;
        $member->password = $pw;
        $member->name = $name;
        $member->save();
        
        return redirect('/board');
    }
  }
}
