<?php
	require_once("BoardDao.php");

	function mkComment($mcomment_num){
		$db = new BoardDao();
		$comment = $db->getRecomment($mcomment_num);
  	if(isset($comment)){
			foreach($comment as $row){
 ?>
			 	<li class="list-group-item list-group-item-secondary" style="margin-left: 20px">
	  		  <?= $row["name"]. " : ". $row["content"]." <b>". $row["regtime"]."</b>" ?><button onclick="location.href='deleteComment.php?num=<?=$row["num"]?>'">댓글삭제</button>
				</li>
<?php
			}
  	}
	}
?>
