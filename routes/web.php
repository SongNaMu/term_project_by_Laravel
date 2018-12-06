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
    return view('login.login');
});
//로그인 정보(id, pw)다 입력후 확인 눌렀을시
Route::post('/login', 'MemberController@logintest');
//로그아웃
Route::get('/logout', 'MemberController@logout');

//회원가입 폼 요청
Route::get('/register', function(){
  return view('login.register');
});
//회원가입 처리
Route::post('/register', 'MemberController@createMember');

//메일 인증 url
Route::get('/acc/{code}', 'MemberController@checkConfirmCode');
Route::get('/mail','SMail@sendmail');

Route::get('login/github', 'SocialController@redirectToProvider');
Route::get('login/github/callback', 'SocialController@handleProviderCallback');


//게시글 상세보기
Route::get('/view/','BoardController@viewBoard');
//글 작성 폼
Route::get('/write_form','BoardController@write');
//db글 삽입
Route::post('/insertBoard', 'BoardController@insertBoard');
//글삭제 요청
Route::get('/view/delete','BoardController@deleteBoard');
//게시글 수정 폼 요청
Route::get('/view/modify', 'BoardController@modifyRequest');
//게시글 수정 요청
Route::post('/view/modify', 'BoardController@modify');

//댓글 입력
Route::post('/view/comment', 'CommentController@insertComment');
//댓글 삭제
Route::get('/view/comment/delete', 'CommentController@deleteComment');
