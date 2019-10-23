<?php
error_reporting(0);
include("connect_db.php");//데이터베이스와 연결
//세션 값 가져오기
session_start();
//mysql과 연결
//게시판 테이블의 아이디 값을 조회해서 해당 아이디값의 row 선택
$sql = "
  SELECT*FROM freeboard WHERE number={$_GET['id']}
";

//쿼리문 실행
$result = mysqli_query($conn, $sql);
//선택된 row의 값들을 $row에 배열로 저장
$row = mysqli_fetch_array($result);

if (empty($row[0])) {
    echo "<script>
    alert('존재하지 않는 페이지 입니다.');
    location.href='freeboard.php';
   </script>";
}

if (empty($_SESSION['id'])) {
    echo "<script>
    alert('로그인 후 이용해주세요.');
    location.href='login.php';
   </script>";
}
$nickname = $row['nickname'];
$date_create = date_create($row['date']);
$date = date_format($date_create, "y년 n월 j일");
$title = $row['title'];
$article = $row['article'];
$view_count = $row['view_count'];
//쿠키가 존재하지 않을 때만 조회수가 올라가고 조회수 쿠키를 만드는 동작을 수행한다.
if (empty($_COOKIE['freeboard_' . $row['number'] . '_' . $_SESSION['id']])) {
    //조회수를 1씩 증가시키기 위한 sql문이다.
    $sql_update = "
  UPDATE freeboard
  SET
   view_count=view_count+1

   WHERE number={$_GET['id']}
   ";
    $view_count_result = mysqli_query($conn, $sql_update);
    //조회수를 증가시켰으면 쿠키를 만들어서 해당 게시물에 접근해도 24시간동안은 조회수가 올라가지 않도록 구현
    setcookie('freeboard_' . $row['number'] . '_' . $_SESSION['id'], 'viewed', time() + (60 * 60 * 24), '/');
    //테스트 용으로 10초 후에 만료되는 쿠키 생성
    // setcookie('freeboard_'.$row['number'].'_'.$_SESSION['id'],'viewed',time()+(10),'/');
}


//이미지를 출력하기 위한 함수
function make_image()
{
    $conn = mysqli_connect('127.0.0.1', 'root', 'rla933466r!', 'billiards');
    $sql = "
     SELECT*FROM freeboard WHERE number={$_GET['id']}
   ";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $image = $row['image'];
    if (!empty($image)) {
        echo "<img src='freeboard_content/{$image}' width='300px' height='200px'>";
    }
}

//댓글의 리스트를 만들기 위한 함수
function make_comment()
{
    $conn = mysqli_connect('127.0.0.1', 'root', 'rla933466r!', 'billiards');
    $sql = "
     SELECT*FROM freeboard WHERE number={$_GET['id']}
   ";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $freeboard_num = $row['number'];

    $sql = "
     SELECT*FROM freeboard_comment WHERE freeboard_number={$freeboard_num}
   ";
    $result = mysqli_query($conn, $sql);
    // $id_array=array();
    while ($row = mysqli_fetch_array($result)) {
        // array_push($id_array, $row['id']);
        // $id_array_index=array_search($row['id'],$id_array);
        $date_create = date_create($row['date']);
        $date = date_format($date_create, "y년 n월 j일");
        if ($row['nickname'] == $_SESSION['nickname']) {
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
             <button class='edit_button' type='button' onclick=\"window.open('http://192.168.56.101/edit_freeboard_comment.php?id={$row['id']}','댓글 수정','width=550, height=400, left=500, top=200')\">수정</button>
           </td>
           <td>
             <button class='delete_button' type='button' onclick=\"location.href='delete_freeboard_comment.php?id={$row['id']}&page={$_GET['page']}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}&mypost={$_GET['mypost']}&mycomment={$_GET['mycomment']}'\">삭제</button>
           </td>
         </tr>
       ";
        } else {
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
          <td></td>
          <td></td>
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
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="main_style.css">
    <link rel="stylesheet" href="freeboard_detail_style.css">
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
<table class=article_box>
    <tr id=article_info>
        <th id='title'>제목</th>
        <td colspan="2" id="freeboard_detail_title">
            <?php echo $title; ?>
        </td>
        <th id='view_count'>
            조회수
        </th>
        <td>
            <?php echo $view_count; ?>
        </td>
    </tr>
    <tr>
        <th id='writer'>
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

<br>

<div class="post_control_menu">
    <?php
    //게시물이 내가 작성한 게시물일 때
    if ($row['nickname'] == $_SESSION['nickname']) {
        //자유 게시판에서 접근했을 경우
        if (empty($_GET['mypost']) && empty($_GET['mycomment'])) {
            echo "
              <a href=\"edit_article.php?id={$_GET['id']}&page={$_GET['page']}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">게시물 수정</a>
              <a id=\"delete_button\" href=\"delete_article.php?id={$_GET['id']}&page={$_GET['page']}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">게시물 삭제</a>
              <a href=\"freeboard.php?page={$_GET['page']}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">목록으로</a>
              ";
        } //내가 쓴 게시물 게시판에서 접근했을 경우
        else if (!empty($_GET['mypost'])) {
            echo "
              <a href=\"edit_article.php?id={$_GET['id']}&page={$_GET['page']}&mypost={$_GET['mypost']}\">게시물 수정</a>
              <a id=\"delete_button\" href=\"delete_article.php?id={$_GET['id']}&page={$_GET['page']}&mypost={$_GET['mypost']}\">게시물 삭제</a>
              <a href=\"mypost.php?page={$_GET['page']}\">목록으로</a>
              ";
        } //내가 댓글 단 게시물 게시판에서 접근했을 경우
        else {
            echo "
              <a href=\"edit_article.php?id={$_GET['id']}&page={$_GET['page']}&mycomment={$_GET['mycomment']}\">게시물 수정</a>
              <a id=\"delete_button\" href=\"delete_article.php?id={$_GET['id']}&page={$_GET['page']}&mycomment={$_GET['mycomment']}\">게시물 삭제</a>
              <a href=\"mycomment.php?page={$_GET['page']}\">목록으로</a>
              ";
        }
    } //게시물이 다른 사용자가 작성한 게시물일 때
    else {
        //자유게시판에서 접근한 경우
        if (empty($_GET['mycomment'])) {
            echo "
                <a href=\"freeboard.php?page={$_GET['page']}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">목록으로</a>
              ";
        } //내가 댓글 단 게시물 게시판에서 접근한 경우
        else {
            echo "
                <a href=\"mycomment.php?page={$_GET['page']}\">목록으로</a>
              ";
        }
    }

    ?>

</div>

<div class="comment_box">
    <h2>댓글</h2>
    <br>
    여러분의 생각을 적어주세요!
    <br>
    <form action="add_freeboard_comment.php" method="post">
        <input type="hidden" name="page" value=<?php echo $_GET['page']; ?>>
        <input type="hidden" name="article_id" value=<?php echo $_GET['id']; ?>>
        <input type="hidden" name="search_value" value="<?php echo $_GET['search_value']; ?>">
        <input type="hidden" name="search_category" value="<?php echo $_GET['search_category']; ?>">
        <input type="hidden" name="mypost" value="<?php echo $_GET['mypost']; ?>">
        <input type="hidden" name="mycomment" value="<?php echo $_GET['mycomment']; ?>">
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
                <th id="list_title">댓글</th>
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
    delete_button.addEventListener('click', function (event) {
        if (confirm('정말로 삭제하시겠습니까?')) {
            alert('게시물이 삭제되었습니다.');
        } else {
            event.preventDefault();
        }
    });


</script>

</body>
</html>
