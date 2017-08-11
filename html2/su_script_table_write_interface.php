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
			$default_title = '';
		}

		if(isset($_GET['type'])){
			$_SESSION['table_write_type'] = $_GET['type'];
		}




		
		if (isset($_GET['key']) == true) {
			$magic_key = $_GET['key'];
		}else{
			$magic_key = -1;
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


    <script type="text/javascript">
						function findTotal(){
							var arr = document.getElementsByName('qty');
							var arr2 = document.getElementsByName('qty2');
							var tot=parseInt(arr[0].value) - parseInt(arr2[0].value);
							if(arr[0].value>0&&arr2[0].value>0)
							document.getElementById('total').value = tot;
						}

						function generate_superTask(){
							
							var arr = document.getElementsByName('sub_task_select_box');
							var tmp = arr[0].value;
							var title = document.getElementById('task_title').value;
							
							window.location.href = './su_script_table_write_interface.php?type='+tmp+'&task_title='+title;
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


<script language="javascript">
				window.resizeTo(screen.availWidth/2,screen.availHeight*0.86); // 지정한 크기로 변한다.(가로,세로)
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


							var popUrl = "./common_func/su_function_real_time_combobox.php";	//팝업창에 출력될 페이지 URL
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

		<?php

			/*
				if($_SESSION['my_department_code']!=$_SESSION['task_master_section']){

						echo("<script> 

                                    alert('다른 부서에 실적등록을 할 수 없습니다.'); 

                                    self.close();    

                                    </script>");


				}
			*/
			
		?>


	
		<div id="wapper" style="background-color:#f5f4e9; width:100%; height:100%; border:1px solid black">
			<div id="first" style="background-color:skyblue; width:100%;height:30px; border:2px solid black">
			</div>
				<form action = 'outsource2.php' method='POST' enctype="multipart/form-data"  name="table_filter">
					
						<div align="center"><h2>실 적 관 리</h2></div>
					<DIV style='display:block'> 
					<table width=100% border='1'>
			
					<tr>
						<td  colspan="1">업 무 등 급</td>
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
						<td  colspan="1">진 행 업 무</td>
						<td  colspan="2"><input id='task_title' type=text name=task_select_box[] size=50% value="<?php echo $default_title;?>"></td>
						
						<td  colspan="1">업 무 타 입</td>
						<td  colspan="2">
						
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
													if($row['master_task_priority_info_code']!=3)
            											  echo "<option value='".$row['master_task_priority_info_code']."'>".$row['master_task_priority_info_name']."</option>";
       										    		                                           
            											 
       										     }
      							  ?>          
   							</select>
						</td>

						

						<td  colspan="1">상 태 명</td>
						<td  colspan="2">
							<select  name = "task_state" id="ajax_state_header">	
       							 <?php
										$query = "SELECT * FROM dmaster_state_info_table";
     					        		$result = mysqli_query($conn,$query);  
										 echo "<option value='50'>완료</option>";
           										 while( $row=mysqli_fetch_array($result) ){    

														if($row['master_code']!=99 && $row['master_code']%10==0){
															if($row['master_code']!=50)
            											  echo "<option value='".$row['master_code']."'>".$row['master_state_detail_name']."</option>";
														}
            											 
       										     }
      							  ?>          
   							</select>
						</td>


					</tr>

					<tr>
						<td>과 업 기 간</td>
						<td><input type="text" name = "task_select_box[]" id="datepicker1" value=<?php echo $_SESSION['now_date']; ?>></td>
						<td><input type="text" name = "task_select_box[]" id="datepicker2" value=<?php echo $_SESSION['now_date']; ?>></td>
						<td>수 행 일</td>
						<td><input type="text" name = "task_select_box[]" id="datepicker3" value=<?php echo $_SESSION['now_date']; ?>></td>
					</tr>
						<tr>
							
							<td>상위 업무명</td>
							<td>
							<select onchange="generate_superTask()"  name = "sub_task_select_box">	
       							 <?php

									if($_SESSION['table_write_type']=='new'){
										$query = "SELECT * FROM task_document_header_table u WHERE ".$_SESSION['sub_hold_level']."=u.task_level_sub_code AND u.task_state!=70 AND u.task_orderer !=".$_SESSION['my_sid_code'];
     					        		$result = mysqli_query($conn,$query);  
										 echo "<option value='' selected>신규</option>"; 
           										 while( $row=mysqli_fetch_array($result) ){   
															echo "<option value='".$row['TID']."'>".$row['task_name']."</option>";
													
													}
									}else{
										$query = "SELECT * FROM task_document_header_table u WHERE ".$_SESSION['sub_hold_level']."=u.task_level_sub_code AND u.task_orderer !=".$_SESSION['my_sid_code'];
     					        		$result = mysqli_query($conn,$query); 
           										 while( $row5=mysqli_fetch_array($result) ){   
														if($row5['TID'] == $_SESSION['table_write_type']){
															echo "<option value='".$row5['TID']."'selected>".$row5['task_name']."</option>";
														}else{
															echo "<option value='".$row5['TID']."'>".$row5['task_name']."</option>";
														}
													}
									}
      							  ?>         
   							</select>	
							
							</td>
						<!--
							<td> + 업무 추가하기 </td>
						-->
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
												<option value=51>완료</option>	
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
								<input type=text name=relate_sp>
							</td>
							<td>감독관</td>
							<td>
								<input type=text name=relate_org>
							</td>
						</tr>


						<tr>
							<td>할당금</td>
							<td>
								<input onblur="findTotal()" type="text" name="qty"/><br>
							</td>
							<td>사용액</td>
							<td>
								<input onblur="findTotal()" type="text" name="qty2"/><br>
							</td>
							<td>잔여액</td>
							<td>
								<input type="text" name="total" id="total"/>
							</td>

						</tr>


						<tr>
							<td class='td5'>업 무 진 행</td>
							<td colspan=5>
							<textarea name="dcontent" class="nse_content2" rows ="1" cols="35"></textarea>
							</td>						
						</tr>


					</table>
				</div>
					
		
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					
					
					
						<div align="center">결제</div>
					<DIV style='display:block'> 
					<table width=100% border='1'>
					<tr>
						<td> 결 제 루 트</td>
						<td>
						<select name = "pathnum">	
       							 <?php

									if($_SESSION['table_write_type']=='new'){	

										$query = "select * from task_approbation_path_table where SID = ".$_SESSION['my_sid_code'].";";
     					        		$result = mysqli_query($conn,$query);  
												 while($row=mysqli_fetch_array($result)){
													 	$approbation_path = $_SESSION['my_name'];
														for($cnt=1;$cnt<8;$cnt++){

															if($row[$cnt."_layer_aida_sid"]){
																	$name = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row[$cnt."_layer_aida_sid"],"master_user_info_name");
																	
																	$approbation_path = $approbation_path.' → '.$name;
															}
														}
														$name = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['end_user_sid'],"master_user_info_name");
														$approbation_path = $approbation_path.' → '.$name;	
											if($magic_key == $row['key_index']){
												echo "<option value=".$row['key_index']." selected>".$approbation_path."</option>"; 
											}else{
													echo "<option value=".$row['key_index'].">".$approbation_path."</option>"; 											
											}
												 		
											}

									}else{

										// 하위업무의 결제루트라고 하는 것은 다음과 같은 간단한 구조이다.$_COOKIE
										// 최초 발안자 => 현재 자신
										// 최종 승인자 => 추가하려는 업무의 담당자
										// 중간 검토자 => null
										// 따라서 최초에 위와 같은 결제루트가 존재하는지 검색하고, 없다면 추가하도록 로직을 만든다.



										$query3 = "SELECT * FROM task_document_header_table u WHERE ".$_SESSION['sub_hold_level']."=u.task_level_sub_code AND u.TID = ".$_SESSION['table_write_type'];
     					        		$result3 = mysqli_query($conn,$query3);  
           								$row5=mysqli_fetch_array($result3);



										$bgmquery = "SELECT * from task_approbation_path_table where SID = ".$_SESSION['my_sid_code']." AND end_user_sid = ".$row5['task_orderer']." AND 1_layer_aida_sid IS NULL AND 2_layer_aida_sid IS NULL AND 3_layer_aida_sid IS NULL AND 4_layer_aida_sid IS NULL AND 5_layer_aida_sid IS NULL AND 6_layer_aida_sid IS NULL AND 7_layer_aida_sid IS NULL;";
										$bgmresult = mysqli_query($conn,$bgmquery);
											if(!mysqli_num_rows($bgmresult)){
												$bmgquery2 = "SELECT MAX(key_index) as max from task_approbation_path_table where SID = ".$_SESSION['my_sid_code'].";";
												$bmgresult = mysqli_query($conn,$bmgquery2);
														if(mysqli_num_rows($bmgresult) == 0){
															$target_key_index = 0;
														}else{
															$row4=mysqli_fetch_array($bmgresult);
															$target_key_index = $row4['max']+1;
														}
												$bmg2query = "INSERT INTO task_approbation_path_table(SID,key_index,end_user_sid,min_sid) VALUES(".$_SESSION['my_sid_code'].",$target_key_index,".$row5['task_orderer'].",8);";
												$bmg2result = mysqli_query($conn,$bmg2query);


												$name = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$_SESSION['my_sid_code'],"master_user_info_name");
												$name2 = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row5['task_orderer'],"master_user_info_name");
												echo "<option value=".$target_key_index." selected>$name → $name2</option>"; 

											}else{
												$row4=mysqli_fetch_array($bgmresult);
												$target_key_index = $row4['key_index'];
												$name = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$_SESSION['my_sid_code'],"master_user_info_name");
												$name2 = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row4['end_user_sid'],"master_user_info_name");
												echo "<option value=".$target_key_index." selected>$name → $name2</option>"; 
											}
													


									}
																	
      							  ?>         
   							</select>
							   </td>
							<?php
							   if($_SESSION['table_write_type']=='new'){	
									echo "<td>";
										echo "<div><input type='button' onclick='get_path_index(task_title.value);' value='신규 경로 생성' ></div>";
									echo "</td>";
								}
							?>
					</tr>
					<tr>
							<td class='td5'>상 신 의 견</td>
							<td>
							<textarea name="task_0layer_content" class="nse_content" rows ="1" cols="35">상신에 대한 설명을 적어주세요.</textarea>
							</td>

					</tr>
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

					</div>

					

					<!--검토자 고려해서 만들기-->
					
			
			
		</div>
		
		<!-- 새로운 달력 자바 스크립트 소스-->
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>                     
      	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	</body>
</html>