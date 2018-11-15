<?php
  require_once(__DIR__."/../tools.php");
  require_once(__DIR__."/BoardDao.php");

  session_start();


  function checkHits($post_num){
  $db = new BoardDao();
  	$result = $db->checkHits($post_num, $_SESSION["id"]);
	if(!$result){
	  $db->insertHits($post_num, $_SESSION["id"]);
	}
  }

?>
