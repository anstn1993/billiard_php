<?php
//제품의 주문 번호를 담은 배열
$order_number=$_POST['order_number'];
//제품의 배송 상태를 담은 배열
$delivery_status=$_POST['delivery_status'];

$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
//댓글의 내용, 수정한 날짜를 update하는 쿼리문

for($i=0; $i<count($delivery_status); $i++){


    $sql="
       UPDATE order_user
       SET
        delivery_status='{$delivery_status[$i]}'

        WHERE order_number={$order_number[$i]}
    ";
    $result=mysqli_query($conn, $sql);

    $sql="
      UPDATE order_admin
      SET
      delivery_status='{$delivery_status[$i]}'

      WHERE order_number={$order_number[$i]}
    ";
    $result=mysqli_query($conn, $sql);
  }


header('Location: ./order_admin.php');


 ?>
