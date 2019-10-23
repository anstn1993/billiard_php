<?php
include("connect_db.php");//데이터베이스와 연결


//뉴스 삭제 전체 알고리즘
//1. news_number가 기사의 번호에 해당하는 news_comment의 행들을 먼저 삭제
//3. 뉴스의 number를 참조해서 해당 뉴스 삭제

//내가 삭제하고자 하는 게시물을 선택하기 위한 sql문
$sql = "
  SELECT*FROM news
  WHERE number={$_GET['id']}
";
$result = mysqli_query($conn, $sql);
//내가 선택한 행의 필드 값들을 $row유사배열에 담는다.
$row = mysqli_fetch_array($result);
//해당 행의 글번호 필드인 number의 값을 $row_number에 담는다.
$row_number = $row['number'];
echo $row['number'];

//게시글 속에 저장되어 있던 댓글을 먼저 지워줘야 한다. 번호를 재정렬하고 지우면 news_comment테이블의 뉴스 번호와 달라지기 때문이다.
$sql = "
   DELETE FROM news_comment
    WHERE news_number={$row_number}
";
$result = mysqli_query($conn, $sql);


//글번호와 댓글 테이블의 뉴스 번호의 재정렬이 끝났으면 이제 게시글을 삭제하는 sql문을 작성하고 실행한다.
$sql = "
   DELETE FROM news
    WHERE number={$_GET['id']}
";
$result = mysqli_query($conn, $sql);

//당구 소식 게시판에서 접근했을 때
if (empty($_GET['mypost'])) {
    header('Location: ./news.php?page=' . $_GET['page'] . '&search_value=' . $_GET['search_value']);
} //내가 쓴 게시물 게시판에서 접근했을 때
else {
    header('Location: ./my_news_post.php?page=' . $_GET['page'] . '&mypost=' . $_GET['mypost']);

}
?>
