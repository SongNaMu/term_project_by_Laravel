<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Latest compiled and minified CSS -->
	<script src="../tui/bower_components/jquery/dist/jquery.js"></script>
	<script src='../tui/bower_components/markdown-it/dist/markdown-it.js'></script>
	<script src="../tui/bower_components/to-mark/dist/to-mark.js"></script>
	<script src="../tui/bower_components/tui-code-snippet/dist/tui-code-snippet.js"></script>
	<script src="../tui/bower_components/codemirror/lib/codemirror.js"></script>
	<script src="../tui/bower_components/highlightjs/highlight.pack.js"></script>
	<script src="../tui/bower_components/squire-rte/build/squire-raw.js"></script>
	<script src="../tui/bower_components/tui-editor/dist/tui-editor-Editor.js"></script>
	<link rel="stylesheet" href="../tui/bower_components/codemirror/lib/codemirror.css">
	<link rel="stylesheet" href="../tui/bower_components/highlightjs/styles/github.css">
	<link rel="stylesheet" href="../tui/bower_components/tui-editor/dist/tui-editor.css">
	<link rel="stylesheet" href="../tui/bower_components/tui-editor/dist/tui-editor-contents.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<?php
  require_once("./../tools.php");

  session_start();
  if(isset($_SESSION["id"])){
	}else{
	  errorBack("로그인 후에 이용하실수 있습니다.");
	}
	require_once("./template/header.php");
?>
</head>
<body>
<div class="container">
<h2>새 글쓰기 폼</h2>
<p>제목과 내용을 작성해주세요</p>
<form action="write.php" method="post">
  <div class="form-group">
    <label for="title">제목 :</label>
    <input type="text" class="form-control" id="title" name="title" >
  </div>
  	<div class="form-group">
   	 <!-- 세션에서 사용자의 name을 받아온다. -->
   	 <label for="writer">작성자 :</label>
   	 <input type="text" class="form-control" id="writer" name="writer" value="<?= $_SESSION["name"]?>"disabled >
  	</div>
  	<div class="form-group">
    	<label for="content">내용 :</label>
			<div id="editSection"></div>
<!-- <textarea class="form-control" rows="5" id="content" name="content" ></textarea>	-->
  	</div>
		<input type="hidden" id="content" name="content">
  <button type="submit" class="btn btn-primary" id="execute">Submit</button>
</form>
 	<input type="button" class="btn btn-primary" onclick="location.href='board.php'" value="목록보기">


<script>
  var editor = new tui.Editor({
    el: document.querySelector('#editSection'),
    initialEditType: 'wysiwyg',
    previewStyle: 'vertical',
    height: '300px',
		events: {
			change: function(){
				document.getElementById("content").value = this.editor.getValue();
			}
		}
  });
</script>

</body>
</html>
