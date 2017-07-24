<?php
    class su_class_message_handler{
            function su_function_call_message_callback($conn,$message_code){
                      $mquery = 'select * from message_table u where u.MSG_CODE = \''.$message_code.'\';'; 
                      $result_set = mysqli_query($conn,$mquery);
                        if(mysqli_num_rows($result_set)==0) {
                                            die ("not existed error code");
                                                // redirect 추가
                                            }
                            $row = mysqli_fetch_assoc($result_set);
                            $message_view = $row['MSG_CONTENTS'];
      
                                
                              echo "<script>alert($message_view);";
                              echo '</script>';
                              
            }
            function su_function_call_message($conn,$message_code,$next_stage){
                      $mquery = 'select * from message_table u where u.MSG_CODE = \''.$message_code.'\';'; 
                      $result_set = mysqli_query($conn,$mquery);
                        if(mysqli_num_rows($result_set)==0) {
                                            die ("not existed error code");
                                                // redirect 추가
                                            }
                            $row = mysqli_fetch_assoc($result_set);
                            $message_view = $row['MSG_CONTENTS'];
      
                                
                              echo "<script>alert($message_view);";
                              echo 'window.location = "';
                              echo $next_stage;
                              echo '.php"';
                              echo '</script>';
                              
            }
            function su_function_call_message_with_one_parameter($conn,$message_code,$next_stage,$value){
                      $mquery = 'select * from message_table u where u.MSG_CODE = \''.$message_code.'\';'; 
                      $result_set = mysqli_query($conn,$mquery);
                        if(mysqli_num_rows($result_set)==0) {
                                            die ("not existed error code");
                                                // redirect 추가
                                            }
                            $row = mysqli_fetch_assoc($result_set);
                            $message_view = $row['MSG_CONTENTS'];
      
                                
                              echo "<script>alert($message_view  +  $value);";
                              echo 'window.location = "';
                              echo $next_stage;
                              echo '.php"';
                              echo '</script>';
                              
            }



            function su_function_call_confirm_message_yes_next($conn,$message_code,$next_stage){
                      $mquery = 'select * from message_table u where u.MSG_CODE = \''.$message_code.'\';'; 
                      $result_set = mysqli_query($conn,$mquery);
                        if(mysqli_num_rows($result_set)==0) {
                                            die ("not existed error code");
                                                // redirect 추가
                                            }
                            $row = mysqli_fetch_assoc($result_set);
                            $message_view = $row['MSG_CONTENTS'];
      
                                
                              echo "<script> var reply = confirm(".$message_view.");";
                              echo "if(reply == true)";
                              echo 'window.location = "';
                              echo $next_stage;
                              echo '.php";';
                              echo '</script>';
                              
            }
            


            function su_function_call_confirm_message_no_next_binary($conn,$message_code,$next_stage,$var,$var2){
                      $mquery = 'select * from message_table u where u.MSG_CODE = \''.$message_code.'\';'; 
                      $result_set = mysqli_query($conn,$mquery);
                        if(mysqli_num_rows($result_set)==0) {
                                            die ("not existed error code");
                                                // redirect 추가
                                            }
                            $row = mysqli_fetch_assoc($result_set);
                            $message_view = $row['MSG_CONTENTS'];
      
                                
                              echo "<script> var reply = confirm(".$message_view.");";
                              echo "if(reply == true){";
                              echo "window.location = '";
                              echo $next_stage."?valid=".$var."';}else{";
                              echo "window.location = '";
                              echo $next_stage."?valid=".$var2."';}";
                              echo '</script>';
                              
            }
            
            function su_function_call_confirm_message_no_next($conn,$message_code,$next_stage){
                      $mquery = 'select * from message_table u where u.MSG_CODE = \''.$message_code.'\';'; 
                      $result_set = mysqli_query($conn,$mquery);
                        if(mysqli_num_rows($result_set)==0) {
                                            die ("not existed error code");
                                                // redirect 추가
                                            }
                            $row = mysqli_fetch_assoc($result_set);
                            $message_view = $row['MSG_CONTENTS'];
      
                                
                              echo "<script> var reply = confirm(".$message_view.");";
                              echo "if(reply == false)";
                              echo 'window.location = "';
                              echo $next_stage;
                              echo '.php";';
                              echo '</script>';
                              
            }

    }
?>