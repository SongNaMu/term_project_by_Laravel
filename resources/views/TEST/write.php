<?php
  require_once("./../tools.php");
  require_once("BoardDao.php");

  /*
	1. 로그인이 되어있는지 아닌지 확인
	2. title, content 값을 request받은 값으로 저장
	  2.1 writer는 세션에서 로그인한 회원의 id로 저장

    3. 그값이 모두 존재하면 db에 삽입
    $dao = new BoardDao();
    #dao->insertMsg(값....);

    4. 글이 다 입력되면 글 목록 페이지로 이동
    5. 값이 하나라도 없으면 errorBack("모든 항목이 빈칸 없이 입력되어야 합니다.");
  */
  session_start();
  if(isset($_SESSION["id"])){
  }else{
    errorBack("로그인 후에 이용하실 수 있습니다.");
  }

  $writer = isset($_SESSION["id"])? $_SESSION["id"] : "";
  $title = requestValue("title");
  $content = requestValue("content");
  echo "$content<br>$title";

  if(!$title || !$content){
    echo "error";
    errorBack("다 입력하시오");
  }else{
    echo "다 입력됨";
    $dao = new BoardDao();
    $dao->insertMsg($writer, $title, $content);
    okGo("글의 입력이 완료되었습니다.", "board.php");
  }
  echo" 끝";

?>
