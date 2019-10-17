<?php
setcookie('basket_'.$_GET['id'],$_GET['id'],time()+(60*60*24),'/');
echo $_COOKIE['basket_'.$_GET['id']];

header('Location: ./product.php?page='.$_GET['page']);
 ?>
