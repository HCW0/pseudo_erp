  <?php
       session_start();
        include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_user_login_check.php');
        include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_class_loader.php');
        include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_db_connecter.php');



	$task_level = $_SESSION['hold_level'];
    $task_sub_level = $_SESSION['sub_hold_level'];
    $task_title = $_POST['task_select_box'][0];
    $task_priority = $_POST['task_select_box'][1];
    $task_state = $_POST['task_state'];

    $task_base_date = $_POST['task_select_box'][2];
    $task_limit_date = $_POST['task_select_box'][3];

    $task_base_elapsed_date = $_POST['task_select_box'][4];
    $task_limit_elapsed_date = $_POST['task_select_box'][4];

    $_rflag = $_POST['reserve_flag'];


    // 디테일 필드 받는 파트

        $task_detail_status = $_POST['dstate']; 
        $task_detail_content = $_POST['dcontent'];                            
        $path_number = $_POST['pathnum']; 

    $my_name_code =  $_SESSION['my_sid_code'];
    $my_department_code = $_SESSION['my_department_code'];
    $my_position_code = $_SESSION['my_position_code'];

        $all_money = $_POST['qty'] ? $_POST['qty'] : 0;         
        $use_money = $_POST['qty2'] ? $_POST['qty2'] : 0;    
        $rema_money = $_POST['total'] ? $_POST['total'] : 0; 

        $cworker = $_POST['relate_org'] ? $_POST['relate_org'] : '--'; 
        $cworksp = $_POST['relate_sp'] ? $_POST['relate_sp'] : '--'; 

     $task_index_contents = $_POST['task_0layer_content']; 
     $upper_task_id = $_POST['sub_task_select_box'];


     
    //debug
    echo "<br />";
    echo "task_title";
    echo "<br />";
    echo $task_title;

    //debug
    echo "<br />";
    echo " _POST['task_select_box'][0]";
    echo "<br />";
    echo  $_POST['task_select_box'][0];

   
    
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
    echo "dstate";
    echo $task_detail_status;
    echo "<br />";








    $ob2 = new su_class_value_name_convert_with_code();


    $msg_ob = new su_class_message_handler();
    

    $bool = ($task_title==='')||($_POST['task_select_box'][3]=='')||($_POST['task_select_box'][4]=='')||($_POST['task_state']=='')||($_POST['pathnum']=='');



    if($bool){
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


        // 업로드 모듈
                        if($_FILES['upload_file']['name']){

                                $file_name = $_FILES['upload_file']['name'];                // 업로드한 파일명
                                $file_tmp_name = $_FILES['upload_file']['tmp_name'];        // 임시 디렉토리에 저장된 파일명
                                $file_size = $_FILES['upload_file']['size'];                // 업로드한 파일의 크기
                                $mimeType = $_FILES['upload_file']['type'];                 // 업로드한 파일의 MIME Type



                                    // 첨부 파일이 저장될 서버 디렉토리 지정(원하는 경로에 맞게 수정하세요)

                                    $save_dir = './storage/tasksheet/'.$SESSION['my_department_code'];



                            // 업로드 파일 확장자 검사 (필요시 확장자 추가)
                            /*
                            if($mimeType=="html" || 

                            $mimeType=="htm" || 

                            $mimeType=="php" || 

                            $mimeType=="php3" || 

                            $mimeType=="inc" || 

                            $mimeType=="pl" || 

                            $mimeType=="cgi" || 

                            $mimeType=="txt" || 

                            $mimeType=="TXT" || 

                            $mimeType=="asp" || 

                            $mimeType=="jsp" || 

                            $mimeType=="phtml" || 

                            $mimeType=="js" || 

                            $mimeType=="") { 

                                    echo("<script> 

                                    alert('업로드를 할 수 없는 파일형식입니다.'); 

                                    document.location.href = './su_script_table_write_interface.php';    

                                    </script>"); 

                                    exit;

                            } 
*/


                            

                            // 파일명 변경 (업로드되는 파일명을 별도로 생성하고 원래 파일명을 별도의 변수에 지정하여 DB에 기록할 수 있습니다.)

                                $real_name = $file_name;     // 원래 파일명(업로드 하기 전 실제 파일명) 

                                $arr = explode(".", $real_name);	 // 원래 파일의 확장자명을 가져와서 그대로 적용 $file_exe	

                                $arr1 = $arr[0];	

                                $arr2 = $arr[1];	

                                $arr3 = $arr[2];	

                                $arr4 = $arr[3];	

                                if($arr4) { 

                                    $file_exe = $arr4;

                                } else if($arr3 && !$arr4) { 

                                    $file_exe = $arr3;					

                                } else if($arr2 && !$arr3) { 

                                    $file_exe = $arr2;					

                                }

                                                        

                                $file_time = time(); 

                                $file_Name = "file_".$file_time.".".$file_exe;	 // 실제 업로드 될 파일명 생성	(본인이 원하는 파일명 지정 가능)	 

                                $change_file_name = $file_Name;			 // 변경된 파일명을 변수에 지정 

                                $real_name = addslashes($real_name);		// 업로드 되는 원래 파일명(업로드 하기 전 실제 파일명) 

                                $real_size = $file_size;                         // 업로드 되는 파일 크기 (byte)



                            

                            //파일을 저장할 디렉토리 및 파일명 전체 경로

                            $dest_url = $save_dir . $change_file_name;

                            

                            //파일을 지정한 디렉토리에 업로드


                                $abspath = $_SERVER["DOCUMENT_ROOT"].'/storage/task_sheet/'.$_SESSION['my_department_code'].'/'.$change_file_name;
                            echo $abspath;
                            move_uploaded_file($file_tmp_name, $abspath);
                            chmod($abspath,0777); 




                            // DB에 기록할 파일 변수 (DB에 저장이 필요한 경우 아래 변수명을 기록하시면 됩니다.)

                            /*

                                $change_file_name : 실제 서버에 업로드 된 파일명. 예: file_145736478766.gif

                                $real_name : 원래 파일명. 예: 풍경사진.gif 

                                $real_size : 파일 크기(byte)

                            */





                            
                    $query = "select max(upload_id) as target from master_upload_table";
                    echo $query;
                    $result = mysqli_query($conn,$query);
                    if(!$result){
                        $target = 0;
                    }else{
                        $row = mysqli_fetch_array($result);
                        $target = $row['target']+1;
                    }

                $query = "Insert into master_upload_table(upload_id,real_name,server_name) Values($target,'$real_name','$change_file_name');";
                $result = mysqli_query($conn,$query);
                echo $query;


                        }









        // 업로드 종료




            $date = date("Y-m-d");
    	    $task_table_query = "Insert into task_document_header_table(task_level_code,task_level_sub_code,task_name,task_order_section,task_order_position,task_orderer,task_priority,task_base_date,task_limit_date,task_elapsed_base_date,task_elapsed_limit_date,task_state,task_birth_date,all_money_master_code_field,use_money_master_code_field,remaind_money_master_code_field,etcetera,coworker,coworkspace,reserve_flag) Values($task_level,$task_sub_level,'$task_title',$my_department_code,$my_position_code,$my_name_code,$task_priority,'$task_base_date','$task_limit_date','$task_base_elapsed_date','$task_limit_elapsed_date',5,'$date',$all_money,$use_money,$rema_money,'$task_detail_content','$cworker','$cworksp',$_rflag);";      
            echo $task_table_query;
            echo "<br />";
   
           $result_set = mysqli_query($conn,$task_table_query);
           $task_table_query2 = "select MAX(TID) as Max from task_document_header_table;";
           $result_set2 = mysqli_query($conn,$task_table_query2);
            $row=mysqli_fetch_array($result_set2);
            $up_page_TID = $row['Max'];
            

            if(isset($target)){
                    $query_update_layer = "update task_document_header_table set upload_id = $target where TID = $up_page_TID;";
                    $result_min = mysqli_query($conn,$query_update_layer);

            }

            if($task_detail_status){
                    $query_update_layer = "update task_document_header_table set task_detail_state = $task_detail_status where TID = $up_page_TID;";
                    $result_min = mysqli_query($conn,$query_update_layer);                
            }


            //결제 경로에서 공석인 자리를 건너 뛰는 로직
            //출장 등의 공석 역시 표현해야 하므로, 기본적으로 빈 공석은 모두 계정을 생성하여 is_valid flag를 set해놓아야한다.


            //선택한 결제 경로 엔터티의 정보를 생성될 결제 정보 테이블에 옮긴다.$_COOKIE
            $min_find_query = "select * from task_approbation_path_table where sid=".$_SESSION['my_sid_code']." AND key_index = $path_number;";
            $result_min = mysqli_query($conn,$min_find_query);
            $row_min = mysqli_fetch_array($result_min);
            $min = $row_min['min_sid'];
            $end_sid = $row_min['end_user_sid'];

            $end = $ob2->su_function_convert_name($conn,"sid_combine_table","SID",$end_sid,"sid_combine_position");
            $task_detail_table_query = "Insert into task_approbation_table(TID,task_order_section,key_index,appro_state,last_appro_date,current_sid,first_order,end_order) Values($up_page_TID,$my_department_code,$path_number,0,'".$_SESSION['now_date']."',$min,".$_SESSION['my_sid_code'].",$end_sid);";
            mysqli_query($conn,$task_detail_table_query);
            echo $task_detail_table_query;
            echo "<br />";

                for($cnt=1;$cnt<8;$cnt++){
                        $field_name = $cnt.'_layer_aida_sid';
                        if($row_min[$field_name]){
                                    $query_update_layer = "update task_approbation_table set $field_name = ".$row_min[$field_name]." where TID = $up_page_TID;";
                                    $result_min = mysqli_query($conn,$query_update_layer);
                        }
                }



         
           if($upper_task_id=='') $upper_task_id = $up_page_TID;
           $task_detail_table_query2 = "update task_approbation_table set task_sq_0layer_message = '$task_index_contents' where TID = $up_page_TID;";
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

