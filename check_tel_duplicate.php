<?php
$tel1=$_POST['tel1'];
$tel2=$_POST['tel2'];
$tel3=$_POST['tel3'];
$tel=$tel1.$tel2.$tel3;
$conn=mysqli_connect('127.0.0.1', 'root', 'rla933466r!', 'billiards');
$sql="
  SELECT*FROM user
  WHERE tel={$tel}
";
$result=mysqli_query($conn, $sql);

$row_number=mysqli_num_rows($result);
if($row_number==0){
  echo "사용 가능한 핸드폰 번호 입니다.";
}else{
  echo "이미 사용 중인 핸드폰 번호 입니다.";
}

 ?>
