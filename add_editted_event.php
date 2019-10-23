<?php

include("connect_db.php");//데이터베이스와 연결

$sql = "
SELECT*FROM event
WHERE number={$_POST['id']}
";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

//이미지가 아예 없는 상태에서 이미지를 선택하는 경우
if (empty($_POST['image_result']) && !empty($_FILES['image']['name'])) {
    $sql = "
     UPDATE event
     SET
      title='{$_POST['title']}',
      article='{$_POST['article']}',
      image='{$row['number']}',
      date=NOW(),
      address='{$_POST['address']}',
      begin='{$_POST['begin']}',
      end='{$_POST['end']}'

      WHERE number={$_POST['id']}
  ";

    $result = mysqli_query($conn, $sql);
    //이벤트 등록 시 넘겨받은 이미지 파일의 이름이다.
    $name = $row['number'];
    //이미지 파일이 실제로 저장될 서버의 폴더 경로를 설정
    $save_dir = './event_image';
    //해당 함수는 넘겨받은 파일이 일시적으로 저장되는 폴더인 tmp폴더에서 내가 설정한 경로로 이동되게 한다.
    //첫번째 파라미터가 일시적으로 저장된 경로, 두번째 파라미터가 내가 옮겨갈 경로에 파일명.
    move_uploaded_file($_FILES['image']['tmp_name'], "$save_dir/$name");
} //이미지가 아예 없는 상태에서 이미지를 선택하지 않는 경우
else if (empty($_POST['image_result']) && empty($_FILES['image']['name'])) {
    $sql = "
     UPDATE event
     SET
      title='{$_POST['title']}',
      article='{$_POST['article']}',
      image=NULL,
      date=NOW(),
      address='{$_POST['address']}',
      begin='{$_POST['begin']}',
      end='{$_POST['end']}'

      WHERE number={$_POST['id']}
  ";

    $result = mysqli_query($conn, $sql);
} //이미지가 있는 상태에서 이미지를 선택하는 경우
else if (!empty($_POST['image_result']) && !empty($_FILES['image']['name'])) {
    $sql = "
     UPDATE event
     SET
      title='{$_POST['title']}',
      article='{$_POST['article']}',
      image='{$row['number']}',
      date=NOW(),
      address='{$_POST['address']}',
      begin='{$_POST['begin']}',
      end='{$_POST['end']}'

      WHERE number={$_POST['id']}
  ";

    $result = mysqli_query($conn, $sql);
    //이벤트 등록 시 넘겨받은 이미지 파일의 이름이다.
    $name = $row['number'];
    //이미지 파일이 실제로 저장될 서버의 폴더 경로를 설정
    $save_dir = './event_image';
    //해당 함수는 넘겨받은 파일이 일시적으로 저장되는 폴더인 tmp폴더에서 내가 설정한 경로로 이동되게 한다.
    //첫번째 파라미터가 일시적으로 저장된 경로, 두번째 파라미터가 내가 옮겨갈 경로에 파일명.
    move_uploaded_file($_FILES['image']['tmp_name'], "$save_dir/$name");
} //이미지가 있는 상태에서 이미지를 선택하지 않는 경우
else if ($_POST['image_result'] != "deleted" && empty($_FILES['image']['name'])) {
    $sql = "
     UPDATE event
     SET
      title='{$_POST['title']}',
      article='{$_POST['article']}',
      image='{$row['number']}',
      date=NOW(),
      address='{$_POST['address']}',
      begin='{$_POST['begin']}',
      end='{$_POST['end']}'

      WHERE number={$_POST['id']}
  ";

    $result = mysqli_query($conn, $sql);
} //이미지가 있는 상태에서 이미지를 삭제하는 경우
else {
    $sql = "
     UPDATE event
     SET
      title='{$_POST['title']}',
      article='{$_POST['article']}',
      image=NULL,
      date=NOW(),
      address='{$_POST['address']}',
      begin='{$_POST['begin']}',
      end='{$_POST['end']}'

      WHERE number={$_POST['id']}
  ";

    $result = mysqli_query($conn, $sql);
    unlink('event_image/' . $row['number']);
}

//이벤트 게시판에서 접근한 경우
if ($_POST['mypost'] != 'yes') {
    header('Location: ./event_detail.php?id=' . $_POST['id'] . '&page=' . $_POST['page'] . '&search_category=' . $_POST['search_category'] . '&search_value=' . $_POST['search_value']);
} //내가 쓴 게시물 게시판에서 접근한 경우
else {
    header('Location: ./event_detail.php?id=' . $_POST['id'] . '&page=' . $_POST['page'] . '&mypost=' . $_POST['mypost']);
}

?>
?>
