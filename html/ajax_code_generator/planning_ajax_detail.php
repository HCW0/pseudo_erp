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

	$req_TID = $_REQUEST['code'];

	$ajax_query = "SELECT TID, task_name, task_order_section, task_order_position, task_orderer, task_base_date, task_limit_date, all_money_master_code_field, use_money_master_code_field, remaind_money_master_code_field, progress_rate from task_document_header_table t where t.TID != t.super_task_TID and t.super_task_TID =";
	$ajax_query = $ajax_query.' '.$req_TID;
    $as_result = mysqli_query($conn,$ajax_query);  
	
	// result
	$data = null;
	$count = 0;
	// <input type=button value=뒤로가기 onclick=backBtn(this, $row[0]);>
    while($row=mysqli_fetch_array($as_result)){
		$count++;
		$data .= "
			<div class=test>
				<table>
					<tr>
						<th>NO</th>
						<th>하위 업무</th>
						<th>업무 부서</th>
						<th>직급</th>
						<th>Writer</th>
						<th>시작일</th>
						<th>마침일</th>
						<th>총 금액</th>
						<th>사용 금액</th>
						<th>남은 금액</th>
						<th>진행률</th>
					</tr>
					<tr class=$row[0]>
						<td>
							<span>$count</span>
						</td>
						<td>
							<span><a href=$row[0]>$row[1]</a></span>
						</td>
						<td>
							<span>$row[2]</span>
						</td>
						<td>
							<span>$row[3]</span>
						</td>
						<td>
							<span>$row[4]</span>
						</td>
						<td>
							<span>$row[5]</span>
						</td>
						<td>
							<span>$row[6]</span>
						</td>
						<td>
							<span>$row[7]</span>
						</td>
						<td>
							<span>$row[8]</span>
						</td>
						<td>
							<span>$row[9]</span>
						</td>
						<td>
							<span>$row[10]</span>
						</td>
					</tr>
			</div>
		";
	}
	echo ($data);	           
?>
