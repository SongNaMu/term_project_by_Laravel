<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Board;
use App\Like;

class MyPageController extends Controller
{
    //
    public function show(){
      $id = session('id');

      if(!$id){
        session(['message' => '로그인 후에 이용하실수 있습니다.']);
        return redirect()->back();
      }
      $member = Member::where('id',$id)->first();
      $board = Like::where('likes.member_id',$id)->join('boards', 'likes.board_id', 'boards.id')->get();

      return view('mypage.memberInfo')->with('member', $member)->with('board',$board);

    }
}
