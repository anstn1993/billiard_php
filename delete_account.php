<?php
//체크박스에서 선택한 회원 계정을 담는 배열
$account=$_POST['account'];
$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
//배열의 크기만큼 user,freeboard,freeboard_comment, event, event_comment, news_comment 테이블에서 해당 계정값이 들어있는 row 모두 삭제
for($i=0; $i<count($account); $i++){
  //계정 정보를 지우는 쿼리문
  $sql="
    DELETE FROM user
    WHERE account='{$account[$i]}'
  ";
  $result=mysqli_query($conn, $sql);

  //해당 계정으로 작성된 자유게시판의 게시물을 삭제하는 쿼리문
  $sql="
    DELETE FROM freeboard
    WHERE account='{$account[$i]}'
  ";
  $result=mysqli_query($conn, $sql);

  //해당 계정으로 작성된 자유게시판 게시물의 댓글을 삭제하는 쿼리문
  $sql="
    DELETE FROM freeboard_comment
    WHERE account='{$account[$i]}'
  ";
  $result=mysqli_query($conn, $sql);

  //해당 계정으로 작성된 이벤트 게시물을 삭제하는 쿼리문
  $sql="
    DELETE FROM event
    WHERE account='{$account[$i]}'
  ";
  $result=mysqli_query($conn, $sql);

  //해당 계정으로 작성된 이벤트 게시물의 댓글을 삭제하는 쿼리문
  $sql="
    DELETE FROM event_comment
    WHERE account='{$account[$i]}'
  ";
  $result=mysqli_query($conn, $sql);

  //해당 계정으로 작성된 자유게시판 게시물의 댓글을 삭제하는 쿼리문
  $sql="
    DELETE FROM news_comment
    WHERE account='{$account[$i]}'
  ";
  $result=mysqli_query($conn, $sql);

  //해당 계정으로 주문한 관리자용 주문 테이블을 삭제하는 쿼리문
  $sql="
    DELETE FROM order_admin
    WHERE user_account='{$account[$i]}'
  ";
  $result=mysqli_query($conn, $sql);

  //해당 계정으로 주문한 사용자용 주문 테이블을 삭제하는 쿼리문
  $sql="
    DELETE FROM order_user
    WHERE user_account='{$account[$i]}'
  ";
  $result=mysqli_query($conn, $sql);



}

header('Location: ./member_list.php');

 ?>
