<?php
include("connect_db.php");//데이터베이스와 연결
//비밀번호 찾기 창에서 입력한 계정
$account = $_POST['account'];
//비밀번호 찾기 창에서 선택한 질문
$findpassword_question = $_POST['findpassword_question'];
//비밀번호 찾기 창에서 입력한 답변
$findpassword_answer = $_POST['findpassword_answer'];
//비밀번호 찾기 창에서 입력한 이름을 기준으로 테이블 조회를 하는 쿼리문
$sql = "
  SELECT*FROM user
  WHERE account='{$account}'
";
$result = mysqli_query($conn, $sql);

//테이블의 행의 수를 담는 변수
$account_row_number = mysqli_num_rows($result);
//테이블의 필드 값을 유사 배열로 담는 변수
$row = mysqli_fetch_array($result);

//계정과 답변 중 하나라도 입력되지 않는 경우
if (empty($account) || empty($findpassword_answer)) {
    echo "<script> alert('모든 항목을 입력해주세요.'); location.href='findpassword.html'; </script>";
} //내가 입력한 이름으로 조회한 테이블의 결과가 나오지 않아 테이블의 행의 수가 0인 경우
else if ($account_row_number == 0) {
    echo "<script> alert('입력한 내용을 다시 확인해주세요.'); location.href='findpassword.html'; </script>";
} //그렇지 않고 조회가 되어 테이블의 행 수가 1 이상인 경우(즉 내가 입력한 아이디가 테이블에 있는 경우)
else {
    //테이블에 저장된 질문이나 답변이 다른 경우
    if ($row['question'] != $findpassword_question || $row['answer'] != $findpassword_answer) {
        echo "<script> alert('입력한 내용을 다시 확인해주세요.'); location.href='findpassword.html'; </script>";
    } //테이블에 저장된 질문과 답변이 내가 입력한 질문, 답변과 같은 경우
    else {
        //폼을 작성하고 히든 방식으로 계정 값을 담아서 결과 페이지로 넘겨줘야 한다. 그런데 내가 따로 제출 버튼을 누를 수 없기 때문에 자바스크립트를 이용해서 form이라는 이름을 가진 form 객체의 submit()함수를 실행했다.
        echo "<form name='form' action='findpasswordresult.php' method='post'>
            <input type='hidden' name='account' value='{$row['account']}'/>
          </form>
          <script>
            document.form.submit();
          </script>
    ";
    }
}

?>
