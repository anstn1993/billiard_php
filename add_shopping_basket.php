<?php
include("connect_db.php");//데이터베이스와 연결

session_start();
$sql = "
  INSERT INTO basket
  (product_id, account, nickname)
  VALUES(
      '{$_GET['id']}',
      '{$_SESSION['account']}',
      '{$_SESSION['nickname']}'
    )
";
$result = mysqli_query($conn, $sql);
header('Location: ./product.php?page=' . $_GET['page']);
?>
