<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container">
    <h2>수정 폼</h2>
    <p>수정해 주세요</p>
    <form action="/view/modify" method="post">
      <?= csrf_field() ?>
      <div class="form-group">
        <label for="title">제목 :</label>
        <input type="text" class="form-control" id="title" name="title" value="<?=$board["title"]?>">
      </div>
      <div class="form-group">
        <!-- 작성자는 수정 못하게 비활성화 -->
        <label for="writer">작성자 :</label>
        <input type="text" class="form-control" id="writer" name="member_id" value="<?=$board["member_id"]?>" disabled>
      </div>
      <div class="form-group">
        <label for="content">내용 :</label>
        <div id="editSection"></div>
        <textarea type="hidden" id="content" name="content" style="display: none"><?= $board["content"]?></textarea>
        <input type="hidden" name="id" value="{{$board['id']}}"></input>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
      <input type="button" class="btn btn-primary" onclick="location.href='/board'" value="목록보기">
    </form>
  </div>
    <script>
      var st = document.getElementById("content").innerHTML;
      var editor = new tui.Editor({
        el: document.querySelector('#editSection'),
        initialEditType: 'wysiwyg',
        previewStyle: 'vertical',
        height: '300px',
        initialValue: st,
    		events: {
    			change: function(){
    				document.getElementById("content").value = this.editor.getValue();
    			}
    		}
      });
    </script>
</body>
</html>
