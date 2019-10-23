<?php
session_start();
include("connect_db.php");//데이터베이스와 연결
$tel = $_POST['tel1'] . $_POST['tel2'] . $_POST['tel3'];
//변경된 유저의 정보를 업데이트하는 쿼리문
$sql = "
      UPDATE user
        SET
        password='{$_POST['password']}',
        nickname='{$_POST['nickname']}',
        name='{$_POST['name']}',
        tel='{$tel}',
        who='{$_POST['account_category']}',
        address='{$_POST['address']}'
        WHERE id={$_SESSION['id']}
      ";
$result = mysqli_query($conn, $sql);

//자유게시판 테이블에 바뀐 nickname을 업데이트 해준다.
$sql = "
      UPDATE freeboard
        SET

        nickname='{$_POST['nickname']}'

        WHERE nickname='{$_SESSION['nickname']}'
      ";
$result = mysqli_query($conn, $sql);

//자유게시판 댓글 테이블에 바뀐 nickname을 업데이트 해준다.
$sql = "
      UPDATE freeboard_comment
        SET

        nickname='{$_POST['nickname']}'

        WHERE nickname='{$_SESSION['nickname']}'
      ";
$result = mysqli_query($conn, $sql);

//이벤트 테이블에 바뀐 nickname을 업데이트 해준다.
$sql = "
      UPDATE event
        SET

        nickname='{$_POST['nickname']}'

        WHERE nickname='{$_SESSION['nickname']}'
      ";
$result = mysqli_query($conn, $sql);

//이벤트 댓글 테이블에 바뀐 nickname을 업데이트 해준다.
$sql = "
      UPDATE event_comment
        SET

        nickname='{$_POST['nickname']}'

        WHERE nickname='{$_SESSION['nickname']}'
      ";
$result = mysqli_query($conn, $sql);

//뉴스 테이블에 바뀐 nickname을 업데이트 해준다.
$sql = "
      UPDATE news
        SET

        nickname='{$_POST['nickname']}'

        WHERE nickname='{$_SESSION['nickname']}'
      ";
$result = mysqli_query($conn, $sql);

//뉴스 댓글 테이블에 바뀐 nickname을 업데이트 해준다.
$sql = "
      UPDATE news_comment
        SET

        nickname='{$_POST['nickname']}'

        WHERE nickname='{$_SESSION['nickname']}'
      ";
$result = mysqli_query($conn, $sql);

//바뀐 정보들로 세션을 다시 넣어줘야 한다. 세션도 저장되어있는 값이기 때문이다.
$_SESSION['password'] = $_POST['password'];
$_SESSION['nickname'] = $_POST['nickname'];
$_SESSION['name'] = $_POST['name'];
$_SESSION['tel'] = $tel;
$_SESSION['who'] = $_POST['account_category'];
$_SESSION['address'] = $_POST['address'];


header('Location: ./mypage.php');
?>
