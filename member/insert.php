<meta charset="utf-8">
<?php
   $id=$_POST['id'];                           //제일 먼저 선언해야 됨
   $pass=$_POST['pass'];
   $name=$_POST['name'];
   $nick=$_POST['nick'];
   $hp1=$_POST['hp1'];
   $hp2=$_POST['hp2'];
   $hp3=$_POST['hp3'];
   $email1=$_POST['email1'];
   $email2=$_POST['email2'];
   
   $hp = $hp1."-".$hp2."-".$hp3;
   $email = $email1."@".$email2;

   $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장
   $ip = $_SERVER['REMOTE_ADDR'];         // 방문자의 IP 주소를 저장
   
   include "../lib/dbconn.php";       // dconn.php 파일을 불러옴
   
   mysqli_query($connect, "set session character_set_connection=utf8;");		 
   mysqli_query($connect, "set session character_set_results=utf8;");		 
   mysqli_query($connect, "set session character_set_client=utf8;");	


   $sql = "select * from member where id='$id'";
   $result = mysqli_query($connect,$sql);
   $exist_id = mysqli_num_rows($result);

    if($exist_id) {
        echo("
            <script>
                window.alert('해당 아이디가 존재합니다.')
                history.go(-1)
            </script>
        ");
        exit;
    }
   else
   {            // 레코드 삽입 명령을 $sql에 입력
	    $sql = "insert into member(id, pass, name, nick, hp, email, regist_day, level) ";
		$sql .= "values('$id', '$pass', '$name', '$nick', '$hp', '$email', '$regist_day', 9)";

		mysqli_query($connect,$sql);  // $sql 에 저장된 명령 실행
   }

   mysqli_close($connect);                // DB 연결 끊기
   echo "
	   <script>
	    location.href = '../index.php';
	   </script>
	";
?>

   
