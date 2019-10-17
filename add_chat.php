<?php
  session_start();

  $conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
  $sql="
    INSERT INTO chat
    (account, message, date)
      VALUES(
          '{$_SESSION['account']}',
          '{$_POST['message']}',
          NOW()
      )
  ";
  $result=mysqli_query($conn, $sql);
  $sql="
    SELECT*FROM chat
    ORDER BY id DESC
    ";
  $result=mysqli_query($conn, $sql);
  $row=mysqli_fetch_array($result);
  echo $row['id'];
 ?>
