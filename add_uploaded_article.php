<?php
session_start();
// //이 함수는 실제 디렉토리에 파일을 추가해주는 함수다. 첫번째 파라미터에 '경로/파일명'을 지정해주고, 두번째 파라미터에 파일에 들어갈 데이터를 입력해주면 된다. 하지만 보통은 게시물을 업로드하면 그 게시물이 업로드 된 페이지로 이동되기 마련인데 이렇게만 두면 굉장히 이상해진다.
// file_put_contents('freeboard_data/'.$_POST['title'], $_POST['article']);
// //그래서 다음과 같이 redirection기능을 이용해서 자신이 업로드한 게시물 페이지로 이동시킨다. 그 기능을 수행하는 함수는 'header'다.
$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');

$account=$_SESSION['account'];

$nickname=$_SESSION['nickname'];



//이미지를 같이 업로드할 때
if(!empty($_FILES['image']['name'])){
  //freeboard테이블에 데이터를 저장하기 위한 쿼리문
  $sql="
    INSERT INTO freeboard
      (account, nickname, title, article, image, date, view_count, comment_count)
     VALUES(
       '{$account}',
       '{$nickname}',
       '{$_POST['title']}',
       '{$_POST['article']}',
        '0',
        NOW(),
        '0',
        '0'
     )
  ";
  $result=mysqli_query($conn, $sql);

  $number=mysqli_insert_id($conn);
  echo $number;

  $sql="
    UPDATE freeboard
    SET
      image='{$number}'
    WHERE number={$number}
  ";
  $result=mysqli_query($conn, $sql);
  $name=$number;
  $save_dir='./freeboard_content';
  move_uploaded_file($_FILES['image']['tmp_name'], "$save_dir/$name");
}
//이미지는 업로드하지 않을 때
else{
  //freeboard테이블에 데이터를 저장하기 위한 쿼리문
  $sql="
    INSERT INTO freeboard
      (account, nickname, title, article, image, date, view_count, comment_count)
     VALUES(
       '{$account}',
       '{$nickname}',
       '{$_POST['title']}',
       '{$_POST['article']}',
       NULL,
        NOW(),
        '0',
        '0'
     )
  ";
  $result=mysqli_query($conn, $sql);
}

if($result===false){
  echo '저장에 문제가 생김';
  mysqli_error($conn);
}else{
  echo '잘 저장됨';
}

$sql="
  SELECT*FROM freeboard
  ORDER BY number DESC
";
$result=mysqli_query($conn, $sql);
$row=mysqli_fetch_array($result);

header('Location: ./freeboard_detail.php?id='.$row['number']);
 ?>
