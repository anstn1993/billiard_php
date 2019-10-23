<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>회원가입</title>
    <link rel="stylesheet" href="main_style.css">
    <link rel="stylesheet" href="join_style.css">
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
<div class="join">
    <h1>회원가입</h1>
</div>
<br>
<form action="join_complete.php" method="post" onsubmit="return join()">
    <table>
        <tr>
            <td>아이디</td>
            <td><input id="id_input" type="text" name="account" size=30></td>
        </tr>
        <!-- 자바 스크립트로 아이디 유효성 검사 메세지를 출력하기 위해 만든 태그  -->
        <tr id="id_check">
            <td id="id_check_child" colspan="3"></td>
        </tr>

        <tr>
            <td>비밀번호</td>
            <td><input id="password_input" type="password" name="password" size=30></td>
        </tr>
        <tr id="password_check">
            <td id="password_check_child" colspan="3"></td>
        </tr>

        <tr>
            <td>비밀번호 확인</td>
            <td><input id="password_check_input" type="password" name="password_check" size=30></td>
        </tr>
        <!-- 자바 스크립트로 비밀번호 검사 메세지를 출력하기 위해 만든 태그  -->
        <tr id="password_match_check">
            <td id="password_match_check_child" colspan="3"></td>
        </tr>

        <tr>
            <td>닉네임</td>
            <td><input id="nickname_input" type="text" name="nickname" size=30></td>
        </tr>
        <!-- 자바 스크립트로 닉네임 검사 메세지를 출력하기 위해 만든 태그  -->
        <tr id="nickname_check">
            <td id="nickname_check_child" colspan="3"></td>
        </tr>

        <tr>
            <td>이름</td>
            <td><input id="name_input" type="text" name="name" size=30></td>
        </tr>
        <!-- 자바 스크립트로 이름 유효성 검사 메세지를 출력하기 위해 만든 태그  -->
        <tr id="name_check">
            <td id="name_check_child" colspan="3"></td>
        </tr>

        <!-- <tr>
          <td>주민등록번호</td>
          <td> <input id="identitynumber1_input" type="text" name="identitynumber1" maxlength="6" size="12">-<input id="identitynumber2_input" type="password" name="identitynumber2" maxlength="7" size="12"></td>
        </tr>
        <tr id="identitynumber_check">
          <td id="identitynumber_check_child" colspan="3"></td>
        </tr> -->

        <tr>
            <td>휴대폰번호</td>
            <td><input id="tel1_input" type="tel" name="tel1" maxlength="3" size="6">-<input id="tel2_input" type="tel"
                                                                                             name="tel2" maxlength="4"
                                                                                             size="6">-<input
                        id="tel3_input" type="tel" name="tel3" maxlength="4" size="6"></td>
        </tr>
        <tr id="tel_check">
            <td id="tel_check_child" colspan="3"></td>
        </tr>

        <tr>
            <td>가입자 구분</td>
            <td>
                <input class="account_category_input" type="radio" name="account_category" value="normal"
                       checked="checked">일반
                <input class="account_category_input" type="radio" name="account_category" value="club_owner">당구장 운영자
            </td>
        </tr>

        <tr>
            <td colspan="3">아이디 비밀번호 찾기 질문</td>

        </tr>
        <tr>
            <td>
                <select class="findaccount_question_category" name="findaccount_question">
                    <option value="hometown">나의 고향은?</option>
                    <option value="fathername">아버지의 성함은?</option>
                    <option value="mothername">어머니의 성함은?</option>
                    <option value="treasure">나의 보물 1호는?</option>
                </select>
            </td>
            <td><input id="findaccount_answer_input" type="text" name="findaccount_answer" size="30"></td>
        </tr>
        <tr>
            <td>
                주소
            </td>
            <td>
                <input type="text" id="sample5_address" placeholder="주소" size="30" name="address">
            </td>
            <td>
                <input type="button" onclick="sample5_execDaumPostcode()" value="주소 검색"><br>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <div id="map" style="width:300px;height:300px;margin-top:10px;display:none"></div>
            </td>
        </tr>
    </table>
    <br>
    <div class="join_cancel">
        <div class="join_cancel_button">
            <input type="submit" id="join_button" value="회원가입">
        </div>
        <div class="join_cancel_button">
            <button type="button" name="cancel" onclick="location.href='login.php'">취소</button>
        </div>
    </div>
</form>


<script type="text/javascript">

    //아이디 입력 칸에 값을 입력하고 포커스가 떠나는 순간을 케치해서 아이디의 유효성을 검사하는 메소드다.
    var check_id = document.getElementById('id_input');
    //blur라는 이벤트는 포커스가 떠나는 순간 발생하는 이벤트고 addEventListener를 통해 해당 이벤트가 발생하는 순간에 동작할 함수를 정의했다.

    check_id.addEventListener('blur', function (event) {
        //id변수는 아이디 입력 칸 입력한 데이터를 담는다.
        var id = document.getElementById('id_input').value;
        //id_form변수는 입력된 아이디의 양식이 이메일 양식에 맞는지를 확인하기 위한 변수다.
        var id_form = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
        //아이디가 공백이면 유효성 체크 메세지를 출력하지 않는다.


        if (id.trim() == "") {
            document.getElementById('id_check_child').innerHTML = "";
        }
        //아이디가 유효성 검사 결과 유효하지 않다면 이메일 양식으로 작성하라는 유효성 체크 메세지를 출력한다.
        else if (!id_form.test(id)) {
            document.getElementById('id_check_child').innerHTML = "이메일 양식으로 작성해주세요.";
            document.getElementById('id_check_child').style.color = "red";
        }

        //아이디 입력 칸이 공백이 아니고 양식도 지켜졌으면 ajax를 통해서 서버의 데이터베이스와 실시간으로 조회를 해서 아이디 중복검사를 실시한다.
        if (id.trim() != "" && id_form.test(id)) {
            //ajax을 통해 서버와 통신을 하기 위해서 처음에 선언해줘야 하는 객체
            var xhr = new XMLHttpRequest();
            //open메소드는 서버와의 통신을 여는 역할을 한다. 이때 첫번째 인자는 'GET','POST'처럼 데이터를 주고받는 방식을 정의하고, 두번째 인자는 통신을 원하는 파일이 들어간다.
            xhr.open('POST', './check_account_duplicate.php');
            //onreadystatechange함수는 요청에 대한 응답을 받는 이벤트 리스너다. 즉 요청에 대한 응답을 받을 시 함수에 정의된 동작을 실행한다는 것이다.
            xhr.onreadystatechange = function () {
                if (xhr.responseText == "사용 가능한 계정 입니다.") {
                    document.getElementById('id_check_child').innerHTML = xhr.responseText;
                    //responseText는 서버측에서 리턴한 값을 말한다.
                    document.getElementById('id_check_child').style.color = "green";
                } else {
                    document.getElementById('id_check_child').innerHTML = xhr.responseText;
                    //responseText는 서버측에서 리턴한 값을 말한다.
                    document.getElementById('id_check_child').style.color = "red";
                }
            }
            var data = '';
            //url에 ?뒤에 변수와 값을 지정해주는 것과 같다. 내가 통신할 서버 페이지 뒤에 ?account=id를 추가하는 것이라고 생각하면 됨.
            data += 'account=' + id;
            //setRequestHeader메소드는 보내는 데이터 형식을 정의하는 것이다. 만약 JSON으로 보내면 application/json이라고 쓰면 된다.
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            //send는 실제로 서버로 요청을 하는 것이다. 이때 인자에 서버로 보낼 값을 넣으면 된다. json형태로 보내는 경우 문자열 형태로 보내야 한다. JSON.stringify(json객체). 아니면 처음부터 문자열 형태로 만들어도 되고
            xhr.send(data);

        }
    });


    var password_input = document.getElementById('password_input');
    password_input.addEventListener('blur', function (event) {
        var password = document.getElementById('password_input').value;
        if (password.trim() == "") {
            document.getElementById('password_check_child').innerHTML = "";
        } else if (password.length < 8) {
            document.getElementById('password_check_child').innerHTML = "최소 8자 이상을 입력해주세요.";
            document.getElementById('password_check_child').style.color = "red";
        } else if (password.length > 16) {
            document.getElementById('password_check_child').innerHTML = "최대 16자까지만 입력 가능합니다.";
            document.getElementById('password_check_child').style.color = "red";
        } else {
            document.getElementById('password_check_child').innerHTML = "";
        }

    });

    //비밀번호와 비밀번호 확인 칸에 입력한 문자열이 일치하는지 확인하기 위한 함수다.
    var check_password = document.getElementById('password_check_input');
    //이벤트 방식은 위와 동일하다.
    check_password.addEventListener('blur', function (event) {
        //password변수는 비밀번호 입력 칸에 입력된 비밀번호를 담는 변수다.
        var password = document.getElementById('password_input').value;
        //password_check변수는 비밀번호 확인 입력 칸에 입력된 비밀번호를 담는 변수다.
        var password_check = document.getElementById('password_check_input').value;

        //비밀번호 확인 입력 칸이 비어있으면 메세지를 출력하지 않는다.
        if (password_check.trim() == "") {
            document.getElementById('password_match_check_child').innerHTML = "";
        }
        //비밀번호 입력 칸이 비어있으면 비밀번호를 입력하라는 메세지를 출력한다.
        else if (password.trim() == "") {
            document.getElementById('password_match_check_child').innerHTML = "비밀번호를 입력해주세요.";
            document.getElementById('password_match_check_child').style.color = "red";
        }
        //비밀번호와 비밀번호 확인 값이 다르면 비밀번호가 일치하지 않는다는 메세지를 출력한다.
        else if (password != password_check) {
            document.getElementById('password_match_check_child').innerHTML = "비밀번호가 일치하지 않습니다.";
            document.getElementById('password_match_check_child').style.color = "red";
        }
        //비밀번호와 비밀번호 확인 값이 일치하면 비밀번호가 일치한다는 메세지를 출력한다.
        else {
            document.getElementById('password_match_check_child').innerHTML = "비밀번호 일치";
            document.getElementById('password_match_check_child').style.color = "green";
        }
    });


    //닉네임의 중복 여부를 검사하기 위해서 만든 함수다.
    var check_nickname = document.getElementById('nickname_input');
    check_nickname.addEventListener('blur', function (event) {
        //nickname변수는 닉네임 입력 칸에 입력된 문자열을 담는 변수다.
        var nickname = document.getElementById('nickname_input').value;

        //닉네임 입력 칸이 공백인 경우 아무런 메세지가 출력되지 않는다.
        if (nickname.trim() == "") {
            document.getElementById('nickname_check_child').innerHTML = "";
        } else if (nickname.length > 10) {
            document.getElementById('nickname_check_child').innerHTML = "최대 10자까지만 입력하세요.";
            document.getElementById('nickname_check_child').style.color = "red";
        }
        //닉네임이 공백이 아니라면 ajax와 통신을 해서 닉네임의 중복여부를 검사한다. .
        else {
            var xhr = new XMLHttpRequest;
            xhr.open('POST', './check_nickname_duplicate.php');
            xhr.onreadystatechange = function () {
                if (xhr.responseText == "이미 사용 중인 닉네임 입니다.") {
                    document.getElementById('nickname_check_child').innerHTML = xhr.responseText;
                    document.getElementById('nickname_check_child').style.color = "red";
                } else {
                    document.getElementById('nickname_check_child').innerHTML = xhr.responseText;
                    document.getElementById('nickname_check_child').style.color = "green";
                }
            }
            var data = '';
            data += 'nickname=' + nickname;
            //setRequestHeader메소드는 보내는 데이터 형식을 정의하는 것이다. 만약 JSON으로 보내면 application/json이라고 쓰면 된다.
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            //send는 실제로 서버로 요청을 하는 것이다. 이때 인자에 서버로 보낼 값을 넣으면 된다. json형태로 보내는 경우 문자열 형태로 보내야 한다. JSON.stringify(json객체). 아니면 처음부터 문자열 형태로 만들어도 되고
            xhr.send(data);

        }


    });

    //이름의 유효성을 검사하기 위해서 만든 함수다.
    var check_name = document.getElementById('name_input');
    check_name.addEventListener('blur', function (event) {
        //name변수는 이름 입력 칸에 입력된 문자열을 담는 변수다.
        var name = document.getElementById('name_input').value;
        //name_form변수는 이름의 유효성 검사 규칙을 담는 변수다.
        var name_form = /^[가-힝]{2,}$/;

        //이름이 공백인 경우 아무런 메세지도 출력하지 않는다.
        if (name.trim() == "") {
            document.getElementById('name_check_child').innerHTML = "";
        } else if (name.length > 30) {
            document.getElementById('name_check_child').innerHTML = "이름은 30글자를 넘을 수 없습니다.";
            document.getElementById('name_check_child').style.color = "red";
        }
        //이름이 유효한 경우 아무런 메세지도 출력하지 않는다.
        else if (name_form.test(name)) {
            document.getElementById('name_check_child').innerHTML = "";
        }

        //이름이 유효하지 않은 경우에는 이름을 다시 입력하라는 메세지가 출력된다.
        else {
            document.getElementById('name_check_child').innerHTML = "이름을 다시 입력해주세요.";
            document.getElementById('name_check_child').style.color = "red";
        }
    });


    //핸드폰번호의 유효성을 검사하기 위한 함수다.
    var check_tel = document.getElementById('tel3_input');
    check_tel.addEventListener('blur', function (event) {
        //tel1변수는 전화번호 입력칸 중 첫번째 칸에 입력된 숫자를 담는 변수다.
        var tel1 = document.getElementById('tel1_input').value;
        //tel2변수는 전화번호 입력칸 중 두번째 칸에 입력된 숫자를 담는 변수다.
        var tel2 = document.getElementById('tel2_input').value;
        //tel3변수는 전화번호 입력칸 중 세번째 칸에 입력된 숫자를 담는 변수다.
        var tel3 = document.getElementById('tel3_input').value;

        //tel변수는 하이픈을 포함한 완결된 양식의 전화번호를 담는 변수다.
        var tel = tel1 + "-" + tel2 + "-" + tel3;
        //tel_form변수는 핸드폰번호의 유효성 규칙을 담는 변수다.
        var tel_form = /(01[0|1|6|9|7])[-](\d{3}|\d{4})[-](\d{4}$)/g;

        //전화번호 입력칸이 셋 중에 하나라도 공백이면 아무런 메세지가 뜨지 않는다.
        if (tel1.trim() == "" || tel2.trim() == "" || tel3.trim() == "") {
            document.getElementById("tel_check_child").innerHTML = "";
        }
        //전화번호 유효성 검사에서 유효하다는 결과가 나왔을 때는 다음과 같이 분기한다.
        else if (tel_form.test(tel)) {
            var xhr = new XMLHttpRequest;
            xhr.open('POST', 'check_tel_duplicate.php');
            xhr.onreadystatechange = function () {
                if (xhr.responseText == "이미 사용 중인 핸드폰 번호 입니다.") {
                    document.getElementById('tel_check_child').innerHTML = xhr.responseText;
                    document.getElementById('tel_check_child').style.color = "red";
                } else {
                    document.getElementById('tel_check_child').innerHTML = xhr.responseText;
                    document.getElementById('tel_check_child').style.color = "green";
                }
            }
            var data = '';
            data += 'tel1=' + tel1 + '&tel2=' + tel2 + '&tel3=' + tel3;
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            //send는 실제로 서버로 요청을 하는 것이다. 이때 인자에 서버로 보낼 값을 넣으면 된다. json형태로 보내는 경우 문자열 형태로 보내야 한다. JSON.stringify(json객체). 아니면 처음부터 문자열 형태로 만들어도 되고
            xhr.send(data);
        }
        //핸드폰번호 유효성 검사 결과 유효하지 않다면 잘못된 휴대폰 번호라는 메세지가 출력된다.
        else {
            document.getElementById("tel_check_child").innerHTML = "잘못된 휴대폰번호 입니다.";
            document.getElementById("tel_check_child").style.color = "red";
        }

    });

    //회원가입 버튼을 눌렀을 때의 동작을 정의하기 위해 만든 메소드다.
    function join() {
        var id = document.getElementById('id_input').value;
        var id_form = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
        var check_id_ment = document.getElementById('id_check_child').innerHTML;
        var password = document.getElementById('password_input').value;
        var password_check = document.getElementById('password_check_input').value;
        var nickname = document.getElementById('nickname_input').value;
        var check_nickname_ment = document.getElementById('nickname_check_child').innerHTML;
        var name = document.getElementById('name_input').value;
        var name_form = /^[가-힝]{2,}$/;

        var tel1 = document.getElementById('tel1_input').value;
        var tel2 = document.getElementById('tel2_input').value;
        var tel3 = document.getElementById('tel3_input').value;
        var tel_form = /(01[0|1|6|9|7])[-](\d{3}|\d{4})[-](\d{4}$)/g;
        var tel = tel1 + "-" + tel2 + "-" + tel3;
        var check_tel_ment = document.getElementById('tel_check_child').innerHTML;
        var findaccount_answer = document.getElementById('findaccount_answer_input').value;
        var address = document.getElementById('sample5_address').value;

        if (id == "" || password == "" || password_check == "" || nickname == "" || name == "" || tel1 == "" || tel2 == "" || tel3 == "" || findaccount_answer == "" || address == "") {
            alert('항목을 모두 입력해주세요.');
            return false;
        } else if (!id_form.test(id)) {
            alert('회원가입을 하실 수 없습니다. 항목들을 다시 확인해 주세요.');
            return false;
        }
        //아이디가 이미 사용중인 경우 제출 불가 (하드코딩)
        else if (check_id_ment == "이미 사용 중인 계정 입니다.") {
            alert('회원가입을 하실 수 없습니다. 항목들을 다시 확인해 주세요.');
            return false;
        } //비밀번호와 비밀번호 확인 값이 다르면 제출 불가
        else if (password.length < 4 || password.length > 16 || password != password_check) {
            alert('회원가입을 하실 수 없습니다. 항목들을 다시 확인해 주세요.')
            return false;
        } //닉네임이 중복되는 경우 제출 불가 (하드코딩)
        else if (nickname.length > 10 || check_nickname_ment == "이미 사용 중인 닉네임 입니다.") {
            alert('회원가입을 하실 수 없습니다. 항목들을 다시 확인해 주세요.');
            return false;
        } //이름이 유효하지 않다면 제출 불가
        else if (name.length > 30 || !name_form.test(name)) {
            alert('회원가입을 하실 수 없습니다. 항목들을 다시 확인해 주세요.');
            return false;
        }
        //핸드폰 번호가 유효하지 않다면 제출 불가
        else if (!tel_form.test(tel)) {
            alert('회원가입을 하실 수 없습니다. 항목들을 다시 확인해 주세요.');
            return false;
        }
        //이미 사용중인 핸드폰 번호라면 제출 불가
        else if (check_tel_ment == "이미 사용 중인 핸드폰 번호 입니다.") {
            alert('회원가입을 하실 수 없습니다. 항목들을 다시 확인해 주세요.');
            return false;
        }
        //위의 경우에 해당하지 않으면 제출 가능해서 회원 가입 승인
        else {
            return true;
        }
    }


</script>

<!-- 다음 지도 api 사용 -->
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=a04b3dea87eec7bdeecba7dc29972d3e&libraries=services"></script>
<script>
    var mapContainer = document.getElementById('map'), // 지도를 표시할 div
        mapOption = {
            center: new daum.maps.LatLng(37.537187, 127.005476), // 지도의 중심좌표
            level: 5 // 지도의 확대 레벨
        };

    //지도를 미리 생성
    var map = new daum.maps.Map(mapContainer, mapOption);
    //주소-좌표 변환 객체를 생성
    var geocoder = new daum.maps.services.Geocoder();
    //마커를 미리 생성
    var marker = new daum.maps.Marker({
        position: new daum.maps.LatLng(37.537187, 127.005476),
        map: map
    });


    function sample5_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function (data) {
                var addr = data.address; // 최종 주소 변수

                // 주소 정보를 해당 필드에 넣는다.
                document.getElementById("sample5_address").value = addr;
                // 주소로 상세 정보를 검색
                geocoder.addressSearch(data.address, function (results, status) {
                    // 정상적으로 검색이 완료됐으면
                    if (status === daum.maps.services.Status.OK) {

                        var result = results[0]; //첫번째 결과의 값을 활용

                        // 해당 주소에 대한 좌표를 받아서
                        var coords = new daum.maps.LatLng(result.y, result.x);
                        // 지도를 보여준다.
                        mapContainer.style.display = "block";
                        map.relayout();
                        // 지도 중심을 변경한다.
                        map.setCenter(coords);
                        // 마커를 결과값으로 받은 위치로 옮긴다.
                        marker.setPosition(coords)
                    }
                });
            }
        }).open();
    }
</script>
</body>

</html>
