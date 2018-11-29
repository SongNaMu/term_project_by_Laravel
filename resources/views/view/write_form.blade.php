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
@endsection
@section('content')

<div class="container">
<h2>새 글쓰기 폼</h2>
<p>제목과 내용을 작성해주세요</p>
<form action="insertBoard" method="post">
  @csrf
  <div class="form-group">
    <label for="title">제목 :</label>
    <input type="text" class="form-control" id="title" name="title" >
  </div>
  	<div class="form-group">
   	 <!-- 세션에서 사용자의 name을 받아온다. -->
   	 <label for="writer">작성자 :</label>
   	 <input type="text" class="form-control" id="writer" name="writer" value="<?= session('name')?>"disabled >
  	</div>
  	<div class="form-group">
    	<label for="content">내용 :</label>
			<div id="editSection"></div>
<!-- <textarea class="form-control" rows="5" id="content" name="content" ></textarea>	-->
  	</div>
		<input type="hidden" id="content" name="content">
  <button type="submit" class="btn btn-primary" id="execute">Submit</button>
</form>
 	<input type="button" class="btn btn-primary" onclick="location.href='board'" value="목록보기">


<script>
  var editor = new tui.Editor({
    el: document.querySelector('#editSection'),
    initialEditType: 'wysiwyg',
    previewStyle: 'vertical',
    height: '300px',
		events: {
			change: function(){
				document.getElementById("content").value = this.editor.getMarkdown();
			}
		}
  });
</script>

@endsection
