<?php
$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');

$sql="
  INSERT INTO product
    (name, image, spec, price)
   VALUES(
     '{$_POST['name']}',
     '0',
     '{$_POST['spec']}',
     '{$_POST['price']}'
   )
";

$result=mysqli_query($conn, $sql);
//제품 이미지 번호(이름)를 지정해주기 위한 변수
$number=mysqli_insert_id($conn);
$sql="
  UPDATE product
  SET
    image='{$number}'
  WHERE id={$number}
";
$result=mysqli_query($conn, $sql);
echo $_FILES['image']['name'];
if(!empty($_FILES['image']['name'])){
  // rename($_FILES['image']['name'],$row_num);
  $name=$number;
  $save_dir='./product_image';
  move_uploaded_file($_FILES['image']['tmp_name'], "$save_dir/$name");
}


header('Location: ./product.php');
 ?>
