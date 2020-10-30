
<meta charset="utf-8">
<?php
   // 이전화면에서 이름이 입력되지 않았으면 "이름을 입력하세요"
   // 메시지 출력
   session_start();
   $id = $_POST['id'];
   $pass = $_POST['pass'];
   
   if(!$id) {
     echo("
           <script>
             window.alert('아이디를 입력하세요.')
             history.go(-1)
           </script>
         ");
         exit;
   }

   if(!$pass) {
     echo("
           <script>
             window.alert('비밀번호를 입력하세요.')
             history.go(-1)
           </script>
         ");
         exit;
   }

    include "../lib/dbconn.php";
	mysqli_query($connect, "set session character_set_connection=utf8;");
    mysqli_query($connect, "set session character_set_results=utf8;");
    mysqli_query($connect, "set session character_set_client=utf8;");

   $sql = "select * from member where id='$id'";
   $result = mysqli_query($connect, $sql);
   $num_match = mysqli_num_rows($result);

   if(!$num_match) 
   {
     echo("
           <script>
             window.alert('등록되지 않은 아이디입니다.')
             history.go(-1)
           </script>
         ");
    }
    else
    {
        $row = mysqli_fetch_array($result);

        $db_pass = $row['pass'];

        if($pass != $db_pass)
        {
           echo("
              <script>
                window.alert('비밀번호가 틀립니다.')
                history.go(-1)
              </script>
           ");

           exit;
        }
        else
        {
			
		   $userid = $row['id'];
		   $username = $row['name'];
		   $usernick = $row['nick'];
		   $userlevel = $row['level'];

           $_SESSION['userid'] = $userid;
           $_SESSION['username'] = $username;
           $_SESSION['usernick'] = $usernick;
           $_SESSION['userlevel'] = $userlevel;

		    echo("
			 <script>   window.alert('로그인합니다.') </script>
			  ");
		    echo("
              <script>
                location.href = '../index.php';
              </script>
           ");
          
        }
   }          
?>
