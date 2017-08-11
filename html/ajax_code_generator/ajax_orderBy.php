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

	// Client 에서 들어오는 reqest 데이터를 받는 변수
	// flag
	// 1 : desc 오름차순
	// 2 : asc  내림차순
	$req_flag = $_REQUEST["flag"];
	$req_flag = ($req_flag == '1') ? ('desc') : ('asc');
	
	//  p : price
	//  s : security code
	// pp : planning progress
	$req_col = $_REQUEST["col"];
	if($req_col == 's') $req_col = "level";
	if($req_col == 'p') $req_col = "orderAmount";
	if($req_col == 'pp') $req_col = "progress";

	//헤더의 상태값에 변화될 상세 상태값들을 가져온다.
	// 하위 업무를 비포함한 최 상위 프로젝트 : 자신의 TID와 super_task_TID가 같은 것만 출력하라.

	// $query = "SELECT TID, coworkspace, task_name, all_money_master_code_field, coworker , task_base_date, 
	// task_limit_date, progress_rate from task_document_header_table t where t.TID = t.super_task_TID";

	$ajax_query = "SELECT order_code, orderName, orderAmount, level, viewer, beginDate, endDate, progress from task_document_header_table ORDER BY";
	
	// $req_col 선택한 컬럼과 $req_flag 상태를 체크하여 concat!
	$ajax_query = $ajax_query.' '.$req_col;
	$ajax_query = $ajax_query.' '.$req_flag;

    $as_result = mysqli_query($conn,$ajax_query);  
	
	// result
	$data = null;
	$count = 0;
    while( $row=mysqli_fetch_array($as_result)){
		$count++;
		$data .= "
			<ul class=data id=$row[0] onclick=planning_Detail_Page(this,this.id)>
			<li class=no style=width:30px><span>$count</span></li>
				<li class=col>
					<label><span>$row[1]<span></label>
				</li>
			<li class=\"price\"><span>$row[2]원</span></li>
			<li>$row[4]</li>
			<li>$row[5]</li>
			<li>$row[6]</li>
			<li><span>$row[7]%</span></li>
			</ul>";
	}
	echo ($data);
	  
?>
