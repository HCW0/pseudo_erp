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


    $msg_ob = new su_class_message_handler();
    $selected_path = -1; // 뭐가 선택될지, 결제 경로 생성단계에서는 알 수 없다.
    $start_sid = $_SESSION['my_sid_code'];
	$end_sid = $_POST['end_master_user'];
    
   
        if(isset($_POST['1layer_sid'])) $layer_1_sid = $_POST['1layer_sid'];
        if(isset($_POST['2layer_sid'])) $layer_2_sid = $_POST['2layer_sid'];
        if(isset($_POST['3layer_sid'])) $layer_3_sid = $_POST['3layer_sid'];
        if(isset($_POST['4layer_sid'])) $layer_4_sid = $_POST['4layer_sid'];
        if(isset($_POST['5layer_sid'])) $layer_5_sid = $_POST['5layer_sid'];
        if(isset($_POST['6layer_sid'])) $layer_6_sid = $_POST['6layer_sid'];
        if(isset($_POST['7layer_sid'])) $layer_7_sid = $_POST['7layer_sid'];
            echo "<br />";
    
      

    // 경로 중복 체크 ~ 이미 있는 경로라면 경고메시지를 출력하고 뒤로 돌려보내야함.$_COOKIE


        $query_head_element = "select * from task_approbation_path_table where sid=$start_sid AND end_user_sid=$end_sid AND ";
         if(isset($layer_1_sid)){
                    $query_1 = "1_layer_aida_sid = $layer_1_sid AND ";
                    $query_head_element = $query_head_element.$query_1;
                    echo "<br />";
                    }
            if(isset($layer_2_sid)){
                    $query_2 = "2_layer_aida_sid = $layer_2_sid AND ";
                    $query_head_element = $query_head_element.$query_2;
                    echo "<br />";
                    }
            if(isset($layer_3_sid)){
                    $query_3 = "3_layer_aida_sid = $layer_3_sid AND ";
                    $query_head_element = $query_head_element.$query_3;
                    echo "<br />";
                    }
            if(isset($layer_4_sid)){
                    $query_4 = "4_layer_aida_sid = $layer_4_sid AND ";
                    $query_head_element = $query_head_element.$query_4;
                    echo "<br />";
                    }
            if(isset($layer_5_sid)){
                    $query_5 = "5_layer_aida_sid = $layer_5_sid AND ";
                    $query_head_element = $query_head_element.$query_5;
                    echo "<br />";
                    }
            if(isset($layer_6_sid)){
                    $query_6 = "6_layer_aida_sid = $layer_6_sid AND ";
                    $query_head_element = $query_head_element.$query_6;
                    echo "<br />";
                    }
            if(isset($layer_7_sid)){
                    $query_7 = "7_layer_aida_sid = $layer_7_sid AND ";
                    $query_head_element = $query_head_element.$query_7;
                    echo "<br />";
                    }

            $cut_point = mb_strlen($query_head_element, 'utf-8');
            $query_head_element = substr($query_head_element,0,$cut_point-4);
            $query_head_element = $query_head_element.';';
            $result = mysqli_query($conn,$query_head_element);
            if(mysqli_num_rows($result)!=0){
                        $msg_ob->su_function_call_message($conn,613,'su_script_table_write_interface');
                       
            }else{

           
    
   
    


    
	$task_level = $_SESSION['hold_level'];
    $task_sub_level = $_SESSION['sub_hold_level'];
    $task_title = $_POST['task_select_box'][0];
    $task_priority = $_POST['task_select_box'][1];
    $task_state = $_POST['task_select_box'][2];

    $task_base_date = $_POST['task_select_box'][3];
    $task_limit_date = $_POST['task_select_box'][4];

    $task_base_elapsed_date = $_POST['task_select_box'][5];
    $task_limit_elapsed_date = $_POST['task_select_box'][5];

    $task_index_contents = $_POST['task_select_box'][6]; 

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

    
  
    if($task_title==''||$task_base_date==''||$task_limit_date==''||$task_base_elapsed_date==''||$task_sub_level==''){
              echo "uninvalid input error in task add module";
              echo "<br />";
              
              $msg_ob->su_function_call_message($conn,514,'su_script_table_write_interface_ura');

    }
    else if($task_base_date>$task_limit_date){
              $msg_ob->su_function_call_message($conn,513,'su_script_table_write_interface_ura');
    }
    else if(($task_base_elapsed_date>$task_limit_date) || ($task_base_elapsed_date<$task_base_date)){
              $msg_ob->su_function_call_message($conn,513,'su_script_table_write_interface_ura');
    }
    else{





 // 절대 경로 테이블에 새로운 결제 정보를 추가하는 로직
           $task_detail_table_query = "select * from task_approbation_path_table where sid=$start_sid;";
           $result_path_query = mysqli_query($conn,$task_detail_table_query);
           $key_max = 0;
           if(mysqli_num_rows($result_path_query)==0){
                //해당 sid의 결제 정보가 없는 경우에
                $task_detail_table_query = "Insert into task_approbation_path_table(SID,key_index,end_user_sid) Values($start_sid,0,$end_sid);";
               echo $task_detail_table_query;
                mysqli_query($conn,$task_detail_table_query);

                
           }else{
           $task_detail_table_query = "select MAX(key_index) as maxx from task_approbation_path_table where sid=$start_sid;";
           echo $task_detail_table_query;
           $result_path_query = mysqli_query($conn,$task_detail_table_query);
           $row=mysqli_fetch_array($result_path_query);
           $key_max = $row['maxx']+1;
            $task_detail_table_query = "Insert into task_approbation_path_table(SID,key_index,end_user_sid) Values($start_sid,$key_max,$end_sid);";
               echo $task_detail_table_query;
                mysqli_query($conn,$task_detail_table_query);
           }

            $selected_path = $key_max;


            $query_head_element = "Update task_approbation_path_table set ";
            
            $min = 514;
            if(isset($layer_1_sid)){
                    $query_1 = "1_layer_aida_sid = $layer_1_sid,";
                    $query_head_element = $query_head_element.$query_1;
                    echo "<br />";
                    if($min>1) $min=1;
                    }
            if(isset($layer_2_sid)){
                    $query_2 = "2_layer_aida_sid = $layer_2_sid,";
                    $query_head_element = $query_head_element.$query_2;
                    echo "<br />";
                    if($min>2) $min=2;
                    }
            if(isset($layer_3_sid)){
                    $query_3 = "3_layer_aida_sid = $layer_3_sid,";
                    $query_head_element = $query_head_element.$query_3;
                    echo "<br />";
                    if($min>3) $min=3;
                    }
            if(isset($layer_4_sid)){
                    $query_4 = "4_layer_aida_sid = $layer_4_sid,";
                    $query_head_element = $query_head_element.$query_4;
                    echo "<br />";
                    if($min>4) $min=4;
                    }
            if(isset($layer_5_sid)){
                    $query_5 = "5_layer_aida_sid = $layer_5_sid,";
                    $query_head_element = $query_head_element.$query_5;
                    echo "<br />";
                    if($min>5) $min=5;
                    }
            if(isset($layer_6_sid)){
                    $query_6 = "6_layer_aida_sid = $layer_6_sid,";
                    $query_head_element = $query_head_element.$query_6;
                    echo "<br />";
                    if($min>6) $min=6;
                    }
            if(isset($layer_7_sid)){
                    $query_7 = "7_layer_aida_sid = $layer_7_sid,";
                    $query_head_element = $query_head_element.$query_7;
                    echo "<br />";
                    if($min>7) $min=7;
                    }
        $query_tail_element = ", key_index = $key_max , min_sid = $min where SID=$start_sid AND key_index=$key_max;";
                    

            $cut_point = mb_strlen($query_head_element, 'utf-8');
            $query_head_element = substr($query_head_element,0,$cut_point-1);
            $query_combined = $query_head_element.$query_tail_element;
            echo $query_combined;
            mysqli_query($conn,$query_combined);
  



























            $date = date("Y-m-d");
    	    $task_table_query = "Insert into task_document_header_table(task_level_code,task_level_sub_code,task_name,task_order_section,task_order_position,task_orderer,task_priority,task_base_date,task_limit_date,task_elapsed_base_date,task_elapsed_limit_date,task_state,task_birth_date) Values($task_level,$task_sub_level,'$task_title',$my_department_code,$my_position_code,$my_name_code,$task_priority,'$task_base_date','$task_limit_date','$task_base_elapsed_date','$task_limit_elapsed_date',$task_state,'$date');";      
            echo $task_table_query;
            echo "<br />";
   
           $result_set = mysqli_query($conn,$task_table_query);
           $task_table_query2 = "select MAX(TID) as Max from task_document_header_table;";
           $result_set2 = mysqli_query($conn,$task_table_query2);
            $row=mysqli_fetch_array($result_set2);
            $up_page_TID = $row['Max'];
            


           $query_of_combined = "select * from task_approbation_path_table where SID = $my_name_code AND key_index = $selected_path";
           $result_c = mysqli_query($conn,$query_of_combined);
           $rowc=mysqli_fetch_array($result_c);
           $offset = 1;
           while($offset<8){
               if($rowc[$offset."_layer_aida_sid"]!=''){
                        $current = $rowc[$offset."_layer_aida_sid"];
                        break;
               }
               $offset++;
           }


           $end_user_position = $ob2->su_function_convert_name($conn,"sid_combine_table","SID",$end_sid,"sid_combine_position");
           $task_detail_table_query = "Insert into task_approbation_table(TID,task_order_section,key_index,appro_state,last_appro_date,current_sid,first_order,end_order) Values($up_page_TID,$my_department_code,$selected_path,0,'".$_SESSION['now_date']."',$min,".$_SESSION['my_position_code'].",$end_user_position);";
 
             echo $task_detail_table_query;
 
           mysqli_query($conn,$task_detail_table_query);


            

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

    }

            }
    
    ?>

