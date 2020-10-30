<?php 
	session_start(); 
	if(isset($_SESSION['userid'])){
		$userid = $_SESSION['userid'];
		$usernick = $_SESSION['usernick'];
	}
	else
	{
		$userid = "";
		$usernick ="";
		echo "
		<script>
	      history.go(-1) ;
	   </script>
	   ";
	}
	if (isset($_GET['table']))
		$table = $_GET['table'];
	
	if (isset($_GET['mode']))
		$mode = $_GET['mode'];
	else
		$mode ="nomal";
	
	if (isset($_GET['num']))
		$num = $_GET['num'];
	else
		$num =1;
	
	if (isset($_GET['page']))
		$page = $_GET['page'];
	else
		$page =1;
	
	
	include "../lib/dbconn.php";
	mysqli_query($connect, "set session character_set_connection=utf8;");		 
    mysqli_query($connect, "set session character_set_results=utf8;");		 
    mysqli_query($connect, "set session character_set_client=utf8;");	

	if ($mode=="modify")
	{
		$sql = "select * from $table where num=$num";
		$result = mysqli_query($connect,$sql);

		$row = mysqli_fetch_array($result);       
	
		$item_subject     = $row['subject'];
		$item_content     = $row['content'];

		$item_file_0 = $row['file_name_0'];
		$item_file_1 = $row['file_name_1'];
		$item_file_2 = $row['file_name_2'];

		$copied_file_0 = $row['file_copied_0'];
		$copied_file_1 = $row['file_copied_1'];
		$copied_file_2 = $row['file_copied_2'];
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<meta charset="utf-8">
<link href="../css/common.css" rel="stylesheet" type="text/css" media="all">
<link href="../css/board3.css" rel="stylesheet" type="text/css" media="all">
<script>
  function check_input()
   {
      if (!document.board_form.subject.value)
      {
          alert("제목을 입력하세요1");    
          document.board_form.subject.focus();
          return;
      }

      if (!document.board_form.content.value)
      {
          alert("내용을 입력하세요!");    
          document.board_form.content.focus();
          return;
      }
      document.board_form.submit();
   }
</script>
</head>

<body>
<div id="wrap">

  <div id="header">
    <?php include "../lib/top_login2.php"; ?>
  </div>  <!-- end of header -->

  <div id="menu">
	<?php include "../lib/top_menu2.php"; ?>
  </div>  <!-- end of menu --> 

  <div id="content">
	<div id="col1">
		<div id="left_menu">
<?php
			include "../lib/left_menu.php";
?>
		</div>
	</div> <!-- end of col1 -->

	<div id="col2">       
		<div id="title">
			<img src="../img/title_download.gif">
		</div>
		<div class="clear"></div>

		<div id="write_form_title">
			<img src="../img/write_form_title.gif">
		</div>

		<div class="clear"></div>
<?php
	if($mode=="modify")
	{

?>
		<form  name="board_form" method="post" action="insert.php" enctype="multipart/form-data">
		<input type="hidden" name="mode" value="modify">
		<input type="hidden" name="num" value=<?php echo $num?>>
		<input type="hidden" name="page" value=<?php echo $page?>>
		<input type="hidden" name="table" value=<?php echo $table?>>
<?php
	}
	else
	{
?>
		<form  name="board_form" method="post" action="insert.php" enctype="multipart/form-data">
		<input type="hidden" name="table" value=<?php echo $table?>>
		<input type="hidden" name="page" value=<?php echo $page?>>
<?php
	}
?>
		<div id="write_form">
			<div class="write_line"></div>
			<div id="write_row1"><div class="col1"> 닉네임 </div><div class="col2"><?php echo $usernick?></div></div>
			<div class="write_line"></div>
<?php
	if( $userid && ($mode != "modify") )
	{
?>		
			<div id="write_row2"><div class="col1"> 제목   </div>
			                     <div class="col2"><input type="text" name="subject"></div>
			</div>
			<div class="write_line"></div>
			<div id="write_row3"><div class="col1"> 내용   </div>
			                     <div class="col2"><textarea rows="15" cols="79" name="content"></textarea></div>
			</div>
<?php
	}
?>
<?php
	if( $userid && ($mode == "modify") )
	{
?>		
			<div id="write_row2"><div class="col1"> 제목   </div>
			                     <div class="col2"><input type="text" name="subject" value="<?php echo $item_subject?>" ></div>
			</div>
			<div class="write_line"></div>
			<div id="write_row3"><div class="col1"> 내용   </div>
			                     <div class="col2"><textarea rows="15" cols="79" name="content"><?php echo $item_content?></textarea></div>
			</div>
<?php
	}
?>

			<div class="write_line"></div>
			<div id="write_row4"><div class="col1"> 첨부파일1   </div>
			                     <div class="col2"><input type="file" name="upfile[]"> * 5MB까지 업로드 가능!</div>
			</div>
			<div class="clear"></div>
<?php 	if ($mode=="modify" && $item_file_0)
	{
?>
			<div class="delete_ok"><?php echo $item_file_0?> 파일이 등록되어 있습니다. <input type="checkbox" name="del_file[]" value="0"> 삭제</div>
			<div class="clear"></div>
<?php
	}
?>
			<div class="write_line"></div>
			<div id="write_row5"><div class="col1"> 첨부파일2  </div>
			                     <div class="col2"><input type="file" name="upfile[]">  * 5MB까지 업로드 가능!</div>
			</div>
<?php 	if ($mode=="modify" && $item_file_1)
	{
?>
			<div class="delete_ok"><?php echo $item_file_1?> 파일이 등록되어 있습니다. <input type="checkbox" name="del_file[]" value="1"> 삭제</div>
			<div class="clear"></div>
<?php
	}
?>
			<div class="write_line"></div>
			<div class="clear"></div>
			<div id="write_row6"><div class="col1"> 첨부파일3   </div>
			                     <div class="col2"><input type="file" name="upfile[]">  * 5MB까지 업로드 가능!</div>
			</div>
<?php 	if ($mode=="modify" && $item_file_2)
	{
?>
			<div class="delete_ok"><?php echo $item_file_2?> 파일이 등록되어 있습니다. <input type="checkbox" name="del_file[]" value="2"> 삭제</div>
			<div class="clear"></div>
<?php
	}
?>
			<div class="write_line"></div>

			<div class="clear"></div>
		</div>

		<div id="write_button"><a href="#"><img src="../img/ok.png" onclick="check_input()"></a>&nbsp;
								<a href="list.php?page=<?php echo $page?>"><img src="../img/list.png"></a>
		</div>

		</form>

	</div> <!-- end of col2 -->
  </div> <!-- end of content -->
</div> <!-- end of wrap -->

</body>
</html>
