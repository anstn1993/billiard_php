<?php

//게시물 삭제 전체 알고리즘
//1. event_number가 기사의 번호에 해당하는 event_comment의 행들을 먼저 삭제
//2. event의 number필드를 참조해서 해당 event 삭제

include("connect_db.php");//데이터베이스와 연결
//내가 삭제하고자 하는 이벤트를 선택하기 위한 sql문
$sql = "
  SELECT*FROM event
  WHERE number={$_GET['id']}
";
$result = mysqli_query($conn, $sql);
//내가 선택한 행의 필드 값들을 $row유사배열에 담는다.
$row = mysqli_fetch_array($result);
//해당 행의 글번호 필드인 number의 값을 $row_number에 담는다.
$row_number = $row['number'];
echo $row['number'];
//서버의 event_image폴더에 저장된 이미지를 삭제하는 함수
unlink('event_image/' . $row['image']);

//해당 번호의 댓글을 삭제하는 쿼리문이다.
$sql = "
   DELETE FROM event_comment
   WHERE event_number={$row_number}
";
$result = mysqli_query($conn, $sql);


//글번호와 댓글 테이블의 게시판 번호의 재정렬이 끝났으면 이제 게시물을 삭제하는 sql문을 작성하고 실행한다.
$sql = "
   DELETE FROM event
   WHERE number={$_GET['id']}
";
$result = mysqli_query($conn, $sql);

//이벤트 게시판에서 접근한 경우
if (empty($_GET['mypost'])) {
    header('Location: /event.php?page=' . $_GET['page'] . '&search_category=' . $_GET['search_category'] . '&search_value=' . $_GET['search_value']);
} //내가 쓴 게시물 게시판에서 접근한 경우
else {
    header('Location: /my_event_post.php?page=' . $_GET['page'] . '&mypost=' . $_GET['mypost']);
}


?>
