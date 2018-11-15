<?php
	require_once("BoardDao.php");
	require_once("./../tools.php");


	session_start();
	/*
	1.로그인 여부 확인
	2.댓글내용과 작성자, 게시글 번호를 db의 comment테이블에 삽입
	3."댓글이 작성되었습니다"라는 메세지를 보여주고 게시글 상세보기 페이지로 이동

	*/
	if(!isset($_SESSION["id"])){
		errorBack("로그인이 필요합니다.");
	}
	$db = new BoardDao();

	$content = requestValue("content");
	$writer = $_SESSION["id"];
	$post_num = requestValue("post_num");

  if(!$content)
    errorBack("내용을 입력해 주세요");

	$db->insertComment($post_num, $writer, $content);
	okGo("댓글이 작성되었습니다.", "view?num=$post_num");







?>
