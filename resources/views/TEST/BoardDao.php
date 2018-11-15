<?php
namespace resources\views\TEST;
/*
  사용 테이블
  1. 회원정보테이블 member
  +-------+-------------+------+-----+---------+-------+
| Field | Type        | Null | Key | Default | Extra |
+-------+-------------+------+-----+---------+-------+
| id    | varchar(20) | NO   | PRI | NULL    |       |
| pw    | varchar(20) | YES  |     | NULL    |       |
| name  | varchar(20) | YES  |     | NULL    |       |
+-------+-------------+------+-----+---------+-------+
회원 계정 id
회원 계정 password
회원 이름 name

  2. 게시글 목록 테이블 board
  +---------+-------------+------+-----+---------------------+----------------+
| Field   | Type        | Null | Key | Default             | Extra          |
+---------+-------------+------+-----+---------------------+----------------+
| Num     | int(11)     | NO   | PRI | NULL                | auto_increment |
| Writer  | varchar(20) | YES  |     | NULL                |                |
| Title   | varchar(60) | YES  |     | NULL                |                |
| Content | text        | YES  |     | NULL                |                |
| Regtime | timestamp   | NO   |     | current_timestamp() |                |
| Hits    | int(11)     | YES  |     | 0                   |                |
+---------+-------------+------+-----+---------------------+----------------+
게시글 번호 num
글쓴이(회원 id) Writer
글 제목 title
글 내용 content
글쓴 시간 regtime
조회수 hits

  3. 댓글 테이블
  +--------------+-------------+------+-----+---------------------+----------------+
| Field        | Type        | Null | Key | Default             | Extra          |
+--------------+-------------+------+-----+---------------------+----------------+
| num          | int(11)     | NO   | PRI | NULL                | auto_increment |
| post_num     | int(11)     | YES  |     | NULL                |                |
| writer       | varchar(20) | YES  |     | NULL                |                |
| content      | text        | YES  |     | NULL                |                |
| regtime      | timestamp   | NO   |     | current_timestamp() |                |
| mcomment_num | int(11)     | YES  |     | NULL                |                |
+--------------+-------------+------+-----+---------------------+----------------+
댓글번호 num
글 번호 post_num (어느 글에 달리는 댓글인지...)
댓글 쓴 회원(회원id) writer
댓글 내용 content
댓글 쓴 시간 regtime
부모 댓글(num) (댓글에 달리는 댓글을 만들기 위해 사용) mcomment_num

4. 조회수 view
+----------+------------+------+-----+---------+-------+
| Field    | Type       | Null | Key | Default | Extra |
+----------+------------+------+-----+---------+-------+
| post_num | int(11)    | YES  |     | NULL    |       |
| count    | bigint(21) | NO   |     | 0       |       |
+----------+------------+------+-----+---------+-------+
count는 조회수 테이블에서 각 post_num이 가지는 user_id의 갯수
5.조회수 테이블
+----------+-------------+------+-----+---------+-------+
| Field    | Type        | Null | Key | Default | Extra |
+----------+-------------+------+-----+---------+-------+
| post_num | int(11)     | YES  |     | NULL    |       |
| user_id  | varchar(20) | YES  |     | NULL    |       |
+----------+-------------+------+-----+---------+-------+
 */


  class BoardDao {
    private $db;

    //생성자
    public function __construct(){
      try{
        $this->db = new PDO("mysql:host=localhost;dbname=php","root","123456");
        $this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      }catch(PDOException $e){
        exit($e->getMessage());
      }
    }

    //게시글 생성 함수
    function insertMsg($writer, $title, $content){
      try{
        $sql = "insert into board(writer, title, content) values(:writer, :title, :content)";
        $pstmt = $this->db->prepare($sql);

        $pstmt->bindValue(":writer", $writer, PDO::PARAM_STR);
        $pstmt->bindValue(":title", $title, PDO::PARAM_STR);
        $pstmt->bindValue(":content", $content, PDO::PARAM_STR);

        $pstmt->execute();
      }catch(PDOException $e){
        exit($e->getMessage());
      }
    }

    //글 번호로 게시글 상세정보
    function getMsg($num){
      try{
       // $sql = "select b.num, b.title, b.content, b.regtime, b.hits, b.writer, m.name
       // from board b join member m on b.writer = m.id and num = :num";
		$sql = "select b.num, b.title, b.content, b.regtime, m.name,b.writer, nvl(h.count, 0) hits
				from board b
				left join post_hits h
				on b.num = h.post_num
				join member m
				on b.writer = m.id
				where num = :num";
        $pstmt = $this->db->prepare($sql);
        $pstmt->bindValue(":num", $num, PDO::PARAM_INT);
        $pstmt->execute();
        $result = $pstmt->fetch(PDO::FETCH_ASSOC);
      }catch(PDOException $e){
        exit($e->getMessage());
      }
      return $result;
    }


    //게시글 삭제 함수
    function delete($num){
      try{
        $sql = "delete from board where num = :num";
        $pstmt = $this->db->prepare($sql);
        $pstmt->bindValue(":num", $num, PDO::PARAM_INT);
        $pstmt->execute();

        $sql = "delete from comment where post_num = :num";
        $pstmt = $this->db->prepare($sql);
        $pstmt->bindValue(":num", $num, PDO::PARAM_INT);
        $pstmt->execute();

      }catch(PDOException $e){
        exit($e->getMessage());
      }
    }

    //메인화면 게시글 목록 반환
    function getManyMesgs($startRecord, $count){
      //sql:"select  b.num, b.title, b.content, b.regtime, b.hits, m.name from board b join member m on b.writer = m.id"
      //member 테이블과 board 테이블을 조인
      //게시판에서는 아이디가 아닌 닉네임 노출

      try{
        $sql = "select b.num, b.title, b.regtime, m.name, nvl(h.count, 0) hits
				from board b
				left join post_hits h
				on b.num = h.post_num
				join member m
				on b.writer = m.id
				order by b.regtime desc, b.num desc
				limit :startRecord, :count";
        $pstmt = $this->db->prepare($sql);
        $pstmt->bindValue(":startRecord", $startRecord, PDO::PARAM_INT);
        $pstmt->bindValue(":count", $count, PDO::PARAM_INT);
        $pstmt->execute();
        $result = $pstmt->fetchAll(PDO::FETCH_ASSOC);
      }catch(PDOException $s){
        exit($e->getMessage());
      }
      return $result;
    }

    //게시글 수정 함수
    function updateContent($num, $title, $content){
      try{
        $sql = "update board set title = :title, content = :content  where num=:num";
        $pstmt = $this->db->prepare($sql);
        $pstmt->bindValue(":num", $num, PDO::PARAM_INT);
        $pstmt->bindValue(":title", $title, PDO::PARAM_STR);
        $pstmt->bindValue(":content", $content, PDO::PARAM_STR);

        $pstmt->execute();
      }catch(PDOException $e){
        exit($e->getMessage());
      }
    }

	//댓글 저장 함수
	  function insertComment($post_num, $writer, $content){
	    try{
	  		$sql = "insert into comment(post_num, writer, content)
        values(:post_num, :writer, :content)";
		  	$pstmt = $this->db->prepare($sql);
		  	$pstmt->bindValue(":post_num", $post_num, PDO::PARAM_INT);
		  	$pstmt->bindValue(":writer", $writer, PDO::PARAM_STR);
		  	$pstmt->bindValue(":content", $content, PDO::PARAM_STR);

	  		$pstmt->execute();
	  	}catch(PDOException $e){
		  	exit($e->getMessage());
		  }
	  }

	//댓글의 댓글 저장 함수
	  function insertRecomment($post_num, $writer, $content, $mcomment_num){
	    try{
	  		$sql = "insert into comment(post_num, writer, content, mcomment_num)
        values(:post_num, :writer, :content, :mcomment_num)";
		  	$pstmt = $this->db->prepare($sql);
		  	$pstmt->bindValue(":post_num", $post_num, PDO::PARAM_INT);
		  	$pstmt->bindValue(":writer", $writer, PDO::PARAM_STR);
		  	$pstmt->bindValue(":content", $content, PDO::PARAM_STR);
			$pstmt->bindValue("mcomment_num", $mcomment_num, PDO::PARAM_INT);

	  		$pstmt->execute();
	  	}catch(PDOException $e){
		  	exit($e->getMessage());
		  }
	  }
		//게시글 번호를 입력받아 해당 게시글의 댓글을 반환하는 함수
		function getComment($num){
			try{
				$sql = "select c.num, c.writer, c.content, c.regtime, m.name
        from comment c join member m on (c.writer = m.id)
        where post_num = :num and mcomment_num is null";
				$pstmt = $this->db->prepare($sql);
				$pstmt->bindValue(":num", $num, PDO::PARAM_INT);

				$pstmt->execute();
				$result = $pstmt->fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e->getMessage());
			}
			return $result;
		}

		//댓글 번호를 입력받아 그 댓글의 정보를 반환하는 함수
		function getCommentInfo($num){
			try{
				$sql = "select * from comment where num = :num";
				$pstmt = $this->db->prepare($sql);
				$pstmt->bindValue(":num", $num, PDO::PARAM_INT);

				$pstmt->execute();
				$result = $pstmt->fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e->getMessage());
			}
			return $result;
		}

		//댓글의 댓글
		function getRecomment($mcomment_num){
			try{
				$sql = "select c.num, c.writer, c.content, c.regtime, m.name
        from comment c join member m on (c.writer = m.id)
        where mcomment_num = :mcomment_num";
				$pstmt = $this->db->prepare($sql);
				$pstmt->bindValue(":mcomment_num", $mcomment_num,PDO::PARAM_INT);

				$pstmt->execute();
				$result = $pstmt->fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e->getMessage());
			}
			return $result;
		}

    //
    function getNumMsgs(){
      try{
        $sql = "select count(*) count from board";
        $pstmt = $this->db->query($sql);

        $result = $pstmt->fetch(PDO::FETCH_ASSOC);
      }catch(PDOException $e){
        $e->getMessage();
      }
      return $result;
    }

    function deleteComment($num){
      try{
        $sql = "delete from comment where num = :num";
        $pstmt = $this->db->prepare($sql);
        $pstmt->bindValue(":num",$num,PDO::PARAM_INT);

        $pstmt->execute();
      }catch(PDOException $e){
        $e->getMessage();
      }
    }
	//조회수 테이블에 아이디와 게시글 번호 입력
	function insertHits($post_num, $user_id){
	  try{
		$sql = "insert into hits(post_num, user_id) values(:post_num, :user_id);";
		$pstmt = $this->db->prepare($sql);
		$pstmt->bindValue(":post_num", $post_num, PDO::PARAM_INT);
		$pstmt->bindValue(":user_id", $user_id, PDO::PARAM_STR);

		$pstmt->execute();
	  }catch(PDOException $e){
	    $e->getMessage();
	  }

	}
	//조회수 테이블 조회
	function checkHits($post_num, $user_id){
	  try{
	    $sql = "select * from hits where post_num = :post_num and user_id = :user_id";
		$pstmt = $this->db->prepare($sql);
		$pstmt->bindValue(":post_num",$post_num, PDO::PARAM_INT);
		$pstmt->bindValue(":user_id", $user_id, PDO::PARAM_STR);

		$pstmt->execute();
		$result = $pstmt->fetchAll(PDO::FETCH_ASSOC);
	  }catch(PDOException $e){
	    $e->getMessage();
	  }
	  return $result;
	}
}
?>
