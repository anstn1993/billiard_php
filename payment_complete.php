<?php
  session_start();
  //사용자의 전화번호
  $tel=$_POST['tel1'].$_POST['tel2'].$_POST['tel3'];
  //결제 페이지에서 넘어온 상품의 번호를 담는 배열
  $basket=$_POST['basket'];
  //결제 페이지에서 넘어온 각 상품의 수량을 담는 배열
  $count=$_POST['count'];

  //총 결제 금액
  $total_price=$_POST['total_price'];

  //주문번호 생성
  $order_number=date('Ymd').time();
  echo $order_number;

  $conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');

  //결제에 성공했기 때문에 장바구니 목록에서는 삭제가 되어야 하고 이후에 주문 테이블에 결제 정보들을 넣어줘야 한다. 그 작업을 반복문을 통해서 실행해준다.
  for($i=0; $i<count($basket); $i++){
    $sql="
      DELETE FROM basket
      WHERE product_id={$basket[$i]}
    ";
    $result=mysqli_query($conn, $sql);

    $sql="
      SELECT*FROM product
      WHERE id={$basket[$i]}
    ";
    $result=mysqli_query($conn, $sql);
    $row=mysqli_fetch_array($result);

    //관리자용 주문 테이블에 주문 정보 저장을 하는 쿼리문
    $sql="
      INSERT INTO order_admin
      (order_number,
       name,
       image,
       price,
       quantity,
       user_account,
       user_name,
       user_address,
       user_tel,
       delivery_status,
       date)
       VALUES(
          '{$order_number}',
          '{$row['name']}',
          '{$row['image']}',
          '{$row['price']}',
          '{$count[$i]}',
          '{$_SESSION['account']}',
          '{$_SESSION['name']}',
          '{$_SESSION['address']}',
          '{$tel}',
          'no',
          NOW()
       )
    ";
    $result=mysqli_query($conn, $sql);

    //사용자용 주문 테이블에 주문 정보 저장을 하는 테이블
    $sql="
      INSERT INTO order_user
      (order_number,
       name,
       image,
       price,
       quantity,
       user_account,
       user_name,
       user_address,
       user_tel,
       delivery_status,
       date)
       VALUES(
          '{$order_number}',
          '{$row['name']}',
          '{$row['image']}',
          '{$row['price']}',
          '{$count[$i]}',
          '{$_SESSION['account']}',
          '{$_SESSION['name']}',
          '{$_SESSION['address']}',
          '{$tel}',
          'no',
          NOW()
       )
    ";
    $result=mysqli_query($conn, $sql);
    //system 함수를 통해서 리눅스에서 직접 명령어를 치는 효과를 준다. 제품 이미지 폴더에 있던 해당 상품의 이미지 파일을 주문 제품 이미지 폴더에 복사해서 넣어준다. 이 작업을 해주는 이유는 그냥 제품 폴더에서 이미지를 공유해서 쓰다가 해당 제품을 관리자가 삭제해버리면 주문 내역에 있는 이미지도 함께 날아가버리기 때문이다. 그래서 분리시키는 작업을 하기 위해서 따로 폴더를 파서 관리할 것이다.
    system("cp /usr/local/apache/htdocs/product_image/{$row['image']} /usr/local/apache/htdocs/order_product_image_admin/{$row['image']}");

    //사용자용과 관리자용을 따로 나눈 이유도 독립성을 줘서 한  쪽이 삭제되더라도 나머지 한 쪽에서는 보이도록 하기 위해서다.
    system("cp /usr/local/apache/htdocs/product_image/{$row['image']} /usr/local/apache/htdocs/order_product_image_user/{$row['image']}");
  }



  header('Location: ./order_user_detail.php?order_number='.$order_number);
 ?>
