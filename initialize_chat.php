<?php
include("connect_db.php");//데이터베이스와 연결
session_start();
$sql = "
  SELECT*FROM chat
";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
    if ($row['account'] == $_SESSION['account']) {
        echo "
    <div id='chat'>
      {$row['message']} {$row['account']}
    </div>
    ";
    } else {
        echo "
    <div id='chat'>
      {$row['account']} {$row['message']}
    </div>
    ";
    }
};

?>
