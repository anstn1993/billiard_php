<?php
include("connect_db.php");//데이터베이스와 연결

$basket = $_POST['basket'];

for ($i = 0; $i < count($basket); $i++) {
    $sql = "
    DELETE FROM basket
    WHERE product_id={$basket[$i]}
  ";
    $result = mysqli_query($conn, $sql);
}

header('Location: ./shopping_basket.php');

?>
