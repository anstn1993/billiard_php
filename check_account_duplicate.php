<?php
$account=$_POST['account'];
$conn=mysqli_connect('127.0.0.1', 'root', 'rla933466r!', 'billiards');
$sql="
  SELECT*FROM user
  WHERE account='{$account}'
";
$result=mysqli_query($conn, $sql);

$row_number=mysqli_num_rows($result);
if($row_number==0){
  echo "사용 가능한 계정 입니다.";
}else{
  echo "이미 사용 중인 계정 입니다.";
}

 ?>
