<?php
	$uri = $_SERVER['REQUEST_URI'];
  $route = explode('/',$uri);

  for($i = 0; $i < count($route); $i++){
    echo $route[$i];
  }

?>
