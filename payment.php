<?php
session_start();
if (empty($_SESSION['id'])) {
    echo "<script>
    alert('로그인 후 이용해주세요.');
    location.href='login.php';
   </script>";
}
$tel1 = substr($_SESSION['tel'], 0, 3);
$tel2 = substr($_SESSION['tel'], 3, 4);
$tel3 = substr($_SESSION['tel'], 7, 4);


//php는 함수 밖에 선언한 전역변수가 함수 안에서 정의되지 않는다. 함수 안에서도 전역변수를 사용하기 위해서는 함수 안의 변수 앞에 global을 달아줘야 한다.
$total_price = 0;
function make_product()
{
    $conn = mysqli_connect('127.0.0.1', 'root', 'rla933466r!', 'billiards');
    //장바구니에서 체크박스에 체크한 상품들의 상품 번호를 담은 배열
    $basket = $_POST['basket'];
    //장바구니에서 체크막스에 체크한 상품들의 수량을 담은 배열
    $count = $_POST['count'];

    for ($i = 0; $i < count($basket); $i++) {
        $sql = "
      SELECT*FROM product WHERE id={$basket[$i]}
    ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        //함수 밖에서 선언한 변수와 연결하기 위해서 global키워드 사용.
        global $total_price;
        $total_price += $row['price'] * $count[$i];
        echo "<tr>
      <td>
        <img src='product_image/{$row['image']}' width=\"200px\" height=\"150px\">
      </td>
      <td>
        {$row['name']}
      </td>
      <td>
        {$count[$i]}개
      </td>
      <td>
      ";
        echo number_format($row['price']) . 원;
        echo "
    </td>
      <td>
      ";
        echo number_format(2500) . 원;
        echo "  </td>
    </tr>";
    }

}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>구매 페이지</title>
    <link rel="stylesheet" href="main_style.css">
    <link rel="stylesheet" href="payment_style.css">
</head>
<body>

<?php
error_reporting(0);
?>
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
<h1 class="payment_title">구매 페이지</h1>
<br>
<table id="product_list_box">
    <tr>
        <th>제품 사진</th>
        <th>제품명</th>
        <th>수량</th>
        <th>가격</th>
        <th>배송비</th>
    </tr>
    <?php
    make_product();
    ?>

</table>


<br>

<h2>최종 결제 금액: <?php echo number_format($total_price + 2500) . 원; ?> </h2>
<br>

<h3>배송지 정보 입력</h3>
<div class="delivery_info">
    <form class="delivery_form" method="post" name='payment_form'>
        <table>
            <tr>
                <th>받으시는 분:</th>
                <td>
                    <input id="name_input" type="text" name="name" value='<?php echo $_SESSION['name']; ?>'>
                </td>
            </tr>

            <tr>
                <th>
                    휴대전화:
                </th>
                <td>
                    <input id="tel1_input" type="tel" name="tel1" maxlength="3" value=<?php echo $tel1; ?> size="6">-
                    <input id="tel2_input" type="tel" name="tel2" maxlength="4" value=<?php echo $tel2; ?> size="6">-
                    <input id="tel3_input" type="tel" name="tel3" maxlength="4" value=<?php echo $tel3; ?> size="6">
                </td>
            </tr>

            <tr>
                <th>
                    주소:
                </th>
                <td>
                    <input id="sample5_address" type="text" name="address" value='<?php echo $_SESSION['address']; ?>'>
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

        <input id='account_input' type="hidden" name="user_id" value="<?php echo $_SESSION['account']; ?>">
        <input id='price_input' type="hidden" name="total_price"
               value="<?php echo number_format($total_price + 2500); ?>">
        <?php
        $basket = $_POST['basket'];
        $count = $_POST['count'];
        for ($i = 0; $i < count($basket); $i++) {
            echo "
                <input type=\"hidden\" name=\"basket[]\" value=\"{$basket[$i]}\">
                <input type=\"hidden\" name=\"count[]\" value=\"{$count[$i]}\">
              ";
        }

        ?>

        <br>
        <br>
        <button id="order" type="button" name="order_button">결제하기</button>
    </form>

</div>


</body>
<script src="//code.jquery.com/jquery-3.4.0.js"></script>
<script src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js" type="text/javascript"></script>
<script type="text/javascript">


    var order_button = document.getElementById('order');
    order_button.addEventListener('click', function (event) {
        var email = document.getElementById('account_input').value;

        var name = document.getElementById('name_input').value;
        var name_form = /^[가-힝]{2,}$/;

        var tel1 = document.getElementById('tel1_input').value;
        var tel2 = document.getElementById('tel2_input').value;
        var tel3 = document.getElementById('tel3_input').value;
        var tel_form = /(01[0|1|6|9|7])[-](\d{3}|\d{4})[-](\d{4}$)/g;
        var tel = tel1 + "-" + tel2 + "-" + tel3;

        var address = document.getElementById('sample5_address').value;
        var price_input = document.getElementById('price_input').value;

        if (name == "" || tel1 == "" || tel2 == "" || tel3 == "" || address == "") {
            alert('항목을 모두 입력해주세요.');

        } //이름이 유효하지 않다면 제출 불가
        else if (name.length > 30 || !name_form.test(name)) {
            alert('결제를 진행하실 수 없습니다. 이름을 다시 확인해 주세요.');

        }
        //핸드폰 번호가 유효하지 않다면 제출 불가
        else if (!tel_form.test(tel)) {
            alert('결제를 진행하실 수 없습니다. 핸드폰 번호를 다시 확인해 주세요.');

        }
        //위의 경우에 해당하지 않으면 제출 가능해서 회원 가입 승인
        else {
            //카카오 페이
            var IMP = window.IMP; // 생략가능
            IMP.init('imp96263290');  // 가맹점 식별 코드
            IMP.request_pay({
                pg: 'kakaopay',
                pay_method: 'card',
                merchant_uid: 'merchant_' + new Date().getTime(),
                name: '주문명:결제테스트',
                amount: price_input,
                buyer_email: email,
                buyer_name: name,
                buyer_tel: tel,
                buyer_addr: address
                // buyer_postcode : '123-456'
            }, function (rsp) {
                //결제에 성공했을 때--결제에 성공한 후 성공 페이지로 넘겨준다.
                if (rsp.success) {
                    var msg = '결제가 완료되었습니다.';
                    // msg += '고유ID : ' + rsp.imp_uid;
                    // msg += '상점 거래ID : ' + rsp.merchant_uid;
                    // msg += '결제 금액 : ' + rsp.paid_amount;
                    // msg += '카드 승인번호 : ' + rsp.apply_num;
                    //결제에 성공하면 payment_complete.php페이지로 넘겨준다.
                    document.payment_form.action = "payment_complete.php";
                    document.payment_form.submit();
                } else {
                    var msg = '';
                    msg += rsp.error_msg;
                }

                alert(msg);
            });
        }

    });


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
</html>
