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



		
    $task_title = $_POST['task_select_box'][0];
    $task_level = $_POST['task_select_box'][1];
    $task_priority = $_POST['task_select_box'][2];
    $task_sub_level = $_POST['task_select_box'][3];
    $task_state = $_POST['task_select_box'][4];
    $task_base_date = $_POST['task_select_box'][5];
    $task_limit_date = $_POST['task_select_box'][6];
    $task_base_elapsed_date = $_POST['task_select_box'][7];
    $task_limit_elapsed_date = $_POST['task_select_box'][8];     
    $my_name_code =  $_SESSION['my_sid_code'];
    $my_department_code = $_SESSION['my_department_code'];
    $my_position_code = $_SESSION['my_position_code'];
    $last_checker_SID = $_POST['task_select_box'][9]; 
    $task_index_contents = $_POST['task_select_box'][10]; 

    $ob2 = new su_class_value_name_convert_with_code();
    $last_checker_position = $ob2->su_function_convert_name($conn,"sid_combine_table","SID",$last_checker_SID,"sid_combine_position");

    $msg_ob = new su_class_message_handler();
  
    if($task_title==''||$task_base_date==''||$task_limit_date==''||$task_base_elapsed_date==''||$task_limit_elapsed_date==''){
              echo "uninvalid input error in task add module";
              echo "<br />";
              
              $msg_ob->su_function_call_message($conn,514,'su_script_table_write_interface');

    }
    else{      

            $date = date("Y-m-d");
    	    $task_table_query = "Insert into task_document_header_table(task_level_code,task_level_sub_code,task_name,task_order_section,task_order_position,task_orderer,task_priority,task_base_date,task_limit_date,task_elapsed_base_date,task_elapsed_limit_date,task_state,task_birth_date) Values($task_level,$task_sub_level,'$task_title',$my_department_code,$my_position_code,$my_name_code,$task_priority,'$task_base_date','$task_limit_date','$task_base_elapsed_date','$task_limit_elapsed_date',$task_state,'$date');";      
            
   
           $result_set = mysqli_query($conn,$task_table_query);
           $task_table_query2 = "select MAX(TID) as Max from task_document_header_table;";
           $result_set2 = mysqli_query($conn,$task_table_query2);
            $row=mysqli_fetch_array($result_set2);
            $up_page_TID = $row['Max'];
            


            //결제 경로에서 공석인 자리를 건너 뛰는 로직
            //출장 등의 공석 역시 표현해야 하므로, 기본적으로 빈 공석은 모두 계정을 생성하여 is_valid flag를 set해놓아야한다.
                $offset = 1;
                while(true){
                $task_table_query_jump = "select is_valid from sid_combine_table u where u.sid_combine_department = $my_department_code AND u.sid_combine_position = $my_position_code+$offset;";
                $result_jump = mysqli_query($conn,$task_table_query_jump);
                $row_jump=mysqli_fetch_array($result_jump);
                    if(($my_position_code+$offset)<8&&$row_jump['is_valid']==0){
                        $offset+=1;
                    }else{
                        break;
                    }
                }

           $task_detail_table_query = "Insert into task_approbation_table(TID,task_order_section,task_sequence_start,task_sequence_current,task_sequence_end) Values($up_page_TID,$my_department_code,$my_position_code,$my_position_code+$offset,$last_checker_position);";
           mysqli_query($conn,$task_detail_table_query);
           echo $task_detail_table_query;
           echo "<br />";
           $task_detail_table_query2 = "update task_approbation_table set task_sq_$my_position_code"."layer_message = '$task_index_contents' where TID = $up_page_TID;";
           echo $task_detail_table_query2;
           mysqli_query($conn,$task_detail_table_query2);
           $msg_ob->su_function_call_message_callback($conn,515);
           echo "<script> self.close(); </script>"; 

    };
    ?>

