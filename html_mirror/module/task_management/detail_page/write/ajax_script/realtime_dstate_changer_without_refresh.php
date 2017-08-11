<?php
	session_start();

	include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_user_login_check.php');
	include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_class_loader.php');
	include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_db_connecter.php');


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
