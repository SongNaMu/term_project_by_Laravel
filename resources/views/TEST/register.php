<?php
  /*
    1. 회원가입폼에서 입력된 정보를 추출
    2. 모든 입력 필드의 값이 채워져 있는지 check
      2.1 다 채워져 있지 않으면  "다 채워 주세요"라는 메세지를 띄워주고 회원가입폼으로 이동
    3. 아이다가 이미 사용중인지 check
      3.1 이미 사용 중이라면 "이미 사용중인 아이디 입니다."라는 메세지를 띄워주고 회원가입폼으로 이동
    4. 데이터베이스에 회원 정보를 insert
    5. 메인 페이지로 이동
  */
  require_once("./../tools.php");
  require_once("./../memberDAO.php");

  $id = requestValue("id");
  $pwd = requestValue("pwd");
  $name = requestValue("name");

  if($id && $pwd && $name) {
    $mdao = new MemberDao();
    if($mdao->getMember($id)){ //getMember는 동일 아이디가 있는지 없는지 조회하는 메소드
      //에러 메시지 출력하고 폼 페이지로 이동
      errorBack("이미 사용중인 아이디 입니다.");
    }else{
      $mdao->insertMember($id, $pwd, $name);
      okGo("가입이 완료되었습니다."," board.php");
    }
  }else {//입력폼이 다 채워지지 않은 경우
    errorBack("모든 입력란을 채워주세요");
  }
?>
