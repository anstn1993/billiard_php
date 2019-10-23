<?php
error_reporting(0);
include("connect_db.php");//데이터베이스와 연결
//검색을 하지 않은 경우의 전체 데이터 수, 검색을 했을 때 작성자 기준, 내용 기준, 제목 기준으로 검색했을 때의 데이터 수를 조건문으로 나누어서 구해준다.
//검색창의 값이 비어있는 경우(즉 검색을 하지 않은 경우)
if (empty($_GET['search_value'])) {
    $sql = "
        SELECT*FROM event
        ORDER BY number DESC
      ";
    $result = mysqli_query($conn, $sql);
    //전체 테이블 사이즈
    $total_data_num = mysqli_num_rows($result);
    //get방식으로 전달받은 현재 page 수/삼항연산자를 이용해서 get값이 없으면 defalut로 1페이지가 출력되게 설정
} //검색을 한 경우
else {
    //제목으로 검색한 경우
    if ($_GET['search_category'] == 'title') {
        $sql = "
          SELECT*FROM event
          WHERE title like '%{$_GET['search_value']}%'
          ORDER BY number DESC
        ";
        $result = mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($result);
        //freeboard테이블의 전체 데이터 수
        $total_data_num = mysqli_num_rows($result);
    } //작성자로 검색한 경우
    else if ($_GET['search_category'] == 'writer') {
        $sql = "
          SELECT*FROM event
          WHERE nickname like '%{$_GET['search_value']}%'
          ORDER BY number DESC
        ";
        $result = mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($result);
        //freeboard테이블의 전체 데이터 수
        $total_data_num = mysqli_num_rows($result);
    } //내용으로 검색한 경우
    else {
        $sql = "
          SELECT*FROM event
          WHERE article like '%{$_GET['search_value']}%'
          ORDER BY number DESC
        ";
        $result = mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($result);
        //freeboard테이블의 전체 데이터 수
        $total_data_num = mysqli_num_rows($result);
    }
}


$page = ($_GET['page']) ? $_GET['page'] : 1;
//한 페이지당 뿌려줄 게시판 리스트의 수
$list_num = 10;
//한 블록당 사이즈
$block_num = 3;

//전체 페이지 사이즈
$total_page = ceil($total_data_num / $list_num);

//존재하지 않는 페이지 예외처리
if (!empty($_GET['page']) && empty($_GET['search_value'])) {
    if ($_GET['page'] <= 0 || $_GET['page'] > $total_page) {
        echo "<script>
          alert('존재하지 않는 페이지 입니다.');
          location.href='event.php';
         </script>";
    }
}

//총 블럭의 수
$total_block = ceil($total_page / $block_num);
//현재 위치한 블럭 번호
$current_block = ceil($page / $block_num);

//각 블럭당 첫 페이지
$start_page = ($current_block * $block_num) - ($block_num - 1);
//첫 페이지가 1보다 작거나 같게 나오면
if ($start_page <= 1) {
    //무조건 첫 페이지는 1이다.
    $start_page = 1;
}

//각 블럭당 마지막 페이지
$end_page = $current_block * $block_num;
//마지막 페이지의 수가 전체 페이지보다 크거나 같게 나오면
if ($end_page >= $total_page) {
    //마지막 페이지는 전체 페이지가 된다.
    $end_page = $total_page;
}

//mysql에서 limit속성을 쓸 때 페이지의 시작 index를 지정해주기 위해서 선언하는 변수
//현재 페이지*한 페이지에 보여질 수
$start_index = ($page - 1) * $list_num;
//리미트 속성을 검색을 하지 않았을 때와 검색을 했을 때로 나누어서 설정해준다.
//검색을 하지 않은 경우
if (empty($_GET['search_value'])) {
    //누른 페이지에 따라 데이터의 시작부터 내가 설정한 페이지당 리스트 수만큼 출력해주는 쿼리문이 실행
    $sql = "
          SELECT*FROM event
          ORDER BY number DESC LIMIT {$start_index}, {$list_num}
        ";
    $result = mysqli_query($conn, $sql);
} //검색을 한 경우
else {
    //제목으로 검색한 경우
    if ($_GET['search_category'] == 'title') {
        $sql = "
            SELECT*FROM event
            WHERE title like '%{$_GET['search_value']}%'
            ORDER BY number DESC LIMIT {$start_index}, {$list_num}
          ";
        $result = mysqli_query($conn, $sql);
    } //작성자로 검색한 경우
    else if ($_GET['search_category'] == 'writer') {
        $sql = "
            SELECT*FROM event
            WHERE nickname like '%{$_GET['search_value']}%'
            ORDER BY number DESC LIMIT {$start_index}, {$list_num}
          ";
        $result = mysqli_query($conn, $sql);
    } //내용으로 검색한 경우
    else {
        $sql = "
            SELECT*FROM event
            WHERE article like '%{$_GET['search_value']}%'
            ORDER BY number DESC LIMIT {$start_index}, {$list_num}
          ";
        $result = mysqli_query($conn, $sql);
    }

}


?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>당구장 이벤트</title>
    <link rel="stylesheet" href="main_style.css">
    <link rel="stylesheet" href="event_style.css">
</head>
<body>
<nav class="top">

    <?php
    session_start();
    error_reporting(0);
    if (empty($_SESSION['id'])) {
        echo "<div class='top_child'><a class='top_menu' href='login.php'>로그인</a></div>
                  <div class='top_child'><a class='top_menu' href='join.php'>회원가입</a></div>";
    } else {
        echo "<div class='top_child'><a class='top_menu' href='logout.php'>로그아웃</a></div>
                  <div class='top_child'><a class='top_menu' href='mypage.php'>마이페이지</a></div>
                  <div id='nickname' class='top_child'>반갑습니다, " . $_SESSION['nickname'] . "님!</div>";
    }

    ?>
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
<h2 class="event_title">당구장 이벤트</h2>

<br>
<div class="post">
    <?php
    session_start();
    error_reporting(0);
    if (empty($_SESSION['id']) || $_SESSION['who'] == "normal") {
        echo "";
    } else {
        echo "<a href=\"upload_event.php\">이벤트 등록</a>";
    }

    ?>

</div>
<br>
<br>

<table>
    <tr>
        <th>번호</th>
        <th>작성자</th>
        <th class="list_title">제목</th>
        <th>조회수</th>
        <th>댓글수</th>
        <th>날짜</th>
    </tr>
    <?php
    for ($i = 0; $i < $total_data_num; $i++) {

        $row = mysqli_fetch_array($result);
        if (!empty($row[0])) {
            $date_create = date_create($row['date']);
            $date = date_format($date_create, "y년 n월 j일");
            echo "
              <tr>
                  <td>
                    <a href='event_detail.php?id={$row['number']}&page={$_GET['page']}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}'>{$row['number']}</a>
                  </td>
                  <td>
                    <a href='event_detail.php?id={$row['number']}&page={$_GET['page']}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}'>{$row['nickname']}</a>
                  </td>
                  <td>
                    <a href='event_detail.php?id={$row['number']}&page={$_GET['page']}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}'>{$row['title']}</a>
                  </td>
                  <td>
                    <a href='event_detail.php?id={$row['number']}&page={$_GET['page']}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}'>{$row['view_count']}</a>
                  </td>
                  <td>
                    <a href='event_detail.php?id={$row['number']}&page={$_GET['page']}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}'>{$row['comment_count']}</a>
                  </td>
                  <td>
                    <a href='event_detail.php?id={$row['number']}&page={$_GET['page']}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}'>{$date}</a>
                  </td>
                </tr>
              ";
        }

    }
    ?>

</table>

<div id="page">
    <?php
    if ($total_data_num != 0) {
        //이전 블록으로 가기, 처음으로 가기 버튼

        $start_page_ = $start_page - 1;
        echo ($page != 1) ? "<a href=\"event.php?page=1&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">[처음으로]</a>" : "[처음으로]";

        echo ($current_block != 1) ? "<a href=\"event.php?page={$start_page_}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">[이전]</a>" : "[이전]";


        //페이징 넘버를 출력해주는 반복문
        for ($i = $start_page; $i <= $end_page; $i++) {
            if ($i == $page) {
                echo "
              <a href=\"event.php?page={$i}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\" style=\"color:red; border:1px solid gray;\">{$i}</a>
            ";
            } else {
                echo "
              <a href=\"event.php?page={$i}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">{$i}</a>
            ";
            }

        }

        //다음 블록으로 가기, 마지막으로 가기 버튼
        $end_page_ = $end_page + 1;
        //현재 블럭이 마지막 블럭이 아닌 경우에만 다음 블럭으로 가는 버튼이 나오게 한다.
        echo ($current_block != $total_block) ? "<a href=\"event.php?page={$end_page_}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">[다음]</a>" : "[다음]";
        //현재 페이지가 마지막 페이지가 아닌 경우에만 마지막 페이지로 가는 버튼이 나오게 한다.
        echo ($page != $total_page) ? "<a href=\"event.php?page={$total_page}&search_category={$_GET['search_category']}&search_value={$_GET['search_value']}\">[마지막으로]</a>" : "[마지막으로]";
    }

    ?>
</div>
<br>
<div id="search">
    <form action="event.php" method="get">
        <select name="search_category">
            <?php
            if ($_GET['search_category'] == 'title') {
                echo '
              <option value="title" selected>제목</option>
              <option value="writer">작성자</option>
              <option value="content">내용</option>
              ';
            } else if ($_GET['search_category'] == 'writer') {
                echo '
              <option value="title" >제목</option>
              <option value="writer" selected>작성자</option>
              <option value="content">내용</option>
              ';
            } else {
                echo '
              <option value="title" >제목</option>
              <option value="writer" >작성자</option>
              <option value="content" selected>내용</option>
              ';
            }
            ?>

        </select>
        <input type="hidden" name="page" value=<?php echo 1; ?>>
        <input type="text" name="search_value" value='<?php
        if (!empty($_GET['search_value'])) {
            echo $_GET['search_value'];
        }
        ?>'>
        <input type="submit" value="검색">
    </form>
</div>


</body>
</html>
