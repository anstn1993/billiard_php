<?php

session_start();
$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
//자신의 계정을 지우는 쿼리
  $sql="
    DELETE FROM user
    WHERE id={$_SESSION['id']}
  ";
  $result=mysqli_query($conn, $sql);
  //삭제한 계정으로 작성된 자유게시판 게시물을 지우는 쿼리
  $sql="
    DELETE FROM freeboard
    WHERE nickname='{$_SESSION['nickname']}'
  ";
  $result=mysqli_query($conn, $sql);

  //삭제한 계정으로 작성된 자유게시판 게시물의 댓글을 지우는 쿼리
  $sql="
    DELETE FROM freeboard_comment
    WHERE nickname='{$_SESSION['nickname']}'
  ";
  $result=mysqli_query($conn, $sql);

  //삭제한 계정으로 작성된 이벤트 게시물을 지우는 쿼리
  $sql="
    DELETE FROM event
    WHERE nickname='{$_SESSION['nickname']}'
  ";
  $result=mysqli_query($conn, $sql);

  //삭제한 계정으로 작성된 이벤트 게시물의 댓글을 지우는 쿼리
  $sql="
    DELETE FROM event_comment
    WHERE nickname='{$_SESSION['nickname']}'
  ";
  $result=mysqli_query($conn, $sql);

  //삭제한 계정으로 작성된 당구소식 게시물의 댓글을 지우는 쿼리
  $sql="
    DELETE FROM news_comment
    WHERE nickname='{$_SESSION['nickname']}'
  ";
  $result=mysqli_query($conn, $sql);

  //관리자용 주문 테이블에서 사용자의 정보를 삭제
  $sql="
    DELETE FROM order_admin
    WHERE user_account='{$_SESSION['account']}'
  ";
  $result=mysqli_query($conn, $sql);
  //사용자용 주문 테이블에서 사용자의 정보를 삭제
  $sql="
    DELETE FROM order_user
    WHERE user_account='{$_SESSION['account']}'
  ";
  $result=mysqli_query($conn, $sql);


session_destroy();
header('Location: ./main.php');

 ?>
