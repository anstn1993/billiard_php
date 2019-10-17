<?php
session_start();
$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
$sql="
  SELECT*FROM event
  WHERE number={$_POST['event_id']}
";
$result=mysqli_query($conn, $sql);
$row=mysqli_fetch_array($result);

$event_number=$row['number'];
$account=$_SESSION['account'];
$nickname=$_SESSION['nickname'];
$sql="
  INSERT INTO event_comment
    (event_number, account, nickname, comment, date)
   VALUES(
     '{$event_number}',
     '{$account}',
     '{$nickname}',
     '{$_POST['comment']}',
     NOW()
   )
";


$result=mysqli_query($conn, $sql);
if($result===false){
  echo '저장에 문제가 생김';
  mysqli_error($conn);
}else{
  echo '잘 저장됨';
}

$sql="
UPDATE event
SET
 comment_count=comment_count+1
 WHERE number={$event_number}
";
$result=mysqli_query($conn, $sql);

//이벤트 게시판에서 댓글을 단 경우
if($_POST['mypost']!='yes'){
  header('Location: ./event_detail.php?id='.$_POST['event_id'].'&page='.$_POST['page'].'&search_category='.$_POST['search_category'].'&search_value='.$_POST['search_value']);
}
//내가 쓴 게시판에서 댓글을 단 경우
else {
  header('Location: ./event_detail.php?id='.$_POST['event_id'].'&page='.$_POST['page'].'&mypost='.$_POST['mypost']);
}

 ?>
