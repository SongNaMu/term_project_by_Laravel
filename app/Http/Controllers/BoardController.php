<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Board;
class BoardController extends Controller
{
    //

    public function boardList(){
        $board = Board::all();
        return view('index')->with('board',$board);
    }
    public static function boardPagenation(){
        $board = Board::paginate(5);
        return view('index')->with('board',$board);
    }

    //게시글 상세보기
    public function viewBoard(){
      $board = Board::find(20);
      $member_id = $board->member_id;
      $title = $board->title;
      $content = $board->content;
      $regtime = $board->regtime;
      return view('view')->with('member_id', $member_id)
      ->with('title', $title)->with('content', $content)
      ->with('regtime', $regtime);
    }
}
