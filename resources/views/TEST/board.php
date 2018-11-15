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
  <style>
    .container{
      max-width: 100%;
      margin: auto 0;
      display: flex;
      justify-content: space-between;
    }
  </style>

  <?php
  require_once(__DIR__."/../tools.php");
  require_once(__DIR__."/BoardDao.php");
  require_once(__DIR__."/../memberDAO.php");
    /*
    1. DB에 등록된 게시글 리스트를 인출(boardDao.php)
    2. 2차원 배열로 반환된 게시글 리스트 각각에 대해
      2.1 HTML문서를 동적으로 생성
      2.2 작성자는 글쓴이의 name을 표여준다.
        <tr>
          <td>번호</td>
          <td>제목</td>
          <td>작성자 name</td>
          <td>작성일시</td>
          <td>조회수</td>
        </tr>
    3. 글쓰기 버튼

    pagenation
    1. page번호 전달되어야 함
    2. 특정 page의 게시글만 리스트로 보여주기 위해서는
      2.1 한 페이지에 보여줄 게식ㄹ의 수
      2.2 게시글의 전체 수
    3. 요청된 page에 해당하는 게시글만 리스트로 출력
    4. 하단에 pagination을 위한 링크를 만들어서 출력
       <1 2 3 4 5 6 7 8 9 10>
       하단에 링크를 출력할 때 고려해야 할 사항
       이전 페이지 링크를 만들 필요가 있는지 여부
       즉, 현재 페이지가 1page라면 이전 페이지 링크는
       필요없다.

       다음 페이지 링크를 만들 필요가 있는지 여부
       즉, 현재 페이지가 마지막 페이지면 다음 페이지 링크를 만들 필요가 없다.

  결정사항 : (1)한페이지에 보여줄 게시글 수 = 5 (NUM_LINES)
            (2)페이지 하단에 표시될 페이지 링크수 = 3 (NUM_PAGELINKS)

    select * from board order by regtime desc

    1page
    foreach(게시글 in 게시판 테이블){
      처음5번의 루프만 돌면서 꺼내고 break;
    }

    2page
    foreach(게시글 in 게시판 테이블){
      처음 5번의 루프는 그냥 돌고
      다음 6번째 부터 10번째까지 레코드를 처리...
      break;
    }

    top-N query
    MySQL 또는 MariaDB에서는 limit절을 이용해서 제공.

    select * from board order by Regtime
    limit start_record, count

    1page 요청 시에는
    select * from board order by Regtime
    limit 0, 5;

    2page 요청 시에는
    select * from board order by Regtime
    limit 5, 5;

    10page 요청 시에는
    select * from board order by Regtime
    limit 45, 5;

page link 만들어 주기
    currnetPage가 1~10일 때
    startPage는 11이다.

    currentPage가 11~20일 때
    startPage는 11이다.

    startPage = 내림((currentPage-1)/NUM_PAGE_LINKS)*(NUM_PAGE_LINKS) + 1
    endPage = startPage + NUM_PAGE_LINKS -1

    endPage는 전체 게시글 수에 따라 더 작은 값이 될수 있다.
    endPage가 10이더라도 전체 게시글 수가 32라면 (한페이지에 10개씩 출력된다고 가정했을때)
    endPage는 4가 되어야 한다.

    totalNumOfPages = 올림(전체 게시글 수)/NUM_LINES
    if(endPage > totalNumOfPages)
      endPage = totalNumOfPages;

    previousPageLink 생성 여부는 startPage가 1이면 생성x
    그외의 경우에는 생성 O

    nextPageLink 생성 여부는  endPage < totalNumOfPages 이면 O
    그 외의 경우에는 X
    */


    $Bdao = new BoardDao();


    //세션 유무에 따라 로그인 상태를 확인하고 로그인,회원가입 or 로그아웃 버튼 생성


    /* currentPage는 주어지는 것
       계산해야 될 것은 startPage, endPage, prevLink, nextLink

    */
    $totalCount = $Bdao->getNumMsgs();
    $currentPage = requestValue("page");
    if($currentPage < 1 | !$currentPage)
      $currentPage = 1;
    $msgs = $Bdao->getManyMesgs(NUM_LINES*($currentPage-1),NUM_LINES);

    session_start();
  ?>

</head>
<body>
	<?php require(__DIR__."/template/header.php");?>
  <div class="container">
    <div id="logo"><h2>게시글 리스트</h2></div>
    <div id="btn-group">
    </div>
  </div>
<?php if(isset($_SESSION['name'])) : ?>
	<h3><?= $_SESSION['name']?>님 환영합니다.</h3>
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
    <td><a href="view?num=<?= $row["num"]?>&page=<?=$currentPage ?>"><?= $row["title"] ?></a></td>
    <td><?= $row["name"] ?></td>
    <td><?= $row["regtime"] ?></td>
    <td><?= $row["hits"] ?></td>
  </tr>

<?php
}?>
  </table>

  <input class="btn btn-info" type="button" value="글쓰기" onclick="location.href='write_form.php'">
  <?php
    echo "<ul class='pagination justify-content-center'>";
    if($currentPage != 1)
      echo "<li class='page-item'><a class='page-link' href='./board?page=1'>처음</a></li>";
    if($prev == false)
      echo "<li class='page-item'><a class='page-link' href='./board?page=",$startPage-1,"'>이전</a></li>";
    for($i = $startPage; $i <= $endPage; $i++){
      if($i == $currentPage)
        echo "<li class='page-item active'><a class='page-link' href='./board?page=$i'>".$i."</a></li>";
      else
        echo "<li class='page-item'><a class='page-link' href='./board?page=$i'>".$i."</a></li>";
    }
    if($next == false)
      echo "<li class='page-item'><a class='page-link' href='./board?page=",$endPage+1,"'>다음</a></li>";
    if($currentPage != $totalPage)
      echo "<li class='page-item'><a class='page-link' href='./board?page=",$totalPage,"'>끝</a></li>";
    echo "</ul>";
    }
  ?>

</body>
</html>
