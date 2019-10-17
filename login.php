<?php
session_start();
if(!empty($_SESSION['id'])){
  echo "<script>
    alert('이미 로그인 상태 입니다.');
    location.href='main.php';
   </script>";
}

 ?>
<!-- 해당 파일은 main.php파일에 사용자의 아이디, 비밀번호 데이터를 전송하기 위해서 존재한다.  -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>로그인</title>
  <link rel="stylesheet" href="main_style.css">
  <link rel="stylesheet" href="login_style.css">
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

  <div class="login">
    <h1>로그인</h1>
  </div>
  <br>
  <form id=login_form action="login_check.php" method="post" onsubmit="return fnc_login()">
    <!-- 로그인에 성공하면 함께 넘어갈 닉네임(하드코딩) -->
    <input type="hidden" name="nickname" value="만수">
    <!-- method속성은 데이터의 전송 방식을 정의할 수 있다. get, post.... -->
    <div id="id" class="logininfo">
      아이디: <input id="input_id" type="text" name="account"
      value="<?php error_reporting(0); echo $_COOKIE['remember_account']; ?>"/>
      <!-- name="id"에서 이 id가 바로 main.php의 $_GET['id'];의 id가 되는 것이다.  -->
    </div>
    <br>
    <div id="password" class="logininfo">
      비밀번호: <input id="input_password" type="password" name="password"/>
      <!-- name="password"에서 이 password가 바로 main.php의 $_GET['password'];의 password가 되는 것이다.  -->
    </div>
    <div class="logininfo">
      <?php
        if(empty($_COOKIE['remember_account'])){
          echo "아이디 기억<input type=\"checkbox\" name=\"remember\" value=\"checked\">";
        }else {
          echo "아이디 기억<input type=\"checkbox\" name=\"remember\" value=\"checked\" checked>";
        }
       ?>

    </div>

    <br>
    <br>
    <div class="login_join_button">
      <div class="login_join_button_child">
        <input id="login_button" type="submit" value="로그인"/>
        <!-- type을 submit으로 하면 action속성에 지정된 페이지로 폼에서 입력한 값들을 넘겨주는 버튼 역할을 하게 된다. -->
      </div>
      <div class="join_join_button_child">
        <button id="join_botton" type="button" name="join" onClick="location.href='join.php'">회원가입</button>
      </div>
    </div>
  </form>
  <br>
  <br>
  <div class="find_id_password">
    <a href="findid.html">아이디 찾기</a>
    <a href="findpassword.html">비밀번호 찾기</a>
  </div>

  <!-- <script type="text/javascript">


    //로그인시 폼에 아이디와 비밀번호를 작성 후 서버에 제출할 시에 입력란이 공백이거나
    //아이디 비밀번호가 잘못됐을 경우 그에 해당하는 경고 메세지가 뜨는 함수다.
    function fnc_login(){
      //input박스에 입력된 아이디 값을 id변수에 대입
      var id=document.getElementById('input_id').value;
      console.log(id);
      //input박스에 입력된 비밀번호 값을 password변수에 대입
      var password=document.getElementById('input_password').value;
      console.log(password);
      var check_result='';
      var xhr=new XMLHttpRequest;
      xhr.onreadystatechange = function() {
        check_result=xhr.responseText;
        console.log(check_result);
      }
      xhr.open('POST', 'login_check.php');

      var data='';
      data += 'account='+id+'&password='+password;
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      //send는 실제로 서버로 요청을 하는 것이다. 이때 인자에 서버로 보낼 값을 넣으면 된다. json형태로 보내는 경우 문자열 형태로 보내야 한다. JSON.stringify(json객체). 아니면 처음부터 문자열 형태로 만들어도 되고
      xhr.send(data);



      //trim()함수는 문자열의 앞/뒤 공백을 제거해주는 함수다.
      if(id.trim()=="" || password.trim()==""){
        alert('아이디와 비밀번호를 모두 입력해주세요.');
        return false;
      }else {
        if(check_result=="deny"){
          alert('아이디나 비밀번호를 다시 확인해주세요.');
          return false;

        } else{
          return true;
        }
      }
    } -->




  </script>



</body>
</html>
