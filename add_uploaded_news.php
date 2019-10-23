<?php
include("connect_db.php");//데이터베이스와 연결

$sql_insert = "
  INSERT INTO news
    (title, url, date, view_count, comment_count)
   VALUES(
     '{$_POST['title']}',
     '{$_POST['url']}',
      NOW(),
      '0',
      '0'
   )
";
echo $sql_insert;

$result = mysqli_query($conn, $sql_insert);
if ($result === false) {
    echo '저장에 문제가 생김';
    mysqli_error($conn);
} else {
    echo '잘 저장됨';
}

header('Location: ./news.php');
?>
