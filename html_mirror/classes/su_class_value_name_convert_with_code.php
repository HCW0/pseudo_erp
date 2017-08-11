<?php

    class su_class_value_name_convert_with_code{

            function su_function_convert_name($conn,$table,$key_field_name,$key_entity,$target_field){

                      $mquery = 'select * from '.$table.' u where u.'.$key_field_name.' = '.$key_entity.';'; 
                      $result_set = mysqli_query($conn,$mquery);
                        if(mysqli_num_rows($result_set)==0) {
                                            echo $mquery;
                                            die ("not existed such field value of master table");
                                                // redirect 추가
                                            }

                            $row = mysqli_fetch_assoc($result_set);
                            return $row["$target_field"];

            }
          

    }

?>