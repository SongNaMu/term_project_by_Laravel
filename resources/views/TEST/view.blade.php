<?php
  require_once(__DIR__."/../tools.php");
  require_once(__DIR__."/BoardDao.php");
  require_once(__DIR__."/recomment.php");
  require_once(__DIR__."/checkHits.php");
  /*
    글 상세보기
    1. 세션id를 이용해 로그인한 이용자만 상세내용을 볼수있음
      1.1 로그인이 되어있지 않다면 로그인 화면으로 이동

    2. request에서 글의 id를 추출
    3. 해당 번호의 글을 읽고, 조회 수 1 증가
  */
  //session_start();
  if(!isset($_SESSION["id"])){
    okGo("상세보기는 회원만 할 수 있습니다.","login");
  }
	//num = 게시글 번호
  $num = requestValue("num");
  $currentPage = requestValue("page");
  $dao = new BoardDao();
  checkHits($num);
  $msg = $dao->getMsg($num);
  $comment = $dao->getComment($num);
	require_once(__DIR__."/template/header.php");
?>
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
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
		<style>
	  .hiddenform{
	    display : none;
		margin-left : 20px;
	  }
      .comment{
        border-top-style: solid;
        margin-bottom : 3px;
      }
      .form{
        margin-top: 15px;
        margin-bottom: 15px;

        border-style: solid;
        border-color : blue;
        border-left: none;
        border-right: none;
      }
      ul{
        list-style:none;
        padding-left:0px;
      }

    </style>
	<script>
		function mkform(num){
		  divEl = document.getElementById(num);
		  classN = document.getElementsByClassName("hiddenform");

		  if(divEl.style.display == "block"){
		    divEl.style.display = "none";
		  }else{
			for(i=0; i<classN.length; i++){
			  classN[i].style.display = "none";
			}
		    divEl.style.display = "block";
		  }
		  console.log(divEl.style.display);
		}
	</script>
  </head>
  <body>
	<h1><?=$num?></h1>
    <div class="container">
      <table class="table">
        <tr>
          <th>제목</th>
          <td><?= $msg["title"] ?></td>
        </tr>
        <tr>
          <th>작성자</th>
          <td><?= $msg["name"] ?></td>
        </tr>
        <tr>
          <th>작성일시</th>
          <td><?= $msg["regtime"] ?></td>
        </tr>
        <tr>
          <th>조회수</th>
          <td><?= $msg["hits"] ?></td>
        </tr>
        <tr>
          <th>내용</th>
          <td id="content"></td>
        </tr>
      </table>
      <hr>
      <p id="dummycontent"style="display:none"><?=$msg["content"]?></p>
			<!-- 댓글 -->
			<b>전체 댓글</b>
			<ul>
			<?php
				foreach($comment as $row) :?>

          <li class="list-group-item list-group-item-primary" onclick="mkform(<?=$row["num"]?>);">
            <?= $row["name"]." : ".$row["content"]." <b>". $row["regtime"]."</b>" ?><button onclick="location.href='deleteComment.php?num=<?=$row["num"]?>'">댓글삭제</button>
          </li>

		  <div class="hiddenform" id="<?= $row["num"] ?>">
	  		<form class="form" action="insertRecomment" method="post">
	   		  <div class="form-group">
		  		<label for="content"><b>작성자 : <?=$_SESSION["name"] ?></b></label>
		  		<textarea class="form-control" row="2" id="content" name="content"></textarea>
				<input type="hidden" name="post_num" value="<?= $msg["num"] ?>">
				<input type="hidden" name="mcomment_num" value="<?= $row["num"] ?>">
	    	  </div>
  			  <div class="form-group">
  				<button type="submit" class="btn btn-primary">댓글등록</button>
  			  </div>
			</form>
		  </div>

		 	 <?php
  				  mkComment($row["num"]);
  				?>

			<?php endforeach ?>
      </ul>

		<!-- 댓글 입력란 -->

	  <form class="form" action="comment" method="post">
      @csrf
	    <div class="form-group">
		  <label for="content"><b>작성자 : <?=$_SESSION["name"] ?></b></label>
		  <textarea class="form-control" row="2" id="content" name="content"></textarea>
			<input type="hidden" name="post_num" value="<?= $msg["num"] ?>">
	    </div>
  		<div class="form-group">
  		<button type="submit" class="btn btn-primary">댓글등록</button>
  		</div>

	  </form>
    <input type="button" class="btn btn-primary" onclick="location.href='board.php?page=<?=$currentPage?>'" value="목록보기">
		<?php
			if($_SESSION["id"] == $msg["writer"]){
?>
    <input type="button" class="btn btn-success" onclick="location.href='modify_form.php?num=<?= $num ?>&page=<?=$currentPage ?>'" value="수정">
    <input type="button" class="btn btn-danger" onclick="location.href='delete.php?num=<?= $num ?>&page=<?=$currentPage?>'" value="삭제">
	<?php
			}
?>
	</div>
  <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
  <script>

  //var st = document.getElementById('content').innerHTML;
  //document.getElementById('content').innerHTML = marked(st);

  var editor = new tui.Editor.factory({
    el: document.querySelector('#content'),
    height: '1500px',
    viewer: true,
    initialValue: document.getElementById('dummycontent').innerHTML
  });
  </script>
	</body>
</html>
