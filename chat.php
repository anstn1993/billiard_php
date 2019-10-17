<?php
  session_start();
  if(empty($_SESSION['id'])){
    echo "<script>
      alert('로그인 후 이용해주세요.');
      location.href='login.php';
     </script>";
  }
  $conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
  $sql="
    SELECT*FROM chat
    ORDER BY id DESC
  ";
  $result=mysqli_query($conn, $sql);
  $row=mysqli_fetch_array($result);
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>당톡방</title>
  <link rel="stylesheet" href="main_style.css">
  <link rel="stylesheet" href="chat_style.css">
</head>
<body>
  <nav class="top">
    <?php

      error_reporting(0);
      if(empty($_SESSION['id'])){
        echo "<div class='top_child'><a class='top_menu' href='login.php'>로그인</a></div>
              <div class='top_child'><a class='top_menu' href='join.php'>회원가입</a></div>";
      }else{
        echo "<div class='top_child'><a class='top_menu' href='logout.php'>로그아웃</a></div>
              <div class='top_child'><a class='top_menu' href='mypage.php'>마이페이지</a></div>
              <div id='nickname' class='top_child'>반갑습니다, ".$_SESSION['nickname']."님!</div>";
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
  <h2 class="chat_title">당톡방</h2>
  <div id="chat_box">

  </div>
  <div id="new_message">

  </div>
  <form>
    <input type="hidden" name='last_chat_id' id='last_chat_id' value=<?php echo $row['id']; ?>>
    <textarea id="message" name="message" rows="4" cols="70" placeholder="채팅내용을 입력하세요" required='required'></textarea>

  </form>
  <div id="chat_control_button">
    <input id="top" type="button" value="최상단으로">
    <input id="send" type="button" value="보내기">
    <input id="bottom" type="button" value="최하단으로">
  </div>

</body>

<script src="//code.jquery.com/jquery-3.4.0.js"></script>
<script type="text/javascript">

  //채팅창의 최상단을 0으로 해서 스크롤의 위치를 담는 변수
  var scroll_top=0;
  //채팅창의 높이
  var client_height=500;
  //최상단에서 스크롤을 최하단으로 내렸을 때 전체 content의 높이(채팅을 보내기 전 높이)
  var scroll_height=500;
  //최상단에서 스크롤을 최하단으로 내렸을 때 전체 content의 높이(채팅을 보낸 후의 높이)
  var next_scroll_height=500;
  //이 변수는 채팅을 보내는 순간 1이 되고 채팅 데이터가 화면에 뿌려진 후에는 다시 0으로 돌아간다.
  var send_state=0;

  //보내기 버튼을 클릭하면 add_chat.php로 채팅내용을 전송해준다.
  //add_chat.php파일에는 전달받은 채팅내용을 mysql에 저장하는 코딩이 되어 있다.
  $('#send').click(function(){
    if($('#message').val()){
      //ajax통신 api를 통해서 post방식으로 form태그에 있는 데이터 전송
      $.ajax(
        //jquery ajax api의 파라미터로 들어가는 setting객체
        {
          url:'add_chat.php',
          type:'POST',//전송방식 post
          data: $('form').serialize(),//form태그 안에 있는 여러 태그들의 value값들을 담아서 전달.
          //통신에 성공하는 경우 실행될 함수 정의
          success: function(data){
            //채팅내용을 보냈으면 채팅 입력창은 다시 비워준다.
            $('#message').val('');

            console.log($('#chat_box').prop('scrollHeight'));
          }
        }
      );

      //스크롤이 채팅창의 최하단이 아닌 중간에 위치할 때
      if($('#chat_box').prop('scrollHeight')>510 && scroll_top+1<scroll_height-client_height){
        //자신의 발신상태는 1이 된다. 이는 자신이 메세지를 보냈음을 표현하기 위한 변수다.
        send_state=1;
      }


    }else{
      alert('채팅 내용을 입력하세요!');
    }
  });


//setInterval함수는 일정 시간을 간격으로 계속 함수가 실행되게 만들어주는 함수다.
//첫번째 인자로 함수가 들어가고, 두번째 인자로 함수가 실행될 주기(시간)가 밀리세컨드 단위로 들어간다.
setInterval(function load_chat(){
    //스크롤이 최하단에 위치하게 되면
    if(scroll_top+1>=next_scroll_height-client_height){
        //새로운 채팅이 왔다는 알림이 사라진다.
        $('#new_message').empty();
        //채팅을 보내기 전의 전체 content높이를 새로운 채팅이 반영된 천체 content 높이로 반영을 해준다.
        //그렇게 해줘야 최하단 상태에서 채팅을 보낼 때 최하단 상태를 유지해줄 수 있다.
        //하단의 코드 참조
        scroll_height=next_scroll_height;

    }
    $.ajax(
      //jquery ajax api의 파라미터로 들어가는 setting객체
      {
        url:'load_chat.php',//해당 php파일에는 데이터베이스에 저장된 채팅목록을 가져온다.
        type:'POST',//전송방식은 POST
        data: $('form').serialize(),
        //전송에 성공하면 load_chat.php의 데이터가 함께 넘어온다. 그 값을 함수의 파라미터로 설정하여 사용할 수 있다.
        success: function(data){
          //채팅창에 채팅을 보낸 사람과 채팅 내용을 추가준다.
          $('#chat_box').append(data);
          //스크롤의 위치를 실시간으로 업데이트 해줘서 누군가가 채팅을 보낸 순간의 스크롤 위치를 캐치할 수 있도록 한다.
          scroll_top=$('#chat_box').scrollTop();


          //데이터 존재한다면
          if(data){

            //데이터가 잘 넘어왔으면
            //마지막 채팅 번호를 새롭게 갱신해준다.
            $('#last_chat_id').val((Number($('#last_chat_id').val())+1));

            //이 조건문에 진입했다는 것은 누군가가 채팅을 보냈다는 것을 의미하기 때문에 채팅이 왔을 때의 전체 content높이를 새롭게 저장해준다.
            next_scroll_height=$('#chat_box').prop('scrollHeight');





              //최초로 스크롤이 생기는 경우
              if($('#chat_box').prop('scrollHeight')-$('#chat_box').prop('clientHeight')<=40){
                //scrollTop은 파라미터로 들어온 값만큼 스크롤을 내려주는 함수다.
                $('#chat_box').scrollTop($('#chat_box').prop('scrollHeight')-$('#chat_box').prop('clientHeight'));
                //스크롤을 최하단으로 내린 상태에서 스크롤의 위치를 저장
                scroll_top=$('#chat_box').scrollTop();
                //scroll height를 채팅이 온 상태의 높이로 업데이트
                scroll_height=next_scroll_height;
                next_scroll_height=$('#chat_box').prop('scrollHeight');


              }


            //현재의 스크롤 위치가 새로운 채팅이 오기 전의 전체 컨텐츠 높이에서 채팅창의 높이를 뺀 값보다 크거나 같으면
            //이는 스크롤이 최하단인 상태에서 새로운 채팅이 생겼음을 의미한다.(+1은 오차범위 조정)
            if(scroll_top+1>=scroll_height-client_height){
              //스크롤의 위치를 최하단으로 내려준다.
              $('#chat_box').scrollTop($('#chat_box').prop('scrollHeight')-$('#chat_box').prop('clientHeight'));
              //scroll height를 채팅이 온 상태의 높이로 업데이트 해준다.
              scroll_height=next_scroll_height;
              next_scroll_height=$('#chat_box').prop('scrollHeight');
            }
            //만약 스크롤의 위치가 최하단이 아닌 상태에서 채팅이 도착하고 스크롤이 존재하며 자신이 보내지 않은 채팅인 경우
            else if($('#chat_box').prop('scrollHeight')>510 && !$('#new_message').text() && send_state==0){
              //새로운 채팅이 도착했다는 알림 출력
              $('#new_message').append('새로운 채팅이 도착했습니다.');

            }
            //모든 채팅 통신이 끝나면 다시 send_state는 0으로 돌아간다.
            send_state=0;




          }
        }
      }
    );
},500);

//최상단으로 버튼을 누르면
$('#top').click(function(){
  //채팅창의 처음으로 올라간다.
  $('#chat_box').scrollTop(0);
});

//최하단으로 버튼을 누르면
$('#bottom').click(function(){
  //채팅창의 최하단으로 내려간다.
  $('#chat_box').scrollTop($('#chat_box').prop('scrollHeight'));
  //새로운 채팅이 도착했다는 메세지가 삭제된다.
  $('#new_message').empty();
  scroll_height=next_scroll_height;

});


</script>
</html>
