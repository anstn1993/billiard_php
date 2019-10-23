<?php
include("connect_db.php");//데이터베이스와 연결

//체크박스에 체크가 된 게시물의 번호를 담는 배열
$mypost = $_POST['mypost'];
//배열의 크기만큼 반복문을 돌면서 해당 번호의 게시물, 그리고 그 게시물의 댓글을 삭제한다.
for ($i = 0; $i < count($mypost); $i++) {
    //게시물을 삭제하는 쿼리문
    $sql = "
    DELETE FROM freeboard
    WHERE number={$mypost[$i]}
  ";
    $result = mysqli_query($conn, $sql);
    //게시물을 지웠으면 그 게시물에 담겨있는 댓글도 지워줘야 한다.
    $sql = "
    DELETE FROM freeboard_comment
    WHERE freeboard_number={$mypost[$i]}
  ";
    $result = mysqli_query($conn, $sql);
}


header('Location: ./mypost.php');

?>
