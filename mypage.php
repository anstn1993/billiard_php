<?php
  session_start();
  $tel1=substr($_SESSION['tel'],0,3);
  $tel2=substr($_SESSION['tel'],3,4);
  $tel3=substr($_SESSION['tel'],7,4);

  if(empty($_SESSION['id'])){
    echo "<script>
      alert('로그인 후 이용해주세요.');
      location.href='login.php';
     </script>";
  }
  function make_mypage_category(){
    if($_SESSION['who']=="normal"){
      echo "
      <div class=\"mypage_category_child\">
        <a href=\"mypage.php\">내 정보</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"edit_user_info.php\">내 정보 변경</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"mypost.php\">내가 쓴 게시물</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"mycomment.php\">내가 단 댓글</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"shopping_basket.php\">장바구니 목록</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"order_user.php\">배송조회</a>
      </div>

      ";
    }
    else if($_SESSION['who']=="club_owner"){
      echo "
      <div class=\"mypage_category_child\">
        <a href=\"mypage.php\">내 정보</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"edit_user_info.php\">내 정보 변경</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"mypost.php\">내가 쓴 게시물</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"mycomment.php?\">내가 단 댓글</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"shopping_basket.php\">장바구니 목록</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"order_user.php\">배송조회</a>
      </div>
      ";
    }
    else{
      echo "
      <div class=\"mypage_category_child\">
        <a href=\"mypage.php\">내 정보</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"edit_user_info.php\">내 정보 변경</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"mypost.php\">내가 쓴 게시물</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"mycomment.php?\">내가 단 댓글</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"shopping_basket.php\">장바구니 목록</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"member_list.php\">회원 목록</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"order_admin.php\">주문조회</a>
      </div>
      ";
    }
  }


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>마이페이지</title>
    <link rel="stylesheet" href="main_style.css">
    <link rel="stylesheet" href="mypage_style.css">
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

    <div class="mypage">
      <div class="mypage_child" id="mypage_category">
        <?php make_mypage_category(); ?>
      </div>
      <div class="mypage_child" id="mypage_article">
          <h2>내 정보</h2>
        <table id="myinfo_table">
          <tr>
            <th>
              사용자 아이디
            </th>
            <td>
              <?php echo $_SESSION['account']; ?>
            </td>
          </tr>
          <tr>
            <th>
              닉네임
            </th>
            <td>
              <?php echo $_SESSION['nickname']; ?>
            </td>
          </tr>
          <tr>
            <th>
              이름
            </th>
            <td>
              <?php echo $_SESSION['name']; ?>
            </td>
          </tr>
          <tr>
            <th>
              핸드폰 번호
            </th>
            <td>
              <?php echo $tel1; ?>-<?php echo $tel2; ?>-<?php echo $tel3; ?>
            </td>
          </tr>
          <tr>
            <th>
              주소
            </th>
            <td>
              <?php echo $_SESSION['address']; ?>
            </td>
          </tr>
        </table>
      </div>
    </div>



  </body>
</html>
