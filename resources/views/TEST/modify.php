<?php
  require_once("BoardDao.php");
  require_once("./../tools.php");

  $db = new BoardDao();

  $num = requestValue("num");
  $title = requestValue("title");
  $content = requestValue("content");
  $currentPage = requestValue("page");
  /* 게시글 수정
	  1. 세션의 유무 확인
	   1.1 세션의 id와 글작성자의id가 일치하는지 확인
	   1.2 일치하면 게시글 수정 아니면 errorBack("이 게시글의 작성자가 아닙니다.");
	  2. 세션이 없으면 errorBack("로그인이 필요합니다.")
	*/
  $row = $db->getMsg("$num");
  session_start();
	if(isset($_SESSION["id"])){
	  if($_SESSION["id"] != $row["writer"]){
	    errorBack("이 게시글의 작성자가 아닙니다.");
	  }
	}else{
	  errorBack("로그인이 필요합니다.");
	}

  //게시글 수정 함수 호출
  $db->updateContent($num, $title, $content);

 // 수정된 게시글의 상세보기 페이지로 이동
  okGo("글의 수정이 완료 되었습니다.","view.php?num=$num&page=$currentPage");

?>
