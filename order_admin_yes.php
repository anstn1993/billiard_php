<?php
  error_reporting(0);
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


      $total_data_num=0;
      $conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
      $sql="
        SELECT*FROM order_admin
        ORDER BY id DESC
      ";
      $result=mysqli_query($conn, $sql);
      // $row=mysqli_fetch_array($result);
      $row=mysqli_fetch_array($result);
      $row_num=$row['id'];

      for($i=$row_num; $i>0; $i--){
        $sql="
          SELECT*FROM order_admin
          WHERE id={$i}
        ";
        $result=mysqli_query($conn, $sql);
        $row=mysqli_fetch_array($result);
        $i_=$i-1;
        $sql="
          SELECT*FROM order_admin
          WHERE id='{$i_}'
        ";
        $result=mysqli_query($conn, $sql);
        $row_compare=mysqli_fetch_array($result);

        if($row['delivery_status']=='yes'){


          //다음 출력되는 주문번호와 지금 출력되는 주문번호가 다르다면
          if($row['order_number']!=$row_compare['order_number']){
            $total_data_num+=1;
          }else {

          }
        }
      }





?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>주문 관리</title>
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
          <h2>주문 관리</h2>
          <br>
          <br>
          <div id="delivery_category">
            <a href='order_admin.php' >배송 전</a>
            <a href='order_admin_ing.php'>배송 중</a>
            <a href='order_admin_yes.php' style="background-color:#F2B08F">배송 완료</a>

          </div>
          <br>
          <br>
          <br>
          <form action="edit_delivery_status.php" method="post">


          <table id="order_user_table">
            <tr>
              <th class="order_number">주문번호</th>
              <th>이미지</th>
              <th >제품명</th>
              <th>가격</th>
              <th>수량</th>
              <th>주문날짜</th>
              <th>배송상태</th>

            </tr>
            <?php
            //get방식으로 전달받은 현재 page 수/삼항연산자를 이용해서 get값이 없으면 defalut로 1페이지가 출력되게 설정
            $page=($_GET['page'])?$_GET['page']:1;
            //한 페이지당 보여줄 리스트의 수
            $list_num=3;
            //한 페이지 블록에 보여줄 페이지 수
            $block_num=3;

            //전체 페이지 수
            //ceil함수는 파라미터의 값을 반올림 처리 해주는 함수다.
            $total_page=ceil($total_data_num/$list_num);

            //존재하지 않는 페이지 예외처리
            if(!empty($_GET['page'])){
              if($_GET['page']<=0 || $_GET['page']>$total_page){
                echo "<script>
                  alert('존재하지 않는 페이지 입니다.');
                  location.href='order_user.php';
                 </script>";
              }
            }


            //총 블록의 수
            $total_block=ceil($total_page/$block_num);

            //현재 위치한 블락의 번호
            $current_block=ceil($page/$block_num);



            //각 블록 당 시작 페이지
            $start_page=($current_block*$block_num)-($block_num-1);
            //시작 페이지가 1보다 작거나 같은 경우에는
            if($start_page<=1){
              //시작 페이지를 1로 설정--페이지의 최소범위보다 시작페이지가 작아지는 것을 방지
              $start_page=1;
            }

            //각 블록 당 마지막 페이지
            $end_page=($current_block*$block_num);
            //만약 전체 페이지 수보다 마지막 페이지의 수가 더 크면
            if($total_page<=$end_page){
              //마지막 페이지 수는 전체 페이지 수로 바꾼다. --마지막 페이지가 페이지의 최대 범위를 넘어서는 것을 방지
              $end_page=$total_page;
            }


            $sql="
              SELECT*FROM order_admin
              ORDER BY id DESC
            ";
            $result=mysqli_query($conn, $sql);
            // $row=mysqli_fetch_array($result);
            $row=mysqli_fetch_array($result);
            $row_num=$row['id'];

            //한 페이지에서 가장 하단에 위치하게 되는 게시물의 인덱스
            $min_index=0;
            //한 페이지에서 가장 상단에 위치하게 되는 게시물의 인덱스
            $max_index=0;
            //가장 하단에 위치하게 되는 게시물의 번호
            $min_number;
            //가장 상단에 위치하게 되는 게시물의 번호
            $max_number;

            //이 반복문은 페이지의 가장 하단에 위치하게 되는 게시물의 인덱스와 게시물 번호를 구하기 위한 반복문
            for($i=$row_num; $i>0; $i--){
              $sql="
                SELECT*FROM order_admin
                WHERE id={$i}
              ";
              $result=mysqli_query($conn, $sql);
              $row=mysqli_fetch_array($result);
              $i_=$i-1;
              $sql="
                SELECT*FROM order_admin
                WHERE id='{$i_}'
              ";
              $result=mysqli_query($conn, $sql);
              $row_compare=mysqli_fetch_array($result);

              if($row['delivery_status']=='yes'){


                //다음 출력되는 주문번호와 지금 출력되는 주문번호가 다르다면
                if($row['order_number']!=$row_compare['order_number']){
                  //최하단 게시물의 인덱스를 1씩 추가해준다.
                  $min_index+=1;
                }else {

                }
                //최하단 게시물의 인덱스가 각 페이지의 마지막 인덱스가 되는 순간
                if($min_index==$page*$list_num){
                    //최하단 게시물 번호를 저장한다.
                    $min_number=$row['id'];
                    //그리고 반복문을 빠져나간다.
                    break;
                }
                //만약 페이지의 리스트가 3개가 되지 않아서 최하단의 게시물 인덱스가 10이 되지 않고
                //테이블 row의 값이 null이 아닌 경우에(이 조건이 없으면 반복문의 마지막 차례의 row값이 들어가서 없는 값을 참조하게 된다.)
                else if(!empty($row[0]) && $min_index < $page*$list_num){
                  //최하단 리스트의 게시물 번호를 저장한다.
                  $min_number=$row['id'];
                }
              }
            }

            //이 반복문은 각 페이지의 최상단 리스트의 인덱스와 게시물 번호를 구하기 위한 반복문이다.
            for($i=$row_num; $i>0; $i--){
              $sql="
                SELECT*FROM order_admin
                WHERE id={$i}
              ";
              $result=mysqli_query($conn, $sql);
              $row=mysqli_fetch_array($result);
              $i_=$i-1;
              $sql="
                SELECT*FROM order_admin
                WHERE id='{$i_}'
              ";
              $result=mysqli_query($conn, $sql);
              $row_compare=mysqli_fetch_array($result);

              if($row['delivery_status']=='yes'){


                //다음 출력되는 주문번호와 지금 출력되는 주문번호가 다르다면
                if($row['order_number']!=$row_compare['order_number']){
                  //최상단 게시물의 인덱스를 1씩 올린다.
                  $max_index+=1;
                }else {

                }
                //최상단 게시물 인덱스가 각 페이지의 첫번째 인덱스와 같은 경우
                if($max_index==$page*$list_num-($list_num-1)){
                  //주문관리 게시판의 경우 하나의 리스트에 복수의 데이터 row가 들어갈 수 있기 때문에 하나 이상의 row가 들어가면 가장 마지막 row가 저장이 된다. 근데 지금 필요한 id값은 그 리스트의 가장 최상단 id이기 때문에 다음과 같은 작업을 해준다.
                  //현재 주문번호를 저장해서
                  $last_order_number=$row['order_number'];
                  //쿼리문을 통해서 현재 주문번호를 가진 row만 내림차순으로 정렬하고
                  $sql="
                    SELECT*FROM order_admin
                    WHERE order_number='{$last_order_number}'
                    ORDER BY id DESC
                  ";
                  $result=mysqli_query($conn, $sql);

                  $row=mysqli_fetch_array($result);
                  //가장 최상단의 id를 저장한다.
                  $max_number=$row['id'];
                  //그리고 반복문을 빠져나간다.
                  break;
                }
              }
            }




          if(!empty($min_number) && !empty($max_number)){
            //이 반복문은 실제로 각 페이지에 리스트가 나타나게 하는 반복문이다.
            //실제로 게시물 번호의 최대값과 최소값의 차는 10이 넘을 수 있지만 이미 위에서 내가 댓글을 단 게시물로 필터링했을 때의 게시물 번호를 저장한 것이기 때문에 정확히 3개씩 리스팅이 가능하다.
            for($i=$max_number; $i>=$min_number; $i--){
              $sql="
                SELECT*FROM order_admin
                WHERE id={$i}
              ";
              $result=mysqli_query($conn, $sql);
              $row=mysqli_fetch_array($result);
              $i_=$i-1;
              $sql="
                SELECT*FROM order_admin
                WHERE id='{$i_}'
              ";
              $result=mysqli_query($conn, $sql);
              $row_compare=mysqli_fetch_array($result);

              if($row['delivery_status']=='yes'){


                //다음 출력되는 주문번호와 지금 출력되는 주문번호가 다르다면
                if($row['order_number']!=$row_compare['order_number']){
                  $date_create=date_create($row['date']);
                  $date=date_format($date_create, "y년 n월 j일");
                     echo "
                     <tr>
                         <td style='border-bottom: 1px solid black;'  class='order_number'>
                           <a href='order_admin_detail.php?order_number={$row['order_number']}'>
                           {$row['order_number']}
                           </a>
                         </td>
                         <td style='border-bottom: 1px solid black;'>
                           <a href='order_admin_detail.php?order_number={$row['order_number']}'>
                           <img src='order_product_image_user/{$row['image']}' width='150px' height='100px'>
                           </a>
                         </td>
                         <td style='border-bottom: 1px solid black;'>
                           <a href='order_admin_detail.php?order_number={$row['order_number']}'>
                           {$row['name']}</a>
                         </td>
                         <td style='border-bottom: 1px solid black;'>
                           <a href='order_admin_detail.php?order_number={$row['order_number']}'>";
                           echo number_format($row['price']);
                           echo "원";
                          echo "</a>
                         </td>
                         <td style='border-bottom: 1px solid black;'>
                           <a href='order_admin_detail.php?order_number={$row['order_number']}'>
                           {$row['quantity']}개
                           </a>
                         </td>
                         <td style='border-bottom: 1px solid black;'>
                           <a href='order_admin_detail.php?order_number={$row['order_number']}'>
                           {$date}
                           </a>
                         </td>";
                          echo "
                          <td style='border-bottom: 1px solid black;'>
                            <select class=\"delivery_category\" name=\"delivery_status[]\">
                              <option value=\"no\" >배송 전</option>
                              <option value=\"ing\" >배송 중</option>
                              <option value=\"yes\" selected='selected'>배송 완료</option>
                            </select>
                          </td>
                          </tr>
                          <input type=\"hidden\" name=\"order_number[]\" value='{$row['order_number']}'>
                          ";

                }else {
                  $date_create=date_create($row['date']);
                  $date=date_format($date_create, "y년 n월 j일");
                  echo "
                  <tr>
                      <td class='order_number'>
                        <a href='order_admin_detail.php?order_number={$row_compare['order_number']}'>
                        {$row_compare['order_number']}
                        </a>
                      </td>
                      <td>
                        <a href='order_admin_detail.php?order_number={$row_compare['order_number']}'>
                        <img src='order_product_image_user/{$row['image']}' width='150px' height='100px'>
                        </a>
                      </td>
                      <td >
                        <a href='order_admin_detail.php?order_number={$row_compare['order_number']}'>
                        {$row['name']}
                        </a>
                      </td>
                      <td>
                        <a href='order_admin_detail.php?order_number={$row_compare['order_number']}'>
                        ";
                        echo number_format($row['price']);
                        echo "원";
                        echo "
                        </a>
                      </td>
                      <td>
                        <a href='order_admin_detail.php?order_number={$row_compare['order_number']}'>
                        {$row['quantity']}개
                        </a>
                      </td>
                      <td>
                        <a href='order_admin_detail.php?order_number={$row_compare['order_number']}'>
                        {$date}
                        </a>
                      </td>
                      <td>
                      </td>
                      </tr>
                      <input type=\"hidden\" name=\"order_number[]\" value='{$row_compare['order_number']}'>
                      ";


                    }
                  }
                }
              }
             ?>

          </table>
          <input type="submit" value="배송 상태 저장" id="delivery_status_change_button">
        </form>
        <div id="page">
          <?php
          if(!empty($min_number) && !empty($max_number)){
          //이전 블록으로 가기, 처음으로 가기 버튼

            $start_page_=$start_page-1;
            echo ($page!=1)?"<a href=\"order_admin_yes.php?page=1\">[처음으로]</a>":"[처음으로]";

            echo ($current_block!=1)?"<a href=\"order_admin_yes.php?page={$start_page_}\">[이전]</a>":"[이전]";


          //페이징 넘버를 출력해주는 반복문
          for($i=$start_page; $i<=$end_page; $i++){
            if($i==$page){
              echo "
                <a href=\"order_admin_yes.php?page={$i}\" style=\"color:red; border:1px solid gray;\">{$i}</a>
              ";
            }else{
              echo "
                <a href=\"order_admin_yes.php?page={$i}\">{$i}</a>
              ";
            }

          }

          //다음 블록으로 가기, 마지막으로 가기 버튼
          $end_page_=$end_page+1;
          //현재 블럭이 마지막 블럭이 아닌 경우에만 다음 블럭으로 가는 버튼이 나오게 한다.
          echo ($current_block!=$total_block)?"<a href=\"order_admin_yes.php?page={$end_page_}\">[다음]</a>":"[다음]";
            //현재 페이지가 마지막 페이지가 아닌 경우에만 마지막 페이지로 가는 버튼이 나오게 한다.
            echo ($page!=$total_page)?"<a href=\"order_admin_yes.php?page={$total_page}\">[마지막으로]</a>":"[마지막으로]";
          }  
           ?>
        </div>
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
