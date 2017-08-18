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

	$squery = "SELECT * FROM master_task_level_sub_info_table WHERE master_task_level_sub_code = $target_sub_level";
	$sresult = mysqli_query($conn,$squery);
	$srow = mysqli_fetch_array($sresult);	


	$hyper_text = '';

	$hyper_text = $hyper_text."<tr class='del'>";
	$hyper_text = $hyper_text.'<td>용역명</td>';

	$hyper_text = $hyper_text."<td colspan=3 id='data'>".$srow['master_task_level_sub_name']."</td>";
	$hyper_text = $hyper_text.'</tr>';

	$hyper_text = $hyper_text."<tr class='del'>";
	$hyper_text = $hyper_text.'<td>현재 용역 상태</td>';
					
	$hyper_text = $hyper_text."<td id='data'>";										
	$hyper_text = $hyper_text.$ob2->su_function_convert_name($conn,"dmaster_state_info_table","master_code",$srow['task_detail_state'],"master_state_detail_name");				
	$hyper_text = $hyper_text.'</td>';

	$hyper_text = $hyper_text.'<td>용역 상태 변화</td>';
	if($srow['task_detail_state']!=50){
		$hyper_text = $hyper_text."<td id='data'>".$ob2->su_function_convert_name($conn,"dmaster_state_info_table","master_code",($srow['task_detail_state']+10),"master_state_detail_name")."</td>";  
	}else{
		$hyper_text = $hyper_text."<td id='data'>"."--";
	}
	$hyper_text = $hyper_text.'</tr>';
	$hyper_text = $hyper_text."<input type='hidden' class='modal_hidden' name='UserIP' value=".$target_sub_level.">";
	$hyper_text = $hyper_text."<input type='hidden' class='modal_hidden2' name='UserIP' value=".$srow['task_detail_state'].">";
	
	echo($hyper_text);

?>