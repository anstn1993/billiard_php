<?php
include("connect_db.php");//데이터베이스와 연결

$myevent = $_POST['myevent'];
for ($i = 0; $i < count($myevent); $i++) {
    $sql = "
    DELETE FROM event
    WHERE number={$myevent[$i]}
  ";
    $result = mysqli_query($conn, $sql);

    $sql = "
    DELETE FROM event_comment
    WHERE event_number={$myevent[$i]}
  ";
    $result = mysqli_query($conn, $sql);
}

header('Location: ./my_event_post.php');

?>
