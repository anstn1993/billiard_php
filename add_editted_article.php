<?php

// //게시물을 수정할 때 기존 게시물 파일의 이름을 재정의 하는 함수
// rename('freeboard_data/'.$_POST['old_title'], 'freeboard_data/'.$_POST['title']);
// //게시물 파일의 이름이 재정의 됐으면 그 파일에 이제 수정된 article을 넣어주는 함수
// file_put_contents('freeboard_data/'.$_POST['title'], $_POST['article']);

include("connect_db.php");//데이터베이스와 연결


$sql = "
SELECT*FROM freeboard
WHERE number={$_POST['id']}
";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

//이미지가 아예 없는 상태에서 이미지를 선택하는 경우
if (empty($_POST['image_result']) && !empty($_FILES['image']['name'])) {
    echo "1";
    $sql = "
     UPDATE freeboard
     SET
      title='{$_POST['title']}',
      article='{$_POST['article']}',
      image='{$row['number']}',
      date=NOW()

      WHERE number={$_POST['id']}
  ";

    $result = mysqli_query($conn, $sql);
    //수정할 때 선택한 이미지의 이름을 $name변수에 담는다.
    $name = $row['number'];
    //이미지를 저장할 서버의 폴더 경로를 지정
    $save_dir = './freeboard_content';
    //이 메소드는 form을 통해 파일을 업로드할 때 일시적으로 저장되는 경로인 tmp폴더에서 내가 지정한 폴더로 파일을 옮기는
    //함수다.
    move_uploaded_file($_FILES['image']['tmp_name'], "$save_dir/$name");
} //이미지가 아예 없는 상태에서 이미지를 선택하지 않는 경우
else if (empty($_POST['image_result']) && empty($_FILES['image']['name'])) {
    echo "2";
    $sql = "
     UPDATE freeboard
     SET
      title='{$_POST['title']}',
      article='{$_POST['article']}',
      image=NULL,
      date=NOW()

      WHERE number={$_POST['id']}
  ";
    $result = mysqli_query($conn, $sql);
} //이미지가 있는 상태에서 이미지를 선택하는 경우
else if (!empty($_POST['image_result']) && !empty($_FILES['image']['name'])) {
    echo "3";
    $sql = "
     UPDATE freeboard
     SET
      title='{$_POST['title']}',
      article='{$_POST['article']}',
      image='{$row['number']}',
      date=NOW()

      WHERE number={$_POST['id']}
  ";

    $result = mysqli_query($conn, $sql);
    //수정할 때 선택한 이미지의 이름을 $name변수에 담는다.
    $name = $row['number'];
    //이미지를 저장할 서버의 폴더 경로를 지정
    $save_dir = './freeboard_content';
    //form을 통해 파일을 업로드할 때 일시적으로 저장되는 경로인 tmp폴더에서 내가 지정한 폴더로 파일을 옮기는 함수다.
    move_uploaded_file($_FILES['image']['tmp_name'], "$save_dir/$name");
} //이미지가 있는 상태에서 이미지를 선택하지 않는 경우
else if ($_POST['image_result'] != "deleted" && empty($_FILES['image']['name'])) {
    echo "4";
    $sql = "
     UPDATE freeboard
     SET
      title='{$_POST['title']}',
      article='{$_POST['article']}',
      image='{$row['number']}',
      date=NOW()

      WHERE number={$_POST['id']}
  ";

    $result = mysqli_query($conn, $sql);
} //이미지가 있는 상태에서 이미지를 삭제하는 경우
else {
    echo "5";
    $sql = "
     UPDATE freeboard
     SET
      title='{$_POST['title']}',
      article='{$_POST['article']}',
      image=NULL,
      date=NOW()

      WHERE number={$_POST['id']}
  ";
    $result = mysqli_query($conn, $sql);
    unlink('freeboard_content/' . $row['number']);//이미지 삭제
}

//자유게시판에서 접근한 경우
if ($_POST['mypost'] != 'yes' && $_POST['mycomment'] != 'yes') {
    header('Location: ./freeboard_detail.php?id=' . $_POST['id'] . '&page=' . $_POST['page'] . '&search_category=' . $_POST['search_category'] . '&search_value=' . $_POST['search_value']);

} //내가 쓴 게시물에서 접근한 경우
else if ($_POST['mypost'] == 'yes') {
    //header를 통해 게시물 페이지로  redirection
    header('Location: ./freeboard_detail.php?id=' . $_POST['id'] . '&page=' . $_POST['page'] . '&mypost=' . $_POST['mypost']);
} //내가 댓글 단 게시물에서 접근한 경우
else {
    //header를 통해 게시물 페이지로  redirection
    header('Location: ./freeboard_detail.php?id=' . $_POST['id'] . '&page=' . $_POST['page'] . '&mycomment=' . $_POST['mycomment']);
}

?>
