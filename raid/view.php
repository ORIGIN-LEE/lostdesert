<?php 
	session_start(); 
	
	if(isset($_SESSION['userid']))
		$userid = $_SESSION['userid'];
	else
		$userid ="";
	
	$table = 'raid';
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
    $item_date    = $row['regist_day'];
	//TODO: 파티원 관련 변수
	$item_member1 = $row['member1'];
	$item_member2 = $row['member2'];
	$item_member3 = $row['member3'];
	$item_done    = $row['done'];

	$item_subject = str_replace(" ", "&nbsp;", $row['subject']);
	$item_content = $row['content'];

    $item_content = str_replace(" ", "&nbsp;", $item_content);
    $item_content = str_replace("\n", "<br>", $item_content);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<meta charset="utf-8">
<link href="../css/common.css" rel="stylesheet" type="text/css" media="all">
<link href="../css/board4.css" rel="stylesheet" type="text/css" media="all">
<script>
	function check_input(userid, item_id)
	{
		if (!document.ripple_form.ripple_content.value)
		{
			alert("내용을 입력하세요!");    
			document.ripple_form.ripple_content.focus();
			return;
		}
		if(userid == item_id) {
		    alert("본인이 작성한 파티모집 게시글에는 댓글을 작성할 수 없습니다.");
			return;
		}
		document.ripple_form.submit();
    }

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
	</div>

	<div id="col2">        
		<div id="title">
			<img src="../img/title_raid.jpg">
		</div>

		<div id="view_comment"> &nbsp;</div>
		<div id="view_title">
			<div id="view_title1"><?php echo $item_subject ?></div><div id="view_title2"><?php echo $item_nick ?> | 조회 : <?php //echo $new_hit ?>
			                      | <?php echo $item_date ?> </div>	
		</div>

		<div id="view_content">
			<?php echo $item_content ?>
		</div>

        <div style="height: 66px;">
        <form name="raid_form" method="post" action="insert_raid.php">
        <input type="hidden" name="num" value="<?php echo $item_num?>">
            <div style="width: 240px; height: 66px; float: left; ">
                파티원 1 :
<?php
	    $sql = "select * from raid_ripple where parent='$item_num'";
	    $ripple_result = mysqli_query($connect, $sql);
	    $ripple_num = mysqli_num_rows($ripple_result);

        if($userid == $item_id) {
            if(!$item_member1) {
?>
                <select class="hp" name="member1">
                    <option value=''>&nbsp&nbsp&nbsp&nbsp&nbsp</option>
                <?php while($row_ripple = mysqli_fetch_array($ripple_result)) { ?>
                        <option value='<?php echo $row_ripple['nick'] ?>'><?php echo $row_ripple['nick'] ?></option>
                <?php } ?>
                </select>
<?php
            } else {
?>
                <input type='hidden' name='member1' value='<?php echo $item_member1?>'>
                <?php echo $item_member1?>
<?php
            }
        } else {
            if($item_member1) {
                echo $item_member1;
            } else {
                echo "파티원 모집중";
            }
        }
?>
            </div>
            <div style="width: 240px; height: 66px; float: left; margin-left: 5px;">
                파티원 2 :
<?php
        mysqli_data_seek($ripple_result, 0);
        if($userid == $item_id) {
            if(!$item_member2) {
?>
                <select class="hp" name="member2">
                    <option value=''>&nbsp&nbsp&nbsp&nbsp&nbsp</option>
                <?php while($row_ripple = mysqli_fetch_array($ripple_result)) { ?>
                        <option value='<?php echo $row_ripple['nick'] ?>'><?php echo $row_ripple['nick'] ?></option>
                <?php } ?>
                </select>
<?php
        } else {
?>
                <input type='hidden' name='member1' value='<?php echo $item_member1?>'>
                <?php echo $item_member2?>
<?php
            }
        } else {
            if($item_member2) {
                echo $item_member2;
            } else {
                echo "파티원 모집중";
            }
        }
?>
            </div>
            <div style="width: 240px; height: 66px; float: left; margin-left: 5px;">
                파티원 3 :
<?php
        mysqli_data_seek($ripple_result, 0);
        if($userid == $item_id) {
            if(!$item_member3) {
?>
                <select class="hp" name="member3">
                    <option value=''>&nbsp&nbsp&nbsp&nbsp&nbsp</option>
                <?php while($row_ripple = mysqli_fetch_array($ripple_result)) { ?>
                        <option value='<?php echo $row_ripple['nick'] ?>'><?php echo $row_ripple['nick'] ?></option>
                <?php } ?>
                </select>
<?php
        } else {
?>
                <input type='hidden' name='member1' value='<?php echo $item_member1?>'>
                <?php echo $item_member3?>
<?php
            }
        } else {
            if($item_member3) {
                echo $item_member3;
            } else {
                echo "파티원 모집중";
            }
        }
?>
            </div>
            <div class="hor_line_ripple"></div>
<?php
        if($userid == $item_id && $item_done == 'n') {
?>
        <input type='image' name='submit' src='../img/ok.png' style="margin-top: 25px;">
<?php
        }
?>
        </form>
        </div>

		<div id="ripple">
        <form  name="ripple_form" method="post" action="insert_ripple.php">
        <input type="hidden" name="num" value="<?php echo $item_num?>">
        <input type="hidden" name="page" value="<?php echo $page?>">

        <div id="ripple_box">
            <div id="ripple_box1"><img src="../img/title_comment.gif"></div>
            <div id="ripple_box2"><textarea rows="5" cols="65" name="ripple_content"></textarea>
            </div>
            <div id="ripple_box3"><a href="#"><img src="../img/ok_ripple.gif"  onclick="check_input('<?php echo $userid?>', '<?php echo $item_id?>')"></a></div>
        </div>
        </form>
<?php
        $sql = "select * from raid_ripple where parent='$item_num'";
        $ripple_result = mysqli_query($connect, $sql);
	    //mysqli_data_seek($ripple_result, 0);

		while ($row_ripple = mysqli_fetch_array($ripple_result))
		{
			$ripple_num     = $row_ripple['num'];
			$ripple_id      = $row_ripple['id'];
			$ripple_nick    = $row_ripple['nick'];
			$ripple_content = str_replace("\n", "<br>", $row_ripple['content']);
			$ripple_content = str_replace(" ", "&nbsp;", $ripple_content);
			$ripple_date    = $row_ripple['regist_day'];
?>
			<div id="ripple_writer_title">
			<ul>
			<li id="writer_title1"><?php echo $ripple_nick?></li>
			<li id="writer_title2"><?php echo $ripple_date?></li>
			<li id="writer_title3"> 
		      <?php 
					if($userid=="admin" || $userid==$ripple_id)
			            echo "<a href='delete_ripple.php?num=$item_num&ripple_num=$ripple_num&page=$page'>[삭제]</a>";
			  ?>
			</li>
			</ul>
			</div>
			<div id="ripple_content"><?php echo $ripple_content?></div>
			<div class="hor_line_ripple"></div>
<?php
		}
?>
		</div> <!-- end of ripple -->

		<div id="view_button">
				<a href="list.php?page=<?php echo $page?>"><img src="../img/list.png"></a>&nbsp;
<?php 
	if($userid==$item_id || $userid == 'admin')
	{
?>
				<a href="write_form.php?mode=modify&num=<?php echo $num?>&page=<?php echo $page?>"><img src="../img/modify.png"></a>&nbsp;
				<a href="javascript:del('delete.php?num=<?php echo $num?>')"><img src="../img/delete.png"></a>&nbsp;
<?php
	}
?>
<?php 
	if($userid)
	{
?>
				<a href="write_form.php?"><img src="../img/write.png"></a>
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
