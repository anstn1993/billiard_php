  <?php
  if($_POST['image_result']=="deleted"){
    echo $_POST['image_result'];
    echo $_POST['id'];
    echo "<script>
      alert('제품 이미지를 선택해 주세요.');
      location.href='edit_product.php?id={$_POST['id']}';
     </script>";
  }else{
    $conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
    $sql="
       SELECT*FROM product
       WHERE id={$_POST['id']}
    ";

    $result=mysqli_query($conn, $sql);
    $row=mysqli_fetch_array($result);

    // $sql="
    //    UPDATE product
    //    SET
    //     name='{$_POST['name']}',
    //     image='{$row['number']}',
    //     spec='{$_POST['spec']}',
    //     price='{$_POST['price']}'
    //     WHERE id={$_POST['id']}
    // ";

    $sql="
       UPDATE product
       SET
        name='{$_POST['name']}',
        image='{$row['image']}',
        spec='{$_POST['spec']}',
        price='{$_POST['price']}'
        WHERE id={$_POST['id']}
    ";

    $result=mysqli_query($conn, $sql);

    if(!empty($_FILES['image']['name'])){
      $name=$row['image'];
      $save_dir='./product_image';
      move_uploaded_file($_FILES['image']['tmp_name'], "$save_dir/$name");
    }




    header('Location: ./product_detail.php?id='.$_POST['id']);
  }


?>
