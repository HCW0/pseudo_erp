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
					
					 <!-- UI Object 가로 -->
					.h_graph ul{margin:0 50px 0 50px;padding:1px 0 0 0;border:1px solid #ddd;border-top:0;border-right:0;font-size:11px;font-family:Tahoma, Geneva, sans-serif;list-style:none}
					.h_graph li{position:relative;margin:10px 0;vertical-align:top;white-space:nowrap}
					.h_graph .g_term{position:absolute;top:0;left:-50px;width:40px;font-weight:bold;color:#767676;line-height:20px;text-align:right}
					.h_graph .g_bar{display:inline-block;position:relative;height:20px;border:1px solid #ccc;border-left:0;background:#e9e9e9}
					.h_graph .g_bar span{position:absolute;top:0;right:-50px;width:40px;color:#767676;line-height:20px; padding:0px 55px 0px 0px;}
				     <!--UI Object -->
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
						function selectEvent(selectObj,field_index){
     					 // You can't define php variables in java script as $course etc.


							var popUrl = "./common_func/su_function_real_time_combobox.php";	//팝업창에 출력될 페이지 URL
							var popOption = "width=680, height=680, resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
							window.location.href = popUrl+'?var=' + selectObj.value + '&index=' +field_index;


    
						}

	</script>

	</head>


	<body style="width:99%">
	
		<div id="wapper" style="background-color: ivory; width:100%;">
			
				
			<p align="center"><img src="./src/su_rsc_sulogo_a.png" width="200" height="100" title="선운로고"/></p>
				
				<div id="head" style="float:left;">
				<span align="left">
				
				<?php echo date("Y-m-d");
					$date = date("Y-m-d");
					echo " / ";
					$parts = explode('-',$date);
					echo "  ".date("W")." 주자";
					echo "<br />";
				  ?>
				  
				  </span>
				</div>
				<form action = 'outsource2.php' method='POST' name="table_filter">
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div align="center" style="margin:0px 0px 0px 0px"><h2>Detail</h2></div>
					</a><DIV style='display:block'> 
					<table width="100%">
			
					<tr>
						<td  colspan="1">업 무 레 벨</td>
							<td  colspan="2"><select id = "task_writer_interface_combobox" name = "task_select_box[]" onchange="javascript:selectEvent(this,0);">	
									<?php
											$query = "SELECT * FROM master_task_level_info_table";
											$result = mysqli_query($conn,$query);  
													while( $row=mysqli_fetch_array($result) ){         
															if($row['master_task_level_code']!=15)
															if($row['master_task_level_code']==$_SESSION['hold_level']){
																echo "<option value='".$row['master_task_level_code']."' selected>".$row['master_task_level_name']."</option>";
															}
															else{
																echo "<option value='".$row['master_task_level_code']."'>".$row['master_task_level_name']."</option>";
															}
														}
									?>         
								</select>	
							</td>

								<td  colspan="1">업 무 코 드</td>
						<td  colspan="2">
						<select name = "task_select_box[]" onchange="javascript:selectEvent(this,1);">	
       							 <?php
										$query = "SELECT * FROM master_task_level_sub_info_table";
     					        		$result = mysqli_query($conn,$query); 
										 		 echo "<option value='' selected>--</option>"; 
           										 while( $row=mysqli_fetch_array($result) ){    
														
														if(($row['master_task_level_code']==$_SESSION['hold_level'])&&($row['master_task_level_sub_code']!=999)){
															if($row['master_task_level_sub_code']==$_SESSION['sub_hold_level']){
            											 		echo "<option value='".$row['master_task_level_sub_code']."' selected>".$row['master_task_level_sub_name']."</option>";
															}else{
															echo "<option value='".$row['master_task_level_sub_code']."'>".$row['master_task_level_sub_name']."</option>";
															}
														   
														}
													
													}
      							  ?>         
   							</select>	
					</td>
					</tr>
							<tr>
						<td>업 무 명</td>
						<td  colspan="5"><input type=text name=task_select_box[] size=60 ></td>
						
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
						<div align="center">공 정 표</div>
					</a><DIV style='display:block'> 
						
					<div align="right">	
						<?php
						 echo '<input type="text" name = "task_select_box[]" id="datepicker1" value="'.$_SESSION['current_base_date'].'">'
						?>
						/
						<?php
						 echo '<input type="text" name = "task_select_box[]" id="datepicker2" value="'.$_SESSION['current_limit_date'].'">'
						?>
					</div>
							<div class="h_graph">
								<table width="100%">
								
					<tr>
						<td colspan="1">진척도 그래프</td>
						<th colspan="12" style="text-align:left">
										<span class="g_bar" style="width:100%"><span>100%</span></span>

									</th>
							
					</tr>

									<tr>
									<th rowspan='2'><span>NO</span></th>
									
									<th rowspan='2'>
										등급
									</th>
									
									<th rowspan='2'>
										업무번호
									</th>

									<th rowspan='2'>
										사업명
									</th>
									
									
									<th rowspan='2'>
										발주
										
									</th>
									<th rowspan='2'>
										감독
									</th>
					
									<th colspan='2'>
										계약
									</th>

									<th rowspan='2'>
										착수일
										
									</th>


									<th rowspan='2'>
										준공일
										
									</th>
									

									<th rowspan='2'>
										계약금
										
									</th>


									<th rowspan='2'>
										기성
									</th>


									<th rowspan='2'>
										잔액
									</th>


									<th rowspan='2'>
										비고	
									</th>
									
									<th rowspan='2'>
										상태
									</th>
									<th rowspan='2'>
										진척도
									</th>
									
									
									<td colspan='12'>
									진척도 그래프
									</td>
									
									
										
									</tr>
							
									<tr>
										<th>시작</th>
										<th>종료</th>
										<th>1월</th>
										<th>2월</th>
										<th>3월</th>
										<th>4월</th>
										<th>5월</th>
										<th>6월</th>
										<th>7월</th>
										<th>8월</th>
										<th>9월</th>
										<th>10월</th>
										<th>11월</th>
										<th>12월</th>		
									</tr>
									
									<tr>
									<td>.</td>
									<td>.</td>
									<td>.</td>
									<td>.</td>
									<td>.</td>
									<td>.</td>
									<td>.</td>
									<td>.</td>
									<td>.</td>
									<td>.</td>
									<td>.</td>
									<td>.</td>
									<td>.</td>
									<td>.</td>
									<td>.</td>
									<td>.</td>
									<!-- 진척도 그래프-->
									
									</td>
									
									</tr>
							
						

									</tr>
									
					

								</table>
					
							</div>
					</div>
					
		
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					
					
	<!--			<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div align="center">결제</div>
					</a><DIV style='display:block'> 
					<table>
					<tr>
						<td> 결 제 루 트</td>
						<td>
						<select name = "task_select_box[]">	
       							 <?php

										$approbation_path = $_SESSION['my_name'];

										$query = "SELECT * FROM sid_combine_table";
     					        		$result = mysqli_query($conn,$query);  
										 		$offset = 1;
												 while($offset+$_SESSION['my_position_code']<8){
													 	$offset_applied = $offset+$_SESSION['my_position_code'];
														$offset++;
														$query = "SELECT * FROM sid_combine_table u WHERE u.sid_combine_position=$offset_applied";
     					        						$result = mysqli_query($conn,$query);
														$row=mysqli_fetch_array($result);
														if(mysqli_num_rows($result)==0||$row['is_valid']==0){
																// 결제루트에서 공백 자리가 검출된 경우, continue 함
																continue;
																}
															$aname = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['SID'],"master_user_info_name");
															$approbation_path = $approbation_path." → ".$aname;
															echo "<option value='".$row['SID']."' selected>".$approbation_path."</option>";
															  
												 		
											}
      							  ?>         
   							</select>	
							   </td>

					</tr>


					</table>
					</div>
					
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>   -->
					
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<p align="center">메 모</p>
					</a><DIV style='display:none'  align="center"> 
							<textarea name="task_select_box[]" class="nse_content" rows ="1" cols="35">업무 생성에 대한 설명을 적어주세요.</textarea>
						</div>





					<tr>
						<td>
							<div align = 'center'><input type="submit" value="완료" ></div>
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