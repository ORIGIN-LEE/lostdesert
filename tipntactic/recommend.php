<?php
    session_start();
    $num = $_GET['num'];
    $page = $_GET['page'];
    $rec = $_GET['rec'];
    $Nrec = $_GET['Nrec'];

    include "../lib/dbconn.php";

    $sql = "select * from tipntactic where num = $num";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($result);

    $sql = "update tipntactic set REC = '$rec', not_rec = '$Nrec' where num=$num";
    mysqli_query($connect, $sql);
    mysqli_close($connect);

    echo "
        <script>
            history.go(-1)
            //location.href = 'view.php?num=$num&page=$page';
        </script>
    ";
?>

