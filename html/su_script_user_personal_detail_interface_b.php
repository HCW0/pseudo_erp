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


		<script> 
		function hrefClick(course,course2){
			// You can't define php variables in java script as $course etc.


		var popUrl = "/su_script_task_approbation_detail_pop_up.php";	//팝업창에 출력될 페이지 URL
		var popOption = "resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
		window.open(popUrl+'?AID=' + course + '&TID=' + course2,popOption,'width=680,height=680');



		}


		function confirm_message(target_tid,id){

			var arr = ["상신","승인","반려"];

				var retVal = confirm("해당 업무를 "+arr[id]+"하시겠습니까?");

			if(retVal==true){
				alert(arr[id]+"처리되었습니다.");
				window.location.href='outsource5go_appro.php?target=' + target_tid + '&type=' + id;
			}else{
				alert("취소하셨습니다.");
			}
		
		
		}

		</script>	



<script language="javascript">
				window.resizeTo(screen.availWidth/2,screen.availHeight*0.86); // 지정한 크기로 변한다.(가로,세로)
				//window.resizeBy(500,500); // 지정한 크기만큼 더하거나 빼져서 변한다.






					function hrefClick_of_delete_task(local){
						// You can't define php variables in java script as $course etc.

					window.location.href='outsource5delete.php?TID=' + local;
				


					}


function generate_reserve(){
							var dt = new Date();
							var dt2 = new Date();
							var arr = document.getElementsByName('reserve_flag');
							if(arr[0].value==1){
							
							// 예약의 경우

							var dayOfMonth = dt.getDate();
							dt.setDate(dayOfMonth + 7);
							dt2.setDate(dayOfMonth + 14);



								var month = dt.getMonth()+1;
								var day = dt.getDate();
								var year = dt.getFullYear();

								day=prependZero(day, 2);
								month=prependZero(month, 2);

								document.getElementById('datepicker1').value =year  + '-' + month + '-' + day;
								document.getElementById('datepicker3').value =year  + '-' + month + '-' + day;
								
								var month = dt2.getMonth()+1;
								var day = dt2.getDate();
								var year = dt2.getFullYear();

								day=prependZero(day, 2);
								month=prependZero(month, 2);

								document.getElementById('datepicker2').value =year  + '-' + month + '-' + day;

								reservedFunc(1);

							}else{


							// 실적의 경우

								var month = dt.getMonth()+1;
								var day = dt.getDate();
								var year = dt.getFullYear();

								day=prependZero(day, 2);
								month=prependZero(month, 2);

								document.getElementById('datepicker1').value =year  + '-' + month + '-' + day;
								document.getElementById('datepicker2').value =year  + '-' + month + '-' + day;
								document.getElementById('datepicker3').value =year  + '-' + month + '-' + day;

								reservedFunc(0);
							}
						}


						function prependZero(num, len) {
									while(num.toString().length < len) {
										num = "0" + num;
									}
									return num;
							}



						function reservedFunc(val){
								//예약을 선택하면 관련 상태의 콤보박스가 선택되는 그것
								
								if(val==1){


									document.getElementById('ajax_state_header').value = 10 ;
									
																		
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



								}else{

									document.getElementById('ajax_state_header').value = 50 ;


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

																			

								}

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



		<script> 
					function hrefClick_of_sub_task(level,sub_level,tid){
						// You can't define php variables in java script as $course etc.

					var popOption = "fullscreen=yes, resizable=0, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
					var popUrl = "/outsource5.php";	//팝업창에 출력될 페이지 URL
					window.open(popUrl+'?level=' + level +'&sub_level=' + sub_level +'&tid=' + tid,popOption,'height=' + (screen.height-50) + ',width=' + (screen.width+50));
				
			

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
						<td  colspan="1">업 무 등 급</td>
							<td  colspan="2">

									<?php
											$last_appro_trigger=true;
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

								<td  colspan="1">사 업 명</td>
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
						<td  colspan="2"><input id='task_title' type=text name=task_select_box[] size=50% value="<?php echo $target_field['task_name']; ?>"></td>


						

						<td>업 무 타 입</td>
						<td>
									<select onchange="generate_reserve()"  name = "reserve_flag" id='ajax_state_header2'>	
										<option value=0>실적업무</option>
										<option value=1>계획업무</option>	
   									</select>
						</td>





					
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
							
							<!-- <td>상위 업무명</td>
							<td>
							<select  name = "sub_task_select_box">	
       							 <?php
										// $query = "SELECT * FROM task_document_header_table u WHERE ".$_SESSION['sub_hold_level']."=u.task_level_sub_code";
     					        		// $result = mysqli_query($conn,$query);  
										//  echo "<option value='' selected>신규</option>"; 
            							// 			 while( $row=mysqli_fetch_array($result) ){

										// 				if($target_field['super_task_TID']==$row['TID']){ 
										// 					if($target_field['super_task_TID']!=$target_field['TID'])
										// 					echo "<option value='".$row['TID']."' selected>".$row['task_name']."</option>";
										// 				}else{
										// 					echo "<option value='".$row['TID']."'>".$row['task_name']."</option>";
										// 				}
										// 			}
      							  ?>         
   							</select>	
							
							</td> -->

						<td  colspan="1">결제현황</td>
						<td  colspan="2">
								<?php


										echo $ob2->su_function_convert_name($conn,"master_state_info_table","master_task_state_info_code",$target_field['task_state'],"master_task_state_info_name");
      							?>  
						</td>

						<?php
						$file_delete_flag = 0;
						echo"<td colspan=1>상위업무</td>";
						echo"<td colspan=2>";
										$squery = "SELECT * FROM task_document_header_table WHERE ".$target_field['TID']."!= TID AND TID = ".$target_field['super_task_TID'].";";
										$sresult = mysqli_query($conn,$squery);
										if($sresult){
											$srow = mysqli_fetch_array($sresult);
											$target_super_title = $srow['task_name'];
											echo $target_super_title;
											
										}else{
											echo"--";
										}
						echo"</td>";
						?> 

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
					

					<div class="h_graph">

							<?php

						
							
								$task_table_query2 = "SELECT * FROM task_document_header_table u where ".$target_tid." = u.super_task_TID AND u.TID != u.super_task_TID AND task_state>=5 AND task_state<=30;";
								$result_set2 = mysqli_query($conn,$task_table_query2);
								if(mysqli_num_rows($result_set2)!=0){
								echo "<table  border='1' width='100%'>";

								
							
									echo "<tr>";

											echo "<td><span><strong />NO</span></td>";

											echo "<td>";
												echo "<strong />하위업무명";
											echo "</td>";
											
											echo "<td>";
												echo "<strong />담당자";
												
											echo "</td>";

											echo "<td>";
												echo "<strong />우선도";

											echo "</td>";
							
											echo "<td>";
												echo "<strong />상태명";

											echo "</td>";

											echo "<td>";
												echo "<strong />작성일";
												
											echo "</td>";

											echo "<td>";
											
												echo "<strong />결제상태";
												
											echo "</td>";

				
									echo "</tr>";

									
					
									

								$cnt = 1;
								while($row2 = mysqli_fetch_array($result_set2)) {
							
									echo "<tr>";


										echo "<td>";
											echo $cnt++;
										echo "</td>";

										echo "<td>";
											echo"<a href='#' onclick='hrefClick_of_sub_task(".$row2['task_level_code'].','.$row2['task_level_sub_code'].','.$row2['TID'].");'/>".$row2['task_name'];
										echo "</td>";

										echo "<td>";
											echo $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row2['task_orderer'],"master_user_info_name");
										echo "</td>";
					
										echo "<td>";
											echo $ob2->su_function_convert_name($conn,"master_priority_info_table","master_task_priority_info_code",$row2['task_priority'],"master_task_priority_info_name");
										echo "</td>";
						
										echo "<td>";
											echo $ob2->su_function_convert_name($conn,"dmaster_state_info_table","master_code",$row2['task_detail_state'],"master_state_detail_name");
										echo "</td>";

										echo "<td>";
											echo $row2['task_birth_date'];
										echo "</td>";

										

										// ** 하위 업무에 각각 결제 버튼을 추가하고 싶은 경우 사용하는 로직
										// 
										// if($row['task_state'] != 70){
										// $query4 = "select * from task_approbation_table where " . $row2['TID'] . " = TID";
										// $result4 = mysqli_query($conn, $query4);
										// $row4 = mysqli_fetch_array($result4);

										//	echo "<td>";
										// if($row2['task_state']!=70){
										// 		echo "<a href='#' onclick='hrefClick(" . $row4['AID'] . ',' . $row4['TID'] . ");'/>결제하기</a><br>";
										// 	echo "</td>";
										// }else{
										// 	echo '결제완료';
										// }
										
										
										
										echo "<td>";
										
										echo $ob2->su_function_convert_name($conn,"master_state_info_table","master_task_state_info_code",$row2['task_state'],"master_task_state_info_name");
										if($row2['task_state']!=30){
											$last_appro_trigger = false;
										}
										
										
										echo "</td>";
										
										
										
										}


									echo "</tr>";
							
									}
								
							?>



								</table>
					
							</div>


					<div style="padding: 0 40px 20px 0;">
					<?php 
					if(mysqli_num_rows($result_set2)>0){
							echo"<input style='float:right;' type='button' value='승인' onclick='confirm_message(".$target_tid.",1);'/>";
							echo"<input style='float:right;' type='button' value='반려' onclick='confirm_message(".$target_tid.",2);'/>";
					}
					?>
					</div>

					



					<table id='insertTable' border=0 cellpadding=0 cellspacing=0>

						<tr>

							<td valign=bottom>


								<?php
									echo "</td>";
									echo "첨부된 파일 : ";
									if($target_field['upload_id']){
										$query = "select * from master_upload_table u where u.upload_id = ".$target_field['upload_id'].";";
										$result = mysqli_query($conn,$query);
																$row = mysqli_fetch_array($result);
																$real_name = $row['real_name'];
																$server_name = $row['server_name'];
																echo "<a href='./storage/task_sheet/".$_SESSION['my_department_code']."/$server_name' download>".$real_name."</a>";
																echo "<td valign=bottom>";
									}else{
										echo "첨부된 파일 없음.<br />";
									}
									
								?>
								첨부 파일 변경 : <INPUT type='file' accept=".gif, .jpg, .png" maxLength='100'   name="upload_file" size='25'>

							</td>

							</tr>
	

						</table>
						<div align = 'right' style="padding: 0px 40px 0px 0px">
							<?php //echo"<input type='button' value='삭제' onclick='hrefClick_of_delete_task(".$target_tid.");'/>"?>
							<?php
									if(($target_field['task_state']==5 OR $target_field['task_state']==20) && $last_appro_trigger==true){
										echo"<input type='button' value='상신' onclick='confirm_message(".$target_tid.",0);'/>";
									}
							?>
							&nbsp &nbsp &nbsp<input type="submit" value="수정" >
							
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