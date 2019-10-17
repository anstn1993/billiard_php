<?php
  session_start();
  error_reporting(0);

  $conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');


  $sql="
    SELECT*FROM basket
    WHERE nickname='{$_SESSION['nickname']}'
  ";
  $result=mysqli_query($conn, $sql);

  //장바구니의 개수를 담는 변수
  $count=mysqli_num_rows($result);





//제품 테이블에서 id값이 가장 큰 값을 조회하기 위한 sql문
$sql="
  SELECT*FROM product
  ORDER BY id DESC
";
$result=mysqli_query($conn, $sql);
$row=mysqli_fetch_array($result);
//가장 큰 id값을 담는다.
$max_id=$row['id'];
//비로그인상태에서 접속한 쿠키를 담기 위한 배열
$basket_unlogin_arr=array();
//반복문을 돌려서 해당 id값으로 된 쿠키가 있으면 그 쿠키만 배열에 담는다.
for($i=1; $i<=$max_id; $i++){
  if(!empty($_COOKIE['basket_'.$i])){
    array_push($basket_unlogin_arr, $_COOKIE['basket_'.$i]);
  }

}

$unlogin_count=count($basket_unlogin_arr);





 ?>


<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>당구용품</title>
  <link rel="stylesheet" href="main_style.css">
  <link rel="stylesheet" href="product_style.css">
  <script src="addComma.js"></script>
</head>
<body>
  <nav class="top">
    <?php

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

  <h1 class="product_title">당구용품</h1>
  <br>
  <br>
  <div class="upload_product">
    <?php
      if(empty($_SESSION['id']) || $_SESSION['who']=='club_owner' || $_SESSION['who']=='normal'){
        echo "";
      }else{
        echo "<a href=\"upload_product.php\">제품등록</a>";
      }
     ?>

  </div>
<br>
<br>
  <div class="product_list">
    <?php
    $sql="
      SELECT*FROM product
      ORDER BY id DESC
    ";
    $result=mysqli_query($conn, $sql);
    //product테이블의 전체 데이터 수
    $total_data_num=mysqli_num_rows($result);
    //현재 페이지
    $page=($_GET['page'])?$_GET['page']:1;

    //한 페이지에 뿌려줄 리스트 수
    $list_num=6;
    //한 블럭의 사이즈
    $block_num=3;

    //전체 페이지 수
    $total_page=ceil($total_data_num/$list_num);

    //존재하지 않는 페이지 예외처리
      if(!empty($_GET['page'])){
        if($_GET['page']<=0 || $_GET['page']>$total_page){
          echo "<script>
            alert('존재하지 않는 페이지 입니다.');
            location.href='product.php';
           </script>";
        }
      }

    //전체 블럭 수
    $total_block=ceil($total_page/$block_num);
    //현재 페이지의 블럭
    $current_block=ceil($page/$block_num);


    //블럭의 첫 페이지
    $start_page=($current_block*$block_num)-($block_num-1);
    //첫 페이지가 1보다 작거나 같게 나오면
    if($start_page<=1) {
      //시작페이지는 1이 된다.
      $start_page=1;
    }

    //블럭의 마지막 페이지
    $end_page=$current_block*$block_num;
    //만약 마지막 페이지가 전체 페이지보다 크거나 같게 나오면
    if($end_page>=$total_page){
      //마지막 페이지는 전체 페이지값이 된다.
      $end_page=$total_page;
    }

    //mysql에서 limit속성을 쓸 때 페이지의 시작 index를 지정해주기 위해서 선언하는 변수
    //현재 페이지*한 페이지에 보여질 수
    $start_index=($page-1)*$list_num;

    //누른 페이지에 따라 데이터의 시작부터 내가 설정한 페이지당 리스트 수만큼 출력해주는 쿼리문이 실행
    $sql="
        SELECT*FROM product
        ORDER BY id DESC LIMIT {$start_index}, {$list_num}
      ";
      $result=mysqli_query($conn, $sql);

    while($row=mysqli_fetch_array($result)){
      echo "<div class='product_list_child'>
        <a href=product_detail.php?id={$row['id']}&page={$_GET['page']}>
          <img src='product_image/{$row['image']}' width='300px' height='200px'>
          <br>
          {$row['name']}
          <br>";
      //number_format함수는 인자에 들어온 숫자를 회계적 숫자로 치환해준다.
      echo number_format($row['price']);
      echo "원
          <br>
        </a>
      </div>
      ";
    }
     ?>
  </div>
  <div id="basket_button">
    <?php

      if(empty($_SESSION['id'])){
        if($unlogin_count==0){
          echo "

          ";
        }else {
          echo "
          <a href=\"shopping_basket_unlogin.php\">
            장바구니
            {$unlogin_count}개
          </a>
          ";
        }

      }else {
        if($count==0){
          echo "";

        }else{
          echo "
          <a href=\"shopping_basket.php\">
            장바구니
            {$count}개
          </a>
          ";
        }
      }
     ?>
  </div>

  <div id="page">
    <?php
    if($total_data_num!=0){
      //이전 블록으로 가기, 처음으로 가기 버튼

        $start_page_=$start_page-1;
        echo ($page!=1)?"<a href=\"product.php?page=1\">[처음으로]</a>":"[처음으로]";

        echo ($current_block!=1)?"<a href=\"product.php?page={$start_page_}\">[이전]</a>":"[이전]";


      //페이징 넘버를 출력해주는 반복문
      for($i=$start_page; $i<=$end_page; $i++){
        if($i==$page){
          echo "
            <a href=\"product.php?page={$i}\" style=\"color:red; border:1px solid gray;\">{$i}</a>
          ";
        }else{
          echo "
            <a href=\"product.php?page={$i}\">{$i}</a>
          ";
        }

      }

      //다음 블록으로 가기, 마지막으로 가기 버튼
      $end_page_=$end_page+1;
      //현재 블럭이 마지막 블럭이 아닌 경우에만 다음 블럭으로 가는 버튼이 나오게 한다.
      echo ($current_block!=$total_block)?"<a href=\"product.php?page={$end_page_}\">[다음]</a>":"[다음]";
        //현재 페이지가 마지막 페이지가 아닌 경우에만 마지막 페이지로 가는 버튼이 나오게 한다.
        echo ($page!=$total_page)?"<a href=\"product.php?page={$total_page}\">[마지막으로]</a>":"[마지막으로]";

    }

     ?>
  </div>

</body>
</html>
