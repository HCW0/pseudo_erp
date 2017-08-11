<?php
	session_start();



// include function
     function my_autoloader($class){
         include '../classes/'.$class.'.php';
    }

 spl_autoload_register('my_autoloader');


//db 연결 파트
        $conn = mysqli_connect('localhost','root','9708258a');
        if(!$conn) { $_SESSION['msg']='DB연결에 실패하였습니다.';
                     header('Location: ../su_script_login_interface.php');
        }
        $use = mysqli_select_db($conn,"suproject");
        if(!$use) die('cannot open db'.mysqli_error($conn));

		$ob2 = new su_class_value_name_convert_with_code();



// 하위 업무를 검색할 키값인 TID를 받는다.$_COOKIE



	echo "<script>alert('21');</script>";

	//헤더의 상태값에 변화될 상세 상태값들을 가져온다.
						$ajax_result;
						$ajax_result[0] = true;
						$ajax_state_query = "SELECT * FROM task_document_header_table WHERE TID = $target_tid AND TID != $target_tid";
     					$as_result = mysqli_query($conn,$ajax_state_query);  
           							while( $row=mysqli_fetch_array($as_result) ){    
												if($row['task_state']==10){
															$ajax_result[0] = false;
													}
            													    		                                                       											 
       										}

                                                
      					//echo json_encode($ajax_result);		           
?>
