<!DOCTYPE html>

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

		$ob2 = new su_class_value_name_convert_with_code();


		if(!isset($_SESSION['hold_level'])){
			
			$_SESSION['hold_level']=1;
		}
		if(!isset($_SESSION['sub_hold_level'])){
			
			$_SESSION['sub_hold_level']=1;
		}

		if(isset($_GET['task_title'])){
			$default_title = $_GET['task_title'];
		}else{
			$default_title = ' ';
		}




					//수정할 대상의 task id를 받아온다.
		            $target_tid = $_GET['tid'];
					

					//기존의 입력 값들을 각 form에 불러와야하니 sql쿼리문으로 row array도 하나 만든다.
					$target_query = "SELECT * FROM task_document_header_table u WHERE u.TID = $target_tid;";
					$target_result = mysqli_query($conn,$target_query);  
					$target_field=mysqli_fetch_array($target_result);

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


    <script type="text/javascript">
function findTotal(){
    var arr = document.getElementsByName('qty');
    var arr2 = document.getElementsByName('qty2');
    var tot=parseInt(arr[0].value) - parseInt(arr2[0].value);
	if(arr[0].value>0&&arr2[0].value>0)
    document.getElementById('total').value = tot;
}

    </script>


<script language="javascript">
				window.resizeTo(screen.availWidth/2,screen.availHeight*0.86); // 지정한 크기로 변한다.(가로,세로)
				//window.resizeBy(500,500); // 지정한 크기만큼 더하거나 빼져서 변한다.






					function hrefClick_of_delete_task(local){
						// You can't define php variables in java script as $course etc.

					window.location.href='outsource5delete.php?TID=' + local;
				


					}




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


							var popUrl = "./common_func/su_function_real_time_combobox_b.php";	//팝업창에 출력될 페이지 URL
							var popOption = "width=680, height=680, resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
							window.location.href = popUrl+'?var=' + selectObj.value + '&index=' +field_index;


    
						}

						function get_path_index(task_title){

							 window.resizeTo(1300,370);
   							 window.location.href = './su_script_approbation_path_write_interface_not_manager.php';
						}

	</script>





	</head>


	<body>
	
		<div id="wapper" style="background-color:#f5f4e9; width:100%; height:100%; border:1px solid black">
			<div id="first" style="background-color:skyblue; width:100%;height:30px; border:2px solid black">
			</div>
				<form action = "<?php echo './outsource2b.php?tid='.$target_tid; ?>" method='POST' enctype="multipart/form-data"  name="table_filter">
					
						<div align="center"><h2>실 적 관 리</h2></div>
					<DIV style='display:block'> 
					<table width=100% border='1'>
			
					<tr>
						<td  colspan="1">업 무 레 벨</td>
							<td  colspan="2">

									<?php
											$query = "SELECT * FROM master_task_level_info_table";
											$result = mysqli_query($conn,$query);  
													while( $row=mysqli_fetch_array($result) ){         
															if($row['master_task_level_code']!=15)
															if($row['master_task_level_code']==$_SESSION['hold_level']){
																echo "<option value='".$row['master_task_level_code']."' selected>".$row['master_task_level_name']."</option>";
															}
														}
									?>         

							</td>

								<td  colspan="1">업 무 코 드</td>
						<td  colspan="2">
						
       							 <?php
										$query = "SELECT * FROM master_task_level_sub_info_table";
     					        		$result = mysqli_query($conn,$query); 
           										 while( $row=mysqli_fetch_array($result) ){    
														
														if(($row['master_task_level_code']==$_SESSION['hold_level'])&&($row['master_task_level_sub_code']!=999)){
															if($row['master_task_level_sub_code']==$_SESSION['sub_hold_level']){
            											 		echo "<option value='".$row['master_task_level_sub_code']."' selected>".$row['master_task_level_sub_name']."</option>";
															}
														   
														}
													
													}
      							  ?>         
   							
					</td>
					</tr>
							<tr>
						<td>진 행 업 무</td>
						<td  colspan="5"><input id='task_title' type=text name=task_select_box[] size=60 value="<?php echo $target_field['task_name']; ?>"></td>
						
					</tr>
					<tr>
						<td  colspan="1">발 주 처</td>
						<td  colspan="2"><?php echo $_SESSION['my_department'];?></td>
						<td  colspan="1">발 주 자</td>
						<td  colspan="2"><?php echo $_SESSION['my_name'];?></td>
					</tr>
					<tr>
						
						<td  colspan="1">우 선 도</td>
						<td  colspan="2">
							<select  name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM master_priority_info_table";
     					        		$result = mysqli_query($conn,$query);  
           										 while( $row=mysqli_fetch_array($result) ){    
													if($row['master_task_priority_info_code']!=3){

														if($target_field['task_priority']==$row['master_task_priority_info_code']){
														echo "<option value='".$row['master_task_priority_info_code']."' selected>".$row['master_task_priority_info_name']."</option>";
														}else{
														echo "<option value='".$row['master_task_priority_info_code']."'>".$row['master_task_priority_info_name']."</option>";	
														}                                           
													}
       										     }
      							  ?>          
   							</select>
						</td>

						

						<td  colspan="1">상 태 명</td>
						<td  colspan="2">
							<select  name = "task_select_box[]" id="ajax_state_header">	
       							 <?php
										$dstate_off = $target_field['task_detail_state'] - $target_field['task_detail_state']%10;
										echo $dstate_off;
										$query = "SELECT * FROM dmaster_state_info_table";
     					        		$result = mysqli_query($conn,$query);
										$query2 = "SELECT master_state_detail_name FROM dmaster_state_info_table where master_code=".$dstate_off.";";
     					        		$result2 = mysqli_query($conn,$query2); 
										$row2=mysqli_fetch_array($result2);
           										 while( $row=mysqli_fetch_array($result) ){    

														if($row['master_code']!=99 && $row['master_code']%10==0 && $dstate_off==$row['master_code']){
            											  echo "<option value='".$row['master_code']."' selected>".$row['master_state_detail_name']."</option>";
														}else if($row['master_code']!=99 && $row['master_code']%10==0 && $dstate_off){
														echo "<option value='".$row['master_code']."'>".$row['master_state_detail_name']."</option>";
														}
            											 
       										     }
      							  ?>          
   							</select>
						</td>


					</tr>

					<tr>
						<td>과 업 기 간</td>
						<td><input type="text" name = "task_select_box[]" id="datepicker1" value=<?php echo $target_field['task_base_date']; ?>></td>
						<td><input type="text" name = "task_select_box[]" id="datepicker2" value=<?php echo $target_field['task_limit_date']; ?>></td>
						<td>수 행 일</td>
						<td><input type="text" name = "task_select_box[]" id="datepicker3" value=<?php echo $target_field['task_elapsed_base_date']; ?>></td>
					</tr>
						<tr>
							
							<td>상위 업무명</td>
							<td>
							<select  name = "sub_task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM task_document_header_table u WHERE ".$_SESSION['sub_hold_level']."=u.task_level_sub_code";
     					        		$result = mysqli_query($conn,$query);  
										 echo "<option value='' selected>신규</option>"; 
            										 while( $row=mysqli_fetch_array($result) ){

														if($target_field['super_task_TID']==$row['TID']){ 
															if($target_field['super_task_TID']!=$target_field['TID'])
															echo "<option value='".$row['TID']."' selected>".$row['task_name']."</option>";
														}else{
															echo "<option value='".$row['TID']."'>".$row['task_name']."</option>";
														}
													}
      							  ?>         
   							</select>	
							
							</td>


						</tr>
				
					</table>

					</div>


				<div style="padding:10px 0 0 0;">
					</div>
					
		
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					
					
						<div align="center">상세 업무 내용</div>
					<DIV style='display:block'> 
					<table width=100% border='1'>


					<tr>
						
							<td>업무상황</td>
							<td>
							<select  name = "dstate"id='dstate_zone'>

								<?php
										$query2 = "SELECT master_state_detail_name FROM dmaster_state_info_table where master_code=".$target_field['task_detail_state'].";";
     					        		$result2 = mysqli_query($conn,$query2); 
										$row2=mysqli_fetch_array($result2);


												echo "<option value=".$target_field['task_detail_state'].">".$row2['master_state_detail_name']."</option>";	

								?>
												<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
												<script>

													$('#ajax_state_header').change(function(){
														$.ajax({
															url:'./ajax_code_generator/dstate_ajax_target.php',
															dataType:'json',
															success:function(data){
																var str = '';
																var selected = $('#ajax_state_header option:selected').val();
																for(var index in data){
																	if(index-selected>0 && index-selected<9)
																	str += '<option value='+index+'>'+data[index]+'</option>';
																}
																$('#dstate_zone').html('<ul>'+str+'</ul>');
															}
														})
													})
												</script>


   							</select>
							</td>
							<td>관련업체</td>
							<td>
								<input id='task_title' type=text name=relate_sp value='<?php echo $target_field['coworkspace']; ?>'>
							</td>
							<td>감독관</td>
							<td>
								<input id='task_title' type=text name=relate_org value='<?php echo $target_field['coworker']; ?>'>
							</td>
						</tr>


						<tr>
							<td>할당금</td>
							<td>
								<input onblur="findTotal()" type="text" name="qty"  value='<?php echo $target_field['all_money_master_code_field']; ?>' /><br>
							</td>
							<td>사용액</td>
							<td>
								<input onblur="findTotal()" type="text" name="qty2"  value='<?php echo $target_field['use_money_master_code_field']; ?>' /><br>
							</td>
							<td>잔여액</td>
							<td>
								<input type="text" name="total" id="total"  value='<?php echo $target_field['remaind_money_master_code_field']; ?>' />
							</td>

						</tr>


						<tr>
							<td class='td5'>업 무 진 행</td>
							<td colspan=5>
							<textarea name="dcontent" class="nse_content2" rows ="1" cols="35"><?php echo $target_field['etcetera']; ?></textarea>
							</td>						
						</tr>


					</div>
					

					<table id='insertTable' border=0 cellpadding=0 cellspacing=0>

						<tr>

							<td valign=bottom>


								<?php
									echo "</td>";
									if($target_field['upload_id']){
										echo "첨부된 파일 : ";
										$query = "select * from master_upload_table u where u.upload_id = ".$target_field['upload_id'].";";
										$result = mysqli_query($conn,$query);
																$row = mysqli_fetch_array($result);
																$real_name = $row['real_name'];
																$server_name = $row['server_name'];

																echo "<a href='./storage/task_sheet/".$_SESSION['my_department_code']."/$server_name' download>".$real_name."</a>";
																echo "<td valign=bottom>";
									}
									
								?>
								첨부 파일 변경 : <INPUT type='file' accept=".gif, .jpg, .png" maxLength='100'   name="upload_file" size='25'>

							</td>

							</tr>
	

						</table>
						<div align = 'right' style="padding: 0px 40px 0px 0px">
							<?php echo"<input type='button' value='삭제' onclick='hrefClick_of_delete_task(".$target_tid.");'/>"?>
							<input type="submit" value="완료" >
							
						</div>
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