<?php
include("connect_db.php");//데이터베이스와 연결
$account = $_POST['account'];
$new_password = $_POST['password'];
$sql = "
    UPDATE user
    SET password='{$new_password}'
    WHERE account='{$account}'
  ";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>비밀번호 변경 완료</title>
    <link rel="stylesheet" href="main_style.css">
    <link rel="stylesheet" href="findpassword_complete_style.css">
</head>
<body>
<nav class="top">
    <div class="top_child">
        <a class="top_menu" href="main.php">메인으로</a>
    </div>
</nav>
<div class="main">
    <h1><a href="main.php">billiards world</a></h1>
</div>

<nav class="menu">
    <div class="menu_child">
        <a class="freeboard" href="freeboard.php">자유게시판</a>
    </div>
    <div class="menu_child">
        <a class="chat" href="chat.html">당톡방</a>
    </div>
    <div class="menu_child">
        <a class="event" href="event.php">당구장 이벤트</a>
    </div>
    <div class="menu_child">
        <a class="news" href="news.php">당구소식</a>
    </div>
    <div class="menu_child">
        <a class="product" href="product.php">당구용품</a>
    </div>
</nav>
<h1 class="findpassword_complete_title">비밀번호 변경 완료</h1>
<div class="findpassword_complete_ment">
    성공적으로 비밀번호를 변경하셨습니다.
</div>
<div class="login_button">
    <a href="login.html">로그인 화면으로</a>
</div>
