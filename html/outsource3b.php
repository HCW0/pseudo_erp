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


//php 객체 생성


    $ob2 = new su_class_value_name_convert_with_code();
    $msg_ob = new su_class_message_handler();
    $ob6 = new su_class_sid_variable_container_manager();
    

//이하 post로 받은 공문의 필드
		
    $former_title = $_POST['title'];
    $former_rank = $_POST['rank'];
    $former_from = $_POST['from_date'];
    $former_to = $_POST['to_date'];
    $former_contents = $_POST['content'];


    
    $former_recv = $ob6->su_function_generate_array_miner($conn);
    $ob6->su_function_generate_input_list($conn,$ob2,$former_recv);
    $former_ref = $_POST['ref'];
    $path_number = $_POST['pathnum'];


    $my_name =  $_SESSION['my_sid_code'];
    $my_department_code = $_SESSION['my_department_code'];








    if($former_title==''||$former_rank==''||$former_from==''||$former_to==''||$former_contents==''||$former_recv==''){
              echo "uninvalid input error in task add module";
              echo "<br />";
              
              $msg_ob->su_function_call_message($conn,514,'su_script_former_write_interface');

    }
    else{      




                                
                                $file_name = $_FILES['upload_file']['name'];                // 업로드한 파일명
                                $file_tmp_name = $_FILES['upload_file']['tmp_name'];        // 임시 디렉토리에 저장된 파일명
                                $file_size = $_FILES['upload_file']['size'];                // 업로드한 파일의 크기
                                $mimeType = $_FILES['upload_file']['type'];                 // 업로드한 파일의 MIME Type



                                    // 첨부 파일이 저장될 서버 디렉토리 지정(원하는 경로에 맞게 수정하세요)

                                    $save_dir = './storage/former/';


/*
                            // 업로드 파일 확장자 검사 (필요시 확장자 추가)

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

                                    document.location.href = './su_script_notice_write_interface.php';    

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


                                $abspath = $_SERVER["DOCUMENT_ROOT"].'/storage/former/'.$change_file_name;
                            echo $abspath;
                            move_uploaded_file($file_tmp_name, $abspath);
                            chmod($abspath,0777); 




                            // DB에 기록할 파일 변수 (DB에 저장이 필요한 경우 아래 변수명을 기록하시면 됩니다.)

                            /*

                                $change_file_name : 실제 서버에 업로드 된 파일명. 예: file_145736478766.gif

                                $real_name : 원래 파일명. 예: 풍경사진.gif 

                                $real_size : 파일 크기(byte)

                            */




            if($_FILES['upload_file']['name']!=''){
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

            $date = date("Y-m-d");
    	    $task_table_query = "Insert into former_document_header_table(former_title,priority,from_date,to_date,birth_date,former_content,orderer,order_section,former_recv) Values('$former_title',$former_rank,'$former_from','$former_to','$date','$former_contents',$my_name,$my_department_code,$former_recv);";      
            echo $task_table_query;
            $result_set = mysqli_query($conn,$task_table_query);


           $task_table_query2 = "select MAX(former_id) as Max from former_document_header_table;";
           $result_set2 = mysqli_query($conn,$task_table_query2);
            $row=mysqli_fetch_array($result_set2);
            $up_page_TID = $row['Max'];

        if(isset($target)){
            $uquery = "update former_document_header_table set upload_id=$target where former_id = ".$up_page_TID;
            echo $uquery;
            mysqli_query($conn,$uquery); 
        }

        if($former_ref!=''){
            $uquery = "update former_document_header_table set former_ref=$former_ref where former_id = ".$up_page_TID;
            echo $uquery;
            mysqli_query($conn,$uquery);
        }

           $task_table_query2 = "select MAX(former_id) as Max from former_document_header_table;";
           $result_set2 = mysqli_query($conn,$task_table_query2);
            $row=mysqli_fetch_array($result_set2);
            $up_page_TID = $row['Max'];



// 여기까지 업무 및 업로드 테이블에 데이터 등록, 이하 결제 테이블 등록



            //선택한 결제 경로 엔터티의 정보를 생성될 결제 정보 테이블에 옮긴다.$_COOKIE
            $min_find_query = "select * from task_approbation_path_table where sid=".$_SESSION['my_sid_code']." AND key_index = $path_number;";
            $result_min = mysqli_query($conn,$min_find_query);
            $row_min = mysqli_fetch_array($result_min);
            $min = $row_min['min_sid'];
            $end_sid = $row_min['end_user_sid'];

            $end = $ob2->su_function_convert_name($conn,"sid_combine_table","SID",$end_sid,"sid_combine_position");
            $task_detail_table_query = "Insert into task_approbation_table(TID,task_order_section,key_index,appro_state,last_appro_date,current_sid,first_order,end_order,appro_type_flag) Values($up_page_TID,$my_department_code,$path_number,0,'".$_SESSION['now_date']."',$min,".$_SESSION['my_sid_code'].",$end_sid,1);";
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








           $msg_ob->su_function_call_message_callback($conn,518);

            if(isset($_SESSION['receive_arr'])){
                unset($_SESSION['receive_arr']);
            }

           echo "<script> opener.location.reload(); </script>";
           echo "<script> self.close(); </script>"; 

    };
    ?>

