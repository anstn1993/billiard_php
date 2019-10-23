<?php
session_start();
include("connect_db.php");//데이터베이스와 연결

$sql = "
  SELECT*FROM freeboard
  WHERE number={$_POST['article_id']}
";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$freeboard_number = $row['number'];
$account = $_SESSION['account'];
$nickname = $_SESSION['nickname'];
$sql = "
  INSERT INTO freeboard_comment
    (freeboard_number, account, nickname, comment, date)
   VALUES(
     '{$freeboard_number}',
     '{$account}',
     '{$nickname}',
     '{$_POST['comment']}',
     NOW()
   )
";


$result = mysqli_query($conn, $sql);
if ($result === false) {
    echo '저장에 문제가 생김';
    mysqli_error($conn);
} else {
    echo '잘 저장됨';
}

$sql = "
UPDATE freeboard
SET
 comment_count=comment_count+1
 WHERE number={$freeboard_number}
";
$result = mysqli_query($conn, $sql);

//자유게시판에서 댓글을 단 경우
if ($_POST['mypost'] != 'yes') {
    header('Location: ./freeboard_detail.php?id=' . $_POST['article_id'] . '&page=' . $_POST['page'] . '&search_category=' . $_POST['search_category'] . '&search_value=' . $_POST['search_value']);
} //내가 쓴 게시물 게시판에서 댓글을 단 경우
else {
    header('Location: ./freeboard_detail.php?id=' . $_POST['article_id'] . '&page=' . $_POST['page'] . '&mypost=' . $_POST['mypost']);
}

?>
