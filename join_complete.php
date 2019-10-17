<?php

  $conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
  $tel=$_POST['tel1'].$_POST['tel2'].$_POST['tel3'];
  $sql="
        INSERT INTO user
          (account, password, nickname, name, tel, who, question, answer,address)
          VALUES(
            '{$_POST['account']}',
            '{$_POST['password']}',
            '{$_POST['nickname']}',
            '{$_POST['name']}',
            '{$tel}',
            '{$_POST['account_category']}',
            '{$_POST['findaccount_question']}',
            '{$_POST['findaccount_answer']}',
            '{$_POST['address']}'
          )
        ";
  $result=mysqli_query($conn, $sql);
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>회원가입 완료</title>
     <link rel="stylesheet" href="main_style.css">
     <link rel="stylesheet" href="join_complete_style.css">
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
     <h2 class="join_complete_title">회원가입 완료!</h2>
     <div class="join_complete_ment">
       성공적으로 회원가입이 되셨습니다.

     </div>
     <div class="login_button">
       <a href="login.php">로그인 화면으로</a>
     </div>

   </body>
 </html>
