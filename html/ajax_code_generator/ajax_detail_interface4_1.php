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

// target_sub_lv는 용역 key값
	$target_sub_level = $_REQUEST['list_num'];


// key값을 가지고 용역 정보를 불러온다.$_COOKIE

	$squery = "UPDATE master_task_level_sub_info_table SET task_detail_state = task_detail_state + 10 WHERE master_task_level_sub_code = $target_sub_level";
	$sresult = mysqli_query($conn,$squery);
	


?>