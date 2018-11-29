@extends('master')

@section('content')
<div class="container">
<h2>회원가입 폼</h2>
<p>회원가입을 위해 아래의 정보를 작성해주세요</p>
<form action="register" method="post">
  @csrf
  <div class="form-group">
    <label for="usr">NAME:</label>
    <input type="text" class="form-control" id="username" name="name" required>
  </div>
  <div class="form-group">
    <label for="usr">ID:</label>
    <input type="text" class="form-control" id="userid" name="id" required>
  </div>
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="text" class="form-control" id="email" name="email" required>
  </div>
  <div class="form-group">
    <label for="pw">Password:</label>
    <input type="password" class="form-control" id="userpw" name="pw" required>
  </div>
  <div class="form-group">
      <a class="btn btn-default btn-block" href="/login/github">
        <strong><i class="fa fa-github icon"></i> Login with Github</strong>
      </a>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
  </div>
@endsection
