<?php 
	session_start(); 
	$table = "download";
	if(isset($_SESSION['userid']))
		$userid = $_SESSION['userid'];
	else
		$userid ="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<meta charset="utf-8">
<link href="../css/common.css" rel="stylesheet" type="text/css" media="all">
<link href="../css/board3.css" rel="stylesheet" type="text/css" media="all">
</head>
<?php
	if(!isset($_POST['mode']))
		$mode = "normal";
	else
	{
		$mode = $_POST['mode'];
		$search =$_POST['search'];
		$find =$_POST['find'];
	}
	if(!isset($_GET['page']))
		$page = 1;
	else
		$page = $_GET['page'];
	
	include "../lib/dbconn.php";
	mysqli_query($connect, "set session character_set_connection=utf8;");		 
    mysqli_query($connect, "set session character_set_results=utf8;");		 
    mysqli_query($connect, "set session character_set_client=utf8;");

	$scale=10;			// 한 화면에 표시되는 글 수

    if ($mode=="search")
	{
		if(!$search)
		{
			echo("
				<script>
				 window.alert('검색할 단어를 입력해 주세요!');
			     history.go(-1);
				</script>
			");
			exit;
		}

		$sql = "select * from $table where $find like '%$search%' order by num desc";
	}
	else
	{
		$sql = "select * from $table order by num desc";
	}

	$result = mysqli_query($connect, $sql);
	$total_record = mysqli_num_rows($result); // 전체 글 수

	// 전체 페이지 수($total_page) 계산 
	if ($total_record % $scale == 0)     
		$total_page = floor($total_record/$scale);      
	else
		$total_page = floor($total_record/$scale) + 1; 
 
	if (!$total_record)                 // 페이지번호($page)가 0 일 때
		$page = 1;              // 페이지 번호를 1로 초기화
 
	// 표시할 페이지($page)에 따라 $start 계산  
	$start = ($page - 1) * $scale;      
	$number = $total_record - $start;
?>
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
	</div>

	<div id="col2">        
		<div id="title">
			<img src="../img/title_item.jpg">
		</div>

		<form  name="board_form" method="post" action="list.php"> 
		<input type="hidden" name="mode" value="search">
		<div id="list_search">
			<div id="list_search1">▷ 총 <?php echo  $total_record ?> 개의 게시물이 있습니다.  </div>
			<div id="list_search2"><img src="../img/select_search.gif"></div>
			<div id="list_search3">
				<select name="find">
                    <option value='subject'>제목</option>
                    <option value='content'>내용</option>
                    <option value='nick'>별명</option>
                    <option value='name'>이름</option>
				</select></div>
			<div id="list_search4"><input type="text" name="search"></div>
			<div id="list_search5"><input type="image" src="../img/list_search_button.gif"></div>
		</div>
		</form>

		<div class="clear"></div>

		<div id="list_top_title">
			<ul>
				<li id="list_title1"><img src="../img/list_title1.gif"></li>
				<li id="list_title2"><img src="../img/list_title2.gif"></li>
				<li id="list_title3"><img src="../img/list_title3.gif"></li>
				<li id="list_title4"><img src="../img/list_title4.gif"></li>
				<li id="list_title5"><img src="../img/list_title5.gif"></li>
			</ul>		
		</div>

		<div id="list_content">
<?php		
   for ($i=$start; $i<$start+$scale && $i < $total_record; $i++)                    
   {
      mysqli_data_seek($result, $i);       
      // 가져올 레코드로 위치(포인터) 이동  
      $row = mysqli_fetch_array($result);       
      // 하나의 레코드 가져오기
	
	  $item_num     = $row['num'];
	  $item_id      = $row['id'];
	  $item_name    = $row['name'];
  	  $item_nick    = $row['nick'];
	  $item_hit     = $row['hit'];

      $item_date    = $row['regist_day'];
	  $item_date = substr($item_date, 0, 10);  

	  $item_subject = str_replace(" ", "&nbsp;", $row['subject']);
?>
			<div id="list_item">
				<div id="list_item1"><?php echo $number ?></div>
				<div id="list_item2"><a href="view.php?table=<?php echo $table?>&num=<?php echo $item_num?>&page=<?php echo $page?>"><?php echo $item_subject ?></a></div>
				<div id="list_item3"><?php echo $item_nick ?></div>
				<div id="list_item4"><?php echo $item_date ?></div>
				<div id="list_item5"><?php echo $item_hit ?></div>
			</div>
<?php
   	   $number--;
   }
    mysqli_close($connect);
?>
			<div id="page_button">
				<div id="page_num"> ◀ 이전 &nbsp;&nbsp;&nbsp;&nbsp; 
<?php
   // 게시판 목록 하단에 페이지 링크 번호 출력
   for ($i=1; $i<=$total_page; $i++)
   {
		if ($page == $i)     // 현재 페이지 번호 링크 안함
		{
			echo "<b> $i </b>";
		}
		else
		{ 
			echo "<a href='list.php?table=$table&page=$i'> $i </a>";
		}      
   }
?>			
			&nbsp;&nbsp;&nbsp;&nbsp;다음 ▶
				</div>
				<div id="button">
					<a href="list.php?page=<?php echo $page?>"><img src="../img/list.png"></a>&nbsp;
<?php 
	if($userid == 'admin')
	{
?>
		<a href="write_form.php?table=<?php echo $table?>"><img src="../img/write.png"></a>
<?php
	}
?>
				</div>
			</div> <!-- end of page_button -->
		
        </div> <!-- end of list content -->

		<div class="clear"></div>

	</div> <!-- end of col2 -->
  </div> <!-- end of content -->
</div> <!-- end of wrap -->

</body>
</html>
