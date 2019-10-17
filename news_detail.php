<?php
error_reporting(0);
session_start();
$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
$sql="
  SELECT*FROM news WHERE number={$_GET['id']}
";
$result=mysqli_query($conn, $sql);
$row=mysqli_fetch_array($result);


if(empty($row[0])){
  echo "<script>
    alert('존재하지 않는 페이지 입니다.');
    location.href='news.php';
   </script>";
}

if(empty($_SESSION['id'])){
  echo "<script>
    alert('로그인 후 이용해주세요.');
    location.href='login.php';
   </script>";
}

//쿠키가 존재하지 않을 때만 조회수가 올라가고 쿠키를 새로 생성한다.
if(empty($_COOKIE['news_'.$row['number'].'_'.$_SESSION['id']])){
  //조회수를 1씩 증가시키기 위한 sql문이다.
  $sql_update="
  UPDATE news
  SET
   view_count=view_count+1

   WHERE number={$_GET['id']}
   ";
   $view_count_result=mysqli_query($conn,$sql_update);
   //유지기간이 24시간인 쿠키를 만들어서 24시간동안은 조회수가 올라가지 않도록 한다.
   setcookie('news_'.$row['number'].'_'.$_SESSION['id'],'viewed',time()+(60*60*24),'/');
   //테스트를 위해서 유지기간이 10초인 쿠키를 만든다.
   // setcookie('news_'.$row['number'].'_'.$_SESSION['id'],'viewed',time()+(10),'/');
}

//댓글의 리스트를 만들기 위한 함수
 function make_comment(){
   $conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
   $sql="
     SELECT*FROM news WHERE number={$_GET['id']}
   ";
   $result=mysqli_query($conn, $sql);
   $row=mysqli_fetch_array($result);
   $news_num=$row['number'];

   $sql="
     SELECT*FROM news_comment WHERE news_number={$news_num}
   ";
   $result=mysqli_query($conn, $sql);
   // $id_array=array();
   while($row=mysqli_fetch_array($result)){
     // array_push($id_array, $row['id']);
     // $id_array_index=array_search($row['id'],$id_array);
     $date_create=date_create($row['date']);
     $date=date_format($date_create,"y년 n월 j일");
     if($row['nickname']==$_SESSION['nickname']) {
       echo "
       <tr>
           <td>
             {$row['nickname']}
           </td>
           <td class='list_title' id='td_comment'>
             {$row['comment']}
           </td>
           <td>
             {$date}
           </td>
           <td>
             <button class='edit_button' type='button' onclick=\"window.open('http://192.168.56.101/edit_news_comment.php?id={$row['id']}&search_value={$_GET['search_value']}','댓글 수정','width=550, height=400, left=500, top=200')\">수정</button>
           </td>
           <td>
             <button class='delete_button' type='button' onclick=\"location.href='delete_news_comment.php?id={$row['id']}&page={$_GET['page']}&search_value={$_GET['search_value']}&mypost={$_GET['mypost']}'\">삭제</button>
           </td>
         </tr>
       ";
     }else {
       echo "
       <tr>
           <td>
             {$row['nickname']}
           </td>
           <td class='list_title' id='td_comment'>
             {$row['comment']}
           </td>
           <td>
             {$date}
           </td>
           <td>

           </td>
           <td>

           </td>
         </tr>
       ";
     }

    }
 }



 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>당구소식</title>
    <link rel="stylesheet" href="main_style.css">
    <link rel="stylesheet" href="news_detail_style.css">
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

      <div class="news_box">
          <iframe src=<?php echo $row['url'] ?> width="1500" height="1000"></iframe>
      </div>
      <div class="edit_delete">
        <?php
          //관리자 계정인 경우
          if($_SESSION['who']=="admin") {
            //당구소식 게시판에서 접근한 경우
            if(empty($_GET['mypost'])){
              echo "
                <a href=\"edit_news.php?id={$_GET['id']}&page={$_GET['page']}&search_value={$_GET['search_value']}\">기사 수정</a>
                <a id=\"delete_button\" href=\"delete_news.php?id={$_GET['id']}&page={$_GET['page']}&search_value={$_GET['search_value']}\">기사 삭제</a>
                <a href=\"news.php?page={$_GET['page']}&page={$_GET['page']}&search_value={$_GET['search_value']}\">목록으로</a>
              ";
            }
            //내가 쓴 게시물 게시판에서 접근한 경우
            else{
              echo "
                <a href=\"edit_news.php?id={$_GET['id']}&page={$_GET['page']}&mypost={$_GET['mypost']}\">기사 수정</a>
                <a id=\"delete_button\" href=\"delete_news.php?id={$_GET['id']}&page={$_GET['page']}&mypost={$_GET['mypost']}\">기사 삭제</a>
                <a href=\"my_news_post.php?page={$_GET['page']}\">목록으로</a>
              ";
            }
          }
          //일반 사용자 계정인 경우
           else {
            echo "
              <a href=\"news.php?page={$_GET['page']}&page={$_GET['page']}&search_value={$_GET['search_value']}\">목록으로</a>
            ";
          }
         ?>

      </div>
      <br>

      <div class="comment_box">
        <h2>댓글</h2>
        <br>
        기사에 대한 여러분의 생각을 적어주세요!
        <br>
        <form  action="add_news_comment.php" method="post">
          <input type="hidden" name="page" value=<?php echo $_GET['page']; ?>>
          <input type="hidden" name="news_id" value=<?php echo $_GET['id']; ?>>
          <input type="hidden" name="search_value" value="<?php echo $_GET['search_value']; ?>">
          <input type="hidden" name="mypost" value="<?php echo $_GET['mypost']; ?>">
          <table>
            <tr>
              <td>
                <textarea name="comment" rows="2" cols="50" placeholder="여기에 댓글을 적으세요."></textarea>
              </td>
              <td>
                <input class="upload" type="submit" value="등록">
              </td>
            </tr>
          </table>

          <table class="comment_list">
            <tr>
              <th>작성자</th>
              <th class="list_title">댓글</th>
              <th>날짜</th>
              <th></th>
              <th></th>
            </tr>
            <?php
              make_comment();
             ?>
          </table>
        </form>
      </div>


  </body>

  <script type="text/javascript">
    var delete_button=document.getElementById('delete_button');
    delete_button.addEventListener('click', function(event){
      if(confirm('정말로 삭제하시겠습니까?')){
        alert('소식이 삭제되었습니다.');
      }else{
        event.preventDefault();
      }
    });
  </script>
</html>
