<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Board;
use App\Comment;
class BoardController extends Controller
{
    //

    public function boardList(){
        $board = Board::all();
        return view('index')->with('board',$board);
    }
    public static function boardPagenation(){
        $board = Board::orderby('id','desc')->paginate(5);

        return view('index')->with('board',$board);
    }

    //게시글 상세보기
    public function viewBoard(Request $request){
      $num = $request->get('num');

      $board = Board::find($num);
      $comment = Comment::where('board_id', $num)->orderByRaw('if(isnull(comment_id), id, comment_id), regtime')->get();


      $member_id = $board->member_id;
      $title = $board->title;
      $content = $board->content;
      $regtime = $board->regtime;

      //foreach($comment as $key => $value){
      //  echo "$key : $value <br>";
      //}
      return view('view.view')->with('member_id', $member_id)
      ->with('title', $title)->with('content', $content)
      ->with('regtime', $regtime)->with('comment', $comment)->with('num', $board->id);
    }

    //글쓰기 양식 요청
    public function write(Request $request){
      $id = session('id');
      if(isset($id)){
        return view('view.write_form');
      }else{
        $message = '로그인후 이용 가능합니다.';
        return redirect('/board')->with('message', $message);
      }
    }
    //DB에 작성글 삽입
    public function insertBoard(Request $request){
      $id = session('id');
      $title = $request->title;
      $content = $request->content;
      Board::insert(
        ['member_id' => "$id",
        'title' => "$title",
        'content' => "$content"]
      );

      return redirect('/');
    }

    //게시글 수정 폼 요청
    public function modifyRequest(Request $request){
      $num = $request->num;
      $board = Board::where('id', "$num")->first();
      $id = session('id');
      //잘못된 게시글 번호(없는 게시글 번호)

      //해달 게시글의 작성자가 아니경우
      if($id != $board['member_id']){
          session(['message' => '게시글의 작성자가 아닙니다.']);
          return redirect()->back();
      }else{
          return view("view.modify")->with('board', $board);
      }
    }
    //DB에서 게시글 수정
    public function modify(Request $request){
      $member_id = session('id');
      $board = Board::where('id', "$request->id")->first();
      if($member_id == $board['member_id']){
        $board['title'] = $request->title;
        $board['content'] = $request->content;
        $board->save();
        return redirect("/view?num=$request->id");
      }else{
        session(['message' => '잘못된 요청입니다.']);
        return redirect()->back();
      }
    }

    //게시글 삭제 요청
    public function deleteBoard(Request $request){
      $member_id = session('id');
      $board = Board::where('id', "$request->num")->first();

      if($member_id == $board['member_id']){
        $board->delete();
      }else{
          session(['message' => '권한이 없습니다.']);
      }
      return redirect('/');
    }


}
