<meta charset="utf-8">
<?php
   if(!$_GET['id']) 
   {
      echo("아이디를 입력하세요.");
   }
   else
   {
      include "../lib/dbconn.php";
	  $id = $_GET['id'];
 
      $sql = "select * from member where id='$id' ";

      $result = mysqli_query($connect, $sql);
      $num_record = mysqli_num_rows($result);

      if ($num_record)
      {
         echo "아이디가 중복됩니다!<br>";
         echo "다른 아이디를 사용하세요.<br>";
      }
      else
      {
         echo "사용가능한 아이디입니다.";
      }
    
      mysqli_close($connect);
   }
?>

