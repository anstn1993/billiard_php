<?php

session_start();
if(empty($_SESSION['id'])){
  echo "<script>
    alert('로그인 후 이용해주세요.');
    location.href='login.php';
   </script>";
}
$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
$sql="
  SELECT*FROM news_comment WHERE id={$_GET['id']}
";
$result=mysqli_query($conn, $sql);
$row=mysqli_fetch_array($result);
if($row['nickname']!=$_SESSION['nickname']){
  echo "<script>
    alert('접근 권한이 없습니다.');
    location.href='main.php';
    self.close();
   </script>";
}

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>댓글 수정</title>
     <link rel="stylesheet" href="edit_news_comment_style.css">
   </head>
   <body>
     <h2>댓글 수정</h2>
     <br>
     <form action="add_editted_news_comment.php" method="post">
       <input type="hidden" name="id" value=<?=$_GET['id']?>>
       <textarea name="comment" rows="8" cols="80" placeholder="이곳에 수정할 댓글을 입력하세요."><?php echo $row['comment'] ?></textarea>
       <div class="edit_cancel">
         <input class="edit_cancel_child" type="submit" value="수정">
         <button class="edit_cancel_child" id='cancel_button' type="button" name="button">취소</button>
       </div>
     </form>
   </body>

   <script type="text/javascript">
     var cancel_button=document.getElementById('cancel_button');
     cancel_button.addEventListener('click', function(){
       self.close();
     });
   </script>
 </html>
