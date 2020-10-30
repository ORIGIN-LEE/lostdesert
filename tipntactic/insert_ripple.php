<?php
   session_start();
?>
<meta charset="utf-8">
<?php
//TODO: 댓글 수정모드 고려
    if(isset($_SESSION['userid']))
        $userid = $_SESSION['userid'] ;
    else
        $userid = "";
    if(isset($_SESSION['username']))
        $username = $_SESSION['username'] ;
    else
        $username = "";
    if(isset($_SESSION['usernick']))
        $usernick = $_SESSION['usernick'] ;
    else
        $usernick = "";

    $num = $_POST['num'];
    $page = $_POST['page'];
    $ripple_content = $_POST['ripple_content'];

    if(!$userid) {
        echo("
            <script>
                window.alert('로그인 후 이용하세요.')
                history.go(-1)
            </script>
        ");
        exit;
    }
    if(!$ripple_content) {
    echo("
        <script>
            window.alert('내용을 입력하세요.')
            history.go(-1)
        </script>
    ");
    exit;
    }

    include "../lib/dbconn.php";       // dconn.php 파일을 불러옴
    mysqli_query($connect, "set session character_set_connection=utf8;");
    mysqli_query($connect, "set session character_set_results=utf8;");
    mysqli_query($connect, "set session character_set_client=utf8;");

    $name = $username;
    $nick = $usernick;
    $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

   // 레코드 삽입 명령
    $sql = "insert into tipntactic_ripple (parent, id, name, nick, content, regist_day)
            values($num, '$userid', '$username', '$usernick', '$ripple_content', '$regist_day')";
   
    mysqli_query($connect, $sql);
    mysqli_close($connect);

    echo "
        <script>
            location.href = 'view.php?num=$num&page=$page';
        </script>
    ";
?>
