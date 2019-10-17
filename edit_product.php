<?php
session_start();

if(empty($_SESSION['id'])){
  echo "<script>
    alert('관리자 아이디로 로그인 후 이용해주세요.');
    location.href='login.php';
   </script>";
}else if($_SESSION['who']!="admin"){
  echo "<script>
    alert('접근 권한이 없습니다.');
    location.href='main.php';
   </script>";
}else {

}

$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
$sql="
  SELECT*FROM product WHERE id={$_GET['id']}
";
$result=mysqli_query($conn, $sql);
$row=mysqli_fetch_array($result);
if(empty($row[0])){
  echo "<script>
    alert('존재하지 않는 페이지 입니다.');
    location.href='product.php';
   </script>";
}

 ?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>제품 수정</title>
    <link rel="stylesheet" href="main_style.css">
    <link rel="stylesheet" href="upload_product_style.css">
  </head>
  <body>
    <nav class="top">
        <div class='top_child'>
          <a class='top_menu' href='mypage.php'>마이페이지</a>
        </div>
      <div class="top_child">
        <a class="top_menu" href="main.php">메인으로</a>
      </div>
  </nav>
  <div class="main">
    <h1><a href="main.php">billiards world</a></h1>
  </div>

    <nav class="menu">
      <div class="menu_child">
        <a class="freeboard" href="freeboard.php">자유게시판</a>
      </div>
      <div class="menu_child">
        <a class="chat" href="chat.php">당톡방</a>
      </div>
      <div class="menu_child">
        <a class="event" href="event.php">당구장 이벤트</a>
      </div>
      <div class="menu_child">
        <a class="news" href="news.php">당구소식</a>
      </div>
      <div class="menu_child">
          <a class="product" href="product.php">당구용품</a>
      </div>
    </nav>

    <h1 class="upload_product_title">제품 수정</h1>

    <form enctype='multipart/form-data' action="add_editted_product.php" method="post"  onsubmit="return upload()">
      <input type="hidden" name="id" value=<?php echo $row['id']; ?>>
      <input id="image_check" type="hidden" name="image_result" value=<?php echo $row['image']; ?>>
      <table>
        <tr>
          <td>제품명</td>
          <td>
            <input type="text" name="name" required="required" placeholder="제품명" value=<?php echo $row['name'];  ?>>
          </td>
        </tr>
        <tr>
          <td>제품 설명</td>
          <td>
            <textarea name="spec" rows="8" cols="80" placeholder="제품 설명"><?php echo $row['spec']; ?></textarea>
          </td>
        </tr>
        <tr>
          <td>제품 가격</td>
          <td>
            <input type="number" name="price" required="required" value=<?php echo $row['price']; ?>>
          </td>
        </tr>
        <tr>
          <td>
            수정할 이미지
          </td>
          <td>
            <input id="image_input" type="file" name="image" value=<?php echo $row['image']; ?>>
          </td>
        </tr>
        <tr>
          <td></td>
          <td id="delete_image_button">

          </td>
        </tr>
          <tr>
            <td></td>
            <td id='img_box'>
                <img id="img" src="">

            </td>
          </tr>

      </table>
      <div class="upload_cancel">
        <input type="submit" name="upload" value="수정">
        <button type="button" name="cancel" onclick="location.href='product.php'">취소</button>
      </div>
    </form>

    <!-- <script type="text/javascript">
      function upload(){
        var
      }

    </script> -->

  </body>

  <script src="//code.jquery.com/jquery-3.4.0.js"></script>
  <script type="text/javascript">
    var image="<?php echo $row['image']; ?>";
    if(image!=""){
      $( document ).ready(function() {
       $('#img_box').prepend("<img id='img' src='product_image/"+image+"' width='300px' height='200px'>");
        document.getElementById('delete_image_button').innerHTML = "<button type='button' name='button' onclick='delete_image()'>이미지 삭제</button>";
     });

    }





    var sel_file;

    $(document).ready(function(){
        $('#image_input').on("change", fileSelect);
    });

    function fileSelect(e){
      var files = e.target.files;
      var filesArr=Array.prototype.slice.call(files);

      filesArr.forEach(function(f){
        if(!f.type.match("image.*")){
          alert('이미지만 선택 가능 합니다.');
          return;
        }

        sel_file=f;

        var reader =new FileReader();
        reader.onload = function(e){
          //img태그 객체를 가져와서 attr속성을 통해서 src를 두번째 파라미터로 지정해줬다.
          $('#img').attr("src", e.target.result).attr("width", '300px').attr("height", '200px');
        }
        reader.readAsDataURL(f);

      });
    }

    $('#image_input').change(function(){
        make_delete_image_button();
    });

    function make_delete_image_button(){
      document.getElementById('delete_image_button').innerHTML = "<button type='button' name='button' onclick='delete_image()'>이미지 삭제</button>";
    }

    function delete_image(){
      $('#img').remove();
      $('#image_input').val("");
      $('#img_box').append("<img id='img' src=''>");
      document.getElementById('delete_image_button').innerHTML = "";
      $('#image_check').val("deleted");

    }

  </script>

</html>
