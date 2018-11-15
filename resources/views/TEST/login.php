<?php
  /*
  1. 로그인 입력폼에서 전달된 아이디, 비밀번호 읽기
  2. 로그인 폼에 입력된 아이디의 회원정보를 DB에서 읽기
  3. 그런 아이디를 가진 레코드가 있고, 비밀번호가 맞으면 로그인
  4. 레코드가 없거나, 비밀번호가 틀리면 로그인 폼 페이지로 이동(에러 메세지 출력후)
  */

  require_once(__DIR__."/../tools.php");
  require_once(__DIR__."/../memberDAO.php");



  $id = requestValue("id");
  $pw = requestValue("pw");

  if($id && $pw){//공란이 없다면...
    $dao = new MemberDao();
    $member = $dao->getMember($id);
    $name = $member["name"];
    if($member && $member["pw"] == $pw){//비번이 맞다.
      session_start();
      $_SESSION['id'] = $id;
      $_SESSION['name'] = $name;


      //메인 페이지로 이동
      okGo("로그인에 성공했습니다!","board");

    }else{//아이디가 없거나 비번이 틀리다.
      errorBack("없는 아이디이거나 비밀번호가 틀립니다.");
    }
  }
  errorBack("아이디 또는 비밀번호를 입력해 주십시오 $id, $pw");

?>
