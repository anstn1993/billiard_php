<?php
$myevent=$_POST['myevent'];
$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
for($i=0; $i<count($myevent); $i++){
  $sql="
    DELETE FROM event
    WHERE number={$myevent[$i]}
  ";
  $result=mysqli_query($conn, $sql);

  $sql="
    DELETE FROM event_comment
    WHERE event_number={$myevent[$i]}
  ";
  $result=mysqli_query($conn, $sql);
}

header('Location: ./my_event_post.php');

 ?>
