<?php
    $num = $_GET['num'];
    $ripple_num=$_GET['ripple_num'];
    $page = $_GET['page'];
	  
    include "../lib/dbconn.php";

    $sql = "delete from tipntactic_ripple where num=$ripple_num";
    mysqli_query($connect, $sql);
    mysqli_close($connect);

    echo "
        <script>
            location.href = 'view.php?num=$num&page=$page';
        </script>
    ";
	 
?>
