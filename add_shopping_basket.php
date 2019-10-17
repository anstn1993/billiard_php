<?php
session_start();
$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
$sql="
  INSERT INTO basket
  (product_id, account, nickname)
  VALUES(
      '{$_GET['id']}',
      '{$_SESSION['account']}',
      '{$_SESSION['nickname']}'
    )
";
$result=mysqli_query($conn, $sql);
header('Location: ./product.php?page='.$_GET['page']);
 ?>
