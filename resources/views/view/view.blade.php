@extends('master')
@section('head')
<script src="/css/tui/bower_components/jquery/dist/jquery.js"></script>
<script src='/css/tui/bower_components/markdown-it/dist/markdown-it.js'></script>
<script src="/css/tui/bower_components/to-mark/dist/to-mark.js"></script>
<script src="/css/tui/bower_components/tui-code-snippet/dist/tui-code-snippet.js"></script>
<script src="/css/tui/bower_components/codemirror/lib/codemirror.js"></script>
<script src="/css/tui/bower_components/highlightjs/highlight.pack.js"></script>
<script src="/css/tui/bower_components/squire-rte/build/squire-raw.js"></script>
<script src="/css/tui/bower_components/tui-editor/dist/tui-editor-Editor.js"></script>
<link rel="stylesheet" href="/css/tui/bower_components/codemirror/lib/codemirror.css">
<link rel="stylesheet" href="/css/tui/bower_components/highlightjs/styles/github.css">
<link rel="stylesheet" href="/css/tui/bower_components/tui-editor/dist/tui-editor.css">
<link rel="stylesheet" href="/css/tui/bower_components/tui-editor/dist/tui-editor-contents.css">
<style>
  .hiddenform{
    display : none;
  margin-left : 20px;
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
@endsection
@section('content')
  <div class='container'>
    <table class="table">
      <tr>
        <th>제목</th>
        <td><?= $title ?></td>
      </tr>
      <tr>
        <th>작성자</th>
        <td><?= $member_id ?></td>
      </tr>
      <tr>
        <th>작성일시</th>
        <td><?= $regtime ?></td>
      </tr>
      <tr>
        <th>조회수</th>
        <td>{{$hit}}</td>
      </tr>
      <tr>
        <th>내용</th>
        <td id="content"></td>
      </tr>
    </table>

    <p id="dummycontent"style="display:none"><?=$content?></p>
    <b>전체 댓글</b>
    <!-- 댓글과 대댓글 출력 및 대댓글 입력 폼 -->
    <ul>
<?php
  foreach($comment as $row) :?>
<?php if($row["comment_id"]){ ?>
    <li class="list-group-item list-group-item-secondary" style="margin-left: 20px">
<?php }else{?>
    <li class="list-group-item list-group-item-primary" onclick="mkform(<?=$row["id"]?>);">
<?php }?>
      <?= $row["member_id"]." : ".$row["content"]." <b>". $row["regtime"]."</b>" ?><button onclick="location.href='/view/comment/delete?num={{$row['id']}}'">댓글삭제</button>
    </li>
    <div class="hiddenform" id="<?= $row["id"]?>">
      <form class="form" action="view/comment" method="post">
        @csrf
        <div class="form-group">
          <label for="content"><b>작성자 : <?= session("name") ?></b></label>
          <textarea class="form-control" row="2" id="content" name="content"></textarea>
          <input type="hidden" name="board_id" value="<?= $num ?>">
          <input type="hidden" name="comment_id" value="<?= $row["id"] ?>">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">댓글등록</button>
        </div>
      </form>
    </div>

<?php endforeach ?>
</ul>

<!-- 댓글 작성하는 폼 -->
<form class="form" action="view/comment" method="post">
  @csrf
  <div class="form-group">
  <label for="content"><b>작성자 : <?=session('name') ?></b></label>
  <textarea class="form-control" row="2" id="content" name="content"></textarea>
  <input type="hidden" name="board_id" value="<?= $num ?>">
  </div>
  <div class="form-group">
  <button type="submit" class="btn btn-primary">댓글등록</button>
  </div>
</form>

<input type="button" class="btn btn-primary" onclick="location.href='board'" value="목록보기">
<?php
if($like == 0){
?>
  <input type="button" class="btn btn-danger" onclick="location.href='/view/like?num={{$num}}'" value="즐겨찾기 삭제">
<?php
  }else{
?>
  <input type="button" class="btn btn-success" onclick="location.href='/view/like?num={{$num}}'" value="즐겨찾기">
<?php
}
?>

<?php
  if(session('id') == $member_id){
?>
<input type="button" class="btn btn-success" onclick="location.href='/view/modify?num={{$num}}'" value="수정">
<input type="button" class="btn btn-danger" onclick="location.href='/view/delete?num={{$num}}'" value="삭제">
<?php
  }
?>
  </div>
<script>
var editor = new tui.Editor.factory({
  el: document.querySelector('#content'),
  height: '1500px',
  viewer: true,
  initialValue: document.getElementById('dummycontent').innerHTML
});

function deleteComment(){
  alert("댓글을 삭제하시게습니까?");
}
function deleteBoard(){
  alert("게시글을 삭제 하시겠습니까?");
}
</script>
@endsection
