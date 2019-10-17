<?php
  $popup_check=$_POST['popup_check'];
  //체크박스에 체크를 해서 값이 들어있으면 24시간 뒤에 만료가 되는 쿠키를 만든다.
  if($popup_check=='checked'){
    setcookie('popup_check','checked',time()+(60*60*24),'/');
    //테스트를 위해서 만료기간이 10초인 쿠키로 생성한다. 원래대로 돌리고 싶으면 주석처리된 코드를 사용
     // setcookie('popup_check','checked',time()+(10),'/');
  }


 ?>

 <script type="text/javascript">
 //팝업창 종료
   self.close();
 </script>
