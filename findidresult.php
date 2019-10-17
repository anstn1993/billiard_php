<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>아이디 찾기 결과</title>
  <link rel="stylesheet" href="main_style.css">
  <link rel="stylesheet" href="findidresult_style.css">
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
  <h1 class="findidresult_title">아이디 찾기 결과</h1>
  <div class="findidresult_ment">
    회원님의 아이디는 '<?php echo $_POST['account']; ?>' 입니다.
  </div>
  <div class="login_button">
    <a href="login.html">로그인 화면으로</a>
  </div>

</body>
</html>
