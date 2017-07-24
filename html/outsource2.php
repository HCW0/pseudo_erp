  <?php
       session_start();


           // 유저 세션 검증
	if(!isset($_SESSION['is_login'])){
		header('Location: ./su_script_logout_support.php');
	};


// include function
     function my_autoloader($class){
         include './classes/'.$class.'.php';
    }

 spl_autoload_register('my_autoloader');


//db 연결 파트
        $conn = mysqli_connect('localhost','root','9708258a');
        if(!$conn) { $_SESSION['msg']='DB연결에 실패하였습니다.';
                     header('Location: ./su_script_login_interface.php');
        }
        $use = mysqli_select_db($conn,"suproject");
        if(!$use) die('cannot open db'.mysqli_error($conn));



	$task_level = $_SESSION['hold_level'];
    $task_sub_level = $_SESSION['sub_hold_level'];
    $task_title = $_POST['task_select_box'][0];
    $task_priority = $_POST['task_select_box'][1];
    $task_state = $_POST['task_select_box'][2];

    $task_base_date = $_POST['task_select_box'][3];
    $task_limit_date = $_POST['task_select_box'][4];

    $task_base_elapsed_date = $_POST['task_select_box'][5];
    $task_limit_elapsed_date = $_POST['task_select_box'][5];

    $path_number = $_POST['task_select_box'][6]; 
    $task_index_contents = $_POST['task_select_box'][7]; 

    $my_name_code =  $_SESSION['my_sid_code'];
    $my_department_code = $_SESSION['my_department_code'];
    $my_position_code = $_SESSION['my_position_code'];


     $upper_task_id = $_POST['sub_task_select_box'][0];
     

    //debug
    echo "<br />";
    echo "task_title";
    echo "<br />";
    echo $task_title;
    
    echo "<br />";
    echo "task_level";
    echo "<br />";
    echo $task_level;

    echo "<br />";
    echo "task_priority";
    echo "<br />";
    echo $task_priority;

    echo "<br />";
    echo "task_sub_level";
    echo "<br />";
    echo $task_sub_level;

    echo "<br />";
    echo "task_state";
    echo "<br />";
    echo $task_state;
   
    echo "<br />";
    echo "date / e-date";
    echo "<br />";
    echo $task_base_date;
    echo "<br />";
    echo $task_limit_date;
    echo "<br />";
    echo $task_base_elapsed_date;
    echo "<br />";
    echo $task_limit_elapsed_date;
    
    echo "<br />";
    echo "path num";
    echo "<br />";
    echo $path_number;
    echo "<br />";
    echo "contents";
    echo $task_index_contents;
    echo "<br />";
    echo "upper";
    echo $upper_task_id;
    echo "<br />";


    $my_name_code =  $_SESSION['my_sid_code'];
    $my_department_code = $_SESSION['my_department_code'];
    $my_position_code = $_SESSION['my_position_code'];






    $ob2 = new su_class_value_name_convert_with_code();


    $msg_ob = new su_class_message_handler();
  
    if($path_number==''||$task_title==''||$task_base_date==''||$task_limit_date==''||$task_base_elapsed_date==''||$task_sub_level==''){
              echo "uninvalid input error in task add module";
              echo "<br />";
              
              $msg_ob->su_function_call_message($conn,514,'su_script_table_write_interface');

    }
    else if($task_base_date>$task_limit_date){
              $msg_ob->su_function_call_message($conn,513,'su_script_table_write_interface');
    }
    else if(($task_base_elapsed_date>$task_limit_date) || ($task_base_elapsed_date<$task_base_date)){
              $msg_ob->su_function_call_message($conn,513,'su_script_table_write_interface');
    }
    else{      

            $date = date("Y-m-d");
    	    $task_table_query = "Insert into task_document_header_table(task_level_code,task_level_sub_code,task_name,task_order_section,task_order_position,task_orderer,task_priority,task_base_date,task_limit_date,task_elapsed_base_date,task_elapsed_limit_date,task_state,task_birth_date) Values($task_level,$task_sub_level,'$task_title',$my_department_code,$my_position_code,$my_name_code,$task_priority,'$task_base_date','$task_limit_date','$task_base_elapsed_date','$task_limit_elapsed_date',$task_state,'$date');";      
            echo $task_table_query;
            echo "<br />";
   
           $result_set = mysqli_query($conn,$task_table_query);
           $task_table_query2 = "select MAX(TID) as Max from task_document_header_table;";
           $result_set2 = mysqli_query($conn,$task_table_query2);
            $row=mysqli_fetch_array($result_set2);
            $up_page_TID = $row['Max'];
            


            //결제 경로에서 공석인 자리를 건너 뛰는 로직
            //출장 등의 공석 역시 표현해야 하므로, 기본적으로 빈 공석은 모두 계정을 생성하여 is_valid flag를 set해놓아야한다.
           $min_find_query = "select * from task_approbation_path_table where sid=".$_SESSION['my_sid_code']." AND key_index = $path_number;";
           $result_min = mysqli_query($conn,$min_find_query);
           $row_min = mysqli_fetch_array($result_min);
           $min = $row_min['min_sid'];
           $end_sid = $row_min['end_user_sid'];

           $end = $ob2->su_function_convert_name($conn,"sid_combine_table","SID",$end_sid,"sid_combine_position");
           $task_detail_table_query = "Insert into task_approbation_table(TID,task_order_section,key_index,appro_state,last_appro_date,current_sid,first_order,end_order) Values($up_page_TID,$my_department_code,$path_number,0,'".$_SESSION['now_date']."',$min,".$_SESSION['my_position_code'].",$end);";
           mysqli_query($conn,$task_detail_table_query);
           echo $task_detail_table_query;
           echo "<br />";

           if($upper_task_id=='') $upper_task_id = $up_page_TID;
           $task_detail_table_query2 = "update task_approbation_table set task_sq_$my_position_code"."layer_message = '$task_index_contents' where TID = $up_page_TID;";
           $task_detail_table_query3 = "update task_document_header_table set super_task_TID = ".$upper_task_id." where TID = $up_page_TID;";

           echo $task_detail_table_query2;
           echo "<br />";
           echo $task_detail_table_query3;
           echo "<br />";

           mysqli_query($conn,$task_detail_table_query2);
           mysqli_query($conn,$task_detail_table_query3);
           $msg_ob->su_function_call_message_callback($conn,515);
           echo "<script> opener.location.reload(); </script>";
           echo "<script> self.close(); </script>"; 

    };
    ?>

