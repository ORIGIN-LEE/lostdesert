    <div id="logo"><a href="../index.php"><img src="../img/logo.jpg" border="0"></a></div>
	<div id="moto"><img src="../img/moto.jpg"></div>
	<div id="top_login">
<?php
    if(!isset($_SESSION['userid']))
	{
		
?>
          <a href="../login/login_form.php">로그인</a> | <a href="../member/member_form.php">회원가입</a>
<?php
	}
	else
	{
?>
		<?php echo "{$_SESSION['usernick']}"?> (level:<?php echo "{$_SESSION['userlevel']}"?>) | 
		<a href="../login/logout.php">로그아웃</a> | <a href="../login/member_form_modify.php">정보수정</a>
<?php
	}
?>
	 </div>
