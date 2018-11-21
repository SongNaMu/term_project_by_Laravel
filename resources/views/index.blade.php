@extends('master')

@section('head')
  <style>
    .container{
      max-width: 100%;
      margin: auto 0;
      display: flex;
      justify-content: space-between;
    }
    .pagenation {
      display: table;
      margin-left: auto;
      margin-right: auto; }
  </style>
@endsection

@section('content')
<div class="container">
  <div id="logo"><h2>게시글 리스트</h2></div>
  <div id="btn-group">
  </div>
</div>
<?php
  $name = session('name');
  if(isset($name)){
?>
<h3><?= $name?>님 환영합니다.</h3>
<?php
}
?>
<table class="table table-striped">
  <tr>
    <th>번호</th>
    <th>제목</th>
    <th>작성자</th>
    <th>작성일시</th>
    <th>조회수</th>
  </tr>

<?php
foreach($board as $row){?>
<tr>
  <td><?= $row["id"] ?></td>
  <td><a href="view?num=<?= $row["id"]?>"><?= $row["title"] ?></a></td>
  <td><?= $row["member_id"] ?></td>
  <td><?= $row["regtime"] ?></td>
  <td>0</td>
</tr>
<?php
}?>

</table>
<input class="btn btn-info" type="button" value="글쓰기" onclick="location.href='write_form.php'">
<div class='pagenation'>
  {{ $board->links() }}
</div>

@endsection
