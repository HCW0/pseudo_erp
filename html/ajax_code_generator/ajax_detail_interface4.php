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

	$insertFlag = false;
	$filterFlag = false;
	$searchFlag = false;
	$detailFlag = false;

	// 초기화면 구성과 추가되는 용역에 필요한 자원입니다.
	$req_col = "";
	$req_count = "";
	$req_line = "";

	// 컬럼 정렬 기능을 위한 자원입니다.
	$req_order = "";
	$req_header_col = "";
	$req_listNum = "";

	if(isset($_REQUEST["data"])){		$req_col 		= $_REQUEST["data"]; $insertFlag=true;}
	if(isset($_REQUEST["count"])){		$req_col 		=  $_REQUEST["count"];}
	if(isset($_REQUEST["line"])){		$req_col 		= $_REQUEST["line"];}
	if(isset($_REQUEST['col'])){		$req_listNum 	= $_REQUEST['col'];}
	if(isset($_REQUEST["order"])){		$req_order 		= $_REQUEST["order"]; $filterFlag=true;}
	if(isset($_REQUEST["col"])){			$req_header_col = $_REQUEST["col"];}
	if(isset($_REQUEST["list_num"])){	$req_listNum 	= $_REQUEST["list_num"];}

	
	// 클릭한 사업의 디테일한 정보를 보여주기 위한 로직
	if($detailFlag){
		if($req_listNum !=null && $req_listNum !=""){
			
			$ajax_query = "master_task_level_sub_info_table";
			
			if(mysqli_query($conn,$ajax_query)){
				
			}else{
				echo "fail";
			}
		}
	}
	
	if($insertFlag){
		$req_count++;
		$pattern = ",";
		
		$req_col_array = explode($pattern, $req_col);

		$rowNum = array(10,11,12);
		$moneyArry = array();
		for($i=0; $i<3; $i++){
			$moneyArry[$i] = number_format((int)$req_col_array[$rowNum[$i]]);
		}

			echo "
				<tr id=\"rowData\" class=\"c$req_line rowData\" onclick=\"state(this.id,$req_col_array[0]);\">
					<td style=\"width:1%;\">$req_count</td>
					<td style=\"width:4%;\">$req_col_array[0]</td>
					<td style=\"width:16%;\" class=\"title\">$req_col_array[1]</td>
					<td style=\"width:6%;\">$req_col_array[2]</td>
					<td style=\"width:4%;\" class=\"coworker\">$req_col_array[3]</td>
					<td style=\"width:4%;\">$req_col_array[4]</td>
					<td style=\"width:5%;\">$req_col_array[5]</td>
					<td style=\"width:4%;\">$req_col_array[6]</td>
					<td style=\"width:4%;\">$req_col_array[7]</td>
					<td style=\"width:4%;\">$req_col_array[8]</td>
					<td style=\"width:4%;\">$req_col_array[9]</td>
					<td style=\"width:7%;\" class=\"_m\">$moneyArry[0]</td>
					<td style=\"width:7%;\" class=\"_m\">$moneyArry[1]</td>
					<td style=\"width:7%;\" class=\"_m\">$moneyArry[2]</td>
					<td style=\"width:4%;\">$req_col_array[13]</td>
					<td style=\"width:4%;\">$req_col_array[14]</td>
					<td style=\"width:4%;\" class=\"$\">$req_col_array[15]</td>									
				</tr>	
			";

		if($req_line==1){
			$req_line=0;
		}else{
			$req_line=1;
		}

		//  INSERT TO VALUES 를 구현하시오
		$ajax_query = "INSERT into master_task_level_sub_info_table () VALUES ()";
		
		if(mysqli_query($conn,$ajax_query)){
			
		}else{
			echo "fail";
		}
	}

	if($filterFlag){

		if($req_header_col=="c_t"){
			$req_header_col = "mt.master_customer";
		}
		if($req_header_col=="f_d"){
			$req_header_col = "mt.sub_level_from_date";
		}
		if($req_header_col=="a_m"){
			$req_header_col = "mt.all_money_master_code_field";
		}
		if($req_header_col=="g_m"){
			
		}


		$query =   
		"SELECT
			mt.master_task_level_sub_code,	mt.master_task_level_sub_name,
			mc.master_name,	mt.coworker,
			mu.master_user_info_name,	md.master_department_info_name,
			mt.sub_level_from_date,	mt.sub_level_birth_date, mt.sub_level_to_date,
			mt.all_money_master_code_field,	mt.use_money_master_code_field,	mt.remaind_money_master_code_field,
			mt.etcetera, mt.complete_rate
		 FROM 	
			master_task_level_sub_info_table mt,master_customer_table mc,master_department_info_table md,master_user_info_table mu
		 WHERE 
			mt.master_customer = mc.master_code AND	mt.sub_level_orderer = mu.SID AND mt.sub_level_order_section = md.sid_combine_department
			ORDER BY $req_header_col $req_order
		";

		$all_Money=0;
		$use_Money=0;
		$remaind_Money=0;
		$count=0;
		$line =0;
		
		$result = mysqli_query($conn,$query);  
		while($row=mysqli_fetch_array($result))
		{         
			$all_Money += $row[9];
			$use_Money += $row[10];
			$remaind_Money += $row[11];

			$count++;
			
			$rowNum = array(9,10,11);
			$moneyArry = array();
			for($i=0; $i<3; $i++){
				$moneyArry[$i] = number_format($row[$rowNum[$i]]);
			}

			$rowDay = array(6,7,8);
			$dayArray = array();
			for($i=0; $i<3; $i++){
				$dayArray[$i] =  date("y.m.d",strtotime($row[$rowDay[$i]]));
			}


			if(		$row[13] == "진행중"){$activity ="false";	}
			else{	$activity ="true";	}

			// 삼항식으로 줄여 주세요
			if( $line == "0" ){ 
				$line = "1";
			}else {
				$line = "0";
			}

			echo (
			"
			<tr id=\"rowData\" class=\"c$line rowData\" onclick=\"state_activity(this.id,$row[0]);\">
				<td style=\"width:1%;\">$count</td>
				<td style=\"width:6%;\">$row[0]</td>
				<td style=\"width:23%;\" class=\"title\">$row[1]</td>
				<td style=\"width:6%;\">$row[2]</td>
				<td style=\"width:4%;\" class=\"coworker\">$row[3]</td>
				<td style=\"width:4%;\">$row[4]</td>
				<td style=\"width:5%;\">$row[5]</td>
				<td style=\"width:4%;\">6</td>
				<td style=\"width:4%;\">$dayArray[0]</td>
				<td style=\"width:4%;\">$dayArray[1]</td>
				<td style=\"width:4%;\">$dayArray[2]</td>
				<td style=\"width:7%;\" class=\"_m\">$moneyArry[0]</td>
				<td style=\"width:7%;\" class=\"_m\">$moneyArry[1]</td>
				<td style=\"width:7%;\" class=\"_m\">$moneyArry[2]</td>
				<td style=\"width:4%;\">$row[12]</td>
				<td style=\"width:4%;\" id=\"$activity\">$row[13]</td>
				<td style=\"width:4%;\"></td>									
			</tr>
			"
			);
		}
	}
?>
