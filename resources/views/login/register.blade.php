@extends('master')

@section('content')
<div class="container">
<h2>회원가입 폼</h2>
<p>회원가입을 위해 아래의 정보를 작성해주세요</p>
<form action="register" method="post">
  @csrf
  <div class="form-group">
    <label for="usr">NAME:</label>
    <input type="text" class="form-control" id="username" name="name">
  </div>
  <div class="form-group">
    <label for="usr">ID:</label>
    <input type="text" class="form-control" id="userid" name="id">
  </div>
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="text" class="form-control" id="email" name="email">
  </div>
  <div class="form-group">
    <label for="pw">Password:</label>
    <input type="password" class="form-control" id="userpw" name="pw">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
  </div>
@endsection
