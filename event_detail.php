<?php
error_reporting(0);
session_start();
$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
$sql="
  SELECT*FROM event WHERE number={$_GET['id']}
";
$result=mysqli_query($conn, $sql);
$row=mysqli_fetch_array($result);


if(empty($row[0])){
  echo "<script>
    alert('존재하지 않는 페이지 입니다.');
    location.href='event.php';
   </script>";
}

if(empty($_SESSION['id'])){
  echo "<script>
    alert('로그인 후 이용해주세요.');
    location.href='login.php';
   </script>";
}

$title=$row['title'];
$article=$row['article'];
$nickname=$row['nickname'];
$address=$row['address'];
$date_create=date_create($row['begin']);
$view_count=$row['view_count'];
$begin=date_format($date_create, "y년 n월 j일");
$date_create=date_create($row['end']);
$end=date_format($date_create, "y년 n월 j일");
$date_create=date_create($row['date']);
$date=date_format($date_create, "y년 n월 j일");

if(empty($_COOKIE['event_'.$row['number'].'_'.$_SESSION['id']])){
  //조회수를 1씩 증가시키기 위한 sql문이다.
  $sql_update="
  UPDATE event
  SET
   view_count=view_count+1

   WHERE number={$_GET['id']}
   ";
   $view_count_result=mysqli_query($conn,$sql_update);
   //유지기간이 24시간인 쿠키를 만들어서 24시간동은은 조회수가 올라가지 않도록 한다.
   setcookie('event_'.$row['number'].'_'.$_SESSION['id'],'viewed',time()+(60*60*24),'/');
   //테스트를 위해서 유지기간이 10초인 쿠키를 만든다.
   // setcookie('event_'.$row['number'].'_'.$_SESSION['id'],'viewed',time()+(10),'/');
}


 //이미지를 출력하기 위한 함수
 function make_image(){
   $conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
   $sql="
     SELECT*FROM event WHERE number={$_GET['id']}
   ";
   $result=mysqli_query($conn, $sql);
   $row=mysqli_fetch_array($result);
   $image=$row['image'];
   if(!empty($image)){
     echo "<img src='event_image/{$image}' width='500px' height='400px'>";
   }
 }

//댓글의 리스트를 만들기 위한 함수
 function make_comment(){
   $conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
   $sql="
     SELECT*FROM event WHERE number={$_GET['id']}
   ";
   $result=mysqli_query($conn, $sql);
   $row=mysqli_fetch_array($result);
   $event_num=$row['number'];

   $sql="
     SELECT*FROM event_comment WHERE event_number={$event_num}
   ";
   $result=mysqli_query($conn, $sql);
   // $id_array=array();
   while($row=mysqli_fetch_array($result)){
     // array_push($id_array, $row['id']);
     // $id_array_index=array_search($row['id'],$id_array);
     $date_create=date_create($row['date']);
     $date=date_format($date_create, "y년 n월 j일");
     if($row['nickname']==$_SESSION['nickname']){
       echo "
       <tr>
           <td>
             {$row['nickname']}
           </td>
           <td id='td_comment'>
             {$row['comment']}
           </td>
           <td>
             {$date}
           </td>
           <td>
             <button class='edit_button' type='button' onclick=\"window.open('http://192.168.56.101/edit_event_comment.php?id={$row['id']}','댓글 수정','width=550, height=400, left=500, top=200')\">수정</button>
           </td>
           <td>
             <button class='delete_button' type='button' onclick=\"location.href='delete_event_comment.php?id={$row['id']}&page={$_GET['page']}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}&mypost={$_GET['mypost']}'\">삭제</button>
           </td>
         </tr>
       ";
     }
     else{
       echo "
       <tr>
           <td>
             {$row['nickname']}
           </td>
           <td id='td_comment'>
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
    <title>당구장 이벤트</title>
    <link rel="stylesheet" href="main_style.css">
    <link rel="stylesheet" href="event_detail_styel.css">
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

    <table  class='article_box'>
      <tr>
        <th id='title'>
          제목
        </th>
        <td colspan='2' id="event_detail_title">
          <?php echo $title; ?>
        </td>
        <th id='view_count'>
          조회수
        </th>
        <td>
          <?php echo $view_count; ?>
        </td>
      </tr>
      <tr id=event_info>
        <th id=writer>
          작성자
        </th>
        <td colspan="2">
          <?php echo $nickname; ?>
        </td>
        <th id=upload_date>
          작성일
        </th>
        <td id=upload_date_data>
          <?php echo $date; ?>
        </td>
      </tr>
      <tr>
        <th id='location'>
          장소
        </th>
        <td id='location_data' colspan="4">
          <?php echo $address; ?>
        </td>
      </tr>

      <tr>
        <th id='period'>
          이벤트 기간
        </th>
        <td id='period_data' colspan="4">
          <?php echo $begin; ?>~<?php echo $end; ?>
        </td>
      </tr>

      <tr>
        <td id='article' colspan="5">
          <div class="article">
            <?php echo $article; ?>
            <div class="image">
              <?php
                make_image();
               ?>
            </div>
          </div>
        </td>
      </tr>

    </table>





    <br>

    <div class="post_control_menu">
      <?php
        //내가 등록한 이벤트인 경우
        if($row['nickname']==$_SESSION['nickname']){
          //이벤트 게시판에서 접근한 경우
          if(empty($_GET['mypost'])){
            echo "
            <a href=\"edit_event.php?id={$_GET['id']}&page={$_GET['page']}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">이벤트 수정</a>
            <a id=\"delete_button\" href=\"delete_event.php?id={$_GET['id']}&page={$_GET['page']}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">이벤트 삭제</a>
            <a href=\"event.php?page={$_GET['page']}&page={$_GET['page']}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">목록으로</a>
            ";
          }
          //내가 쓴 게시물 게시판에서 접근한 경우
          else {
            echo "
            <a href=\"edit_event.php?id={$_GET['id']}&page={$_GET['page']}&mypost={$_GET['mypost']}\">이벤트 수정</a>
            <a id=\"delete_button\" href=\"delete_event.php?id={$_GET['id']}&page={$_GET['page']}&mypost={$_GET['mypost']}\">이벤트 삭제</a>
            <a href=\"my_event_post.php?page={$_GET['page']}\">목록으로</a>
            ";
          }
        }
        //다른 사용자가 등록한 이벤트인 경우
        else{
          echo "

          <a href=\"event.php?page={$_GET['page']}&page={$_GET['page']}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">목록으로</a>
          ";
        }

       ?>

    </div>

    <div class="comment_box">
      <h2>댓글</h2>
      <br>
      이벤트에 대한 궁금한 점이나 여러분의 생각을 적어주세요!
      <br>
      <form  action="add_event_comment.php" method="post">
        <input type="hidden" name="page" value=<?php echo $_GET['page']; ?>>
        <input type="hidden" name="event_id" value=<?php echo $_GET['id']; ?>>
        <input type="hidden" name="search_value" value="<?php echo $_GET['search_value']; ?>">
        <input type="hidden" name="search_category" value="<?php echo $_GET['search_category']; ?>">
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
            <th>댓글</th>
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

    <script>
      //게시물을 삭제할 때 confirm을 이용해서 true가 반환되면 게시물을 삭제하는 경고창을 띄우고
      //false를 반환하면 a태그의 실행을 중지시켰다.
      var delete_button = document.getElementById('delete_button');
      delete_button.addEventListener('click',function(event){
        if(confirm('정말로 삭제하시겠습니까?')){
          alert('게시물이 삭제되었습니다.');
        }else{
          event.preventDefault();
        }
      });
    </script>
  </body>
</html>
