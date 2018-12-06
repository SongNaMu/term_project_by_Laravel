<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
class CommentController extends Controller
{
    //댓글 삽입
    public function insertComment(Request $request){

      $member_id = session('id');
      $content = $request->content;
      $board_id = $request->board_id;

      if(!$member_id){
        session(['message'=>'로그인 후 이용가능 합니다.']);
        return redirect()->back();
      }

      if(isset($request->comment_id)){//대댓글인 경우 보모 댓글 번호 삽입
        Comment::insert(
          ['board_id' => "$board_id",
          'content' => "$content",
          'member_id' => session('id'),
          'comment_id' => "$request->comment_id"]
        );
      }else{//댓글의 경우
        Comment::insert(
          ['board_id' => "$board_id",
          'content' => "$content",
          'member_id' => session('id')]
        );
      }
      return redirect()->back();
    }

    public function deleteComment(Request $request){
      $member_id = session('id');
      $comment = Comment::where("id","$request->num")->first();

      if($comment['member_id'] == $member_id){
        $comment->delete();
        session(['message' => '댓글이 삭제되었습니다.']);
      }else{
        session(['message' => '권한이 없습니다.']);
      }
      return redirect()->back();
    }
}
