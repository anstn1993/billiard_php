<?php
error_reporting(0);
session_start();
if (empty($_SESSION['id'])) {
    echo "<script>
      alert('로그인 후 이용해주세요.');
      location.href='login.php';
     </script>";
}
function make_mypage_category()
{
    if ($_SESSION['who'] == "normal") {
        echo "
      <div class=\"mypage_category_child\">
        <a href=\"mypage.php\">내 정보</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"edit_user_info.php\">내 정보 변경</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"mypost.php\">내가 쓴 게시물</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"mycomment.php\">내가 단 댓글</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"shopping_basket.php\">장바구니 목록</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"order_user.php\">주문조회</a>
      </div>

      ";
    } else if ($_SESSION['who'] == "club_owner") {
        echo "
      <div class=\"mypage_category_child\">
        <a href=\"mypage.php\">내 정보</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"edit_user_info.php\">내 정보 변경</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"mypost.php\">내가 쓴 게시물</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"mycomment.php?\">내가 단 댓글</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"shopping_basket.php\">장바구니 목록</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"order_user.php\">주문조회</a>
      </div>
      ";
    } else {
        echo "
      <div class=\"mypage_category_child\">
        <a href=\"mypage.php\">내 정보</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"edit_user_info.php\">내 정보 변경</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"mypost.php\">내가 쓴 게시물</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"mycomment.php?\">내가 단 댓글</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"shopping_basket.php\">장바구니 목록</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"member_list.php\">회원 목록</a>
      </div>
      <div class=\"mypage_category_child\">
        <a href=\"order_admin.php\">주문관리</a>
      </div>
      ";
    }
}

include("connect_db.php");//데이터베이스와 연결
$total_data_num = 0;
$sql = "
      SELECT*FROM event
      ORDER BY number DESC
    ";
$result = mysqli_query($conn, $sql);
// $row=mysqli_fetch_array($result);
$row = mysqli_fetch_array($result);
$row_num = $row['number'];

for ($i = $row_num; $i > 0; $i--) {
    $sql = "
        SELECT*FROM event
        WHERE number={$i}
      ";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $sql = "
        SELECT*FROM event_comment
        WHERE event_number={$i}
      ";
    $result = mysqli_query($conn, $sql);
    //해당 게시물 번호에 들어있는 댓글에 내 닉네임이 있는지 판별하는 변수. 0이면 없는 거고 1이상이면 존재하는 것!
    $exist_state = 0;
    while ($comment_row = mysqli_fetch_array($result)) {
        if ($comment_row['nickname'] == $_SESSION['nickname']) {
            $exist_state += 1;
            break;
        }
    }
    if ($exist_state != 0) {
        $total_data_num += 1;
    }
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>내가 단 댓글</title>
    <link rel="stylesheet" href="main_style.css">
    <link rel="stylesheet" href="mypage_style.css">
</head>
<body>
<nav class="top">
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

<div class="mypage">
    <div class="mypage_child" id="mypage_category">
        <?php make_mypage_category(); ?>
    </div>
    <div class="mypage_child" id="mypage_article">
        <h2>내가 댓글 단 게시물</h2>
        <br>
        <div id="post_category">
            <a href='mycomment.php'>자유게시판</a>
            <a href='mycomment_event.php' style="background-color:#F2B08F">당구장 이벤트</a>
            <a href='mycomment_news.php'>당구소식</a>

        </div>
        <br>
        <br>
        <table id="mypost_freeobard_table">
            <tr>
                <th>번호</th>
                <th>작성자</th>
                <th class="list_title">제목</th>
                <th>조회수</th>
                <th>댓글수</th>
                <th>날짜</th>
            </tr>
            <?php
            //'내가 단 댓글 게시판' 페이징 로직
            //1. 두개의 테이블을 연계해서 게시물을 리스팅하기 때문에 전체 게시물 수를 조건이 부합할 때마다 하나씩 추가해주는 방식으로 결정해줘야 한다.
            //2. 위와 같은 이유로 쿼리문의 limit조건을 쓰기가 어렵다. 그래서 각 페이지의 최상단 게시물과 최하단 게시물의 인덱스와 번호를 각자 따로 구해준다.
            //3. 위에서 구한 두 값을 범위로 하는 반복문을 돌려서 각 페이지마다 10개의 리스트가 보이게끔 한다.

            //get방식으로 전달받은 현재 page 수/삼항연산자를 이용해서 get값이 없으면 defalut로 1페이지가 출력되게 설정
            $page = ($_GET['page']) ? $_GET['page'] : 1;
            //한 페이지당 보여줄 리스트의 수
            $list_num = 10;
            //한 페이지 블록에 보여줄 페이지 수
            $block_num = 3;

            //전체 페이지 수
            //ceil함수는 파라미터의 값을 반올림 처리 해주는 함수다.
            $total_page = ceil($total_data_num / $list_num);

            //존재하지 않는 페이지 예외처리
            if (!empty($_GET['page'])) {
                if ($_GET['page'] <= 0 || $_GET['page'] > $total_page) {
                    echo "<script>
                  alert('존재하지 않는 페이지 입니다.');
                  location.href='mycomment.php';
                 </script>";
                }
            }


            //총 블록의 수
            $total_block = ceil($total_page / $block_num);

            //현재 위치한 블락의 번호
            $current_block = ceil($page / $block_num);


            //각 블록 당 시작 페이지
            $start_page = ($current_block * $block_num) - ($block_num - 1);
            //시작 페이지가 1보다 작거나 같은 경우에는
            if ($start_page <= 1) {
                //시작 페이지를 1로 설정--페이지의 최소범위보다 시작페이지가 작아지는 것을 방지
                $start_page = 1;
            }

            //각 블록 당 마지막 페이지
            $end_page = ($current_block * $block_num);
            //만약 전체 페이지 수보다 마지막 페이지의 수가 더 크면
            if ($total_page <= $end_page) {
                //마지막 페이지 수는 전체 페이지 수로 바꾼다. --마지막 페이지가 페이지의 최대 범위를 넘어서는 것을 방지
                $end_page = $total_page;
            }


            $sql = "
                SELECT*FROM event
                ORDER BY number DESC
              ";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            //freeboard테이블을 내림차순으로 정렬했을 때 가장 큰 게시물 번호
            $row_num = $row['number'];
            //한 페이지에서 가장 하단에 위치하게 되는 게시물의 인덱스
            $min_index = 0;
            //한 페이지에서 가장 상단에 위치하게 되는 게시물의 인덱스
            $max_index = 0;
            //가장 하단에 위치하게 되는 게시물의 번호
            $min_number;
            //가장 상단에 위치하게 되는 게시물의 번호
            $max_number;


            //이 반복문은 페이지의 가장 하단에 위치하게 되는 게시물의 인덱스와 게시물 번호를 구하기 위한 반복문
            for ($i = $row_num; $i > 0; $i--) {
                $sql = "
                SELECT*FROM event
                WHERE number={$i}
              ";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                $sql = "
                SELECT*FROM event_comment
                WHERE event_number={$i}
              ";
                $result = mysqli_query($conn, $sql);
                //해당 게시물 번호에 들어있는 댓글에 내 닉네임이 있는지 판별하는 변수. 0이면 없는 거고 1이상이면 존재하는 것!
                $exist_state = 0;
                while ($comment_row = mysqli_fetch_array($result)) {
                    if ($comment_row['nickname'] == $_SESSION['nickname']) {
                        $exist_state += 1;
                        break;
                    }
                }
                //내가 댓글을 단 게시물일 경우
                if ($exist_state != 0) {
                    //최하단의 게시물 인덱스 값을 1씩 올린다.
                    $min_index += 1;
                }
                //최하단 게시물의 인덱스가 각 페이지의 마지막 인덱스가 되는 순간
                if ($min_index == $page * 10) {

                    //최하단 게시물 번호를 저장한다.
                    $min_number = $row['number'];
                    //그리고 반복문을 빠져나간다.
                    break;
                }
                //만약 페이지의 리스트가 10개가 되지 않아서 최하단의 게시물 인덱스가 10이 되지 않고
                //테이블 row의 값이 null이 아닌 경우에(이 조건이 없으면 반복문의 마지막 차례의 row값이 들어가서 없는 값을 참조하게 된다.)
                else if (!empty($row[0]) && $min_index < $page * 10) {
                    //최하단 리스트의 게시물 번호를 저장한다.
                    $min_number = $row['number'];
                }
            }


            //이 반복문은 각 페이지의 최상단 리스트의 인덱스와 게시물 번호를 구하기 위한 반복문이다.
            for ($i = $row_num; $i > 0; $i--) {
                $sql = "
                SELECT*FROM event
                WHERE number={$i}
              ";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                $sql = "
                SELECT*FROM event_comment
                WHERE event_number={$i}
              ";
                $result = mysqli_query($conn, $sql);
                //해당 게시물 번호에 들어있는 댓글에 내 닉네임이 있는지 판별하는 변수. 0이면 없는 거고 1이상이면 존재하는 것!
                $exist_state = 0;
                while ($comment_row = mysqli_fetch_array($result)) {
                    if ($comment_row['nickname'] == $_SESSION['nickname']) {
                        $exist_state += 1;
                        break;
                    }
                }
                //해당 게시물에 내가 쓴 댓글이 있는 경우
                if ($exist_state != 0) {
                    //최상단 게시물의 인덱스를 1씩 올린다.
                    $max_index += 1;

                }
                //최상단 게시물 인덱스가 각 페이지의 첫번째 인덱스와 같은 경우
                if ($max_index == $page * 10 - 9) {
                    //그때의 게시물 번호를 저장한다.
                    $max_number = $row['number'];
                    //그리고 반복문을 빠져나간다.
                    break;
                }
            }


            //이 반복문은 실제로 각 페이지에 리스트가 나타나게 하는 반복문이다.
            //실제로 게시물 번호의 최대값과 최소값의 차는 10이 넘을 수 있지만 이미 위에서 내가 댓글을 단 게시물로 필터링했을 때의 게시물 번호를 저장한 것이기 때문에 정확히 10개씩 리스팅이 가능하다.
            for ($i = $max_number; $i >= $min_number; $i--) {
                $sql = "
                SELECT*FROM event
                WHERE number={$i}
              ";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                $sql = "
                SELECT*FROM event_comment
                WHERE event_number={$i}
              ";
                $result = mysqli_query($conn, $sql);
                //해당 게시물 번호에 들어있는 댓글에 내 닉네임이 있는지 판별하는 변수. 0이면 없는 거고 1이상이면 존재하는 것!
                $exist_state = 0;
                while ($comment_row = mysqli_fetch_array($result)) {
                    if ($comment_row['nickname'] == $_SESSION['nickname']) {
                        $exist_state += 1;
                        break;
                    }
                }
                if ($exist_state != 0) {
                    $date_create = date_create($row['date']);
                    $date = date_format($date_create, "y년 n월 j일");
                    echo "
                    <tr>
                        <td>
                          <a href='event_detail.php?id={$row['number']}'>{$row['number']}</a>
                        </td>
                        <td>
                          <a href='event_detail.php?id={$row['number']}'>{$row['nickname']}</a>
                        </td>
                        <td>
                          <a href='event_detail.php?id={$row['number']}'>{$row['title']}</a>
                        </td>
                        <td>
                          <a href='event_detail.php?id={$row['number']}'>{$row['view_count']}</a>
                        </td>
                        <td>
                          <a href='event_detail.php?id={$row['number']}'>{$row['comment_count']}</a>
                        </td>
                        <td>
                          <a href='event_detail.php?id={$row['number']}'>{$date}</a>
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
                echo ($page != 1) ? "<a href=\"mycomment_event.php?page=1\">[처음으로]</a>" : "[처음으로]";

                echo ($current_block != 1) ? "<a href=\"mycomment_event.php?page={$start_page_}\">[이전]</a>" : "[이전]";


                //페이징 넘버를 출력해주는 반복문
                for ($i = $start_page; $i <= $end_page; $i++) {
                    if ($i == $page) {
                        echo "
                  <a href=\"mycomment_event.php?page={$i}\" style=\"color:red; border:1px solid gray;\">{$i}</a>
                ";
                    } else {
                        echo "
                  <a href=\"mycomment_event.php?page={$i}\">{$i}</a>
                ";
                    }

                }

                //다음 블록으로 가기, 마지막으로 가기 버튼
                $end_page_ = $end_page + 1;
                //현재 블럭이 마지막 블럭이 아닌 경우에만 다음 블럭으로 가는 버튼이 나오게 한다.
                echo ($current_block != $total_block) ? "<a href=\"mycomment_event.php?page={$end_page_}\">[다음]</a>" : "[다음]";
                //현재 페이지가 마지막 페이지가 아닌 경우에만 마지막 페이지로 가는 버튼이 나오게 한다.
                echo ($page != $total_page) ? "<a href=\"mycomment_event.php?page={$total_page}\">[마지막으로]</a>" : "[마지막으로]";
            }
            ?>
        </div>
    </div>
</div>


</body>
</html>
