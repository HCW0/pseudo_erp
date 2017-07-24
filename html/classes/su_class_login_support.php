<?php
    class su_class_login_support{

        function incorrect_cnt($id,$conn,$ob){
            
            $mquery = 'select * from account_table u where u.ID = \''.$id.'\';';
            $result = mysqli_query($conn,$mquery);
            
            $row = mysqli_fetch_assoc($result);
            $flag_Value = $row['PASSWORD_INCORRECT_COUNTER'];
            
             

            if($row['PASSWORD_INCORRECT_COUNTER']<5){
                $mquery = 'update account_table set PASSWORD_INCORRECT_COUNTER = PASSWORD_INCORRECT_COUNTER+1 where ID = \''.$id.'\';';
                $result = mysqli_query($conn,$mquery);
            }

           if($row['PASSWORD_INCORRECT_COUNTER']==5){
                 $mquery = 'update account_table set FLAG_ACCOUNT_LOCK = 1 where ID = \''.$id.'\';';
                $result = mysqli_query($conn,$mquery);

            }
            $var = 5-$row['PASSWORD_INCORRECT_COUNTER'];
            $ob->su_function_call_message_with_one_parameter($conn,154,'su_script_login_interface',$var);
            
        


        }


    }
?>