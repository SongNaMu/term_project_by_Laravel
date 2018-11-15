<?php
  /*
    댓글삭제
    1. 삭제할 댓글의 작성자 id를 request로 받는다
    2. 세션의 id값과 댓글작성자의 id 값을 비교
      2.1 id가 같으면 댓글 삭제
      2.2 id가 다르면 errorBack"댓글 작성자가 아닙니다."
  */

  require_once("BoardDao.php");
  require_once("./../tools.php");

  session_start();

  $db = new BoardDao();
  $num = requestValue("num");
  //댓글쓴이의 id
  $commentInfo = $db->getCommentInfo($num);
	if(!$commentInfo){
		errorBack("없는 댓글입니다.");
	}
  $id = $commentInfo[0]['writer'];
  if($_SESSION["id"] == $id){
    $db->deleteComment($num);
	okGo("댓글이 삭제되었습니다.","view.php?num=".$commentInfo[0]['post_num']."");
  }else{
	errorBack("자신이 쓴 댓글만 지울 수 있습니다");
  }



?>
