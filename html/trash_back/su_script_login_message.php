<?php
session_start();

//db 연결 파트
        $conn = mysqli_connect('localhost','root','9708258a');
        
//메시지 정보 로드 파트
        $use = mysqli_select_db($conn,"suproject");
        if(!$use) die('cannot open db : '.mysqli_error($conn));

        $mquery = 'select * from message_table u where u.MSG_CODE = \''.$_SESSION['msg_code'].'\';';
    
        $result_set = mysqli_query($conn,$mquery);
        if(mysqli_num_rows($result_set)==0) die ("not existed error code");
       
        $row = mysqli_fetch_assoc($result_set);
        $err_view = $row['MSG_CONTENTS'];
      

         echo "<script>alert(\" $err_view\");";
         echo 'window.location= "./su_script_login_interface.php"';
         echo '</script>';
        


?>