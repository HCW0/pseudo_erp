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








					//수정할 대상의 task id를 받아온다.
		            $target_tid = $_GET['tid'];
					

					//기존의 입력 값들을 각 form에 불러와야하니 sql쿼리문으로 row array도 하나 만든다.
					$target_query = "SELECT * FROM task_document_header_table u WHERE u.TID = $target_tid;";
					$target_result = mysqli_query($conn,$target_query);  
					$target_field=mysqli_fetch_array($target_result);



                    // 업무수정과 결제는 완전히 독ㄹ;ㅂ된 구조이다.
                    // 따라서 기존의 모듈에서 결제는 배제



	$task_level = $_SESSION['hold_level'];
    $task_sub_level = $_SESSION['sub_hold_level'];
    $task_title = $_POST['task_select_box'][0];
    $task_priority = $_POST['task_select_box'][1];
    $task_state = $_POST['task_select_box'][2];

    $task_base_date = $_POST['task_select_box'][3];
    $task_limit_date = $_POST['task_select_box'][4];

    $task_base_elapsed_date = $_POST['task_select_box'][5];
    $task_limit_elapsed_date = $_POST['task_select_box'][5];

    


    // 디테일 필드 받는 파트

        $task_detail_status = $_POST['dstate']; 
        $task_detail_content = $_POST['dcontent'];                            
        //$path_number = $_POST['pathnum']; 

    $my_name_code =  $_SESSION['my_sid_code'];
    $my_department_code = $_SESSION['my_department_code'];
    $my_position_code = $_SESSION['my_position_code'];

        $all_money = $_POST['qty'] ? $_POST['qty'] : 0;         
        $use_money = $_POST['qty2'] ? $_POST['qty2'] : 0;    
        $rema_money = $_POST['total'] ? $_POST['total'] : 0; 

        $cworker = $_POST['relate_org'] ? $_POST['relate_org'] : '--'; 
        $cworksp = $_POST['relate_sp'] ? $_POST['relate_sp'] : '--'; 

     //$task_index_contents = $_POST['task_0layer_content']; 
     //$upper_task_id = $_POST['sub_task_select_box'];


    //

     
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
   // echo $path_number;
    echo "<br />";
    echo "contents";
   // echo $task_index_contents;
    echo "<br />";
    echo "upper";
  //  echo $upper_task_id;
    echo "<br />";








    $ob2 = new su_class_value_name_convert_with_code();


    $msg_ob = new su_class_message_handler();
    
    if($_POST['task_select_box'][0]==''||$_POST['task_select_box'][2]==''||$_POST['task_select_box'][3]==''||$_POST['task_select_box'][4]==''||$_POST['task_select_box'][5]==''){
              echo "uninvalid input error in task add module";
              echo "<br />";
              
              $msg_ob->su_function_call_message($conn,514,'su_script_table_write_interface_b');

    }
    else if($task_base_date>$task_limit_date){
              $msg_ob->su_function_call_message($conn,513,'su_script_table_write_interface_b');
    }
    else if(($task_base_elapsed_date>$task_limit_date) || ($task_base_elapsed_date<$task_base_date)){
              $msg_ob->su_function_call_message($conn,513,'su_script_table_write_interface_b');
    }
    else{      


        // 업로드 모듈
                        if($_FILES['upload_file']['name']){

                                $file_name = $_FILES['upload_file']['name'];                // 업로드한 파일명
                                $file_tmp_name = $_FILES['upload_file']['tmp_name'];        // 임시 디렉토리에 저장된 파일명
                                $file_size = $_FILES['upload_file']['size'];                // 업로드한 파일의 크기
                                $mimeType = $_FILES['upload_file']['type'];                 // 업로드한 파일의 MIME Type



                                    // 첨부 파일이 저장될 서버 디렉토리 지정(원하는 경로에 맞게 수정하세요)

                                    $save_dir = './storage/tasksheet/'.$_SESSION['my_department_code'];



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





                  
                if($target_field['upload_id']){
                    $query = "update master_upload_table set real_name = '$real_name', server_name = '$change_file_name' where upload_id = ".$target_field['upload_id'].";";
                }else{

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
                    $query2 = "update task_document_header_table set upload_id = $target  where TID = ".$target_field['TID'].";";
                    $result = mysqli_query($conn,$query2);


                    echo "$query";

                }
                $result = mysqli_query($conn,$query);
                echo $query;


                        }









        // 업로드 종료

            $date = date("Y-m-d");


            
            $update_query = "update task_document_header_table set task_name = '$task_title'  where TID = $target_tid";
            
           $result_set = mysqli_query($conn,$update_query); 
            $update_query = "update task_document_header_table set task_priority = $task_priority  where TID = $target_tid";

$result_set = mysqli_query($conn,$update_query);
            $update_query = "update task_document_header_table set task_base_date = '$task_base_date' where TID = $target_tid";

$result_set = mysqli_query($conn,$update_query);
            $update_query = "update task_document_header_table set task_limit_date = '$task_limit_date' where TID = $target_tid";
$result_set = mysqli_query($conn,$update_query);

//             $update_query = "update task_document_header_table set task_elapsed_base_date = '$task_elapsed_base_date' where TID = $target_tid";

// $result_set = mysqli_query($conn,$update_query);
//             $update_query = "update task_document_header_table set task_elapsed_limit_date = '$task_elapsed_limit_date' where TID = $target_tid";

// $result_set = mysqli_query($conn,$update_query);
            $update_query = "update task_document_header_table set task_birth_date = '$date' where TID = $target_tid";           
            
            $result_set = mysqli_query($conn,$update_query);
            $update_query = "update task_document_header_table set all_money_master_code_field = $all_money where TID = $target_tid";   

$result_set = mysqli_query($conn,$update_query);
            $update_query = "update task_document_header_table set use_money_master_code_field = $use_money where TID = $target_tid";   


$result_set = mysqli_query($conn,$update_query);
//             $update_query = "update task_document_header_table set super_task_TID = $upper_task_id where TID = $target_tid";   


// $result_set = mysqli_query($conn,$update_query);
            $update_query = "update task_document_header_table set remaind_money_master_code_field = $rema_money where TID = $target_tid";                                      
         $result_set = mysqli_query($conn,$update_query);   

            $update_query = "update task_document_header_table set etcetera = '$task_detail_content' where TID = $target_tid";    
$result_set = mysqli_query($conn,$update_query);
            $update_query = "update task_document_header_table set coworker = '$cworker' where TID = $target_tid";    
$result_set = mysqli_query($conn,$update_query);
            $update_query = "update task_document_header_table set coworkspace = '$cworksp' where TID = $target_tid";                                      
            $result_set = mysqli_query($conn,$update_query);

          
           $msg_ob->su_function_call_message_callback($conn,517);

           echo "<script> opener.location.reload(); </script>";
           echo "<script> self.close(); </script>"; 

    };
    ?>

