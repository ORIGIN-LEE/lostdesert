<?php
   session_start();
?>
<meta charset="utf-8">
<?php
   $userid = $_SESSION['userid'] ;
   $username = $_SESSION['username'] ;
   $usernick = $_SESSION['usernick'] ;

   $num = $_POST['num'];
   $member1 = $_POST['member1'];
   $member2 = $_POST['member2'];
   $member3 = $_POST['member3'];
   $done = 'n';

   echo "$member1, $member2, $member3";

   include "../lib/dbconn.php";       // dconn.php 파일을 불러옴
   mysqli_query($connect, "set session character_set_connection=utf8;");		 
   mysqli_query($connect, "set session character_set_results=utf8;");		 
   mysqli_query($connect, "set session character_set_client=utf8;");

   $sql = "select * from raid where num = '$num'";
   $result = mysqli_query($connect, $sql);
   $row = mysqli_fetch_array($result);

   if($row['member1']) {
        $member1 = $row['member1'];
   }
   if($row['member2']) {
        $member2 = $row['member2'];
   }
   if($row['member3']) {
        $member3 = $row['member3'];
   }
   if($member1 && $member2 && $member3) {
        $done = 'y';
   }
   $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

   // 레코드 삽입 명령
    $sql = "update raid set member1 = '$member1', member2 = '$member2', member3 = '$member3', done = '$done' where num = $num";
    mysqli_query($connect, $sql);

    mysqli_close($connect);

    /*echo "
        <script>
            history.go(-1);
        </script>
    ";*/
?>
