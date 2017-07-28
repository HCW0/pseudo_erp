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




	//헤더의 상태값에 변화될 상세 상태값들을 가져온다.
						$ajax_dstate_array;
						$ajax_state_query = "SELECT * FROM dmaster_state_info_table";
     					$as_result = mysqli_query($conn,$ajax_state_query);  
           							while( $row=mysqli_fetch_array($as_result) ){    
												if($row['master_code']!=99 && $row['master_code']%10!=0)
            										$ajax_dstate_array[$row['master_code']] = $row['master_state_detail_name'];			    		                                                       											 
       										     }

                                                
      					echo json_encode($ajax_dstate_array);		           
?>
