<?php
error_reporting(0);
//로그인 창에서 입력한 계정
$account=$_POST['account'];
//비밀번호 창에서 입력한 비밀번호
$password=$_POST['password'];
$remember=$_POST['remember'];
$conn=mysqli_connect('127.0.0.1', 'root', 'rla933466r!', 'billiards');
//로그인 창에서 입력한 아이디를 기준으로 테이블 조회
$sql="
  SELECT*FROM user
  WHERE account='{$account}'
";
$result=mysqli_query($conn, $sql);

//테이블의 행의 수를 담는 변수
$account_row_number=mysqli_num_rows($result);
//테이블의 필드 값을 유사 배열로 담는 변수
$row=mysqli_fetch_array($result);

//아이디나 비밀번호가 하나라도 입력되지 않는 경우
if(empty($account) || empty($password)){
  echo "<script> alert('아이디와 비밀번호를 모두 입력해주세요.'); location.href='login.php'; </script>";
}
//내가 입력한 아이디로 조회한 테이블의 결과가 나오지 않아 테이블의 행의 수가 0인 경우
else if($account_row_number==0){
  echo "<script> alert('아이디와 비밀번호를 확인해주세요.'); location.href='login.php'; </script>";
}
//그렇지 않고 조회가 되어 테이블의 행 수가 1인 경우(즉 내가 입력한 아이디가 테이블에 있는 경우)
else{
  //테이블에 저장된 비밀번호가 내가 입력한 비밀번호와 다른 경우
  if($row['password']!=$password){
    echo "<script> alert('아이디와 비밀번호를 확인해주세요.'); location.href='login.php'; </script>";
  }
  //테이블에 저장된 비밀번호가 내가 입력한 비밀번호와 같은 경우 세션 스타트!!!
  else{
    //세션을 초기화하는 함수
    session_start();
    $_SESSION['id']=$row['id'];
    $_SESSION['account']=$row['account'];
    $_SESSION['password']=$row['password'];
    $_SESSION['nickname']=$row['nickname'];
    $_SESSION['name']=$row['name'];
    $_SESSION['tel']=$row['tel'];
    $_SESSION['who']=$row['who'];
    $_SESSION['question']=$row['question'];
    $_SESSION['answer']=$row['answer'];
    $_SESSION['address']=$row['address'];

    //아이디 기억 체크박스를 클릭했을 때 아이디를 기억하기 위해서 쿠키를 생성한다.
    if(!empty($remember)){
      setcookie('remember_account',$account,time()+(60*60*24*365),'/');
    }
    //체크하지 않고 넘어왔다면 쿠키를 삭제시킨다.
    else {
      setcookie('remember_account',$account,time()-1,'/');
    }

    //비로그인상태에서 담았던 장바구니 목록을 그대로 옮겨주는 작업
    //비로그인 상태에서 넣었던 장바구니를 로그인했을 때 넘겨주는 로직
    //쿠키 값을 담을 배열 선언
    $basket_arr=array();
    //제품 테이블을 제품 아이디를 기준으로 내림차순 정렬
    $conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
    $sql="
      SELECT*FROM product
      ORDER BY id DESC
    ";
    $result=mysqli_query($conn, $sql);
    $row=mysqli_fetch_array($result);
    //가장 큰 아이디 값을 담고
    $max_id=$row['id'];
    //반복문을 통해서 존재하는 쿠키를 배열에 담는다.
    for($i=1; $i<=$max_id; $i++){
      if(!empty($_COOKIE['basket_'.$i])){
        array_push($basket_arr, $_COOKIE['basket_'.$i]);
      }
    }
    //배열의 길이가 0이 아니면 로그인 전에 장바구니에 추가한 제품이 있다는 것이니까
    if(count($basket_arr)!=0){
      //반복문을 배열의 크기만큼 돌리면서 제품 번호를 장바구니 테이블에 넣어준다.
      for($i=0; $i<count($basket_arr); $i++){
        //제품의 번호가 해당 배열에 담긴 값을 조회하는 sql문
        $sql="
          SELECT*FROM basket
          WHERE product_id={$basket_arr[$i]}
        ";
        $result=mysqli_query($conn, $sql);
        $row=mysqli_fetch_array($result);
        //이때 로그인한 사람의 장바구니에 로그인 전에 장바구니에 넣은 상품이 있으면 추가하지 않고
        //로그인한 사람의 장바구니에 새롭게 추가되는 제품일 경우에만 넣기 위해서 다음과 같은 조건문 설정
        if($row['nickname']!=$_SESSION['nickname']){
          $sql="
          INSERT INTO basket
          (product_id, account, nickname)
          VALUES(
              '{$basket_arr[$i]}',
              '{$_SESSION['account']}',
              '{$_SESSION['nickname']}'
            )
          ";
          $result=mysqli_query($conn, $sql);
        }
        //쿠키를 모두 삭제해준다.
        setcookie('basket_'.$basket_arr[$i],'',time()-1,'/');
      }
    }

    echo "<script> location.href='main.php'; </script>";
  }
}

 ?>
