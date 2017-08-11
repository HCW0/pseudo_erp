<?php


// 서버 점검 확인 파트
        $msg_ob = new su_class_message_handler();
         $flag = 'shut_down';
         $mquery = 'select * from server_state_table u where u.FLAG_NAME = \''.$flag.'\';';
         $result_set = mysqli_query($conn,$mquery);
         $row = mysqli_fetch_assoc($result_set);
         $flag_Value = $row['FLAG_VALUE'];
         if($flag_Value) {
              
              $msg_ob->su_function_call_message($conn,334,'su_script_login_interface');
         
          die();   
         }
?>
