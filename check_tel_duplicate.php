<?php
$tel1 = $_POST['tel1'];
$tel2 = $_POST['tel2'];
$tel3 = $_POST['tel3'];
$tel = $tel1 . $tel2 . $tel3;
include("connect_db.php");//데이터베이스와 연결

$sql = "
  SELECT*FROM user
  WHERE tel={$tel}
";
$result = mysqli_query($conn, $sql);

$row_number = mysqli_num_rows($result);
if ($row_number == 0) {
    echo "사용 가능한 핸드폰 번호 입니다.";
} else {
    echo "이미 사용 중인 핸드폰 번호 입니다.";
}

?>
