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

$type = $_GET['type']; // 0이면 관리자 외 유저가 사업 등록 요청한 것, 1이면 관리자가 직접 등록한 것.


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
										window.resizeTo(screen.availWidth/2,screen.availHeight*0.486); // 지정한 크기로 변한다.(가로,세로)
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
				<form action = <?php echo "outsource2new_sub.php?type=".$type; ?> method='POST'  enctype="multipart/form-data"  name="table_filter">
					
						<div align="center"><h2>용역등록</h2></div>
					<DIV style='display:block'> 
					<table border='1' width=100%;>
			
					<tr>
						<td  colspan="1"width=25%;>업 무 등 급</td>
							<td  colspan="1" width=25%><select id = "task_writer_interface_combobox" name = "task_select_box[]" <?php echo "onchange='javascript:selectEvent(this,0,document.getElementbyID('sub_title').value);'"; ?>>	
									<?php
									$query = "SELECT * FROM master_task_level_info_table";
									$result = mysqli_query($conn, $query);
									while ($row = mysqli_fetch_array($result)) {
										if ($row['master_task_level_code'] != 15)
											if ($row['master_task_level_code'] == $_SESSION['hold_level']) {
											echo "<option value='" . $row['master_task_level_code'] . "' selected>" . $row['master_task_level_name'] . "</option>";
										}
										else {
											echo "<option value='" . $row['master_task_level_code'] . "'>" . $row['master_task_level_name'] . "</option>";
										}
									}
									?>         
								</select>	
							</td>



						<?php

							echo "<td>신규사업명</td>";
							echo "<td  colspan='1'><input type=text id=title name='task_select_box[]' size=30% value=".$_SESSION['sub_title']."></td>";
						?>

					</tr>

					<tr>


						<td  colspan="1">발 주 처</td>
							<td  colspan="1" width=25%><select id = "task_writer_interface_combobox" name = "customer" >	
									<?php
									$query = "SELECT * FROM master_customer_table";
									$result = mysqli_query($conn, $query);
									while ($row = mysqli_fetch_array($result)) {

											echo "<option value='" . $row['master_code'] . "' selected>" . $row['master_name'] . "</option>";
									
									}
									?>         
								</select>	
							</td>


						<td  colspan="1">감 독 관</td>
							<td  colspan="1" width=25%><select id = "task_writer_interface_combobox" name = "superviser" >	
									<?php
									$query = "SELECT * FROM master_superviser_table";
									$result = mysqli_query($conn, $query);
									while ($row = mysqli_fetch_array($result)) {

											echo "<option value='" . $row['master_code'] . "' selected>" . $row['master_name'] . "</option>";
									
									}
									?>         
								</select>	
							</td>

					</tr>

					<tr>
						<td  colspan="1">관 리 처</td>
						<td  colspan="1"><?php echo $_SESSION['my_department']; ?></td>
						<td  colspan="1">작 성 자</td>
						<td  colspan="1"><?php echo $_SESSION['my_name']; ?></td>
					</tr>

					<tr>
						<td>계 약 기 간</td>
						<td colspan=3><input type="text" name = "task_select_box[]" id="datepicker1" value=<?php echo $_SESSION['now_date']; ?>>~
						<input type="text" name = "task_select_box[]" id="datepicker2" value=<?php echo $_SESSION['now_date']; ?>></td>
					</tr>


					<tr>
						<td>착 수 금</td>
						<td colspan=1><input type="text" name = "start_money"></td>
						<td>상 태</td>
						<td colspan=1>
								<select name = "state">	
									<?php
									$query = "SELECT * FROM dmaster_state_info_table";
									$result = mysqli_query($conn, $query);
									while ($row = mysqli_fetch_array($result)) {
										if ($row['master_code'] != 99 && $row['master_code']%10==0)
											echo "<option value='" . $row['master_code'] . "'>" . $row['master_state_detail_name'] . "</option>";							
									}
									?>         
								</select>	
						
						</td>
					</tr>
					<tr>
						<td>협업부서1</td>
						<td colspan=1>						
								<select name = "suketo1">	
									<?php
									$query = "SELECT * FROM master_department_info_table";
									$result = mysqli_query($conn, $query);
									echo "<option value=''>--</option>";	
									while ($row = mysqli_fetch_array($result)) {
										if ($row['sid_combine_department'] != 8388607)
											echo "<option value='" . $row['sid_combine_department'] . "'>" . $row['master_department_info_name'] . "</option>";							
									}
									?>         
								</select>
						</td>	
						<td>협업부서2</td>
						<td colspan=1>						
								<select name = "suketo2">	
									<?php
									$query = "SELECT * FROM master_department_info_table";
									$result = mysqli_query($conn, $query);
									echo "<option value=''>--</option>";										
									while ($row = mysqli_fetch_array($result)) {
										if ($row['sid_combine_department'] != 8388607)
											echo "<option value='" . $row['sid_combine_department'] . "'>" . $row['master_department_info_name'] . "</option>";							
									}
									?>         
								</select>
						</td>	
					</tr>

					<?php
					if($type==0){
							echo "<tr>";
									echo "<td class='td5'>상 신 의 견</td>";
									echo "<td colspan=7>";
									echo "<textarea name='opinion' class='nse_content' placeholder='관리자 모듈이 완성되면 해당 필드의 내용이 관리자의 요청 게시판에 전송됩니다. 관리자는 그것을 보고, 새로운 용역/사업의 추가 사실을 알고 관리를 할 수 있습니다.' rows ='1' cols='35'></textarea>";
									echo "</td>";

							echo "</tr>";
					}
					?>

					</table>
					</div>
					
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					
					<table id='insertTable' border=0 cellpadding=0 cellspacing=0>

						<tr>

							<td valign=bottom>

								<INPUT type='file' accept=".gif, .jpg, .png" maxLength='100'   name="upload_file" size='25'>

							</td>


							</tr>
	

						</table>
						<div align = 'right' style="padding: 0px 40px 0px 0px"><input type="submit" value="완료" ></div>
						<input type="hidden" name="rowCount" value="1">

					</form>      				
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					
					


					

					<!--검토자 고려해서 만들기-->
					
			
			
		</div>
		
		<!-- 새로운 달력 자바 스크립트 소스-->
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>                     
      	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	</body>
</html>