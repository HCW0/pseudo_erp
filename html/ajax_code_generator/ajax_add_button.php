<?php
	session_start();

	// include function
    function my_autoloader($class){
		include '../classes/'.$class.'.php';
    }

	spl_autoload_register('my_autoloader');

	//db 연결 파트	
    $conn = mysqli_connect('localhost','root','9708258a');
    
	if(!$conn) { 
		$_SESSION['msg']='DB연결에 실패하였습니다.';
    	header('Location: ../su_script_login_interface.php');
    }

    $use = mysqli_select_db($conn,"suproject");

    if(!$use) die('cannot open db'.mysqli_error($conn));

	$ob2 = new su_class_value_name_convert_with_code();

	$sel = $_GET['sel'];
	$_SESSION['receive_arr'][] = $sel;
	$_SESSION['receive_arr'] = array_unique($_SESSION['receive_arr']);
	$len = count($_SESSION['receive_arr']);

	$result='';
		for($cnt = 0 ; $cnt < $len ; $cnt ++){
			if(isset($_SESSION['receive_arr'][$cnt])){
				
						if($_SESSION['receive_arr'][$cnt]<0){
							$target = -1*$_SESSION['receive_arr'][$cnt];
							$string = $ob2->su_function_convert_name($conn,"master_department_info_table","sid_combine_department",$target,"master_department_info_name");
						}else{
							$target = $_SESSION['receive_arr'][$cnt];
							$string = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$target,"master_user_info_name");
						}

				}
				if($result==''){
						$result = $result.$string;
				}else{
					$result = $result.",".$string;
				}
		}

	echo $result;
	  
?>
