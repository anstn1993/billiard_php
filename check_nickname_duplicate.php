<?php
$nickname = $_POST['nickname'];
include("connect_db.php");//데이터베이스와 연결

$sql = "
  SELECT*FROM user
  WHERE nickname='{$nickname}'
";
$result = mysqli_query($conn, $sql);

$row_number = mysqli_num_rows($result);
if ($row_number == 0) {
    echo "사용 가능한 닉네임 입니다.";
} else {
    echo "이미 사용 중인 닉네임 입니다.";
}

?>
