<?php
include("connect_db.php");//데이터베이스와 연결

$sql = "
  SELECT*FROM product
";

$result = mysqli_query($conn, $sql);
$size = mysqli_num_rows($result);


$sql = "
  SELECT*FROM product
  WHERE id={$_GET['id']}
";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$row_number = $row['image'];
unlink('product_image/' . $row['image']);
//반복문을 이용해서 순차적으로 행의 number필드 값을 업데이트 해준다.
//범위는 내가 지우는 행의 번호 이후부터 전체 행의 사이즈까지다.
for ($i = $row_number + 1; $i < $size + 1; $i++) {
    //freeboard 테이블에서 글번호가 i인 행의 글번호를 1씩 감소기키라는 sql문이다.
    $sql = "
  UPDATE product
  SET
  image=image-1
  WHERE image={$i}
  ";
    $result = mysqli_query($conn, $sql);
    $new_name = $i - 1;
    // rename("'".$i."'","'".$new_name."'");
    rename('product_image/' . $i, 'product_image/' . $new_name);
}

$sql = "
   DELETE FROM product
    WHERE id={$_GET['id']}
";

$result = mysqli_query($conn, $sql);
//제품이 삭제되면 장바구니 테이블에서도 해당 id의 제품들을 다 지워준다.
$sql = "
   DELETE FROM basket
    WHERE product_id={$_GET['id']}
";
$result = mysqli_query($conn, $sql);
header('Location: ./product.php');
?>
