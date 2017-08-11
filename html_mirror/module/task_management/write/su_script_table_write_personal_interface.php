<!DOCTYPE html>

<?php
session_start();

	include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_class_loader.php');
	include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_user_login_check.php');
	include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_db_connecter.php');
	include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_server_state_check.php');



$ob2 = new su_class_value_name_convert_with_code();


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


?>






<html>
	<head>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />
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
										window.resizeTo(screen.availWidth/2,screen.availHeight*0.46); // 지정한 크기로 변한다.(가로,세로)
										//window.resizeBy(500,500); // 지정한 크기만큼 더하거나 빼져서 변한다.
						</script>
						
			<script type="text/javascript">
				//첨부파일 추가

				var rowIndex = 1;

						   

				function addFile(form){

					if(rowIndex > 10) return false;

					rowIndex++;

					var getTable = document.getElementById("insertTable");

				var oCurrentRow = getTable.insertRow(getTable.rows.length);

					var oCurrentCell = oCurrentRow.insertCell(0);

					oCurrentCell.innerHTML = "<tr><td colspan=2><INPUT TYPE='FILE' NAME='filename" + rowIndex + "' size=25></td></tr>";

				}

			   

				//첨부파일 삭제

				function deleteFile(form){

					if(rowIndex<2){

						return false;

					}else{

						rowIndex--;

						var getTable = document.getElementById("insertTable");

						getTable.deleteRow(rowIndex);

				   }

				}

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
						function selectEvent(selectObj,field_index){
     					 // You can't define php variables in java script as $course etc.


							var popUrl = "./combobox_modifier/su_function_combobox_of_header_write_page.php";	//팝업창에 출력될 페이지 URL
							var popOption = "width=680, height=680, resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
							window.location.href = popUrl+'?var=' + selectObj.value + '&index=' +field_index;


    
						}

	</script>

	</head>


	<body>
	
		<div id="wapper" style="background-color:#f5f4e9; width:100%; height:100%; border:1px solid black">
				<div id="first" style="background-color:skyblue; width:100%;height:30px; border:2px solid black">
			</div>		
				<form action = './su_script_table_write_logic.php' method='POST' name="table_filter">
					
						<div align="center"><h2>등 록</h2></div>
					<DIV style='display:block'> 
					<table border='1' width=100%;>
			
					<tr>
						<td  colspan="1"width=25%;>업 무 등 급</td>
							<td  colspan="1" width=25%><select id = "task_writer_interface_combobox" name = "task_select_box[]" onchange="javascript:selectEvent(this,0);">	
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

					<td  colspan="1">사업명</td>
						<td  colspan="1">
						<select name = "task_select_box[]" onchange="javascript:selectEvent(this,1);">	
       							 <?php
															$query = "SELECT * FROM master_task_level_sub_info_table";
															$result = mysqli_query($conn, $query);
															echo "<option value='new' selected>신규 사업</option>";
												  //if($_SESSION['sub_hold_level']=='new'){
            											 		// echo "<option value='new' selected>신규 사업 생성</option>"; 
															/*}else{
																echo "<option value='new'>신규 사업 생성</option>"; 
															}
												 
           										 while( $row=mysqli_fetch_array($result) ){    
														
														if(($row['master_task_level_code']==$_SESSION['hold_level'])&&($row['master_task_level_sub_code']!=999)){
															if($row['master_task_level_sub_code']==$_SESSION['sub_hold_level']){
            											 		echo "<option value='".$row['master_task_level_sub_code']."' selected>".$row['master_task_level_sub_name']."</option>";
															}else{
															echo "<option value='".$row['master_task_level_sub_code']."'>".$row['master_task_level_sub_name']."</option>";
															}
															
														   
														}
													
													}*/
															?>         
   						</select>	
					</td>

					</tr>
						<?php
						if (true) {
							echo "<tr>";
							echo "<td>신규사업명</td>";
							echo "<td  colspan='1'><input type=text name='task_select_box[]' size=30% ></td>";
							echo "</tr>";
						}
						?>
					<tr>
						<td  colspan="1">발 주 처</td>
						<td  colspan="1"><?php echo $_SESSION['my_department']; ?></td>
						<td  colspan="1">발 주 자</td>
						<td  colspan="1"><?php echo $_SESSION['my_name']; ?></td>
					</tr>

					<tr>
						<td>사 업 기 간</td>
						<td colspan=3><input type="text" name = "task_select_box[]" id="datepicker1" value=<?php echo $_SESSION['now_date']; ?>>~
						<input type="text" name = "task_select_box[]" id="datepicker2" value=<?php echo $_SESSION['now_date']; ?>></td>
					</tr>

				
					</table>

					</div>


				<div style="padding:10px 0 0 0;">
					</div>
					

					
					
						<div align="center">관 리 자 상 신</div>
					<DIV style='display:block'> 
					<table>
					
					<tr>
							<td class='td5'>상 신 의 견</td>
							<td>
							<textarea name="task_select_box[]" class="nse_content" rows ="1" cols="35">관리자 모듈이 완성되면 해당 필드의 내용이 관리자의 요청 게시판에 전송됩니다. 관리자는 그것을 보고, 새로운 용역/사업의 추가 사실을 알고 관리를 할 수 있습니다.</textarea>
							</td>

					</tr>
					</table>
					</div>
					
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					

					<tr>
						<td>
							<div align = 'center'><input type="submit" value="작성 완료" ></div>
						</td>
					</tr>

					</form>
						
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					
					
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
					<p align="center">첨 부 파 일</p>
					</a><DIV style='display:none'> 
					
					<form name="write">
					 <table id='insertTable' border=0 cellpadding=0 cellspacing=0>

						<tr>

							<td valign=bottom>

								<INPUT type='file' maxLength='100' name='filename1' size='25'>

							</td>

							<td >
								
								&nbsp&nbsp
								<input type="button" value="추가" onClick="addFile(this.form)" border=0 style='cursor:hand'>
								/			
								<input type="button" value="삭제" onClick='deleteFile(this.form)' border=0 style='cursor:hand'>

							</td>

							</tr>
						</tr>
						</table>

						<input type="hidden" name="rowCount" value="1">

					</form>        

					</div>

					

					<!--검토자 고려해서 만들기-->
					
			
			
		</div>
		
		<!-- 새로운 달력 자바 스크립트 소스-->
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>                     
      	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	</body>
</html>