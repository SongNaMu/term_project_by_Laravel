@extends('master')
@section('head')
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
@endsection
@section('content')
  <h1>게시글 상세보기</h1>
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
        <td<?= $regtime ?>></td>
      </tr>
      <tr>
        <th>조회수</th>
        <td></td>
      </tr>
      <tr>
        <th>내용</th>
        <td id="content"><?= $content?></td>
      </tr>
    </table>
</div>
@endsection
