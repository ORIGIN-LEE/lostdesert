<?php
   session_start();
   $table = 'raid';
   $num = $_GET['num'];
   
   include "../lib/dbconn.php";

   $sql = "delete from $table where num = $num";
   mysqli_query($connect, $sql);

   mysqli_close($connect);

   echo "
	   <script>
	    location.href = 'list.php?';
	   </script>
	";
?>

