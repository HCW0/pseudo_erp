<?php

    class su_class_task_table_config{

            function su_function_init_config($conn,$SID,$field_name){

                      $mquery = 'select * from task_document_header_table_config u where u.SID = \''.$SID.'\';'; 
                      $result_set = mysqli_query($conn,$mquery);
                        if(mysqli_num_rows($result_set)==0) {
                                            echo $mquery;
                                            die ("not existed default field value of task table");
                                                // redirect 추가
                                            }

                            $row = mysqli_fetch_assoc($result_set);
                            return $row["$field_name"];

            }

    }

?>