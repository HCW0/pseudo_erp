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

		$TID = $_GET['TID'];
		$AID = $_GET['AID'];

			$task_table_query = "select * from task_document_header_table u where u.TID = $TID ;";
			$result_set = mysqli_query($conn,$task_table_query);
			$row = mysqli_fetch_array($result_set);


			$task_table_query2 = "select * from task_approbation_table u where u.AID = $AID ;";
			$result_set2 = mysqli_query($conn,$task_table_query2);
			$row2 = mysqli_fetch_array($result_set2);


			$task_table_query4 = "select * from task_approbation_path_table u where u.SID = ".$row['task_orderer']." AND u.key_index = ".$row2['key_index'].";";
			$result_set4 = mysqli_query($conn,$task_table_query4);
			$row4 = mysqli_fetch_array($result_set4);

// 클래스 객체 선언


		$ob2 = new su_class_value_name_convert_with_code();
		$this_state = $ob2->su_function_convert_name($conn,"task_document_header_table","TID",$TID,"task_state");
		$this_state = $ob2->su_function_convert_name($conn,"master_state_info_table","master_task_state_info_code",$this_state,"master_task_state_info_name");


		$end_user_position = $ob2->su_function_convert_name($conn,"sid_combine_table","SID",$row4['end_user_sid'],"sid_combine_position");

		

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
					.nse_content{width:600px;height:80px}
					.nse_content2{width:660px;height:130px}

					.tr1 {height:50px;background:#ace;}
					.td1 {}
					.td2 {vertical-align:center}
					.td3 {vertical-align:middle}
					.td4 {vertical-align:asdfasdf}
					.td5 {vertical-align:top}
					.td6 {vertical-align:bottom}
					
			</style>

	

	</head>

<!-- 상황에따라서 스마트에디터 사용 일단 서술식 텍스트-->
	<body >

		<div id="wapper" style="background-color:#f5f4e9; width:800px; border:1px solid black">
		<div id="first" style="background-color:skyblue; width:100%;height:30px; border:2px solid black">
			</div>
			<table summary="글쓰기 전체 테이블">
	
				
				<table summary="테이블 구성" >
					<tr>
						<td colspan ='15'>제 목</td>
						<td colspan='25'><?php echo $row['task_name']?></td>
					</tr>
					<tr>
						<td colspan ='15'>상 태</td>
						<td colspan ='10'>
							<?php
								 echo $this_state;
							?>
						</td>
						<td colspan ='1'>생성일</td>
						<td colspan ='5'>
						<?php
								 echo $row2['last_appro_date'];
							?>
						</td>
					</tr>
					<tr>
					
					<tr>
					<td  colspan = '40'>
						결제상황
					</td>
					</tr>


					<!--  -->


					<tr>
                 
                 
							<?php
								/*	


										
										// detail debug state
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
										$name_count=1;
										for($count = $row2['first_order'] ; $count < 8 ; $count++ ){



												$var = "task_sq_".$count."layer_message";
												echo "<br />";
												

												//query generate
												$task_table_query3 = "select * from sid_combine_table u where u.sid_combine_department = ".$row2['task_order_section']." AND u.sid_combine_position = ".$count.";";
												$result_set3 = mysqli_query($conn,$task_table_query3);
												$row3 = mysqli_fetch_array($result_set3);
												

												if($row3['SID']==null) continue; //존재하지 않는 공석은 그냥 건너뛴다.
												$approb_name = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row3['SID'],"master_user_info_name");
												

												//variable generate


												if($row2['first_order']==$count){
													$approb_position = '최초발의자 :';
												}else{
													$approb_position = '제'.$name_count.'차 결제자 : ';
													$name_count++;
												}




												if($end_user_position==$count){
													$approb_position = '최종승인자  :';
												}
												
												//rendering
												if($row2['current_sid']!=$count){
													echo "<tr>";
													echo "<td class='td5' colspan = '10'>";
													echo $approb_position;
													echo "</td>";

														echo "<td class='td5' colspan = '10'>";
														echo $approb_name;
														echo "&nbsp &nbsp &nbsp";
														echo "</td>";

														echo "<td class='td5' colspan = '20'>";
														echo $row2[$var];
														echo "</td>";
													echo "</tr>";

												}else{
													echo "<tr>";
													echo "<td  class='td5' colspan = '10'>";
													echo $approb_position;
													echo "</td>";

														echo "<td class='td5' colspan = '10'>";
														echo $approb_name;
														echo "&nbsp &nbsp &nbsp";
														echo "</td>";

														echo "<td colspan = '20'>";
															echo "<form action = 'outsource9.php' method='POST'>";
																if($row2[$var]){
																	echo "<textarea name='opinion_write[]' id='opinion' class='nse_content' rows ='17' cols='75'>".$row2[$var]."</textarea>";
																}
																else{
																	echo "<textarea name='opinion_write[]' id='opinion' class='nse_content' rows ='17' cols='75'>의견을 입력해주세요.</textarea>";
																}
															
														echo "</td>";
													echo "</tr>";
														echo "<tr>";
														echo "<td colspan='15'>";
														echo "</td>";
																echo "<td colspan='25'>";
																echo "<div align = 'left'>";
																echo "&nbsp &nbsp &nbsp";
																echo "<select name = 'opinion_write[]'>";
																if($row2['current_sid']==$end_user_position){	
            														echo "<option value='-1'>승인</option>";
																}else if($row2['current_sid']==$row2['first_order']){
																	echo "<option value='2'>승인</option>";
																}else{
																	echo "<option value='0'>승인</option>";
																}
																echo "<option value='1'>반려</option>";
   																echo "</select>";	
																echo "<input type='submit' value='승인'>";
																echo "</div>";
																echo "</td>";
														echo "</tr>";
														echo "<input type='hidden' value=".$AID." name='opinion_write[]'>";
													echo "</form>";
                                          
												}

										}

							?>
              

					</tr>
					


					<!--  -->


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
           					 	<a href="미구현"> 개발중입니다. </a>
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