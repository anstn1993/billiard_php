<?php
//비로그인 상태에서 장바구니에 상품을 담을 경우 접근하는 api
setcookie('basket_' . $_GET['id'], $_GET['id'], time() + (60 * 60 * 24), '/');//쿠키에 선택한 용품의 데이터를 담아준다.
echo $_COOKIE['basket_' . $_GET['id']];

header('Location: ./product.php?page=' . $_GET['page']);//제품 페이지로 redirection
?>
