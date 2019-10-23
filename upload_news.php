<?php
session_start();
if (empty($_SESSION['id'])) {
    echo "<script>
    alert('관리자 아이디로 로그인 후 이용해주세요.');
    location.href='login.php';
   </script>";
} else if ($_SESSION['who'] == "normal" || $_SESSION['who'] == "club_owner") {
    echo "<script>
    alert('접근 권한이 없습니다.');
    location.href='main.php';
   </script>";
} else {

}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>소식 올리기</title>
    <link rel="stylesheet" href="main_style.css">
    <link rel="stylesheet" href="upload_news_style.css">
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
        <a class="chat" href="chat.php">당톡방</a>
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
<h1 class="upload_news_title">당구 소식 올리기</h1>
<br>
<form action="add_uploaded_news.php" method="post">
    <table>
        <tr>
            <td>기사 제목</td>
            <td>
                <input type="text" name="title" required="required" placeholder="기사 제목">
            </td>
        </tr>
        <tr>
            <td>기사 URL</td>
            <td>
                <input type="text" name="url" placeholder="기사 url" required="required">
            </td>
        </tr>

    </table>
    <div class="upload_cancel">
        <input type="submit" name="upload" value="소식 등록">
        <button type="button" name="cancel" onclick="location.href='news.php'">취소</button>
    </div>
</form>

</body>
</html>
