<?php
   function latest_article($table, $loop, $char_limit) 
   {
		include "dbconn.php";
		mysqli_query($connect, "set session character_set_connection=utf8;");		 
		mysqli_query($connect, "set session character_set_results=utf8;");		 
		mysqli_query($connect, "set session character_set_client=utf8;");


		$sql = "select * from $table order by num desc limit $loop";
		$result = mysqli_query($connect, $sql);
		

		while ($row = mysqli_fetch_array($result))
		{
			$num = $row['num'];
			$len_subject = strlen($row['subject']);
			$subject = $row['subject'];

			if ($len_subject > $char_limit)
			{
				$subject = mb_substr($row['subject'], 0, $char_limit, 'euc-kr');
				$subject = $subject."...";
			}

			$regist_day = substr($row['regist_day'], 0, 10);

			echo "      
				<div class='col1'><a href='./$table/view.php?table=$table&num=$num&page=1'>$subject</a></div> <div class='col2'>$regist_day</div>
				<div class='clear'></div>
			";
		}
		mysqli_close($connect);
   }
?>