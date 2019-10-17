<?php
$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');

$sql="
   UPDATE news
   SET
    title='{$_POST['title']}',
    url='{$_POST['url']}',
    date=NOW()

    WHERE number={$_POST['id']}
";

$result=mysqli_query($conn, $sql);

//당구 소식 게시판에서 접근한 경우
if($_POST['mypost']!='yes'){
  header('Location: ./news_detail.php?id='.$_POST['id'].'&page='.$_POST['page'].'&search_value='.$_POST['search_value']);
}
//내가 쓴 게시물 게시판에서 접근한 경우
else {
  header('Location: ./news_detail.php?id='.$_POST['id'].'&page='.$_POST['page'].'&mypost='.$_POST['mypost']);
}

?>
