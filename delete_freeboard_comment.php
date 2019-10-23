<?php

include("connect_db.php");//데이터베이스와 연결

//삭제할 댓글을 그 댓글의 id를 통해서 찾아내는 쿼리문
$sql = "
  SELECT*FROM freeboard_comment
  WHERE id={$_GET['id']}
";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
//그 삭제할 댓글이 달린 게시물의 번호를 $news_number변수에 저장한다. 이건 해당 댓글이 달린 게시물을 찾아내기 위해서 존재
$freeboard_number = $row['freeboard_number'];
//그 게시물번호에 해당하는 freeboard테이블의 행을 조회하는 쿼리문. 이건 나중에 페이지 이동을 할 때 freeboard의 id값을 url에 넣어주기 위해서 선언한 것.
$sql = "
  SELECT*FROM freeboard
  WHERE number={$freeboard_number}
";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
//header함수에 넣을 url에 들어갈 게시판의 id값을 $freeboard_id변수에 넣어준다.
$freeboard_id = $row['number'];

//해당 댓글을 삭제하는 쿼리문
$sql = "
   DELETE FROM freeboard_comment
    WHERE id={$_GET['id']}
";
$result = mysqli_query($conn, $sql);

$sql = "
UPDATE freeboard
SET
 comment_count=comment_count-1
 WHERE number={$freeboard_number}
";
$result = mysqli_query($conn, $sql);

//자유게시판에서 삭제하는 경우
if (empty($_GET['mypost'])) {
    header('Location: ./freeboard_detail.php?id=' . $freeboard_id . '&page=' . $_GET['page'] . '&search_category=' . $_GET['search_category'] . '&search_value=' . $_GET['search_value']);
} //내가 쓴 게시판에서 삭제하는 경우
else {
    header('Location: ./freeboard_detail.php?id=' . $freeboard_id . '&page=' . $_GET['page'] . '&mypost=' . $_GET['mypost']);
}
?>
