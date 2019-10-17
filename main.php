<?php
  //쿠키를 조회해서 'popup_check'라는 이름의 쿠키가 있으면 팝업창이 실행되지 않고 없으면 실행된다.

  // setcookie('popup_check','checked',time()-1,'/');

  if(empty($_COOKIE['popup_check'])){
    echo "
    <script type=\"text/javascript\">
      window.open('http://192.168.56.101/popup.php', '이벤트', 'width=800, height=700, left=400');
    </script>
    ";
  }


// 이 함수는 조회수가 높은 순서대로 자유게시판 목록을 생성하는 함수다.
  function make_freeboard(){
    $conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
    $sql="
      SELECT*FROM freeboard
    ";
    $result=mysqli_query($conn, $sql);
    // $row=mysqli_fetch_array($result);
    $row_num=mysqli_num_rows($result);
    $sql="
      SELECT*FROM freeboard
      ORDER BY view_count DESC
    ";
    $result=mysqli_query($conn, $sql);
    if($row_num<=10){
      for($i=1; $i<=$row_num; $i++){
        $row=mysqli_fetch_array($result);
        $date_create=date_create($row['date']);
        $date=date_format($date_create, "y년 n월 j일");
          echo "
          <tr>
              <td>
                <a href='freeboard_detail.php?id={$row['number']}'>{$row['nickname']}</a>
              </td>
              <td class='freeboard_title'>
                <a href='freeboard_detail.php?id={$row['number']}'>{$row['title']}</a>
              </td>
              <td>
                <a href='freeboard_detail.php?id={$row['number']}'>{$date}</a>
              </td>
            </tr>
          ";
      }
    }else{
      for($i=1; $i<=10; $i++){
        $row=mysqli_fetch_array($result);
        $date_create=date_create($row['date']);
        $date=date_format($date_create, "y년 n월 j일");
          echo "
          <tr>
              <td>
                <a href='freeboard_detail.php?id={$row['number']}'>{$row['nickname']}</a>
              </td>
              <td class='freeboard_title'>
                <a href='freeboard_detail.php?id={$row['number']}'>{$row['title']}</a>
              </td>
              <td>
                <a href='freeboard_detail.php?id={$row['number']}'>{$date}</a>
              </td>
            </tr>
          ";
    }
  }
}




// 이 함수는 조회수가 높은 순서대로 당구장 이벤트 목록을 생성하는 함수다.
  function make_event(){
    $conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
    $sql="
      SELECT*FROM event
    ";
    $result=mysqli_query($conn, $sql);
    // $row=mysqli_fetch_array($result);
    $row_num=mysqli_num_rows($result);
    $sql="
      SELECT*FROM event
      ORDER BY view_count DESC
    ";
    $result=mysqli_query($conn, $sql);
    if($row_num<=10){
      for($i=1; $i<=$row_num; $i++){
        $row=mysqli_fetch_array($result);
        $date_create=date_create($row['begin']);
        $begin=date_format($date_create, "y년 n월 j일");
        $date_create=date_create($row['end']);
        $end=date_format($date_create, "y년 n월 j일");
          echo "
          <tr>
              <td>
                <a href='event_detail.php?id={$row['number']}'>{$row['nickname']}</a>
              </td>
              <td class='event_title'>
                <a href='event_detail.php?id={$row['number']}'>{$row['title']}</a>
              </td>
              <td>
                <a href='event_detail.php?id={$row['number']}'>{$begin}~{$end}</a>
              </td>
            </tr>
          ";
      }
    }else{
      for($i=1; $i<=10; $i++){
        $row=mysqli_fetch_array($result);
        $date_create=date_create($row['begin']);
        $begin=date_format($date_create, "y년 n월 j일");
        $date_create=date_create($row['end']);
        $end=date_format($date_create, "y년 n월 j일");
          echo "
          <tr>
              <td>
                <a href='event_detail.php?id={$row['number']}'>{$row['nickname']}</a>
              </td>
              <td class='event_title'>
                <a href='event_detail.php?id={$row['number']}'>{$row['title']}</a>
              </td>
              <td>
                <a href='event_detail.php?id={$row['number']}'>{$begin}~{$end}</a>
              </td>
            </tr>
          ";
    }
  }
}

 ?>




<!-- 해당 파일은 login.html파일로부터 받은 데이터를 화면에 표시해주기 위해서 존재한다.  -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>billards world</title>
  <link rel="stylesheet" href="main_style.css">
  <link rel="stylesheet" href="main_article_style.css">
</head>
<body>
    <nav class="top">
        <?php
          session_start();
          error_reporting(0);
          if(empty($_SESSION['id'])){
            echo "<div class='top_child'><a class='top_menu' href='login.php'>로그인</a></div>
                  <div class='top_child'><a class='top_menu' href='join.php'>회원가입</a></div>";
          }else{
            echo "<div class='top_child'><a class='top_menu' href='logout.php'>로그아웃</a></div>
                  <div class='top_child'><a class='top_menu' href='mypage.php'>마이페이지</a></div>
                  <div id='nickname' class='top_child'>반갑습니다, ".$_SESSION['nickname']."님!</div>";
          }

         ?>
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
    <div class="main_article">
      <div class="main_article_child" id="issue_video">
        <div id="freeboard_text">
          <a  href="freeboard.php">핫한 게시물</a>
        </div>
        <br>
        <table>
          <tr>
            <th>작성자</th>
            <th class='freeboard_title'>제목</th>
            <th>날짜</th>
          </tr>
          <?php
            make_freeboard();
           ?>
        </table>
      </div>
      <div class="main_article_child" id="event">
        <div id="event_text">
          <a  href="event.php">핫한 당구장 이벤트</a>
        </div>
        <br>
        <table>
          <tr>
            <th>당구장</th>
            <th class='event_title'>이벤트</th>
            <th>이벤트 기간</th>
          </tr>
          <?php
            make_event();
           ?>
        </table>
    </div>
      </div>

      <div id="issue_video_text" class="issue_video" >
        화재의 경기
      </div>
      <div class="issue_video">
        <iframe width="700" height="400" src="https://www.youtube.com/embed/hFyzCzv7KJE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>

</body>

</html>
