﻿<!DOCTYPE html>

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

		$TID = $_GET['TID'];

			$task_table_query = "select * from task_document_header_table u where u.TID = $TID ;";
			$result_set = mysqli_query($conn,$task_table_query);
			$row = mysqli_fetch_array($result_set);


			$task_table_query2 = "select * from task_approbation_table u where u.TID = $TID ;";
			$result_set2 = mysqli_query($conn,$task_table_query2);
			
			

// 클래스 객체 선언


		$ob2 = new su_class_value_name_convert_with_code();
		


		$ob3 = new su_class_value_name_convert_with_code();
		$this_state = $ob3->su_function_convert_name($conn,"task_document_header_table","TID",$TID,"task_state");
		$this_state = $ob3->su_function_convert_name($conn,"master_state_info_table","master_task_state_info_code",$this_state,"master_task_state_info_name");


?>


<html>
	<head>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<script type="text/javascript" src="nse_files/js/HuskyEZCreator.js" charset="utf-8"></script>
			<title>글쓰기</title>
			<style>
					@import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
					body {
						font-family: 'Nanum Gothic', sans-serif;
					}
					
			</style>

	

	</head>

<!-- 상황에따라서 스마트에디터 사용 일단 서술식 텍스트-->
	<body>

		<div id="wapper" style="background-color: ivory; width:640px;">
			<table summary="글쓰기 전체 테이블">
	
				
				<table summary="테이블 구성" >
				<caption>업무 상세</caption>	
				
					
					<tr>
						<td>제 목</td>
						<td colspan='3'><?php echo $row['task_name']?></td>
					</tr>
					<tr>
						<td>상 태</td>
						<td>
							<?php
								 echo $this_state;
							?>
						</td>
					</tr>
					<tr>
					
					<tr>
					<td>
						결제상황
					</td>
					</tr>

					<tr>


							<?php
									$row2 = mysqli_fetch_array($result_set2);



										// detail debug state
										/*
											echo "현재 결제 단계  ";
											echo $row2['task_sequence_current'];
											echo "<br />";
											echo "시작 결제 단계  ";
											echo $row2['task_sequence_start'];
											echo "<br />";
											echo "종료 결제 단계  ";
											echo $row2['task_sequence_end'];
											echo "<br />";
											*/


											if($row2['task_sq_1layer_message']!=""){
												echo "<td>의견</td>";
												echo "<td>".$row2['task_sq_1layer_message']."</td>";	

												
											}


											echo "<tr>";
											if($row2['task_sq_2layer_message']!=""){

													if($row2['task_sequence_start']==2){
															echo "<td>최초발의자</td>";

															$task_table_query3 = "select * from sid_combine_table u where u.sid_combine_department = ".$row2['task_order_section']." AND u.sid_combine_position = ".$row2['task_sequence_start'].";";
															$result_set3 = mysqli_query($conn,$task_table_query3);
															$row3 = mysqli_fetch_array($result_set3);
															$appro_name = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row3['SID'],"master_user_info_name");
															echo "<td>".$appro_name."</td>";
															
															echo "<td>의견</td>";
															echo "<td>".$row2['task_sq_2layer_message']."</td>";	
													}else{
														if($row2['task_sequence_start']!=2){
															echo "<td>결제자</td>";
															$task_table_query3 = "select * from sid_combine_table u where u.sid_combine_department = ".$row2['task_order_section']." AND u.sid_combine_position = ".$row2['task_sequence_current'].";";
															$result_set3 = mysqli_query($conn,$task_table_query3);
															$row3 = mysqli_fetch_array($result_set3);
															$appro_name = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row3['SID'],"master_user_info_name");
															echo "<td>".$appro_name."</td>";

															echo "<td>의견</td>";
															echo "<td>".$row2['task_sq_2layer_message']."</td>";
														}else{
															echo "<td>의견</td>";
															echo "<td>"."결제 대기 중입니다."."</td>";	
														}	

													}		
										}echo "</tr>";

										
											echo "<tr>";
											if($row2['task_sq_3layer_message']!=""){
														
													if($row2['task_sequence_start']==3){
															echo "<td>최초발의자</td>";

															$task_table_query3 = "select * from sid_combine_table u where u.sid_combine_department = ".$row2['task_order_section']." AND u.sid_combine_position = ".$row2['task_sequence_start'].";";
															$result_set3 = mysqli_query($conn,$task_table_query3);
															$row3 = mysqli_fetch_array($result_set3);
															$appro_name = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row3['SID'],"master_user_info_name");
															echo "<td>".$appro_name."</td>";
															
															echo "<td>의견</td>";
															echo "<td>".$row2['task_sq_3layer_message']."</td>";	
													}else{
														if($row2['task_sequence_start']!=3){
															echo "<td>결제자</td>";
															$task_table_query3 = "select * from sid_combine_table u where u.sid_combine_department = ".$row2['task_order_section']." AND u.sid_combine_position = ".$row2['task_sequence_current'].";";
															$result_set3 = mysqli_query($conn,$task_table_query3);
															$row3 = mysqli_fetch_array($result_set3);
															$appro_name = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row3['SID'],"master_user_info_name");
															echo "<td>".$appro_name."</td>";

															echo "<td>의견</td>";
															echo "<td>".$row2['task_sq_3layer_message']."</td>";
														}else{
															echo "<td>의견</td>";
															echo "<td>"."결제 대기 중입니다."."</td>";	
														}	

													}		
										}echo "</tr>";


							?>


					</tr>
					
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					<tr>
					<form action="http://localhost:1234/storage/upload.php" method="post" enctype="multipart/form-data">
            
      
					 <table id='insertTable' border=0 cellpadding=0 cellspacing=0>

						<tr>
							<td>관련근거</td>
							<td>
								&nbsp
           					 	<a href="미구현"> 미구현입니다. </a>
							</td>

							</tr>
	
						</table>



					</form>        

					
					<tr>
						<div align="center">
						<input type="button" value="확인" onclick="self.close();"></div>
						</td>
					</tr> 
				</table>	
			</table>
		</div>

	</body>
</html>