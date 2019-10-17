<!-- 댓글 팝업창에서 수정한 댓글을 submit하면 넘어오는 페이지 -->
<?php
$conn=mysqli_connect('127.0.0.1','root','rla933466r!','billiards');
//댓글의 내용, 수정한 날짜를 update하는 쿼리문
$sql="
   UPDATE news_comment
   SET
    comment='{$_POST['comment']}',
    date=NOW()
    WHERE id={$_POST['id']}
";
$result=mysqli_query($conn, $sql);

// header('Location: ./news_detail.php?id='.$_POST['id']);
?>

<script type="text/javascript">
  //현재 자기 자신 팝업창을 종료시킨다.
  self.close();
  //자신의 부모 창을 새로 고침한다. 이 작업은 댓글을 수정하고 수정한 내용이 반영되게 하기 위해서 하는 작업이다.
  opener.location.reload();
</script>
