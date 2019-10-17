<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="main_style.css">
  <link rel="stylesheet" href="findpasswordresult_style.css">
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
  <h1 class="findpasswordresult_title">비밀번호 변경</h1>

  <form action="findpassword_complete.php" method="post" onsubmit="return change_password()">
    <input type="hidden" name="account" value="<?php echo $_POST['account']; ?>">
    <table>
      <tr>
        <td>비밀번호</td>
        <td><input id="password_input" type="password" name="password" size=30></td>
      </tr>
      <tr>
        <td>비밀번호 확인</td>
        <td><input id="password_check_input" type="password" name="password_check" size=30></td>
      </tr>
        <!-- 자바 스크립트로 비밀번호 검사 메세지를 출력하기 위해 만든 태그  -->
      <tr id="password_match_check">
        <td id="password_match_check_child" colspan="2"></td>
      </tr>


    </table>
    <br>
    <div class="change_cancel">
      <div class="change_cancel_button">
        <input type="submit" id="join_button" value="비밀번호 변경">
      </div>
      <div class="change_cancel_button">
        <button type="button" name="cancel" onclick="location.href='login.html'">취소</button>
      </div>
    </div>
  </form>

  <script type="text/javascript">
  //비밀번호와 비밀번호 확인 칸에 입력한 문자열이 일치하는지 확인하기 위한 함수다.
  var check_password=document.getElementById('password_check_input');
  //이벤트 방식은 위와 동일하다.
  check_password.addEventListener('blur', function(event){
    //password변수는 비밀번호 입력 칸에 입력된 비밀번호를 담는 변수다.
    var password=document.getElementById('password_input').value;
    //password_check변수는 비밀번호 확인 입력 칸에 입력된 비밀번호를 담는 변수다.
    var password_check=document.getElementById('password_check_input').value;

    //비밀번호 확인 입력 칸이 비어있으면 메세지를 출력하지 않는다.
    if(password_check.trim()==""){
        document.getElementById('password_match_check_child').innerHTML="";
    }
    //비밀번호 입력 칸이 비어있으면 비밀번호를 입력하라는 메세지를 출력한다.
    else if(password.trim()==""){
      document.getElementById('password_match_check_child').innerHTML="비밀번호를 입력해주세요.";
      document.getElementById('password_match_check_child').style.color="red";
    }
    //비밀번호와 비밀번호 확인 값이 다르면 비밀번호가 일치하지 않는다는 메세지를 출력한다.
    else if(password != password_check){
      document.getElementById('password_match_check_child').innerHTML="비밀번호가 일치하지 않습니다.";
      document.getElementById('password_match_check_child').style.color="red";
    }
    //비밀번호와 비밀번호 확인 값이 일치하면 비밀번호가 일치한다는 메세지를 출력한다.
    else{
      document.getElementById('password_match_check_child').innerHTML="비밀번호 일치";
      document.getElementById('password_match_check_child').style.color="green";
    }
  });

  function change_password(){
    //password변수는 비밀번호 입력 칸에 입력된 비밀번호를 담는 변수다.
    var password=document.getElementById('password_input').value;
    //password_check변수는 비밀번호 확인 입력 칸에 입력된 비밀번호를 담는 변수다.
    var password_check=document.getElementById('password_check_input').value;

    //비밀번호 확인 입력 칸이 비어있으면 메세지를 출력하지 않는다.
    if(password.trim()=="" ||password_check.trim()==""){
        alert('항목을 모두 채워주세요.');
        return false;
    }
    //비밀번호와 비밀번호 확인 값이 다르면 비밀번호가 일치하지 않는다는 메세지를 출력한다.
    else if(password != password_check){
        alert('비밀번호가 일치하지 않습니다.');
        return false;
    }
    //비밀번호와 비밀번호 확인 값이 일치하면 비밀번호가 일치한다는 메세지를 출력한다.
    else{
      alert('비밀번호가 변경되었습니다.');
      return true;
    }
  }

  </script>

</body>
</html>
