<?php
session_start();
include("connect_db.php");//데이터베이스와 연결
$sql = "
  SELECT*FROM product WHERE id={$_GET['id']}
";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);


if (empty($row[0])) {
    echo "<script>
    alert('존재하지 않는 페이지 입니다.');
    location.href='product.php';
   </script>";
}
//로그인을 하지 않으면 세션값이 없기 때문에 하단의 sql문 때문에 에러가 뜬다.
//그 에러 메세지가 화면에 뜨지 않게 하는 처리
error_reporting(0);
$sql = "
  SELECT*FROM basket WHERE nickname='{$_SESSION['nickname']}'
";
$result = mysqli_query($conn, $sql);
$added_basket = '';
//이미 장바구니에 있는 상품을 중복 추가하지 못하게 막기 위해서 변수 하나를 설정
//장바구니의 제품 id와 제품의 id가 같을 때 $added_basket변수에 'added'대입
//변수값이 'added'이 아닐 경우에만 추가 됨.
while ($basket = mysqli_fetch_array($result)) {
    if ($basket['product_id'] == $row['id']) {
        $added_basket = 'added';
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $row['name']; ?></title>
    <link rel="stylesheet" href="main_style.css">
    <link rel="stylesheet" href="product_detail_style.css">
</head>
<body>
<nav class="top">
    <?php

    error_reporting(0);
    if (empty($_SESSION['id'])) {
        echo "<div class='top_child'><a class='top_menu' href='login.php'>로그인</a></div>
              <div class='top_child'><a class='top_menu' href='join.php'>회원가입</a></div>";
    } else {
        echo "<div class='top_child'>
          <a class='top_menu' href='mypage.php'>마이페이지</a>
        </div>
      <div class=\"top_child\">
        <a class=\"top_menu\" href=\"main.php\">메인으로</a>
      </div>";
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
<h1 class="product_detail">구매 페이지</h1>
<br>
<div class="edit_delete">
    <?php
    if ($_SESSION['who'] == "admin") {
        echo "
        <a href=\"edit_product.php?id={$_GET['id']}\">제품 수정</a>
        <a id=\"delete_button\" href=\"delete_product.php?id={$_GET['id']}\">제품 삭제</a>
        <a href=\"product.php?page={$_GET['page']}\">목록으로</a>
        ";
    } else {
        echo "<a href=\"product.php?page={$_GET['page']}\">목록으로</a>";
    }

    ?>

</div>
<br>
<h2 class="product_name"><?php echo $row['name']; ?></h2>
<div class="product_img">
    <img src=<?php echo 'product_image/' . $row['image']; ?> alt=<?php echo $row['name']; ?> width="300px"
         height="300px">
</div>
<div class="product_spec">
    <?php echo $row['spec']; ?>
</div>
<div class="product_price">
    <?php echo number_format($row['price']); ?>원
</div>
<br>
<br>

<div>
    <form class="purchase_form" action="payment.php" method="post">
        <!-- 제품 id 전달 -->
        <input type="hidden" name="basket[]" value=<?php echo $row['id']; ?>>
        수량: <input type="number" name="count[]" value="1" min='1'> 개
        <br>
        <br>
        <input class="purchase_basket_button" type="submit" value="구매하기">
        <?php
        //비로그인 상태일 경우
        if (empty($_SESSION['id'])) {
            //장바구니 쿠키가 없는 경우
            if (empty($_COOKIE['basket_' . $row['id']])) {
                //새롭게 장바구니에 추가를 해준다.
                echo "
            <button class=\"purchase_basket_button\" type=\"button\" name=\"button\" onclick=\"alert('장바구니에 추가되었습니다.'); location.href='add_shopping_basket_unlogin.php?id={$row['id']}&page={$_GET['page']}'\">장바구니에 추가</button>
          ";

            } //장바구니 쿠기가 있는 경우
            else {
                //이미 장바구니에 있는 상품이기 때문에 따로 추가하지 않고 이미 존재한다는 경고 메세지 출력
                echo "
            <button class=\"purchase_basket_button\" type=\"button\" name=\"button\" onclick=\"alert('이미 장바구니에 있는 상품 입니다.');\">장바구니에 추가</button>
          ";
                // setcookie('basket_'.$row['id'],'added',time()-1,'/');
            }
        } //로그인 상태인 경우
        else {
            //장바구니에 있는 상품을 등록하려하는 경우
            if ($added_basket == 'added') {
                //이미 장바구니에 있는 상품이기 때문에 따로 추가하지 않고 이미 존재한다는 경고 메세지 출력
                echo "
            <button class=\"purchase_basket_button\" type=\"button\" name=\"button\" onclick=\"alert('이미 장바구니에 있는 상품 입니다.');\">장바구니에 추가</button>
          ";
            } //장바구니에 없는 제품인 경우
            else {
                //새롭게 장바구니에 추가를 해준다.
                echo "
            <button class=\"purchase_basket_button\" type=\"button\" name=\"button\" onclick=\"alert('장바구니에 추가되었습니다.'); location.href='add_shopping_basket.php?id={$row['id']}&page={$_GET['page']}'\">장바구니에 추가</button>
          ";
            }
        }

        ?>

    </form>
</div>

<script type="text/javascript">
    var delete_button = document.getElementById('delete_button');
    delete_button.addEventListener('click', function (event) {
        if (confirm('정말로 삭제하시겠습니까?')) {
            alert('제품이 삭제되었습니다.');
        } else {
            event.preventDefault();
        }
    });
</script>

</body>
</html>
