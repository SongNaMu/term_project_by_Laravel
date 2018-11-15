<?php
  require_once("BoardDao.php");
  require_once("./../tools.php");


  /* 게시글 삭제
	  1. 세션의 유무 확인
	   1.1 세션의 id와 글작성자의id가 일치하는지 확인
	   1.2 일치하면 게시글 삭제 아니면 errorBack("이 게시글의 작성자가 아닙니다.");
	  2. 세션이 없으면 errorBack("로그인이 필요합니다.")
	*/

  $num = requestValue("num");
  $currentPage = requestValue("page");
  $db = new BoardDao();
  $row = $db->getMsg($num);

  session_start();
	if(isset($_SESSION["id"])){
	  if($_SESSION["id"] != $row["writer"]){
	    errorBack("이 게시글의 작성자가 아닙니다.작성자 : ".$row['writer'].",". $_SESSION['id']);
	  }
	}else{
	  errorBack("로그인이 필요합니다.");
	}


  $db->delete($num);
  okGo("글이 삭제되었습니다.","board.php?page=$currentPage");

?>
