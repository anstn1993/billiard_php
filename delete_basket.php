<?php
$basket=$_POST['basket'];
$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
for($i=0; $i<count($basket); $i++){
  $sql="
    DELETE FROM basket
    WHERE product_id={$basket[$i]}
  ";
  $result=mysqli_query($conn, $sql);
}

header('Location: ./shopping_basket.php');

 ?>
