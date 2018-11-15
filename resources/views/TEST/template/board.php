<?php
$Bdao = new BoardDao();
$totalCount = $Bdao->getNumMsgs();
$currentPage = requestValue("page");
if($currentPage < 1 | !$currentPage)
  $currentPage = 1;
$msgs = $Bdao->getManyMesgs(NUM_LINES*($currentPage-1),NUM_LINES);
//echo "왜 안나와 currentPage = $currentPage,".NUM_LINES*($currentPage-1).", ".NUM_LINES."";
?>

<?php if(isset($_SESSION["id"])) : ?>
<h3><?= $_SESSION["name"]?>님 환영합니다.</h3>
<?php endif ?>
<table class="table table-striped">
<tr>
  <th>번호</th>
  <th>제목</th>
  <th>작성자</th>
  <th>작성일시</th>
  <th>조회수</th>
</tr>

<?php
if($totalCount> 0){

$startPage = floor(($currentPage-1)/NUM_PAGE_LINKS)*NUM_PAGE_LINKS+1;
//http://localhost/bbs/board.php?page=3;
$endPage = $startPage + NUM_PAGE_LINKS - 1;
//total page : ceil(전체 게시글 수 / NUM_LINES)
$totalPage = ceil($totalCount["count"]/NUM_LINES);

if($endPage > $totalPage)
  $endPage = $totalPage;

$prev = false;
$next = false;

if($startPage == 1)
  $prev = true;

if($endPage == $totalPage)
  $next = true;

$startRecord = ($currentPage-1)*NUM_LINES;

//echo "current = $currentPage<br>";
//echo "totalcount = ".$totalCount["count"] ." <br> totalPage = $totalPage<br>";
//echo "startPage = ".$startPage ." <br> endPage = $endPage<br>";

foreach($msgs as $row){?>
<tr>
<td><?= $row["num"] ?></td>
<td><a href="view.php?num=<?= $row["num"]?>&page=<?=$currentPage ?>"><?= $row["title"] ?></a></td>
<td><?= $row["name"] ?></td>
<td><?= $row["regtime"] ?></td>
<td><?= $row["hits"] ?></td>
</tr>

<?php
}?>
</table>
<div>
  <input class="btn btn-info" type="button" value="글쓰기" onclick="location.href='write_form.php'">
  <ul class='pagination justify-content-center'>
    <?php
    if($currentPage != 1)
      echo "<li class='page-item'><a class='page-link' href='./board.php?page=1'>처음</a></li>";
    if($prev == false)
      echo "<li class='page-item'><a class='page-link' href='./board.php?page=",$startPage-1,"'>이전</a></li>";
    for($i = $startPage; $i <= $endPage; $i++){
      if($i == $currentPage)
        echo "<li class='page-item active'><a class='page-link' href='./board.php?page=$i'>".$i."</a></li>";
      else
        echo "<li class='page-item'><a class='page-link' href='./board.php?page=$i'>".$i."</a></li>";
    }
    if($next == false)
      echo "<li class='page-item'><a class='page-link' href='./board.php?page=",$endPage+1,"'>다음</a></li>";
    if($currentPage != $totalPage)
      echo "<li class='page-item'><a class='page-link' href='./board.php?page=",$totalPage,"'>끝</a></li>";
    }
    ?>
  </ul>
</div>
