<?php
include("connect_db.php");//데이터베이스와 연결
session_start();

$sql = "
    INSERT INTO chat
    (account, message, date)
      VALUES(
          '{$_SESSION['account']}',
          '{$_POST['message']}',
          NOW()
      )
  ";
$result = mysqli_query($conn, $sql);
$sql = "
    SELECT*FROM chat
    ORDER BY id DESC
    ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
echo $row['id'];
?>
