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
		$ob5 = new su_class_between_start_and_end();

		if(!isset($_SESSION['hold_level'])){
			
			$_SESSION['hold_level']=1;
		}
		if(!isset($_SESSION['sub_hold_level'])){
			
			$_SESSION['sub_hold_level']=1;
		}


		if(isset($_GET['end_appro_point'])){
			$end_appro_point = $_GET['end_appro_point'];
		}else{
			$end_appro_point = 5140;
		}

		if(isset($_GET['task_title'])){
			$default_title = $_GET['task_title'];
		}else{
			$default_title = ' ';
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
					body {
						font-family: 'Nanum Gothic', sans-serif;
					}
					.nse_content{width:600px;height:100px}
					.nse_content2{width:660px;height:130px}



					.tr1 {height:50px;background:#ace;}
					.td1 {}
					.td2 {vertical-align:center}
					.td3 {vertical-align:middle}
					.td4 {vertical-align:asdfasdf}
					.td5 {vertical-align:top}
					.td6 {vertical-align:bottom}


			</style>

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
						function selectEvent(end_appro_point,task_title){
     					 // You can't define php variables in java script as $course etc.


							var popUrl = "./common_func/su_function_real_time_combobox.php";	//팝업창에 출력될 페이지 URL
							var popOption = "width=680, height=680, resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
							window.location.href = './su_script_table_write_interface_ura.php?end_appro_point=' + end_appro_point +'&task_title='+task_title;


    
						}


						function get_path_index(task_title){


   							 window.location.href = './su_script_table_write_interface.php?task_title='+task_title;
						}


	</script>

	</head>


	<body style="width:800px">
	
		<div id="wapper" style="background-color:#f5f4e9; width:100%; border:1px solid black">
			<div id="first" style="background-color:skyblue; width:100%;height:30px; border:2px solid black">
			</div>
				<form action = 'outsource2new_app_path.php' method='POST' name="table_filter">
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div align="center"><h2>업 무 등 록</h2></div>
					</a><DIV style='display:block'> 
					<table>
			
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
						<td  colspan="5"><input id='task_title' type=text name=task_select_box[] size=60 value="<?php echo $default_title; ?>"></td>
						
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
							<select  name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM master_state_info_table";
     					        		$result = mysqli_query($conn,$query);  
           										 while( $row=mysqli_fetch_array($result) ){    

														if($row['master_task_state_info_code']!=99)
            											  echo "<option value='".$row['master_task_state_info_code']."'>".$row['master_task_state_info_name']."</option>";
       										    		                                             
            											 
       										     }
      							  ?>          
   							</select>
						</td>


					</tr>

					<tr>
						<td>과 업 기 간</td>
						<td><input type="text" name = "task_select_box[]" id="datepicker1" value=<?php echo $_SESSION['now_date']; ?>></td>
						<td><input type="text" name = "task_select_box[]" id="datepicker2" value=<?php echo $_SESSION['now_date']; ?>></td>
						<td>작 업 기 간</td>
						<td><input type="text" name = "task_select_box[]" id="datepicker3" value=<?php echo $_SESSION['now_date']; ?>></td>
					</tr>
						<tr>
							<td><br /></td>
						</tr>
				
					</table>

					</div>


				<div style="padding:10px 0 0 0;">
					</div>
					
		
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div align="center">상세 업무 내용</div>
					</a><DIV style='display:block'> 
					<table>
					<tr>
						<td>상위 업무명</td>
							<td>
							<select  name = "sub_task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM task_document_header_table u WHERE ".$_SESSION['sub_hold_level']."=u.task_level_sub_code";
     					        		$result = mysqli_query($conn,$query);  
										 echo "<option value='' selected>신규</option>"; 
           										 while( $row=mysqli_fetch_array($result) ){   
															echo "<option value='".$row['TID']."'>".$row['task_name']."</option>";
													
													}
      							  ?>         
   							</select>	
							</td>
						</tr>
						<tr>
			

						</tr>
					</table>
				</div>
					
		
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					
					
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div align="center">결제</div>
					</a><DIV style='display:block'> 
					<table>
					<tr>
						<td>최종 결제자</td>
						<td>
						<select name = "end_master_user" onchange="javascript:selectEvent(this.value,task_title.value);">
       							 <?php
										$query = "SELECT * FROM sid_combine_table u WHERE u.sid_combine_department=".$_SESSION['my_department_code']." AND u.sid_combine_position>".$_SESSION['my_position_code'].";";
     					        		
										 $result = mysqli_query($conn,$query); 
										 				if($end_appro_point==5140){
														echo "<option value='' selected>--</option>";
														} 
												 while($row=mysqli_fetch_array($result)){
													 	
													$name = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['SID'],"master_user_info_name");

														if($end_appro_point==$row['SID']){
															echo "<option value='".$row['SID']."' selected>".$name."</option>";
														}else{
															echo "<option value='".$row['SID']."'>".$name."</option>";	
														}
													
												 }
      							  ?>         
   							</select>
							   </td>

							   <td>
							   		<div><input type="button" onclick="get_path_index(task_title.value);" value="취소" ></div>
							   </td>

					</tr>
					<tr>
							<?php
										if($end_appro_point!=5140){
												$ob5->su_function_between_two_sid_selectbox_format_generator($conn,$end_appro_point,$ob2);
										}					
							?>
					</tr>
					<tr>
							<td class='td5'>상 신 의 견</td>
							<td>
							<textarea name="task_select_box[]" class="nse_content" rows ="1" cols="35">상신에 대한 설명을 적어주세요.</textarea>
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