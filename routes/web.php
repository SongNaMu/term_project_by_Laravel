<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/board');
Route::get('/memberList', 'MemberController@memberList');

//Route::get('/board', 'BoardController@boardList');
Route::get('/board', 'BoardController@boardPagenation');

//로그인 화면
Route::get('/login', function () {
    return view('login');
});
//로그인 정보(id, pw)다 입력후 확인 눌렀을시
Route::post('/login', 'MemberController@logintest');
//로그아웃
Route::get('/logout', 'MemberController@logout');

//회원가입 폼 요청
Route::get('/register', function(){
  return view('register');
});
//회원가입 처리
Route::post('/register', 'MemberController@createMember');

//게시글 상세보기
Route::get('/view/','BoardController@viewBoard');


Route::get('/views', function () {
    return view('views');
});
