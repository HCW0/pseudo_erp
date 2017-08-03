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
					.nse_content{width:800px;height:300px}
					.nse_content2{width:660px;height:130px}
										.td5 {vertical-align:top}
				
					.h_graph ul{margin:0 50px 0 50px;padding:1px 0 0 0;border:1px solid #ddd;border-top:0;border-right:0;font-size:11px;font-family:Tahoma, Geneva, sans-serif;list-style:none}
					.h_graph li{position:relative;margin:10px 0;vertical-align:top;white-space:nowrap}
					.h_graph .g_term{position:absolute;top:0;left:-50px;width:40px;font-weight:bold;color:#767676;line-height:20px;text-align:right}
					.h_graph .g_bar{display:inline-block;position:relative;height:20px;border:1px solid #ccc;border-left:0;background:#e9e9e9}
					.h_graph .g_bar span{position:absolute;top:0;right:-50px;width:40px;color:#767676;line-height:20px; padding:0px 55px 0px 0px;}
			

					.graph { 
							position: relative; /* IE is dumb */
							width: 200px; 
							border: 1px solid #B1D632; 
							padding: 2px; 
							font-size:11px;
							font-family:tahoma;
							margin-bottom:3px;
						}
					.graph .bar { 
							display: block;
							position: relative;
							background: #B1D632; 
							text-align: center; 
							color: #333; 
							height: 2em; 
							line-height: 2em;            
						}
					.graph .bar span { position: absolute; left: 1em; }


			</style>

<script language="javascript">
				window.resizeTo(screen.availWidth/2,screen.availHeight*0.72); // 지정한 크기로 변한다.(가로,세로)
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

			<script>           /*달력 함수*/
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
					function hrefClick(course){
						// You can't define php variables in java script as $course etc.


					var popUrl = "/su_script_task_detail_pop_up.php";	//팝업창에 출력될 페이지 URL
					var popOption = "width=680, height=680, resizafble=0, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
					window.open(popUrl+'?TID=' + course,popOption,'width=680,height=680');



					}

		</script>



		<script> 
		function hrefClick(course,course2){
			// You can't define php variables in java script as $course etc.


		var popUrl = "/su_script_task_approbation_detail_pop_up.php";	//팝업창에 출력될 페이지 URL
		var popOption = "resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
		window.open(popUrl+'?AID=' + course + '&TID=' + course2,popOption,'width=680,height=680');



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


		<script> 
					function hrefClick_of_delete_task(local){
						// You can't define php variables in java script as $course etc.

					window.location.href='outsource5delete.php?TID=' + local;
				


					}

		</script>
		

		<script> 
					function hrefClick_of_modify_task(local){
						// You can't define php variables in java script as $course etc.

					window.location.href='outsource5modify.php?TID=' + local;
				


					}

		</script>

	</head>


	<body>
	
		<div id="wapper" style="background-color:#f5f4e9; width:100%; height:100%; border:1px solid black">
		<div id="first" style="background-color:skyblue; width:100%;height:30px; border:2px solid black">
			</div>	
				
			
				
				<div id="head">
				<span align="left">
				
				<?php 
					echo date("Y-m-d");
					$date = date("Y-m-d");
					echo " / ";
					$parts = explode('-',$date);
					echo "  ".date("W")." 주차";
					echo "<br />";
				  ?>
				  
				  </span>
				</div>
				<form action = 'outsource2.php' method='POST' name="table_filter">
					 
						<div align="center" style="margin:0px 0px 0px 0px"><h2></h2></div>
				 
					<table  border="1" width="100%">
			

					<!-- 공정표에 채울 값들을 TID를 key로 해서 가져오는 부분 -->
					<?php
										$query = "SELECT * FROM task_document_header_table u where ".$_SESSION['current_focused_TID']." = u.TID;";
     					        		$result = mysqli_query($conn,$query);  
           								$row=mysqli_fetch_array($result);
					
					 ?>




					<tr>
						<td  colspan="1">업 무 레 벨</td>
							<td  colspan="2">
										<?php echo $ob2->su_function_convert_name($conn,"master_task_level_info_table","master_task_level_code",$row['task_level_code'],"master_task_level_name");?>
							</td>

						<td  colspan="1">업 무 코 드</td>
							<td  colspan="2">
										<?php echo $ob2->su_function_convert_name($conn,"master_task_level_sub_info_table","master_task_level_sub_code",$row['task_level_sub_code'],"master_task_level_sub_name");?>
							</td>
					</tr>
							<tr>
						<td colspan='1'>업 무 명</td>        
						<td  colspan="2">
								 <?php
										echo $row['task_name'];    
      							  ?>  	
						</td>
						<td  colspan="1">우 선 도</td>
						<td  colspan="2">
								<?php
										echo $ob2->su_function_convert_name($conn,"master_priority_info_table","master_task_priority_info_code",$row['task_priority'],"master_task_priority_info_name");
      							?>  
						</td>
					</tr>
					<tr>
						<td  colspan="1">담당부서</td>
						<td  colspan="2">
								 <?php
								 		echo $ob2->su_function_convert_name($conn,"master_department_info_table","sid_combine_department",$row['task_order_section'],"master_department_info_name");
      							  ?>  
							</td>
						<td  colspan="1">담 당 자</td>
						<td  colspan="2">
								 <?php
								 		echo $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['task_orderer'],"master_user_info_name");
      							  ?>  
							</td>
					</tr>
					<tr>
						
						<td  colspan="1">결제현황</td>
						<td  colspan="2">
								<?php
										echo $ob2->su_function_convert_name($conn,"master_state_info_table","master_task_state_info_code",$row['task_state'],"master_task_state_info_name");
      							?>  
						</td>

						<td  colspan="1">상 태 명</td>
						<td  colspan="2">
								<?php
										echo $ob2->su_function_convert_name($conn,"dmaster_state_info_table","master_code",$row['task_detail_state']-$row['task_detail_state']%10,"master_state_detail_name");
										echo " ( ";
										echo $ob2->su_function_convert_name($conn,"dmaster_state_info_table","master_code",$row['task_detail_state'],"master_state_detail_name");
										echo " )";
								?>  
						</td>


					</tr>

					<tr>
						<td  colspan="1">과 업 기 간</td>
						<td  colspan="2">
								<?php
										echo $row['task_elapsed_base_date'];  
										echo '  ~  ';
										echo $row['task_elapsed_limit_date'];  
      							?>  
						</td>

						<td>수 행 일</td>

						<td>
								<?php
										echo $row['task_limit_date'];    
      							?>  
						</td>

					</tr>

					<tr>
						<td  colspan="4"><b>할당금 &nbsp&nbsp&nbsp
								<?php
										echo '   '.$row['all_money_master_code_field'];
      							?>  
						원 &nbsp &nbsp &nbsp &nbsp 사용액 &nbsp&nbsp&nbsp
								<?php
										echo '   '.$row['use_money_master_code_field'];
      							?>  
						원 &nbsp &nbsp &nbsp &nbsp 잔여액 &nbsp&nbsp&nbsp
								<?php
										echo '   '.$row['remaind_money_master_code_field'];
								?>
						원
						</td>
					</tr>

					<tr>

					<td>관련업체</td>
					<td>
					<?php echo $row['coworkspace']; ?>  
					</td>

					
					<td>감독관</td>
					<td>
					<?php echo $row['coworker']; ?>  
					</td>

					</tr>

					<tr>

						<td class='td5'>업 무 진 행</td>
						<td colspan=5>
						<textarea name="task_select_box[]"  readonly="readonly" class="nse_content2" rows ="1" cols="35"><?php echo $row['etcetera']?></textarea>
						</td>	

					</tr>

					<tr>
					<td>
					결제 현황 2
					</td>
					<td>

							<?php
						
										$query2 = "select * from task_approbation_table where TID = ".$row['TID'].";";
     					        		$result2 = mysqli_query($conn,$query2);  
										$row4=mysqli_fetch_array($result2);
										
													 	echo $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row4['first_order'],"master_user_info_name");
														for($cnt=1;$cnt<8;$cnt++){

															if($row4[$cnt."_layer_aida_sid"]){
																if($cnt!=$row4['current_sid']){
																	echo ' → '."<font color='black'>".$ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row4[$cnt."_layer_aida_sid"],"master_user_info_name")."</font>";
																}else{
																	echo ' → '."<font color='red'>".$ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row4[$cnt."_layer_aida_sid"],"master_user_info_name")."</font>";
																}
															}
														}
														echo ' → '.$ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row4['end_order'],"master_user_info_name");
														if($row4['current_sid']>=8 && $row['task_state']==70){
															echo ' ( 최종승인됨 )';
														}
												 		
										
							?>




					</td>
					</tr>
					<?php
					if($row['task_state']!=70 && $row['task_order_position']>$_SESSION['my_sid_code']){
					echo "<tr>";
						echo "<td>";
						
							echo "<input type='button' name='버튼' value='실적등록' onclick=\"window.location.href='./su_script_table_write_interface.php?type=".$row['TID']."'\"/><br />";
						
					echo "</td>";
					echo "</tr>";
					}else if($row4['end_order']==$_SESSION['my_sid_code'] && $row['task_state']!=70){
					echo "<tr>";
						echo "<td>";
						
							echo "<a href='#' onclick='hrefClick(" . $row4['AID'] . ',' . $row4['TID'] . ");'/>결제하기</a><br>";
						
					echo "</td>";
					echo "</tr>";	
					}
					?>
					</table>
				


				<div style="padding:10px 0 0 0;">
					</div>
					
							
	
						<div class="h_graph">

							<?php

						
							
								$task_table_query2 = "SELECT * FROM task_document_header_table u where ".$_SESSION['current_focused_TID']." = u.super_task_TID AND u.task_state!=5  AND u.TID != u.super_task_TID ;";
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

										if($row['task_orderer']==$_SESSION['my_sid_code'] && $row['task_state'] != 70){
											echo "<td>";
												echo "<a href='#' onclick='hrefClick(" . $row4['AID'] . ',' . $row4['TID'] . ");'/>결제하기</a><br>";
											echo "</td>";
										}


									echo "</tr>";
							
									}
								}
							?>



								</table>
					
							</div>
					
					
		
							<table border=0 cellpadding=0 cellspacing=0>

								<tr>
											<td>관련근거&nbsp</td>
													<td>
														
														<?php
															
																$query = "select * from master_upload_table u where u.upload_id = ".$row['upload_id'].";";
																$result = mysqli_query($conn,$query);
																if($result){
																if(mysqli_num_rows($result)!=0){
																$row = mysqli_fetch_array($result);
																$real_name = $row['real_name'];
																$server_name = $row['server_name'];

																echo "<a href='./storage/task_sheet/".$_SESSION['my_department_code']."/$server_name' download>".$real_name."</a>";
																}else{
																	echo "[첨부된 파일 없음]";
																}
																}else{echo "[첨부된 파일 없음]";
																}
														?>
													
													</td>

								</tr>
		
							</table>


					

					<tr>
						<td>
							<div align="center">
								<input type="button" value="확인" onclick="self.close();">
							</div>
						</td>
					</tr>

					</form>
						

			
			
		</div>
	</body>
</html>