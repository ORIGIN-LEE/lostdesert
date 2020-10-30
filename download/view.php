<?php 
	session_start(); 
	
	if(isset($_SESSION['userid']))
		$userid = $_SESSION['userid'];
	else
		$userid ="";
	
	$table = $_GET['table'];
	$num=$_GET['num'];
	$page=$_GET['page'];
	
	include "../lib/dbconn.php";
	mysqli_query($connect, "set session character_set_connection=utf8;");		 
    mysqli_query($connect, "set session character_set_results=utf8;");		 
    mysqli_query($connect, "set session character_set_client=utf8;");	

	$sql = "select * from $table where num=$num";
	$result = mysqli_query($connect ,$sql);

    $row = mysqli_fetch_array($result);       

	$item_num     = $row['num'];
	$item_id      = $row['id'];
	$item_name    = $row['name'];
  	$item_nick    = $row['nick'];
	$item_hit     = $row['hit'];

	$file_name[0]   = $row['file_name_0'];
	$file_name[1]   = $row['file_name_1'];
	$file_name[2]   = $row['file_name_2'];

	$file_type[0]   = $row['file_type_0'];
	$file_type[1]   = $row['file_type_1'];
	$file_type[2]   = $row['file_type_2'];

	$file_copied[0] = $row['file_copied_0'];
	$file_copied[1] = $row['file_copied_1'];
	$file_copied[2] = $row['file_copied_2'];

    $item_date    = $row['regist_day'];
	$item_subject = str_replace(" ", "&nbsp;", $row['subject']);

	$item_content = str_replace(" ", "&nbsp;", $row['content']);
	$item_content = str_replace("\n", "<br>", $item_content);
	$new_hit = $item_hit + 1;

	$sql = "update $table set hit=$new_hit where num=$num";   // 글 조회수 증가시킴
	mysqli_query($connect, $sql);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<meta charset="utf-8">
<link href="../css/common.css" rel="stylesheet" type="text/css" media="all">
<link href="../css/board3.css" rel="stylesheet" type="text/css" media="all">
<script>
    function del(href) 
    {
        if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
                document.location.href = href;
        }
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
			<img src="../img/title_item.jpg">
		</div>
		<div id="view_comment"> &nbsp;</div>

		<div id="view_title">
			<div id="view_title1"><?php echo $item_subject ?></div><div id="view_title2"><?php echo $item_nick ?> | 조회 : <?php echo $item_hit ?>  
			                      | <?php echo $item_date ?> </div>	
		</div>

		<div id="view_content">
<?php
	for ($i=0; $i<3; $i++)
	{
		if ($userid && $file_copied[$i])
		{
			$show_name = $file_name[$i];
			$real_name = $file_copied[$i];
			$real_type = $file_type[$i];
			$file_path = "./data/".$real_name;
			$file_size = filesize($file_path);

			echo "▷ 첨부파일 : $show_name($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
			       <a href='download.php?real_name=$real_name&show_name=$show_name&file_type=$real_type'>[저장]</a><br>";
		}
	}
?>
		    <br>
			<?php echo  $item_content ?>
		</div>

		<div id="view_button">
				<a href="list.php?table=<?php echo $table?>&page=<?php echo $page?>"><img src="../img/list.png"></a>&nbsp;
<?php 
	if($userid=="admin" || $userid==$item_id)
	{
?>
				<a href="write_form.php?table=<?php echo $table?>&mode=modify&num=<?php echo $num?>&page=<?php echo $page?>"><img src="../img/modify.png"></a>&nbsp;
				<a href="javascript:del('delete.php?table=<?php echo $table?>&num=<?php echo $num?>')"><img src="../img/delete.png"></a>&nbsp;
<?php
	}
?>
<?php 
	if($userid)
	{
?>
				<a href="write_form.php?table=<?php echo $table?>"><img src="../img/write.png"></a>
<?php
	}
?>
		</div>
		<div class="clear"></div>

	</div> <!-- end of col2 -->
  </div> <!-- end of content -->
</div> <!-- end of wrap -->

</body>
</html>
