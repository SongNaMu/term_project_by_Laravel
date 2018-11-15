<?php
  require_once "BoardDao.php";
  $dao = new BoardDao();

  foreach (file('./../rows.txt') as $line){
    $line = trim($line);
    $value = explode('|', $line);
    //0:writer 1:title 2: content
	$dao->insertMsg($value[0],$value[1],$value[2]);
  }
?>
