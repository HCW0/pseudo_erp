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
	$flagSearch = false;

	// 초기화면 구성과 추가되는 용역에 필요한 자원입니다.
	$req_col = "";
	$req_count = "";
	$req_line = "";

	// 컬럼 정렬 기능을 위한 자원입니다.
	$req_order = "";
	$req_header_col = "";
	$req_listNum = "";

	//
	$req_search = "";
	
	// 자동 완성 

	if(isset($_REQUEST["data"])){		$req_col 		= $_REQUEST["data"]; $insertFlag=true;}
	if(isset($_REQUEST["count"])){		$req_count 		= $_REQUEST["count"];}
	if(isset($_REQUEST["line"])){		$req_line 		= $_REQUEST["line"];}
	if(isset($_REQUEST['col'])){		$req_listNum 	= $_REQUEST['col'];}
	if(isset($_REQUEST["order"])){		$req_order 		= $_REQUEST["order"]; $filterFlag=true;}
	if(isset($_REQUEST["col"])){		$req_header_col = $_REQUEST["col"];}
	if(isset($_REQUEST["list_num"])){	$req_listNum 	= $_REQUEST["list_num"]; $detailFlag=true;}
	if(isset($_REQUEST['search'])) { 	$req_search 	= $_REQUEST['search']; $flagSearch = true;}
	//if(isset($_REQUEST['auto'])) { 	$req_search 	= $_REQUEST['search']; $flagSearch = true;}
	

	//자꾸 오류떠서 봉인
	if(false){
		$columnName = "master_user_info_name";
		$str = $req_search;

		switch ($str){
			case 'ㄱ':
					$qry = " ($columnName RLIKE '^(ㄱ|ㄲ)' OR ( $columnName >= '가' AND $columnName < '나' )) order by $columnName"; 
					break;
			case 'ㄴ':
					$qry = " ($columnName RLIKE '^ㄴ' OR ( $columnName >= '나' AND $columnName < '다' )) order by $columnName"; 
					break;
			case 'ㄷ':
					$qry = " ($columnName RLIKE '^(ㄷ|ㄸ)' OR ( $columnName >= '다' AND $columnName < '라' )) order by $columnName"; 
					break;
			case 'ㄹ':
					$qry = " ($columnName RLIKE '^ㄹ' OR ( $columnName >= '라' AND $columnName < '마' )) order by $columnName"; 
					break;
			case 'ㅁ':
					$qry = " ($columnName RLIKE '^ㅁ' OR ( $columnName >= '마' AND $columnName < '바' )) order by $columnName";        
					break;
			case 'ㅂ':
					$qry = " ($columnName RLIKE '^ㅂ' OR ( $columnName >= '바' AND $columnName < '사' )) order by $columnName"; 
					break;
			case 'ㅅ':
					$qry = " ($columnName RLIKE '^(ㅅ|ㅆ)' OR ( $columnName >= '사' AND $columnName < '아' )) order by $columnName"; 
					break;
			case 'ㅇ':
					$qry = " ($columnName RLIKE '^ㅇ' OR ( $columnName >= '아' AND $columnName < '자' )) order by $columnName"; 
					break;
			case 'ㅈ':
					$qry = " ($columnName RLIKE '^(ㅈ|ㅉ)' OR ( $columnName >= '자' AND $columnName < '차' )) order by $columnName"; 
					break;
			case 'ㅊ':
					$qry = " ($columnName RLIKE '^ㅊ' OR ( $columnName >= '차' AND $columnName < '카' )) order by $columnName"; 
					break;
			case 'ㅋ':
					$qry = " ($columnName RLIKE '^ㅋ' OR ( $columnName >= '카' AND $columnName < '타' )) order by $columnName"; 
					break;
			case 'ㅌ':
					$qry = " ($columnNamele RLIKE '^ㅌ' OR ( $columnName >= '타' AND $columnName < '파' )) order by $columnName"; 
					break;
			case 'ㅍ':
					$qry = " ($columnName RLIKE '^ㅍ' OR ( $columnName >= '파' AND $columnName < '하' )) order by $columnName"; 
					break;
			case 'ㅎ':
					$qry = " ($columnName RLIKE '^ㅎ' OR ( $columnName >= '하')) order by $columnName"; 
					break;
			default:
					$qry = "order by $columnName";
		}

		$sql = "select master_user_info_name from master_user_info_table where $qry";    	

		$result = mysqli_query($conn,$sql);  
		$test = "";
		while($row=mysqli_fetch_array($result))
		{
			 $test .= $row[0].' ';
		}

		echo $test;
	}

	// 클릭한 사업의 디테일한 정보를 보여주기 위한 로직
	if($detailFlag){
		// $req_listNum 하도급이 존재하는 용역의 코드 네임
		
		$sql = "SELECT 
				mma.code, 
				ms.name, 
				mma.contents, 
				mma.ratio, 
				mma.master_user_sid, 
				mma.contract_date, 
				mma.from_date , 
				mma.to_date, 
				mma.all_money, 
				mma.use_money, 
				mma.remind_money				
			    from 
					master_management_account mma,
					master_subcontracting ms
				where 
					mma.master_task_level_sub_code = $req_listNum and
					ms.code = mma.subcontracting_code
				";    	

		$result = mysqli_query($conn,$sql);  
		$test = 0;
		while($row=mysqli_fetch_array($result))
		{

			//$row[4] = date("y.m.d",strtotime($row[4]));


			echo "
				<tr class=data>
					<td>$row[0]</td>
					<td>$row[1]</td>
					<td>$row[2]</td>
					<td>$row[3]</td>
					<td>$row[4]</td>
					<td>$row[5]</td>
					<td>$row[6]</td>
					<td>$row[7]</td>
					<td>$row[8]</td>
					<td>$row[9]</td>
					<td>$row[10]</td>
				</tr>
			";
		}
	}
	
	if($insertFlag){
		// $req_col_array[5] 담당팀 정하기

		$req_count++;
		$pattern = ",";
		
		$req_col_array = array();
		$req_col_array = explode($pattern, $req_col);

		$req_col_array[12] = $req_col_array[10] - $req_col_array[11];

		$rowNum = array(10,11,12);
		$moneyArry = array();
		for($i=0; $i<3; $i++){
			$moneyArry[$i] = number_format((int)$req_col_array[$rowNum[$i]]);
		}	
		


		$cquery = "SELECT * FROM sid_combine_table WHERE SID = ".$req_col_array[6];
		$cresult = mysqli_query($conn,$cquery);
		$crow = mysqli_fetch_array($cresult);
		$t_position = $crow['sid_combine_position'];
		//작성자~담당자 직책 찾기

		
		$squery = "SELECT MAX(master_task_level_sub_code) as max FROM master_task_level_sub_info_table";
		$sresult = mysqli_query($conn,$squery);
		$srow = mysqli_fetch_array($sresult);
		$target_key = $srow['max'] + 1; 
		//연관된 테이블 master management의 외래키 설정용

		$t_title = $req_col_array[1];
		$t_customer = $req_col_array[2];
		$t_superviser = $req_col_array[3];
		$t_order_section = $req_col_array[5];
		$t_orderer = $req_col_array[6]; 
		$t_birth = $req_col_array[7];
		$t_from = $req_col_array[8];
		$t_to = $req_col_array[9];   
		$t_all_money = $moneyArry[0];
		$t_use_money = $moneyArry[1];
		$t_remaind_money = $moneyArry[2];		
		$t_contents = $req_col_array[13];
		//수금은 먼지 몰라서 패스
		//마침 업무 등급(t_levl) 입력하는 곳도 없었기에 수금을 업무 등급으로 활용함
		//업무 등급의 자료형은 4bit
		$target_level = $req_col_array[14];
		$t_detail_state = $req_col_array[15];  	


				//  sub level table의 key값은 auto inc 처리 되어 있음.$_COOKIE
				// 
				//  INSERT TO VALUES 를 구현하시오


				$ajax_query = "INSERT into master_task_level_sub_info_table(master_task_level_code,master_task_level_sub_name,sub_level_order_section,sub_level_position,sub_level_orderer,sub_level_from_date,sub_level_to_date,sub_level_birth_date,task_detail_state,task_dp_state,all_money_master_code_field,use_money_master_code_field,remaind_money_master_code_field,etcetera,master_customer,master_superviser)
				 VALUES ($target_level,'$t_title',$t_order_section,$t_position,$t_orderer,'$t_from','$t_to','$t_birth',$t_detail_state,30,$t_all_money,$t_use_money,$t_remaind_money,$t_contents,$t_customer,$t_superviser)";

				$ajax_result = mysqli_query($conn,$ajax_query);


				$ajax_query = "INSERT into master_task_level_sub_info_table(master_task_level_code,master_task_level_sub_name,sub_level_order_section,sub_level_position,sub_level_orderer,sub_level_from_date,sub_level_to_date,sub_level_birth_date,task_detail_state,task_dp_state,all_money_master_code_field,use_money_master_code_field,remaind_money_master_code_field,etcetera,master_customer,master_superviser)
				VALUES ($target_level,'$t_title',$t_order_section,$t_position,$t_orderer,'$t_from','$t_to','$t_birth',$t_detail_state,30,$t_all_money,$t_use_money,$t_remaind_money,$t_contents,$t_customer,$t_superviser)";

			   $ajax_result = mysqli_query($conn,$ajax_query);
				



			echo "
				<tr id=\"rowData\" class=\"c$req_line rowData\" \">
					<td style=\"width:1%;\">$req_count</td>
					<td style=\"width:6%;\">$req_col_array[0]</td>
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
					<td style=\"width:5%;\" class=\"$\">$req_col_array[15]</td>		
					<td></td>							
				</tr>	
			";

		if($req_line==1){
			$req_line=0;
		}else{
			$req_line=1;
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
		if($req_header_col=="s_v"){
			$req_header_col = "ms.master_name";
		}
		if($req_header_col=="u_c"){
			$req_header_col = "mt.master_task_level_sub_code";
		}
		if($req_header_col=="m_d"){
			$req_header_col = "md.master_department_info_name";
		}
		if($req_header_col=="a_c"){
			$req_header_col = "mt.complete_rate";
		}
		if($req_header_col=="g_m"){
			$req_header_col = "mt.";
		}


		$query =   
		"SELECT
			mt.master_task_level_sub_code,	mt.master_task_level_sub_name,
			mc.master_name,	ms.master_name,
			mu.master_user_info_name,	md.master_department_info_name,
			mt.sub_level_from_date,	mt.sub_level_birth_date, mt.sub_level_to_date,
			mt.all_money_master_code_field,	mt.use_money_master_code_field,	mt.remaind_money_master_code_field,
			mt.etcetera, mt.complete_rate, mt.sub_management
		 FROM 	
			master_task_level_sub_info_table mt,master_customer_table mc,master_department_info_table md,master_user_info_table mu,
			master_superviser_table ms
		 WHERE 
			mt.master_customer = mc.master_code AND	mt.sub_level_orderer = mu.SID AND mt.sub_level_order_section = md.sid_combine_department AND
			mt.master_superviser = ms.master_code
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

			$state = "진행중";
			if(		$row[13] == 0){ $activity ="false"; $state = "진행중";}
			else{	$activity ="true";	$state = "완료";}

			// 삼항식으로 줄여 주세요
			if( $line == "0" ){ 
				$line = "1";
			}else {
				$line = "0";
			}
			
			$fun = "";
			$sub = "";
			if($row[14]!=0){
				$sub = "<button id='sub'></button>";
				$fun = "state_activity(this.id,$row[0]);";
			}

			echo (
			"
			<tr id=\"rowData\" class=\"c$line rowData\" onclick=$fun>
				<td style=\"width:1%;\">$count</td>
				<td style=\"width:6%;\"><a href=\"#\">$row[0]</td>
				<td style=\"width:19%;\" class=\"title\">$row[1]</td>
				<td style=\"width:6%;\">$row[2]</td>
				<td style=\"width:5%;\" class=\"coworker\">$row[3]</td>
				<td style=\"width:4%;\">$row[4]</td>
				<td style=\"width:7%;\">$row[5]</td>
				<td style=\"width:4%;\">6</td>
				<td style=\"width:4%;\">$dayArray[0]</td>
				<td style=\"width:4%;\">$dayArray[1]</td>
				<td style=\"width:4%;\">$dayArray[2]</td>
				<td style=\"width:7%;\" class=\"_m\">$moneyArry[0]</td>
				<td style=\"width:7%;\" class=\"_m\">$moneyArry[1]</td>
				<td style=\"width:7%;\" class=\"_m\">$moneyArry[2]</td>
				<td style=\"width:4%;\">$row[12]</td>
				<td style=\"width:4%;\"></td>	
				<td style=\"width:4%;\" id=\"$activity\">$state</td>
				<td style=\"width:5%;\">$sub</td>								
			</tr>
			"
			);
		}
	}

?>