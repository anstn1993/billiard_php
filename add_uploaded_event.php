<?php
session_start();
include("connect_db.php");//데이터베이스와 연결

$account = $_SESSION['account'];
$nickname = $_SESSION['nickname'];


//이미지를 업로드할 때
if (!empty($_FILES['image']['name'])) {
    //event테이블에 데이터를 저장하기 위한 쿼리문
    $sql_insert = "
    INSERT INTO event
      (account, nickname, title, article, image,address, begin, end, date, view_count, comment_count)
     VALUES(
       '{$account}',
       '{$nickname}',
       '{$_POST['title']}',
       '{$_POST['article']}',
       '0',
       '{$_POST['address']}',
       '{$_POST['begin']}',
       '{$_POST['end']}',
        NOW(),
        '0',
        '0'
     )
  ";
    $result = mysqli_query($conn, $sql_insert);
    $number = mysqli_insert_id($conn);
    echo $number;

    $sql = "
    UPDATE event
    SET
      image='{$number}'
    WHERE number={$number}
  ";
    $result = mysqli_query($conn, $sql);

    $name = $number;
    $save_dir = './event_image';
    move_uploaded_file($_FILES['image']['tmp_name'], "$save_dir/$name");

} //이미지를 업로드하지 않을 때
else {
    //event테이블에 데이터를 저장하기 위한 쿼리문
    $sql_insert = "
    INSERT INTO event
      (account, nickname, title, article, image,address, begin, end, date, view_count, comment_count)
     VALUES(
       '{$account}',
       '{$nickname}',
       '{$_POST['title']}',
       '{$_POST['article']}',
       NULL,
       '{$_POST['address']}',
       '{$_POST['begin']}',
       '{$_POST['end']}',
        NOW(),
        '0',
        '0'
     )
  ";
    $result = mysqli_query($conn, $sql_insert);
}


if ($result === false) {
    echo '저장에 문제가 생김';
    mysqli_error($conn);
} else {
    echo '잘 저장됨';
}

$sql = "
  SELECT*FROM event
  ORDER BY number DESC
";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

header('Location: ./event_detail.php?id=' . $row['number']);
?>
