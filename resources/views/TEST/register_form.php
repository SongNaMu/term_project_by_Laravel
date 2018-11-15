<!DOCTYPE html>
<html lang="en">
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
</head>
<body>
<div class="container">
<h2>회원가입 폼</h2>
<p>회원가입을 위해 아래의 정보를 작성해주세요</p>
<form action="register" method="post">
  <div class="form-group">
    <label for="usr">NAME:</label>
    <input type="text" class="form-control" id="username" name="name">
  </div>
  <div class="form-group">
    <label for="usr">ID:</label>
    <input type="text" class="form-control" id="userid" name="id">
  </div>
  <div class="form-group">
    <label for="pwd">PWD:</label>
    <input type="password" class="form-control" id="userpw" name="pwd">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
  </div>
</body>
</html>
