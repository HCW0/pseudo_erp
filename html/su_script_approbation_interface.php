<!DOCTYPE html>

<html>

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


// class 객체 생성

		$ob1 = new su_class_task_table_config();


		//임시코드

		if(isset($_SESSION['current_ap_task_level_code'])==false){
			$_SESSION['current_ap_base_date']=$_SESSION['now_date'];
			$_SESSION['current_ap_limit_date']=$_SESSION['now_date'];
			$_SESSION['current_ap_task_level_code'] = 15;
			$_SESSION['current_ap_task_level_sub_code'] =999;
			$_SESSION['current_ap_task_order_section'] = 15;
			$_SESSION['current_ap_task_orderer'] = 8388607;
			$_SESSION['current_ap_task_priority'] = 3;
			$_SESSION['current_ap_task_state'] = 99;
		}

		$ob2 = new su_class_value_name_convert_with_code();
		$ob3 = new su_class_value_combine_combobox_value_to_mysql_query();
		$UI_form_ob = new su_class_UI_format_generator();		


// 하드 코딩된 함수 이하

function toWeekNum($get_year, $get_month, $get_day){
 $timestamp = mktime(0, 0, 0, $get_month, $get_day, $get_year);
 $w = date('w',mktime(0,0,0,date('n',$timestamp),1,date('Y',$timestamp)));
 return ceil(($w + date('j',$timestamp) - 1)/7);
}





		
?>

<!-- 하드 코딩된 함수 이하 -->



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

						var popOption = "fullscreen=0, resizable=no, scrollbars=1, status=no;";    //팝업창 옵션(optoin)
	  					var popUrl = "/outsource5.php";	//팝업창에 출력될 페이지 URL
						window.open(popUrl+'?level=' + level +'&sub_level=' + sub_level +'&tid=' + tid,popOption,'height=' + (screen.height*0.60) + ',width=' + (screen.width*0.69));

					

    
						}

						</script>
	

			<script> 
						function selectEvent(selectObj,field_index){
     					 // You can't define php variables in java script as $course etc.


	  					var popUrl = "./common_func/su_function_real_time_combobox_appro.php";	//팝업창에 출력될 페이지 URL
						var popOption = "width=680, height=680, resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
						 window.location.href = popUrl+'?var=' + selectObj.value + '&index=' +field_index;


    
						}

			</script>




	<head>
		<title>test</title>
		<meta charset="utf-8" />
		
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,600,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="assets/css/reset.css"> <!-- CSS reset -->
		<link rel="stylesheet" href="assets/css/style.css"> <!-- Resource style -->
		<script src="assets/js/modernizr.js"></script> <!-- Modernizr -->
	
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      	<script src="//code.jquery.com/jquery.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	
	
<style>
  table {
    width: 100%;
    border-top: 1px solid #444444;
    border-collapse: collapse;
  }
  th {
    border-bottom: 1px solid #444444;
    padding: 1px;
    text-align: center;
  }
  td {
    border-bottom: 1px solid #444444;
    padding: 1px;
    text-align: center;
  }
  #left{
	  text-align: left;

  }

  th:nth-child(2n), td:nth-child(2n) {
    background-color: #;
  }
  th:nth-child(2n+1), td:nth-child(2n+1) {
    background-color: #;
  }
  
  
  .fixed-table-container {
        width: 1300px;
        height: 550px;
        border: 1px solid #000;
        position: relative;
        padding-top: 30px; /* header-bg height값 */
    }
    .header-bg {
        background: skyblue;
        height: 30px; /* header-bg height값 */
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        border-bottom: 1px solid #000;
    }
	.foot-bg {
        background: skyblue;
        height: 20px; /* header-bg height값 */
        position: absolute;
        bottom: 0;
        right: 0;
        left: 0;
        border-bottom: 1px solid #000;
    }
    .table-wrapper {
        overflow-x: hidden;
        overflow-y: auto;
        height: 100%;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    td {
        border-bottom: 1px solid #ccc;
        padding: 5px;
    }
    td + td {
        border-left: 1px solid #ccc;
    }
    th {
        padding: 0px; /* reset */
    }
    .th-text {
        position: absolute;
        top: 0;
        width: inherit;
        line-height: 30px; /* header-bg height값 */
        border-left: 1px solid #000;
    }
	.th-text2 {
        position: absolute;
        bottom: 0;
        width: inherit;
        line-height: 20px; /* header-bg height값 */
        border-left: 1px solid #000;
    }
    th:first-child .th-text {
        border-left: none;
    }
	#wrapper{
	  padding: 0px 0px 0px 66px;
  }
</style>

	<script>               /*달력 함수*/
         $(function() {
            $("#datepicker1, #datepicker2").datepicker({
               dateFormat: 'yy-mm-dd'
            });
         });

    </script>

  </head>
	<body>

	
	<header>
		<a id="cd-menu-trigger" href="#0"><span class="cd-menu-text">메뉴</span></a>

		
	<div id="wrapper" style="width:100%" "height:300px">

				<?php
					$UI_form_ob->su_function_get_title('결제 관리 화면',$_SESSION['my_name'],$_SESSION['my_position'],$_SESSION['my_department'],'su_script_user_personal_interface');
				?>




				<div style="padding:20px 0px 20px 0px;">


					<div>
					
								업무등급
								<select name = "task_select_box[]"  onchange="javascript:selectEvent(this,0);">	
									<?php
											$query = "SELECT * FROM master_task_level_info_table";
											$result = mysqli_query($conn,$query);  
											echo "<option value='15'>전체</option>";
													while( $row=mysqli_fetch_array($result)){
															if($row['master_task_level_code']!=15){           
															if($row['master_task_level_code']==$_SESSION['current_ap_task_level_code']){
																echo "<option value='".$row['master_task_level_code']."' selected>".$row['master_task_level_name']."</option>";
															}
															else{
															echo "<option value='".$row['master_task_level_code']."'>".$row['master_task_level_name']."</option>";
															}
														}
													}
										?>         
								</select>	
					</div>

					<div>
						사업명&nbsp &nbsp &nbsp
							<select name = "task_select_box[]" onchange="javascript:selectEvent(this,1);">	
       							 <?php
										$cnt = 0;
										$query = "SELECT * FROM master_task_level_sub_info_table";
     					        		$result = mysqli_query($conn,$query); 
										 		 echo "<option value='999' selected>전체</option>"; 
           										 while( $row=mysqli_fetch_array($result) ){
														
														if(($row['master_task_level_code']==$_SESSION['current_ap_task_level_code'])){
													
														if($row['master_task_level_sub_code']!=999){
																if($_SESSION['current_ap_task_level_sub_code']==$row['master_task_level_sub_code']){
																	$cnt=1;
																	echo "<option value='".$row['master_task_level_sub_code']."' selected>".$row['master_task_level_sub_name']."</option>";
																}else{
																	echo "<option value='".$row['master_task_level_sub_code']."'>".$row['master_task_level_sub_name']."</option>";
																}
															}
														}
													}
													if($cnt==0) $_SESSION['current_ap_task_level_sub_code'] = 999;
							
      							  ?>         
   							</select>	 
						</div>

					<div>
							
					<form action = 'outsource4.php' method='POST' name="table_filter">		
							<span>시작일&nbsp &nbsp &nbsp</span>
							<?php
							echo '<input type="text" name = "task_select_box[]" id="datepicker1" onchange="javascript:selectEvent(this,5);" value="'.$_SESSION['current_ap_base_date'].'">'
							?>
							<span>/ 마감일&nbsp &nbsp &nbsp</span>
							<?php
							echo '<input type="text" name = "task_select_box[]" id="datepicker2"  onchange="javascript:selectEvent(this,6);" value="'.$_SESSION['current_ap_limit_date'].'">'
							?>
							
							
							
					
					</div>

				</div>





				<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
					<thead>
				

					<table>
						<tr>
						<th width="3%"><div class="th-text">NO</div></th>
						<th width="22%" text-align="center">
						<div class="th-text">업무명</div>
						</th>




						<th width="16%" text-align="center">
							<div class="th-text">요청자
							<select name = "task_select_box[]" onchange="javascript:selectEvent(this,2);">	
       							 <?php
										$query = "SELECT * FROM sid_combine_table u where ".$_SESSION['my_department_code']." = u.sid_combine_department AND ".$_SESSION['my_position_code']."> u.sid_combine_position AND u.is_valid=1";
     					        		$result = mysqli_query($conn,$query);
										 		echo "<option value='8388607'>전체</option>";
           										 while( $row=mysqli_fetch_array($result) ){    
														$name_Value = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['SID'],"master_user_info_name");
																	
																				if($row['SID']==$_SESSION['current_ap_task_orderer']){
																					echo "<option value='".$row['SID']."' selected>".$name_Value."</option>";
																				}
																				else{
																				echo "<option value='".$row['SID']."'>".$name_Value."</option>";
																				}		                                    
																	}
       										     
      							  ?>          
   							</select>	</div>
						</th>
						

						<th width="10%" text-align="center">
							<div class="th-text">우선도
							<select name = "task_select_box[]" onchange="javascript:selectEvent(this,3);">	
       							 <?php
										$query = "SELECT * FROM master_priority_info_table";
										$result = mysqli_query($conn,$query);
										 echo "<option value='3'>전체</option>";
           										 while( $row=mysqli_fetch_array($result) ){   
														if($row['master_task_priority_info_code']!=3){  
														if($row['master_task_priority_info_code']==$_SESSION['current_ap_task_priority']){
															echo "<option value='".$row['master_task_priority_info_code']."' selected>".$row['master_task_priority_info_name']."</option>";
														}
														else{
            											  echo "<option value='".$row['master_task_priority_info_code']."'>".$row['master_task_priority_info_name']."</option>";
       										    		 }                                             
													}
       										     }
      							  ?>          
   							</select> </div>
						</th>




						<th width="13%" text-align="center">
							<div class="th-text">상태명
							<select name = "task_select_box[]" onchange="javascript:selectEvent(this,4);">		
       							 <?php
										$query = "SELECT * FROM master_state_info_table";
										$result = mysqli_query($conn,$query);
										 echo "<option value='99'>전체</option>";
           										 while( $row=mysqli_fetch_array($result) ){   
														if($row['master_task_state_info_code']!=99){  
														if($row['master_task_state_info_code']==$_SESSION['current_ap_task_state']){
															echo "<option value='".$row['master_task_state_info_code']."' selected>".$row['master_task_state_info_name']."</option>";
														}
														else{
            											  echo "<option value='".$row['master_task_state_info_code']."'>".$row['master_task_state_info_name']."</option>";
       										    		 }                                             
														}
       										     }
      							  ?>          
   							</select> </div>
						</th>


						<th  width="16%" text-align="center">
							<div class="th-text">작성일자</div>
						</th>
					
						</form>		
						<th  width="16%" text-align="center">
							<div class="th-text">☆★</div>
						</th>
							
						</tr>
				
						</thead>
						
						<tr>


			<?php

				/*
				// 각 필드 콤보박스의 입력 값 확인하는 로직
				// 테이블 위치에 코드값으로 바로 표시됨.
				echo "<br />";
				echo "<br />";
				echo "debug status";
				echo "<br />";
				echo '업무 레벨 ';
				echo $_SESSION['current_ap_task_level_code'];
				echo "<br />";
				echo '업무 코드 ';
				echo $_SESSION['current_ap_task_level_sub_code'];
				echo "<br />";
				echo '발주처 코드 ';
				echo $_SESSION['current_ap_task_order_section'];
				echo "<br />";
				echo '발주자 코드 ';
				echo $_SESSION['current_ap_task_orderer'];
				echo "<br />";
				echo '우선도 코드 ';
				echo $_SESSION['current_ap_task_priority'];
				echo "<br />";
				echo '상태 코드 ';
				echo $_SESSION['current_ap_task_state'];
				echo "<br />";
				echo '필터 시작 일자 ';
				echo $_SESSION['current_ap_base_date'];
				echo "<br />";
				echo '필터 제한 일자 ';
				echo $_SESSION['current_ap_limit_date'];
				echo "<br />";
				*/


				$task_table_query = $ob3->su_function_combine_query_to_task_header_table_lower_only($_SESSION['current_ap_task_level_code'],$_SESSION['current_ap_task_level_sub_code'],$_SESSION['current_ap_task_order_section'],$_SESSION['current_ap_task_orderer'],$_SESSION['current_ap_task_priority'],$_SESSION['current_ap_task_state'],$_SESSION['current_ap_base_date'],$_SESSION['current_ap_limit_date']);
				$result_set = mysqli_query($conn,$task_table_query);
				$row = mysqli_fetch_array($result_set);




				
       			/*
				echo '입력된 쿼리문 ';
				echo $task_table_query;
				echo "<br />";   
				   
				   if(mysqli_num_rows($result_set)==0) echo "일치하는 항목이 없습니다.";
				else
					echo "일치하는 항목을 발견했습니다.";
					echo "<br />";
					echo "총 ";
					echo mysqli_num_rows($result_set);
					echo "개";
					echo "<br />";
					echo "<br />";
				*/
				


			?> 


						
						
		<?php
			$cnt = 1;
			$task_table_query = $ob3->su_function_combine_query_to_task_header_table_lower_only($_SESSION['current_ap_task_level_code'],$_SESSION['current_ap_task_level_sub_code'],$_SESSION['current_ap_task_order_section'],$_SESSION['current_ap_task_orderer'],$_SESSION['current_ap_task_priority'],$_SESSION['current_ap_task_state'],$_SESSION['current_ap_base_date'],$_SESSION['current_ap_limit_date']);
			$result_set = mysqli_query($conn,$task_table_query);
            while($row = mysqli_fetch_array($result_set)) {

				$orderer = $row['task_orderer'];
			

				$task_table_query2 = "select * from task_approbation_table u where u.TID = ".$row['TID'].";";
				$result_set2 = mysqli_query($conn,$task_table_query2);
				$row2 = mysqli_fetch_array($result_set2);

				// field name 조립해서 aida 필드시리즈의 sid 값을 가져온다.
				
				if($row2['current_sid']!=8){
				$field_name = $row2['current_sid'].'_layer_aida_sid';
				$current = $row2[$field_name];
				}else{
				$current = $row2['end_order'];
				}
				if($current != $_SESSION['my_sid_code']) continue;

            ?> 
                <tr>
					<td><?php echo $cnt++?></td>
					<td id='left'><?php
						 echo"<a href='#' onclick='hrefClick_of_sub_task(".$row['task_level_code'].','.$row['task_level_sub_code'].','.$row['TID'].");'/>"; echo $row['task_name']?></td>
					</td>
					<td><?php echo 
						 $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['task_orderer'],"master_user_info_name");
					?></td>
					<td><?php echo 
					 	 $ob2->su_function_convert_name($conn,"master_priority_info_table","master_task_priority_info_code",$row['task_priority'],"master_task_priority_info_name");
					?></td>

					<td><?php echo  
						 $ob2->su_function_convert_name($conn,"master_state_info_table","master_task_state_info_code",$row['task_state'],"master_task_state_info_name");
					?></td>
					<td>
					<?php
						$query_of_date = "SELECT * FROM task_document_header_table u WHERE u.TId = ".$row['TID'].";";
     					    $result_of_date = mysqli_query($conn,$query_of_date);  
           						$row_of_date = mysqli_fetch_array($result_of_date);   
									echo $row_of_date['task_birth_date'];
											
					?>
					</td>

						<td>
					<?php
    
     					 echo "<a href='#' onclick='hrefClick(".$row2['AID'].','.$row2['TID'].");'/>결제하기</a><br>";
    
					?>

				

					</td>
                </tr>





            <?php
            }



			//statistical summary
			echo "<div class='foot-bg'></div>";
				echo "<tr><th colspan=10 width=100% id='left'>";
					echo "<div class='th-text2'>";
						if(($cnt-1)==0){ echo "일치하는 항목이 없습니다.";
							}else{
								echo "합계 : ";
								echo $cnt-1;
								echo "건";
							}
					echo "</div>";
				echo "</th></tr>";

            ?>
</tr>
					</table>
				</div>

		










			<div id="footer" style="padding:120px 0px 0px 0px;">
						











			</div>
				<p style="background-color:coffee" class="bd" align="center">COPYRIGHT(C) 2017 SUNUNENG.ENG ALL RIGHTS RESERVED&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp주소 : 광주광역시 광산구 송정동 735 선운빌딩 3층 <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp연락처 : 062-651-9272 / FAX : 062-651-9271</p>
			
			
			
			
			
			
			
			</div>
</header>


<div style="height:1000px">

	<nav id="cd-lateral-nav" >
												<br />
															<br />
																		<br />
		<p align="center"><img src="./src/su_rsc_sulogo_back.png" width="200" height="100" title="선운로고"/></p>
															<br />
												<br />
			<li><a class="current" href="#0">* * * *</a></li>

				<a >이름
				<font color='white'><?php
					echo $_SESSION['my_name'];
				?></font></a>
			
				<a>부서
					<font color='white'><?php
					echo $_SESSION['my_department'];
				?></font></a>		
			
				<a>직급
					<font color='white'><?php
					echo $_SESSION['my_position'];
				?></font></a>

				<a>사번
					<font color='white'><?php
					echo $_SESSION['my_sid_code'];
				?></font></a>

				<a href = "./su_script_logout_support.php">로그아웃</a>
			
			</li> 
				
		</ul> 

		<ul class="cd-navigation cd-single-item-wrapper">
			<li><a class="current" href="#0">* * * *</a></li>


<li><a href="./su_script_notice_interface.php"> # 공지사항</a></li>
			
			<li>
			
			<a href="#0"> 
			<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div>! 업무관리</div>
					</a><DIV style='display:none'> 
			
				<a href = "su_script_user_personal_interface.php" align = "right">
					<font color='white'>
					내 업무
					</font></a>	

				<a href = "su_script_process_table_interface.php" align = "right">
					<font color='white'>
					공정표 조회
					</font></a>		
			
						</DIV>
			</a>
			
			
			</li>

			<li><a href="su_script_approbation_interface.php"> # 결제함</a></li>
			<li><a href="su_script_configure_interface.php"> # 설정</a></li>
						<li>
			
			<a href="#0"> 
			<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div># 관리자 기능</div>
					</a><DIV style='display:none'> 
			
				<a href = "su_script_approbation_management_interface.php" align = "right">
					<font color='white'>
					결제 루트 설정
					</font></a>	

				<a href = "su_script_process_table_interface.php" align = "right">
					<font color='white'>
					이하 추가예정
					</font></a>		
			
						</DIV>
			</a>
			
			
			</li>
		</ul> <!-- cd-single-item-wrapper -->

		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="assets/js/main.js"></script> <!-- Resource jQuery -->
		<script language="JavaScript" src="assets/js/date_picker.js"></script>

 		<!-- 새로운 달력 자바 스크립트 소스-->
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>                     
      	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		</div>
	</body>    

</html>