<?php
session_start();

include("connect_db.php");//데이터베이스와 연결

$account = $_SESSION['account'];

$nickname = $_SESSION['nickname'];


//이미지를 같이 업로드할 때
if (!empty($_FILES['image']['name'])) {
    //freeboard테이블에 데이터를 저장하기 위한 쿼리문
    $sql = "
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
    $result = mysqli_query($conn, $sql);

    $number = mysqli_insert_id($conn);
    echo $number;

    $sql = "
    UPDATE freeboard
    SET
      image='{$number}'
    WHERE number={$number}
  ";
    $result = mysqli_query($conn, $sql);
    $name = $number;
    $save_dir = './freeboard_content';
    move_uploaded_file($_FILES['image']['tmp_name'], "$save_dir/$name");
} //이미지는 업로드하지 않을 때
else {
    //freeboard테이블에 데이터를 저장하기 위한 쿼리문
    $sql = "
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
    $result = mysqli_query($conn, $sql);
}

if ($result === false) {
    echo '저장에 문제가 생김';
    mysqli_error($conn);
} else {
    echo '잘 저장됨';
}

$sql = "
  SELECT*FROM freeboard
  ORDER BY number DESC
";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

header('Location: ./freeboard_detail.php?id=' . $row['number']);
?>
