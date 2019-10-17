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
        <a href=\"delivery_tracking.php\">배송조회</a>
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
        <a href=\"delivery_tracking.php\">배송조회</a>
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
          <h2>회원 목록</h2>
          <br>

          <form action="delete_account.php" method="post" onsubmit="return delete_account()">


          <div id="delete_button_box">
              전체선택<input type="checkbox" id="check_all">
              <input type="submit" value="회원 탈퇴">
          </div>
          <br><br>
          <table id="mypost_event_table">
            <tr>
              <th>번호</th>
              <th>계정</th>
              <th>닉네임</th>
              <th>이름</th>
              <th></th>
            </tr>
            <?php
            $conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
            //검색하지 않은 상태일 경우
            if(empty($_GET['search_value'])){
              //전체 사용자 데이터를 조회
              $sql="
                SELECT*FROM user
              ";
              $result=mysqli_query($conn, $sql);
              //freeboard테이블의 전체 데이터 수
              $total_data_num=mysqli_num_rows($result)-1;
            }
            //검색을 한 경우
            else {
              //검색 카테고리가 계정인 경우
              if($_GET['search_category']=='account'){
                //계정이 검색어를 포함하는 경우의 데이터 조회
                $sql="
                  SELECT*FROM user
                  WHERE account like '%{$_GET['search_value']}%'
                ";
                $result=mysqli_query($conn, $sql);
                //freeboard테이블의 전체 데이터 수
                $total_data_num=mysqli_num_rows($result);
              }
              //검색 카테고리가 닉네임인 경우
              else if($_GET['search_category']=='nickname'){
                //닉네임이 검색어를 포함하는 경우의 데이터 조회
                $sql="
                  SELECT*FROM user
                  WHERE nickname like '%{$_GET['search_value']}%'
                ";
                $result=mysqli_query($conn, $sql);
                //freeboard테이블의 전체 데이터 수
                $total_data_num=mysqli_num_rows($result);
              }
              //검색 카테고리가 이름인 경우
              else {
                //이름이 검색어를 포함하는 경우의 데이터 조회
                $sql="
                  SELECT*FROM user
                  WHERE name like '%{$_GET['search_value']}%'
                ";
                $result=mysqli_query($conn, $sql);
                //freeboard테이블의 전체 데이터 수
                $total_data_num=mysqli_num_rows($result);
              }

            }


            //get방식으로 전달받은 현재 page 수/삼항연산자를 이용해서 get값이 없으면 defalut로 1페이지가 출력되게 설정
            $page=(!empty($_GET['page']))?$_GET['page']:1;
            //한 페이지당 보여줄 리스트의 수
            $list_num=10;
            //한 페이지 블록에 보여줄 페이지 수
            $block_num=3;

            //전체 페이지 수
            //ceil함수는 파라미터의 값을 반올림 처리 해주는 함수다.
            $total_page=ceil($total_data_num/$list_num);

            //존재하지 않는 페이지 예외처리
            if(!empty($_GET['page']) && empty($_GET['search_value'])){
              if($_GET['page']<=0 || $_GET['page']>$total_page){
                echo "<script>
                  alert('존재하지 않는 페이지 입니다.');
                  location.href='member_list.php';
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


            //mysql에서 limit속성을 쓸 때 페이지의 시작 index를 지정해주기 위해서 선언하는 변수
            //현재 페이지*한 페이지에 보여질 수
            $start_index=($page-1)*$list_num;

            //리미트 속성을 검색을 하지 않았을 때와 검색을 했을 때로 나누어서 설정해준다.
            //검색을 하지 않은 경우
            if(empty($_GET['search_value'])){
              //누른 페이지에 따라 데이터의 시작부터 내가 설정한 페이지당 리스트 수만큼 출력해주는 쿼리문이 실행
              $sql="
                  SELECT*FROM user
                  ORDER BY id DESC LIMIT {$start_index}, {$list_num}
                ";
                $result=mysqli_query($conn, $sql);
            }
            //검색을 한 경우
            else{
              //검색 카테고리가 계정인 경우
              if($_GET['search_category']=='account'){
                $sql="
                    SELECT*FROM user
                    WHERE account like '%{$_GET['search_value']}%'
                    ORDER BY id DESC LIMIT {$start_index}, {$list_num}
                  ";
                  $result=mysqli_query($conn, $sql);
              }
              //검색 카테고리가 닉네임인 경우
              else if($_GET['search_category']=='nickname'){
                $sql="
                    SELECT*FROM user
                    WHERE nickname like '%{$_GET['search_value']}%'
                    ORDER BY id DESC LIMIT {$start_index}, {$list_num}
                  ";
                  $result=mysqli_query($conn, $sql);
              }
              //검색 카테고리가 이름인 경우
              else{
                $sql="
                    SELECT*FROM user
                    WHERE name like '%{$_GET['search_value']}%'
                    ORDER BY id DESC LIMIT {$start_index}, {$list_num}
                  ";
                  $result=mysqli_query($conn, $sql);
              }
            }





              for($i=0; $i<$total_data_num; $i++){
                $row=mysqli_fetch_array($result);
                //테이블 행이 존재하는 행이고 관리자 계정이 아닌 경우에만 리스트로 출력
                if(!empty($row[0]) && $row['nickname']!='관리자'){
                    echo "
                    <tr>
                        <td>
                          {$row['id']}
                        </td>
                        <td>
                          {$row['account']}
                        </td>
                        <td>
                          {$row['nickname']}
                        </td>
                        <td>
                          {$row['name']}
                        </td>
                        <td>
                         <input type=\"checkbox\" name=\"account[]\" value=\"{$row['account']}\" class=\"myevent_check\">
                        </td>
                      </tr>
                    ";
                  }
              }

             ?>

          </table>
        </form>
        <div id="page">
          <?php
          if($total_data_num!=0){
            //이전 블록으로 가기, 처음으로 가기 버튼

              $start_page_=$start_page-1;
              echo ($page!=1)?"<a href=\"member_list.php?page=1&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">[처음으로]</a>":"[처음으로]";

              echo ($current_block!=1)?"<a href=\"member_list.php?page={$start_page_}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">[이전]</a>":"[이전]";


            //페이징 넘버를 출력해주는 반복문
            for($i=$start_page; $i<=$end_page; $i++){
              if($i==$page){
                echo "
                  <a href=\"member_list.php?page={$i}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\" style=\"color:red; border:1px solid gray;\">{$i}</a>
                ";
              }else{
                echo "
                  <a href=\"member_list.php?page={$i}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">{$i}</a>
                ";
              }

            }

            //다음 블록으로 가기, 마지막으로 가기 버튼
            $end_page_=$end_page+1;
            //현재 블럭이 마지막 블럭이 아닌 경우에만 다음 블럭으로 가는 버튼이 나오게 한다.
            echo ($current_block!=$total_block)?"<a href=\"member_list.php?page={$end_page_}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">[다음]</a>":"[다음]";
              //현재 페이지가 마지막 페이지가 아닌 경우에만 마지막 페이지로 가는 버튼이 나오게 한다.
              echo ($page!=$total_page)?"<a href=\"member_list.php?page={$total_page}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">[마지막으로]</a>":"[마지막으로]";

          }

           ?>
        </div>
        <br>
        <div id="search">
          <form action="member_list.php" method="get">
            <select name="search_category">
              <?php
                if($_GET['search_category']=='account'){
                  echo '
                  <option value="account" selected>계정</option>
                  <option value="nickname">닉네임</option>
                  <option value="name">이름</option>
                  ';
                } else if($_GET['search_category']=='nickname'){
                  echo '
                  <option value="account" >계정</option>
                  <option value="nickname" selected>닉네임</option>
                  <option value="name">이름</option>
                  ';
                }else {
                  echo '
                  <option value="account" >계정</option>
                  <option value="nickname" >닉네임</option>
                  <option value="name" selected>이름</option>
                  ';
                }
               ?>

            </select>
            <input type="hidden" name="page" value=<?php echo 1; ?>>
            <input type="text" name="search_value" value='<?php
              if(!empty($_GET['search_value'])){
                echo $_GET['search_value'];
              }
             ?>'>
            <input type="submit" value="검색">
          </form>
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
      $('.myevent_check').prop('checked',this.checked);
    });
  });

  function delete_account(){
    var check_state=false;
    var arr_basket=document.getElementsByName("account[]");

    for(var i=0; i<arr_basket.length; i++){
      if(arr_basket[i].checked==true){
        check_state=true;
        break;
      }
    }
    if(check_state==true){
      if(confirm('정말 탈퇴처리 하시겠습니까?')){
        return true;
      }else{
        return false;
      }
    }else {
      alert('탈퇴처리할 회원을 선택해 주세요.');
      return false;
    }
  }
  </script>
</html>
