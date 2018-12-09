<?php

namespace App\Http\Controllers;
use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //
    // 즐겨찾기 추가
    public function boardLike(Request $request){
        $member_id = session('id');
        $board_id = $request->num;

        if(!$member_id){
          session(['message' => '로그인 후에 이용할수 있습니다.']);
          return redirect()->back();
        }

        $like = Like::where('member_id', $member_id)->where('board_id', $board_id)->first();

        if($like){
          $like->delete();
        }else{
          Like::insert(
            [
              'board_id' => "$board_id",
              'member_id' => "$member_id"
            ]);
        }
        return redirect()->back();
    }
}
