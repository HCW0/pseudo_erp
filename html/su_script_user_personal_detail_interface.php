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
					body {
						font-family: 'Nanum Gothic', sans-serif;
					}
					.nse_content{width:800px;height:300px}
					.nse_content2{width:660px;height:130px}
					
				
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


	<body style="width:1400px ; height:100% ;">
	
		<div id="wapper" style="background-color:#f5f4e9; width:100%; border:1px solid black">
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
				 
					<table width="100%">
			

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
						<td>업 무 명</td>        
						<td  colspan="5">
								 <?php
										echo $row['task_name'];    
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
						
						<td  colspan="1">우 선 도</td>
						<td  colspan="2">
								<?php
										echo $ob2->su_function_convert_name($conn,"master_priority_info_table","master_task_priority_info_code",$row['task_priority'],"master_task_priority_info_name");
      							?>  
						</td>

						<td  colspan="1">상 태 명</td>
						<td  colspan="2">
								<?php
										echo $ob2->su_function_convert_name($conn,"master_state_info_table","master_task_state_info_code",$row['task_state'],"master_task_state_info_name");
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

						<td>수 행 기 간</td>

						<td>
								<?php
										echo $row['task_limit_date'];    
      							?>  
						</td>

					</tr>

					<tr>
						<td><br /></td>
					</tr>
			
					</table>
							<div align = 'right'>
									<?php echo"<a href='#' onclick='hrefClick_of_modify_task(".$_SESSION['current_focused_TID'].");'/>"; echo '수정</a>  '?>
									/
									<?php echo"<a href='#' onclick='hrefClick_of_delete_task(".$_SESSION['current_focused_TID'].");'/>"; echo '  삭제</a>&nbsp&nbsp&nbsp&nbsp'?>
							</div>
				


				<div style="padding:10px 0 0 0;">
					</div>
					
		
					
					
					 
						<div align="center"><h2></h2></div>
					
						
	
							<div class="h_graph">
								<table width="100%">

								
							
									<tr>
									<td><span><strong />NO</span></td>

									<td>
										<strong />하위업무명
									</td>
									
									<td>
										<strong />담당자
										
									</td>

									<td>
										<strong />우선도

									</td>
					
									<td>
										<strong />상태명

									</td>

									<td>
										<strong />결제의견
										
									</td>


				
									</tr>

									
					
									
						
							<?php
								$task_table_query2 = "SELECT * FROM task_document_header_table u where ".$_SESSION['current_focused_TID']." = u.super_task_TID AND u.TID != u.super_task_TID ;";
								$result_set2 = mysqli_query($conn,$task_table_query2);
								$cnt = 1;
								while($row2 = mysqli_fetch_array($result_set2)) {
							?>
								<tr>
									<td>
										<?php echo $cnt++?>
									</td>

									<td>
										<?php echo"<a href='#' onclick='hrefClick_of_sub_task(".$row2['task_level_code'].','.$row2['task_level_sub_code'].','.$row2['TID'].");'/>"; echo $row2['task_name']?>
									</td>

									<td>
										<?php echo $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row2['task_orderer'],"master_user_info_name");?>
									</td>
				
									<td>
										<?php echo $ob2->su_function_convert_name($conn,"master_priority_info_table","master_task_priority_info_code",$row2['task_priority'],"master_task_priority_info_name");?>
									</td>
					
									<td>
										<?php echo $ob2->su_function_convert_name($conn,"master_state_info_table","master_task_state_info_code",$row2['task_state'],"master_task_state_info_name");?>
									</td>

									<td>
										<?php echo "<a href='#' onclick='hrefClick(".$row2['TID'].");'/>결제현황</a><br>";?>
									</td>


								</tr>
							<?php
								}
							?>



								</table>
					
							</div>
					
					
		
					


					

					<tr>
						<td>
							<div align="center">
								<input type="button" value="확인" onclick="self.close();">
							</div>
						</td>
					</tr>

					</form>
						
					
					
					<div align="center"><h2></h2></div>
					
					
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

				

					

					<!--검토자 고려해서 만들기-->
					
			
			
		</div>
		
		<!-- 새로운 달력 자바 스크립트 소스-->
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>                     
      	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	</body>
</html>