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


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>내가 쓴 게시물</title>
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
        <h2>내가 쓴 게시물</h2>
        <br>
        <div id="post_category">
            <a href='mypost.php' style="background-color:#F2B08F">자유게시판</a>
            <!-- 당구장 운영을 하는 사용자가 로그인 했을 때만 노출되게끔 설정 -->
            <?php
            if ($_SESSION['who'] == 'club_owner') {
                echo "<a href='my_event_post.php'>당구장 이벤트</a>";
            } else if ($_SESSION['who'] == 'admin') {
                echo "
                  <a href='my_event_post.php'>당구장 이벤트</a>
                  <a href='my_news_post.php'>당구 소식</a>
                  ";
            }
            ?>
        </div>
        <form action="delete_myarticle.php" method="post" onsubmit="return delete_post()">
            <div id="delete_button_box">
                전체선택<input type="checkbox" id="check_all">
                <input type="submit" value="게시물 삭제">
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
                    <th></th>
                </tr>
                <?php
                include("connect_db.php");//데이터베이스와 연결
                $sql = "
                    SELECT*FROM freeboard
                    WHERE account='{$_SESSION['account']}'
                    ORDER BY number DESC
                  ";
                $result = mysqli_query($conn, $sql);

                $row = mysqli_fetch_array($result);


                //news테이블의 전체 데이터 수
                $total_data_num = mysqli_num_rows($result);

                //현재 페이지
                $page = ($_GET['page']) ? $_GET['page'] : 1;

                //한 페이지당 뿌려줄 리스트의 수
                $list_num = 10;

                //한 블럭의 사이즈
                $block_num = 3;

                //전체 페이지 수
                $total_page = ceil($total_data_num / $list_num);

                //존재하지 않는 페이지 예외처리
                if (!empty($_GET['page'])) {
                    if ($_GET['page'] <= 0 || $_GET['page'] > $total_page) {
                        echo "<script>
                        alert('존재하지 않는 페이지 입니다.');
                        location.href='mypost.php';
                       </script>";
                    }
                }
                //전체 블럭 수
                $total_block = ceil($total_page / $block_num);

                //현재 페이지의 블럭
                $current_block = ceil($page / $block_num);

                //블럭의 첫 페이지
                $start_page = ($current_block * $block_num) - ($block_num - 1);
                //첫 페이지가 1보다 작거나 같게 나오면
                if ($start_page <= 1) {
                    //시작페이지는 1이 된다.
                    $start_page = 1;
                }

                //블럭의 마지막 페이지
                $end_page = $current_block * $block_num;
                //만약 마지막 페이지가 전체 페이지보다 크거나 같게 나오면
                if ($end_page >= $total_page) {
                    //마지막 페이지는 전체 페이지값이 된다.
                    $end_page = $total_page;
                }

                //mysql에서 limit속성을 쓸 때 페이지의 시작 index를 지정해주기 위해서 선언하는 변수
                //현재 페이지*한 페이지에 보여질 수
                $start_index = ($page - 1) * $list_num;

                //누른 페이지에 따라 데이터의 시작부터 내가 설정한 페이지당 리스트 수만큼 출력해주는 쿼리문이 실행
                $sql = "
                      SELECT*FROM freeboard
                      WHERE account='{$_SESSION['account']}'
                      ORDER BY number DESC LIMIT {$start_index}, {$list_num}
                    ";
                $result = mysqli_query($conn, $sql);


                for ($i = 0; $i < $total_data_num; $i++) {

                    $row = mysqli_fetch_array($result);
                    if (!empty($row[0])) {
                        $date_create = date_create($row['date']);
                        $date = date_format($date_create, "y년 n월 j일");
                        echo "
                         <tr>
                             <td>
                               <a href='freeboard_detail.php?id={$row['number']}&page={$page}&mypost=yes'>{$row['number']}</a>
                             </td>
                             <td>
                               <a href='freeboard_detail.php?id={$row['number']}&page={$page}&mypost=yes'>{$row['nickname']}</a>
                             </td>
                             <td class='list_title'>
                               <a href='freeboard_detail.php?id={$row['number']}&page={$page}&mypost=yes'>{$row['title']}</a>
                             </td>
                             <td>
                               <a href='freeboard_detail.php?id={$row['number']}&page={$page}&mypost=yes'>{$row['view_count']}</a>
                             </td>
                             <td>
                               <a href='freeboard_detail.php?id={$row['number']}&page={$page}&mypost=yes'>{$row['comment_count']}</a>
                             </td>
                             <td>
                               <a href='freeboard_detail.php?id={$row['number']}&page={$page}&mypost=yes'>{$date}</a>
                             </td>
                             <td>
                              <input type=\"checkbox\" name=\"mypost[]\" value=\"{$row['number']}\" class=\"mypost_check\">
                             </td>
                           </tr>
                         ";
                    }
                }

                ?>

            </table>
        </form>
        <div id="page">
            <?php
            if ($total_data_num != 0) {
                //이전 블록으로 가기, 처음으로 가기 버튼

                $start_page_ = $start_page - 1;
                echo ($page != 1) ? "<a href=\"mypost.php?page=1\">[처음으로]</a>" : "[처음으로]";

                echo ($current_block != 1) ? "<a href=\"mypost.php?page={$start_page_}\">[이전]</a>" : "[이전]";


                //페이징 넘버를 출력해주는 반복문
                for ($i = $start_page; $i <= $end_page; $i++) {
                    if ($i == $page) {
                        echo "
                  <a href=\"mypost.php?page={$i}\" style=\"color:red; border:1px solid gray;\">{$i}</a>
                ";
                    } else {
                        echo "
                  <a href=\"mypost.php?page={$i}\">{$i}</a>
                ";
                    }

                }

                //다음 블록으로 가기, 마지막으로 가기 버튼
                $end_page_ = $end_page + 1;
                //현재 블럭이 마지막 블럭이 아닌 경우에만 다음 블럭으로 가는 버튼이 나오게 한다.
                echo ($current_block != $total_block) ? "<a href=\"mypost.php?page={$end_page_}\">[다음]</a>" : "[다음]";
                //현재 페이지가 마지막 페이지가 아닌 경우에만 마지막 페이지로 가는 버튼이 나오게 한다.
                echo ($page != $total_page) ? "<a href=\"mypost.php?page={$total_page}\">[마지막으로]</a>" : "[마지막으로]";
            }


            ?>
        </div>

    </div>

</div>


</body>
<script src="//code.jquery.com/jquery-3.4.0.js"></script>
<script type="text/javascript">
    //페이지의 모든 객체가 로딩되면
    $(document).ready(function () {
        //전체선택 체크박스를 클릭할 때
        $('#check_all').click(function () {
            //게시물의 체크박스가 체크상태가 된다.
            $('.mypost_check').prop('checked', this.checked);
        });
    });


    function delete_post() {
        var check_state = false;
        var arr_basket = document.getElementsByName("mypost[]");

        for (var i = 0; i < arr_basket.length; i++) {
            if (arr_basket[i].checked == true) {
                check_state = true;
                break;
            }
        }
        if (check_state == true) {
            if (confirm('정말 삭제하시겠습니까?')) {
                return true;
            } else {
                return false;
            }
        } else {
            alert('삭제할 게시물을 선택해 주세요.');
            return false;
        }
    }
</script>
</html>
