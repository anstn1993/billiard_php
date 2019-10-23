<?php
session_start();
if (empty($_SESSION['id'])) {
    echo "<script>
    alert('로그인 후 이용해주세요.');
    location.href='login.php';
   </script>";
} else if ($_SESSION['who'] == "normal") {
    echo "<script>
    alert('접근 권한이 없습니다.');
    location.href='main.php';
   </script>";
} else {

}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>이벤트 등록</title>
    <link rel="stylesheet" href="main_style.css">
    <link rel="stylesheet" href="upload_article_style.css">
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

<h1 class="upload_article_style">이벤트 등록</h1>
<br>
<form enctype='multipart/form-data' action="add_uploaded_event.php" method="post">
    <table>
        <tr>
            <td>
                제목
            </td>
            <td>
                <input type="text" name="title" required="required" placeholder="이벤트의 제목을 입력하세요!" size="50">
            </td>
        </tr>
        <tr>
            <td>
                이벤트 내용
            </td>
            <td>
                <textarea name="article" required="required" wrap="soft" placeholder="이벤트에 대한 설명을 적어주세요." rows="20"
                          cols="80"></textarea>
            </td>
        </tr>

        <tr>
            <td>
                당구장 위치
            </td>
            <td>
                <input type="text" name="address" required="required" value="<?php echo $_SESSION['address']; ?>">
            </td>
        </tr>
        <tr>
            <td>
                이벤트 기간
            </td>
            <td>
                <input id="begin_date" type="date" name="begin" required="required">~<input id="end_date" type="date"
                                                                                            name="end"
                                                                                            required="required">
            </td>
        </tr>
        <tr>
            <td>
                사진
            </td>
            <td>
                <input id="image_input" type="file" name="image">
            </td>
        </tr>
        <tr>
            <td></td>
            <td id="delete_image_button">

            </td>
        </tr>
        <tr>
            <td></td>
            <td id="img_box">
                <img id="img">
            </td>
        </tr>
    </table>
    <br>
    <div class="upload_cancel">
        <input class="upload_cancel_child" type="submit" value="이벤트 등록">
        <button class="upload_cancel_child" type="button" name="cancel" onclick="location.href='event.php'">취소</button>
    </div>

</form>
</body>

<script src="//code.jquery.com/jquery-3.4.0.js"></script>
<script type="text/javascript">
    var sel_file;

    $(document).ready(function () {
        $('#image_input').on("change", fileSelect);
    });

    function fileSelect(e) {
        var files = e.target.files;
        var filesArr = Array.prototype.slice.call(files);

        filesArr.forEach(function (f) {
            if (!f.type.match("image.*")) {
                alert('이미지만 선택 가능 합니다.');
                return;
            }

            sel_file = f;

            var reader = new FileReader();
            reader.onload = function (e) {
                //img태그 객체를 가져와서 attr함수를 통해서 src, width, height속성을 지정.
                $('#img').attr("src", e.target.result).attr("width", '300px').attr("height", '200px');
            }
            reader.readAsDataURL(f);

        });
    }

    //input file객체에 변화가 감지될 때 make_delete_image_button함수를 실행한다.
    $('#image_input').change(function () {
        make_delete_image_button();
    });

    //이 함수는 '이미지 삭제 버튼'이 나타나도록 한다.
    function make_delete_image_button() {
        document.getElementById('delete_image_button').innerHTML = "<button type='button' name='button' onclick='delete_image()'>이미지 삭제</button>";
    }

    //이 함수는 '이미지 삭제 버튼'을 눌렀을 때 동작한다.
    function delete_image() {
        //이미지 태그 삭제
        $('#img').remove();
        //파일 태그 value 초기화
        $('#image_input').val("");
        //이미지 태그 다시 생성
        $('#img_box').append("<img id='img'>");
        //이미지 삭제 버튼 삭제
        document.getElementById('delete_image_button').innerHTML = "";
    }


</script>
</html>
