<?php
include("connect_db.php");//데이터베이스와 연결

session_start();
$sql = "
  SELECT*FROM news
  WHERE number={$_POST['news_id']}
";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$news_number = $row['number'];
$account = $_SESSION['account'];
$nickname = $_SESSION['nickname'];
$sql = "
  INSERT INTO news_comment
    (news_number, account, nickname, comment, date)
   VALUES(
     '{$news_number}',
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
UPDATE news
SET
 comment_count=comment_count+1
 WHERE number={$news_number}
";
$result = mysqli_query($conn, $sql);

//당구소식 게시판에서 댓글을 다는 경우
if ($_POST['mypost'] != 'yes') {
    header('Location: ./news_detail.php?id=' . $_POST['news_id'] . '&page=' . $_POST['page'] . '&search_value=' . $_POST['search_value']);
} //내가 쓴 게시물 게시판에서 댓글을 다는 경우
else {
    header('Location: ./news_detail.php?id=' . $_POST['news_id'] . '&page=' . $_POST['page'] . '&mypost=' . $_POST['mypost']);
}

?>
