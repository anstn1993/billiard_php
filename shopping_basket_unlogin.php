<?php


function make_basket()
{
    $conn = mysqli_connect('127.0.0.1', 'root', 'rla933466r!', 'billiards');
    $sql = "
      SELECT*FROM product
      ORDER BY id DESC
    ";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $max_id = $row['id'];
    $basket_unlogin_arr = array();
    for ($i = 1; $i <= $max_id; $i++) {
        if (!empty($_COOKIE['basket_' . $i])) {
            array_push($basket_unlogin_arr, $_COOKIE['basket_' . $i]);
        }
    }

    for ($i = 0; $i < count($basket_unlogin_arr); $i++) {
        $sql = "
        SELECT*FROM product
        WHERE id={$basket_unlogin_arr[$i]}
      ";
        $result_ = mysqli_query($conn, $sql);
        $product = mysqli_fetch_array($result_);
        echo "<div class='basket_list_child' id={$product['id']}>
        <a href=product_detail.php?id={$product['id']}>
          <img src='product_image/{$product['image']}' width='300px' height='200px'>
          <br>
          {$product['name']}
          <br>";
        //number_format함수는 인자에 들어온 숫자를 회계적 숫자로 치환해준다.
        echo number_format($product['price']);
        echo "원
          <br>
        </a>
      수량 <input type=\"number\" name=\"count[]\" value='1' min='1'>개
        <br>
        <input type=\"checkbox\" name=\"basket[]\" value=\"{$product['id']}\" class=\"basket_check\">
      </div>
      ";
    }
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>장바구니</title>
    <link rel="stylesheet" href="main_style.css">
    <link rel="stylesheet" href="basket_unlogin_style.css">
</head>
<body>
<nav class="top">
    <div class='top_child'><a class='top_menu' href='login.php'>로그인</a></div>
    <div class='top_child'><a class='top_menu' href='join.php'>회원가입</a></div>
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


<div class="mypage_child" id="mypage_article">
    <h2>장바구니 목록</h2>
    <br>

    <form class="purchase_form" method="post" name="basket_form">
        <div id="delete_button_box">
            전체선택<input type="checkbox" id="check_all">
            <input type="button" value="장바구니 삭제" onclick="action_delete()">
        </div>
        <br>
        <br>
        <br>
        <div id="basket_list">
            <?php
            make_basket();
            ?>
        </div>
        <br>
        <div id="pay_info">
            <input type="button" value="구매하기" onclick="action_payment()">
        </div>
    </form>
</div>

</body>

<script src="//code.jquery.com/jquery-3.4.0.js"></script>
<script type="text/javascript">
    //페이지의 모든 객체가 로드되면
    $(document).ready(function () {
        //전체선택 체크박스를 클릭할 때
        $('#check_all').click(function () {
            //장바구니 리스트의 모든 체크박스가 체크상태가 된다.
            $('.basket_check').prop('checked', this.checked);
        });
    });


    //장바구니 리스트를 삭제하는 함수
    function action_delete() {
        var check_state = false;
        var arr_basket = document.getElementsByName("basket[]");

        for (var i = 0; i < arr_basket.length; i++) {
            if (arr_basket[i].checked == true) {
                check_state = true;
                break;
            }
        }
        if (check_state == true) {
            if (confirm('정말 삭제하시겠습니까?')) {
                document.basket_form.action = 'delete_unlogin_basket.php';
                document.basket_form.submit();
            } else {

            }
        } else {
            alert('삭제할 장바구니 리스트를 선택해 주세요.');
        }
    }

    function action_payment() {
        var check_state = false;
        var arr_basket = document.getElementsByName("basket[]");
        var arr_count = document.getElementsByName("count[]");
        for (var i = 0; i < arr_basket.length; i++) {
            if (arr_basket[i].checked == true) {
                check_state = true;
                break;
            }
        }

        if (check_state == true) {
            for (var i = 0; i < arr_basket.length; i++) {
                if (arr_basket[i].checked == false) {
                    arr_count = 0;
                }
            }
            alert('로그인 후 이용해주세요.');
            document.basket_form.action = 'login.php';
            document.basket_form.submit();
        } else {
            alert('최소 한 개 이상의 상품을 선택해 주세요.');
        }
    }
</script>

</html>
