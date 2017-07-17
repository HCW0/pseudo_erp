<!DOCTYPE html>

<html>

<?php
    session_start();


// 유저 세션 검증
	if(!isset($_SESSION['is_login'])){
		header('Location: ./su_script_logout_support.php');
	};


// include function
     function my_autoloader($class){
         include './classes/'.$class.'.php';
    }

 spl_autoload_register('my_autoloader');


//db 연결 파트
        $conn = mysqli_connect('localhost','root','9708258a');
        if(!$conn) { $_SESSION['msg']='DB연결에 실패하였습니다.';
                     header('Location: ./su_script_login_interface.php');
        }
        $use = mysqli_select_db($conn,"suproject");
        if(!$use) die('cannot open db'.mysqli_error($conn));


// class 객체 생성

		$ob1 = new su_class_task_table_config();


		//임시코드

		if(isset($_SESSION['current_task_level_code'])==false){
			$_SESSION['current_base_date']="";
			$_SESSION['current_limit_date']="";
			$_SESSION['current_task_level_code'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_level_code");
			$_SESSION['current_task_level_sub_code'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_level_sub_code");
			$_SESSION['current_task_order_section'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_order_section");
			$_SESSION['current_task_orderer'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_orderer");
			$_SESSION['current_task_priority'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_priority");
			$_SESSION['current_task_state'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_state");
		}

		$ob2 = new su_class_value_name_convert_with_code();
			$_SESSION['my_name'] = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$_SESSION['my_sid_code'],"master_user_info_name");
			$_SESSION['my_position'] = $ob2->su_function_convert_name($conn,"master_position_info_table","sid_combine_position",$_SESSION['my_position_code'],"master_position_info_name");
			$_SESSION['my_department'] = $ob2->su_function_convert_name($conn,"master_department_info_table","sid_combine_department",$_SESSION['my_department_code'],"master_department_info_name");


		$ob3 = new su_class_value_combine_combobox_value_to_mysql_query();
		


// 하드 코딩된 함수 이하

function toWeekNum($get_year, $get_month, $get_day){
 $timestamp = mktime(0, 0, 0, $get_month, $get_day, $get_year);
 $w = date('w',mktime(0,0,0,date('n',$timestamp),1,date('Y',$timestamp)));
 return ceil(($w + date('j',$timestamp) - 1)/7);
}





		
?>

<!-- 하드 코딩된 함수 이하 -->



	<script> 
						function hrefClick(course){
     					 // You can't define php variables in java script as $course etc.


	  					var popUrl = "/su_script_task_detail_pop_up.php";	//팝업창에 출력될 페이지 URL
						var popOption = "width=680, height=680, resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
						window.open(popUrl+'?TID=' + course,popOption,'width=680,height=680');


    
						}

						</script>



	<head>
		<title>test</title>
		<meta charset="utf-8" />
		
<!--		<meta name="viewport" content="width=device-width, initial-scale=1" />  -->
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=2, user-scalable=yes">

		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,600,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="assets/css/reset.css"> <!-- CSS reset -->
		<link rel="stylesheet" href="assets/css/style.css"> <!-- Resource style -->
		<script src="assets/js/modernizr.js"></script> <!-- Modernizr -->
	
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      	<script src="//code.jquery.com/jquery.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	
	
<style>
  table {
    width: 100%;
    border-top: 1px solid #444444;
    border-collapse: collapse;
  }
  th, td {
    border-bottom: 1px solid #444444;
    padding: 1px;
    text-align: center;
  }

  th:nth-child(2n), td:nth-child(2n) {
    background-color: #;
  }
  th:nth-child(2n+1), td:nth-child(2n+1) {
    background-color: #;
  }

 

</style>

  </head>
	<body>

					<table width="100%" >
						<tr  >
							<th style="border-width:2px; border-color:black;border-style:solid; vertical-align:middle;" rowspan='2' >
								작업시간
							</th >
							
							<th style="border-width:2px; border-color:black;border-style:solid;" colspan='3' >
								협업인원 
							</th>
							
							<th style="border-width:2px; border-color:black;border-style:solid;" colspan='2' >
								사용한 장비 
							</th>

							<th style="border-width:2px; border-color:black;border-style:solid;" colspan='2'>
								작업장소 
					
							</th>
							
							<th style="border-width:2px; border-color:black;border-style:solid; vertical-align:middle; width:300px" rowspan='2'>
								작업내용 
					
							</th>
						</tr>
						
						<tr >
							<th style="border-width:2px; border-color:black;border-style:solid;" colspan='1' >
							내부 인력
							</th>
							<th style="border-width:2px; border-color:black;border-style:solid;">
							외부 인력
							</th>
							<th style="border-width:2px; border-color:black;border-style:solid; width:70px;">
							총인원수
							</th>
							<th style="border-width:2px; border-color:black;border-style:solid;">
							장비명
							</th>
							<th style="border-width:2px; border-color:black;border-style:solid;">
							수량
							</th>
							<th style="border-width:2px; border-color:black;border-style:solid;">
							위치
							</th>
							<th style="border-width:2px; border-color:black;border-style:solid;">
							면적
							</th>
							
						</tr>
						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>

					</table>
				
	</body>     
</html>