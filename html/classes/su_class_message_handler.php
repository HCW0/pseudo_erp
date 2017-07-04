<?php

    class su_class_message_handler{

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

    }

?>