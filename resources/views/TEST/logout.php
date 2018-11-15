<?php
  /*
    로그아웃
    1. 세션id, 세션name을 제거하고 메인페이지(board.php)로 이동
  */
  session_start();
  unset($_SESSION["id"]);
  unset($_SESSION["name"]);

?>
<script>
  location.href='/board';
</script>
