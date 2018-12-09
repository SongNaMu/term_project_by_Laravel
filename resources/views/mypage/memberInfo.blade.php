@extends('master')

@section('content')
<div class='container'>
  <table class="table">
    <tr>
      <th>이름</th>
      <td>{{$member->name}}</td>
    </tr>
    <tr>
      <th>ID</th>
      <td>{{$member->id}}</td>
    </tr>
    <tr>
      <th>EMAIL</th>
      <td>{{$member->email}}</td>
    </tr>
    <tr>
      <th>PASSWORD</th>
      <td>{{$member->password}}</td>
    </tr>
    <tr>
      <th>즐겨찾기</th>
      <th>번호</th>
      <th>제목</th>
      <th>작성자</th>
      <th>작성일시</th>
      <th>조회수</th>
    </tr>
    <?php
    foreach($board as $row){?>
    <tr>
      <td></td>
      <td><?= $row["id"] ?></td>
      <td><a href="view?num=<?= $row["id"]?>"><?= $row["title"] ?></a></td>
      <td><?= $row["member_id"] ?></td>
      <td><?= $row["regtime"] ?></td>
      <td>0</td>
    </tr>
    <?php
    }?>
  </table>
</div>
@endsection
