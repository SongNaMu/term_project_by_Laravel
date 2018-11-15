<?php
  define ("MAIN_PAGE","login_main.php");
  define ("NUM_LINES", 5); //한페이지에 출력할 게시글 수
  define ("NUM_PAGE_LINKS", 5);

  function requestValue($name){
    return isset($_REQUEST[$name]) ? $_REQUEST[$name] : "";
  }

  function errorBack($msg){
?>
    <!doctype html>
    <html>
    <head>
      <meta charset="utf-8">
    </head>
    <body>
      <script>
        alert("<?=$msg?>");
        history.back();
      </script>
    </body>
    </html>
<?php
    exit();
  }

  function okGo($msg, $url){
?>
    <!doctype html>
    <html>
    <head>
      <meta charset="utf-8">
    </head>
    <body>
      <script>
        alert("<?php echo"$msg";?>");
        location.href='<?=$url?>';
      </script>
    </body>
    </html>
<?php
    exit();
  }
	function isLogin(){
		
	
	}


?>
