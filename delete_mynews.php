<?php
include("connect_db.php");//데이터베이스와 연결

//이 변수에는 해당 뉴스의 번호가 담긴다.
$mynews = $_POST['mynews'];
//반복문을 돌리면서 체크박스에 체크가 된 수만큼 기사를 삭제한다.
for ($i = 0; $i < count($mynews); $i++) {
    $sql = "
    DELETE FROM news
    WHERE number={$mynews[$i]}
  ";
    $result = mysqli_query($conn, $sql);

    $sql = "
    DELETE FROM news_comment
    WHERE news_number={$mynews[$i]}
  ";
    $result = mysqli_query($conn, $sql);
}

header('Location: ./my_news_post.php');

?>
