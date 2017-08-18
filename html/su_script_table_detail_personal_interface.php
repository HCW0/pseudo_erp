<!DOCTYPE html>

<?php
session_start();


	
// 유저 세션 검증
if (!isset($_SESSION['is_login'])) {
	header('Location: ./su_script_logout_support.php');
};


// include function
function my_autoloader($class)
{
	include './classes/' . $class . '.php';
}

spl_autoload_register('my_autoloader');


//db 연결 파트
$conn = mysqli_connect('localhost', 'root', '9708258a');
if (!$conn) {
	$_SESSION['msg'] = 'DB연결에 실패하였습니다.';
	header('Location: ./su_script_login_interface.php');
}
$use = mysqli_select_db($conn, "suproject");
if (!$use) die('cannot open db' . mysqli_error($conn));

$ob2 = new su_class_value_name_convert_with_code();


if (!isset($_SESSION['sub_title'])) {

	$_SESSION['sub_title'] = '';
}

if (!isset($_SESSION['hold_level'])) {

	$_SESSION['hold_level'] = 1;
}
if (!isset($_SESSION['sub_hold_level'])) {

	$_SESSION['sub_hold_level'] = 1;
}
if (!isset($_SESSION['new_sub_level_awaked'])) {

	$_SESSION['new_sub_level_awaked'] = 1;
}
if (!isset($_SESSION['new_sub_level_commander'])) {

	$_SESSION['new_sub_level_commander'] = $_SESSION['my_sid_code'];
}


					$target_sub_id = $_GET['sub_id'];


					$tquery = "SELECT * FROM master_task_level_sub_info_table WHERE 	master_task_level_sub_code = $target_sub_id";
					$tresult = mysqli_query($conn, $tquery);
					$trow = mysqli_fetch_array($tresult);





?>






<html>
	<head>
			<meta charset="utf-8" />
			<!-- <meta name="viewport" content="width=device-width, initial-scale=1" /> -->
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
			<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	    
		  	<script src="//code.jquery.com/jquery.min.js"></script>
    	    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
			<script type="text/javascript" src="/assets/nse_files/js/HuskyEZCreator.js" charset="utf-8"></script>
		
			<title>글쓰기</title>
			<style>
					@import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
					html, body {
						font-family: 'Nanum Gothic', sans-serif;
						height:98%;
					}
					.nse_content{width:600px;height:50px}
					.nse_content2{width:600px;height:130px}



					.tr1 {height:50px;background:#ace;}
					.td1 {}
					.td2 {vertical-align:center}
					.td3 {vertical-align:middle}
					.td4 {vertical-align:asdfasdf}
					.td5 {vertical-align:top}
					.td6 {vertical-align:bottom}


			</style>

						<script language="javascript">
										window.resizeTo(screen.availWidth/2,screen.availHeight*0.45); // 지정한 크기로 변한다.(가로,세로)
										//window.resizeBy(500,500); // 지정한 크기만큼 더하거나 빼져서 변한다.
						</script>


			<script>               /*달력 함수*/
         $(function() {
				$("#datepicker1, #datepicker2").datepicker({
				dateFormat: 'yy-mm-dd'
				});
			});

		</script>

		<script>               /*달력 함수2*/
         $(function() {
				$("#datepicker3, #datepicker4").datepicker({
				dateFormat: 'yy-mm-dd'
				});
			});

		</script>


	<script> 
						function selectEvent(selectObj,field_index,title){
     					 // You can't define php variables in java script as $course etc.


							var popUrl = "./common_func/su_function_real_time_combobox_sub_level_maker.php";	//팝업창에 출력될 페이지 URL
							var popOption = "width=680, height=680, resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
							window.location.href = popUrl+'?var=' + selectObj.value + '&index=' +field_index +'&title=' +title;


    
						}

						function empty_textarea(){

							$('.nse_content').empty();

						}

	</script>

	</head>


	<body>
	
		<div id="wapper" style="background-color:#f5f4e9; width:100%; height:100%; border:1px solid black">
				<div id="first" style="background-color:skyblue; width:100%;height:30px; border:2px solid black">
			</div>		
				<form action = 'outsource2new_sub.php' method='POST' name="table_filter">
					
						<div align="center"><h2>용역정보</h2></div>
					<DIV style='display:block'> 
					<table border='1' width=100%;>
			
					<tr>
						<td  colspan="1"width=25%;>업 무 등 급</td>
							<td  colspan="1" width=25%>
									<?php
										 echo $ob2->su_function_convert_name($conn,"master_task_level_info_table","master_task_level_code",$trow['master_task_level_code'],"master_task_level_name");
									?>
							</td>


						<input type="hidden" name="task_select_box[]">
						<td>신규사업명</td>
							<td  colspan="1" width=25%>
									<?php
										 echo $trow['master_task_level_sub_name'];
									?>
							</td>

					</tr>

					<tr>
						<td  colspan="1">발 주 처</td>
							<td  colspan="1" width=25%>
									<?php
										 echo $ob2->su_function_convert_name($conn,"master_customer_table","master_code",$trow['master_customer'],"master_name");
									?>
							</td>


						<td  colspan="1">감 독 관</td>
							<td  colspan="1" width=25%>
									<?php
										 echo $ob2->su_function_convert_name($conn,"master_customer_table","master_code",$trow['master_superviser'],"master_name");
									?>
							</td>
					</tr>

					<tr>
						<td  colspan="1">관 리 처</td>
						<td  colspan="1">
									<?php
										 echo $ob2->su_function_convert_name($conn,"master_department_info_table","sid_combine_department",$trow['sub_level_order_section'],"master_department_info_name");
									?>
						</td>
						<td  colspan="1">작 성 자</td>
						<td  colspan="1">
									<?php
										 echo $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$trow['sub_level_orderer'],"master_user_info_name");
									?>						
						</td>
					</tr>

					<tr>
						<td>계 약 기 간</td>
						<td colspan=3>
									<?php
										echo $trow['sub_level_from_date']." ~ ".$trow['sub_level_to_date'];
									?>	
						</td>
					</tr>


					<tr>
						<td>착 수 금</td>
						<td colspan=1>
									<?php
										echo $trow['all_money_master_code_field']." 원";
									?>	
						</td>
						<td>상 태</td>
						<td colspan=1>
									<?php
										 echo $ob2->su_function_convert_name($conn,"dmaster_state_info_table","master_code",$trow['task_detail_state'],"master_state_detail_name");
									?>							
						</td>
					</tr>
					<tr>
						<td>협업부서1</td>
						<td colspan=1>						
									<?php
										if($trow['sub_level_order_section_sub1']){
										 echo $ob2->su_function_convert_name($conn,"master_customer_table","master_code",$trow['sub_level_order_section_sub1'],"master_name");
										}else{
										 echo "--";	
										}
									?>
						</td>	
						<td>협업부서2</td>
						<td colspan=1>						
									<?php
										if($trow['sub_level_order_section_sub2']){
										 echo $ob2->su_function_convert_name($conn,"master_customer_table","master_code",$trow['sub_level_order_section_sub2'],"master_name");
										}else{
										 echo "--";	
										}	 
									?>
						</td>	
					</tr>

					
					<tr>
							<td class='td5'>상 신 의 견</td>
							<td colspan=7>
							<textarea name="task_select_box[]" class="nse_content" readonly="readonly"  rows ="1" cols="35"><?php echo $trow['etcetera'];?></textarea>
							</td>
					</tr>
			

					
					<tr>
						<td colspan=8>
							<?php 
								$upload_query = "select * from master_upload_table u where u.upload_id = " . $trow['upload_id'] . ";";
								$result_set3 = mysqli_query($conn, $upload_query);
								$update_row = mysqli_fetch_array($result_set3);

								$download_link = '';
								if ($update_row['server_name']) {
									$download_link = $_SESSION['root'] . "/storage/former/" . $update_row['server_name'];
								}


								if ($download_link!=''){
									echo "첨부파일 : ";
									echo "<a href='$download_link' download />".$update_row['real_name'];
								}else{
									echo "첨부 파일 없음";
								}

							?>
						
						</td>
					</tr>


					</form>					

			
				</table>


					

					<!--검토자 고려해서 만들기-->
					
			
			
		</div>
		
		<!-- 새로운 달력 자바 스크립트 소스-->
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>                     
      	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	</body>
</html>