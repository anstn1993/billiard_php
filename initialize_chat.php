<?php
session_start();
$conn=mysqli_connect('localhost','root','rla933466r!','billiards');
$sql="
  SELECT*FROM chat
";
$result=mysqli_query($conn, $sql);
while($row=mysqli_fetch_array($result)){
  if($row['account']==$_SESSION['account']){
    echo "
    <div id='chat'>
      {$row['message']} {$row['account']}
    </div>
    ";
  }else {
    echo "
    <div id='chat'>
      {$row['account']} {$row['message']}
    </div>
    ";
  }
};

 ?>
