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
        return redirect('/board');
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
}
