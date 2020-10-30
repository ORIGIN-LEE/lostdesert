<?php
    $db_json = file_get_contents('config.json')
    $db_config = json_decode($db_json, true);
    $connect=mysqli_connect( $db_config['host'], $db_config['username'], $db_config['password'], $db_config['dbname'], $db_config['port']) or
        die( "SQL server에 연결할 수 없습니다.");
?>
