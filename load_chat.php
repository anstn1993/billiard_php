<?php

session_start();
$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
$sql="
  SELECT*FROM chat
  ORDER BY id DESC
";
$result=mysqli_query($conn, $sql);
//가장 마지막 채팅 데이터를 담는 배열
$row=mysqli_fetch_array($result);
//이 데이터는 당톡방 페이지에 최초로 접근했을 당시의 chat테이블의 가장 마지막 id값이다.
$last_chat_id=$_POST['last_chat_id'];

$sql="
  SELECT*FROM user
  WHERE account='{$row['account']}'
";
$result=mysqli_query($conn, $sql);
$user=mysqli_fetch_array($result);

//chat.php에서 넘어온 마지막 채팅 번호가 실제 데이터 베이스에서의 마지막 채팅 번호와 다르다면
//새롭게 채팅이 등록되었다는 것을 의미하기 때문에 채팅 데이터를 출력해준다.
if($row['id']!=$last_chat_id){
  if($row['account']==$_SESSION['account']){
    echo "
    <div id='chat_mine'>
      <div id='nickname_mine'>
        {$user['nickname']}
      </div>
      <div id='message_mine'>
        {$row['message']}
      </div>
    </div>
    ";
  }else {
    echo "
    <div id='chat_others'>
      <div id='nickname_others'>
        {$user['nickname']}
      </div>
      <div id='message_others'>
        {$row['message']}
      </div>
    </div>
    ";
}

}

 ?>
