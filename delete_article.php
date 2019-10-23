<?php
include("connect_db.php");//데이터베이스와 연결


//게시물 삭제 전체 알고리즘
//1. freeboard_number가 기사의 번호에 해당하는 freeboard_comment의 행들을 먼저 삭제
//2. freeboard의 number필드를 참조해서 해당 뉴스 삭제

//내가 삭제하고자 하는 게시물을 선택하기 위한 sql문
$sql = "
    SELECT*FROM freeboard
    WHERE number={$_GET['id']}
  ";
$result = mysqli_query($conn, $sql);
//내가 선택한 행의 필드 값들을 $row유사배열에 담는다.
$row = mysqli_fetch_array($result);
//해당 행의 글번호 필드인 number의 값을 $row_number에 담는다.
$row_number = $row['number'];
echo $row['number'];
//서버의 freeboard_content폴더에 저장된 이미지를 삭제하는 함수
unlink('freeboard_content/' . $row['image']);

//게시글 속에 저장되어 있던 댓글을 먼저 지워줘야 한다. 번호를 재정렬하고 지우면 freeboard_comment테이블의 게시물 번호와 달라지기 때문이다.
$sql = "
     DELETE FROM freeboard_comment
      WHERE freeboard_number={$row_number}
  ";
$result = mysqli_query($conn, $sql);


//글번호와 댓글 테이블의 게시판 번호의 재정렬이 끝났으면 이제 게시물을 삭제하는 sql문을 작성하고 실행한다.
$sql = "
     DELETE FROM freeboard
      WHERE number={$_GET['id']}
  ";
$result = mysqli_query($conn, $sql);

//자유게시판에서 게시물을 삭제할 경우
if (empty($_GET['mypost']) && empty($_GET['mycomment'])) {
    header('Location: /freeboard.php?page=' . $_GET['page'] . '&search_category=' . $_GET['search_category'] . '&search_value=' . $_GET['search_value']);
} //내가 쓴 게시물에서 게시물을 삭제할 경우
else if (!empty($_GET['mypost'])) {
    header('Location: /mypost.php?page=' . $_GET['page'] . '&mypost=' . $_GET['mypost']);
} //내가 댓글 단 게시물에서 게시물을 삭제할 경우
else {
    header('Location: /mycomment.php?page=' . $_GET['page'] . '&mycomment=' . $_GET['mycomment']);
}

?>
