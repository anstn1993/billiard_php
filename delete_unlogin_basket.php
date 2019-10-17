<?php
$basket=$_POST['basket'];

//체크박스에서 선택한 장바구니 쿠키를 삭제한다.
for($i=0; $i<count($basket); $i++){
  //time()뒤에 시간을 -1이나 그보다 큰 숫자로 설정하면 해당 쿠키는 삭제된다.
  setcookie('basket_'.$basket[$i],'added',time()-1,'/');
}

header('Location: ./shopping_basket_unlogin.php');

 ?>
