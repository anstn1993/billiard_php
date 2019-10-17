<?php

$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
//삭제할 댓글을 그 댓글의 id를 통해서 찾아내는 쿼리문
$sql="
  SELECT*FROM event_comment
  WHERE id={$_GET['id']}
";
$result=mysqli_query($conn, $sql);
$row=mysqli_fetch_array($result);
//그 삭제할 댓글이 달린 게시물의 번호를 $news_number변수에 저장한다. 이건 해당 댓글이 달린 게시물을 찾아내기 위해서 존재
$event_number=$row['event_number'];
//그 게시물번호에 해당하는 event테이블의 행을 조회하는 쿼리문. 이건 나중에 페이지 이동을 할 때 event의 id값을 url에 넣어주기 위해서 선언한 것.
$sql="
  SELECT*FROM event
  WHERE number={$event_number}
";
$result=mysqli_query($conn, $sql);
$row=mysqli_fetch_array($result);
//header함수에 넣을 url에 들어갈 뉴스의 id값을 $news_id변수에 넣어준다.
$event_id=$row['number'];

//해당 댓글을 삭제하는 쿼리문
$sql="
   DELETE FROM event_comment
    WHERE id={$_GET['id']}
";
$result=mysqli_query($conn, $sql);

$sql="
UPDATE event
SET
 comment_count=comment_count-1
 WHERE number={$event_number}
";
$result=mysqli_query($conn, $sql);

//이벤트 게시판에서 댓글을 삭제하는 경우
if(empty($_GET['mypost'])){
  header('Location: ./event_detail.php?id='.$event_id.'&page='.$_GET['page'].'&search_category='.$_GET['search_category'].'&search_value='.$_GET['search_value']);
}
//내가 쓴 게시물 게시판에서 댓글을 삭제하는 경우
else{
  header('Location: ./event_detail.php?id='.$event_id.'&page='.$_GET['page'].'&mypost='.$_GET['mypost']);
}
?>
