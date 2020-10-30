<?php session_start(); 
    $userid   = $_SESSION['userid'];
	$usernick = $_SESSION['usernick'];
	$username = $_SESSION['username'];

?>
<meta charset="utf-8">
<?php
	if (!isset($_POST['mode'])){
		$mode = "normal";
	}
	else{
		$mode = $_POST['mode'];
		$num = $_POST['num'];
	}
    $table = 'raid';
    $page = $_POST['page'];
	
	$subject = $_POST['subject'];
	$content = $_POST['content'];
	$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

	include "../lib/dbconn.php";       // dconn.php 파일을 불러옴
	mysqli_query($connect, "set session character_set_connection=utf8;");		 
    mysqli_query($connect, "set session character_set_results=utf8;");		 
    mysqli_query($connect, "set session character_set_client=utf8;");

	if ($mode=="modify")
	{
		$sql = "update $table set subject='$subject', content='$content' where num=$num";
	}
	else
	{
		$sql = "insert into $table (id, name, nick, subject, content, regist_day)
		        values('$userid', '$username', '$usernick', '$subject', '$content', '$regist_day')";
	}
    mysqli_query ($connect,$sql);  // $sql 에 저장된 명령 실행
	mysqli_close($connect);                 // DB 연결 끊기

	echo "
	   <script>
	    location.href = 'list.php?&page=$page';
	   </script>
	";
?>

  
