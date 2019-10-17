<?php
  session_start();
  if(empty($_SESSION['id'])){
    echo "<script>
      alert('로그인 후 이용해주세요.');
      location.href='login.php';
     </script>";
  }


    if($_SESSION['who']!="admin"){
      echo "<script>
        alert('해당 페이지에 접근할 수 없습니다.');
        location.href='main.php';
       </script>";
    }

  $conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
  $sql="
    SELECT*FROM order_admin WHERE order_number={$_GET['order_number']}
  ";
  $result=mysqli_query($conn, $sql);
  $row=mysqli_fetch_array($result);
  if(empty($row[0])){
    echo "<script>
      alert('존재하지 않는 페이지 입니다.');
      location.href='order_admin.php';
     </script>";
  }
  $tel1=substr($row['user_tel'],0,3);
  $tel2=substr($row['user_tel'],3,4);
  $tel3=substr($row['user_tel'],7,4);




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
        <a href=\"order_user.php\">주문조회</a>
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
        <a href=\"order_user.php\">주문조회</a>
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
        <a href=\"order_admin.php\">주문관리</a>
      </div>
      ";
    }
  }

    $total_price=2500;
    function make_product(){
      $conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
      $sql="
        SELECT*FROM order_admin
        WHERE order_number={$_GET['order_number']}
      ";
      $result=mysqli_query($conn, $sql);
      // $row=mysqli_fetch_array($result);
      while($row=mysqli_fetch_array($result)){
            global $total_price;
            $total_price+=$row['price']*$row['quantity'];
            $date_create=date_create($row['date']);
            $date=date_format($date_create, "y년 n월 j일");
            echo "
            <tr>
                <td class='order_number'>
                  {$row['order_number']}
                </td>
                <td>
                  <img src='order_product_image_user/{$row['image']}' width='200px' height='150px'>
                </td>
                <td>
                  {$row['name']}
                </td>
                <td>

                  ";
                  echo number_format($row['price']);
                  echo "원";
                  echo "

                </td>
                <td>

                  {$row['quantity']}개

                </td>
                <td>

                  {$date}

                </td>
              </tr>
            ";
          }

        }





?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>주문 상세</title>
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
          <h2>주문 상세</h2>
          <br>
          <br>
          <br>


          <table id="product_list_box">
            <tr>
              <th class="order_number">주문번호</th>
              <th>이미지</th>
              <th >제품명</th>
              <th>가격</th>
              <th>수량</th>
              <th>주문날짜</th>


            </tr>
            <?php
              make_product();
             ?>
          </table>
          <br>
          <br>
          <div>
            <h2>총 결제 금액: <?php echo number_format($total_price).'원'; ?></h2>
          </div>
          <table id=order_info_box>
            <tr>
              <th>받으시는 분</th>
              <td><?php echo $row['user_name']; ?></td>
            </tr>
            <tr>
              <th>주소</th>
              <td><?php echo $row['user_address']; ?></td>
            </tr>
            <tr>
              <th>핸드폰 번호</th>
              <td><?php echo $tel1.'-'.$tel2.'-'.$tel3; ?></td>
            </tr>
            <tr>
              <th>배송상태</th>
              <td><?php
                if($row['delivery_status']=='no'){
                  echo '배송 전';
                }else if($row['delivery_status']=='ing'){
                  echo '배송 중';
                }else {
                  echo '배송 완료';
                }
               ?></td>
            </tr>

          </table>
      </div>
    </div>



  </body>
  <script src="//code.jquery.com/jquery-3.4.0.js"></script>
  <script type="text/javascript">
  //페이지의 모든 객체가 로딩되면
  $(document).ready(function(){
    //전체선택 체크박스를 클릭할 때
    $('#check_all').click(function(){
      //게시물의 체크박스가 체크상태가 된다.
      $('.mypost_check').prop('checked',this.checked);
    });
  });



    function delete_post(){
      var check_state=false;
      var arr_basket=document.getElementsByName("mypost[]");

      for(var i=0; i<arr_basket.length; i++){
        if(arr_basket[i].checked==true){
          check_state=true;
          break;
        }
      }
      if(check_state==true){
        if(confirm('정말 삭제하시겠습니까?')){
          return true;
        }else{
          return false;
        }
      }else {
        alert('삭제할 게시물을 선택해 주세요.');
        return false;
      }
    }
  </script>
</html>
