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
		$ob2 = new su_class_value_name_convert_with_code();
		$ob3 = new su_class_value_combine_combobox_value_to_mysql_query();
		$ob4 = new su_class_folder_table_manager();

// 테이블 콤보박스의 필드값 초기화



		if(!isset($_SESSION['process_radio_index'])){
			$_SESSION['process_radio_index']=0;
			
			$_SESSION['process_current_personal_base_date']="";
			$_SESSION['process_current_personal_limit_date']="";

			$_SESSION['process_current_personal_task_priority'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_priority");
			$_SESSION['process_current_personal_task_state'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_state");
		}

		if(!isset($_SESSION['process_hold_level'])){
			
			$_SESSION['process_hold_level']=15;
		}
		if(!isset($_SESSION['process_sub_hold_level'])){
			
			$_SESSION['process_sub_hold_level']=999;
		}


		/*	
		if(isset($_SESSION['process_current_personal_task_state'])==false){
			$_SESSION['process_current_personal_task_order_section'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_order_section");
			$_SESSION['process_current_personal_task_orderer'] = 8388607;
			$_SESSION['process_current_personal_task_priority'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_priority");
			$_SESSION['process_current_personal_task_state'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_state");
		}
		*/

// 하드 코딩된 함수 이하

function toWeekNum($get_year, $get_month, $get_day){
 $timestamp = mktime(0, 0, 0, $get_month, $get_day, $get_year);
 $w = date('w',mktime(0,0,0,date('n',$timestamp),1,date('Y',$timestamp)));
 return ceil(($w + date('j',$timestamp) - 1)/7);
}





		
?>

<!-- 하드 코딩된 함수 이하 -->


	<script> 
						function selectEvent(selectObj,field_index){
     					 // You can't define php variables in java script as $course etc.


							var popUrl = "./common_func/su_function_real_time_combobox_process.php";	//팝업창에 출력될 페이지 URL
							var popOption = "width=680, height=680, resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
							window.location.href = popUrl+'?var=' + selectObj.value + '&index=' +field_index;


    
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



	<head>
		<title>test</title>

		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

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
		<script type="text/javascript" src="/assets/nse_files/js/HuskyEZCreator.js" charset="utf-8"></script>

	
<style>
  table {
    width: 100%;
    border-top: 1px solid #444444;
    border-collapse: collapse;
  }
  td {
    border-bottom: 1px solid #444444;
    padding: 1px;
    text-align: left;
  }
  th {
    border-bottom: 1px solid #444444;
    padding: 1px;
    text-align: center;
  }

  th:nth-child(2n), td:nth-child(2n) {
    background-color: #;
  }
  th:nth-child(2n+1), td:nth-child(2n+1) {
    background-color: #;
  }

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
        text-align: right; 
        color: #333; 
        height: 1em; 
        line-height: 1em;            
    }
	.graph .bar2 { 
		display: block;
        position: relative;
        background: #BFFF32; 
        text-align: right; 
        color: #333; 
        height: 1em; 
        line-height: 1em;            
    }
    .graph .bar span { position: absolute; left: 1em; }

	#fly{
		padding : 0px 0px 0px 200px;

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
		


	<div id="wrapper" style="width:1900px" "height:300px">

		<div style="width:200px" "height:300px"  style="float:left;">
			<a id="cd-menu-trigger" href="#0"><span class="cd-menu-text">메뉴</span><span class="cd-menu-icon"></span></a>
		</div>

		<div id = 'fly' style="width:1200px" "height:300px"  style="float:right;" >

				<form action = 'outsource2.php' method='POST' name="table_filter">
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div align="center"><h2>공 정 표</h2></div>
					</a><DIV style='display:block'>
					 
					<table>
			
					<tr>
						<td  colspan="1">업 무 등 급</td>
							<td  colspan="5"><select id = "task_writer_interface_combobox" name = "task_select_box[]" onchange="javascript:selectEvent(this,0);">	
									<?php
											$query = "SELECT * FROM master_task_level_info_table";
											$result = mysqli_query($conn,$query);  
													while( $row=mysqli_fetch_array($result) ){         
															if($row['master_task_level_code']!=15){
															if($row['master_task_level_code']==$_SESSION['process_hold_level']){
																echo "<option value='".$row['master_task_level_code']."' selected>".$row['master_task_level_name']."</option>";
															}
															else{
																echo "<option value='".$row['master_task_level_code']."'>".$row['master_task_level_name']."</option>";
															}
														}
													}
									?>         
								</select>	
							</td>
								<!--
								<td  colspan="1">사 업 명</td>
						<td  colspan="2">
						<select name = "task_select_box[]" onchange="javascript:selectEvent(this,1);">	
       							 <?php/*
										$query = "SELECT * FROM master_task_level_sub_info_table";
     					        		$result = mysqli_query($conn,$query); 
										 		 echo "<option value='' selected>--</option>"; 
           										 while( $row=mysqli_fetch_array($result) ){    
														
														if(($row['master_task_level_code']==$_SESSION['process_hold_level'])&&($row['master_task_level_sub_code']!=999)){
															if($row['master_task_level_sub_code']==$_SESSION['process_sub_hold_level']){
            											 		echo "<option value='".$row['master_task_level_sub_code']."' selected>".$row['master_task_level_sub_name']."</option>";
															}else{
															echo "<option value='".$row['master_task_level_sub_code']."'>".$row['master_task_level_sub_name']."</option>";
															}
														   
														}
													
													}
      							  */?>         
   							</select>	
					</td>
					-->
					</tr>

					<tr>
						
						<td  colspan="1">우 선 도</td>
						<td  colspan="2">
							<select  name = "task_select_box[]" name = "task_select_box[]" onchange="javascript:selectEvent(this,2);">	
       							 <?php
										$query = "SELECT * FROM master_priority_info_table";
     					        		$result = mysqli_query($conn,$query);
										 echo "<option value='3'>전체</option>";  
           										 while( $row=mysqli_fetch_array($result) ){    
													if($row['master_task_priority_info_code']!=3){
            											  
														  if($row['master_task_priority_info_code']==$_SESSION['process_current_personal_task_priority']){
																echo "<option value='".$row['master_task_priority_info_code']."' selected>".$row['master_task_priority_info_name']."</option>";
															}
															else{
																echo "<option value='".$row['master_task_priority_info_code']."'>".$row['master_task_priority_info_name']."</option>";
															}
            											 
       										     }
											}
      							  ?>         
   							</select>
						</td>

						<td  colspan="1">상 태 명</td>
						<td  colspan="2">
							<select  name = "task_select_box[]" name = "task_select_box[]" onchange="javascript:selectEvent(this,3);">	
       							 <?php
										$query = "SELECT * FROM master_state_info_table";
     					        		$result = mysqli_query($conn,$query);  
										 echo "<option value='99'>전체</option>";  
           										 while( $row=mysqli_fetch_array($result) ){    
														if($row['master_task_state_info_code']!=99){
       										    		                                             
            											   if($row['master_task_state_info_code']==$_SESSION['process_current_personal_task_state']){
																echo "<option value='".$row['master_task_state_info_code']."' selected>".$row['master_task_state_info_name']."</option>";
															}
															else{
																echo "<option value='".$row['master_task_state_info_code']."'>".$row['master_task_state_info_name']."</option>";
															}
														}
											}
      							  ?>          
   							</select>
						</td>


					</tr>

					<tr>
						<td>기 준 시 간</td>
										<td colspan=2>
													<?php

															switch ($_SESSION['process_radio_index']){
														
																case 0 :
																	echo "<input type='radio' onclick='selectEvent(this.value,7)' checked>주간 ";
																	echo "<input type='radio' onclick='selectEvent(this.value,8)'>월간 ";
																	echo "<input type='radio' onclick='selectEvent(this.value,9)'>연간 ";
																	break;
																case 1 :
																	echo "<input type='radio' onclick='selectEvent(this.value,7)'>주간 ";
																	echo "<input type='radio' onclick='selectEvent(this.value,8)'' checked>월간 ";
																	echo "<input type='radio' onclick='selectEvent(this.value,9)'>연간 ";
																	break;
																case 2 :
																	echo "<input type='radio' onclick='selectEvent(this.value,7)'>주간 ";
																	echo "<input type='radio' onclick='selectEvent(this.value,8)'>월간 ";
																	echo "<input type='radio' onclick='selectEvent(this.value,9)' checked>연간 ";
																	break;
															}
													?>
										</td>
						<td>조 회 기 간</td>
						<td><input type="text" name = "task_select_box[]" id="datepicker1" value=<?php echo $_SESSION['process_current_personal_base_date']; ?>></td>
						<td><input type="text" name = "task_select_box[]" id="datepicker2" value=<?php echo $_SESSION['process_current_personal_limit_date']; ?>></td>

					</tr>
						
					</table>

					</div>


				<div style="padding:10px 0 0 0;"></div>
					
		
					
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div align="center">상세</div>
					</a><DIV  style='display:block';> 
					<div style="width:100%; height:500px; overflow:auto">
					<table>
						<tr>
							<td colspan = 5>
								<select name = "task_select_box[]" onchange="javascript:selectEvent(this,1);">	
									<?php
											$query = "SELECT * FROM master_task_level_sub_info_table";
											$result = mysqli_query($conn,$query); 
													echo "<option value='999' selected>전체</option>"; 
													while($row=mysqli_fetch_array($result)){    
															
															if(($row['master_task_level_code']==$_SESSION['process_hold_level'])&&($row['master_task_level_sub_code']!=999)){
																if($row['master_task_level_sub_code']==$_SESSION['process_sub_hold_level']){
																	echo "<option value='".$row['master_task_level_sub_code']."' selected>".$row['master_task_level_sub_name']."</option>";
																}else{
																echo "<option value='".$row['master_task_level_sub_code']."'>".$row['master_task_level_sub_name']."</option>";
																}
															
															}
														
														}
									?>         
								</select>
								</form>   
							</td>		
						</tr>
						<tr>
							<td width=25%>
								업무명
							</td>
							
							<th  width=25% colspan=2>
								과업기간
							</th>
							
							<td  width=15%>
								수행일수
							</td>

							<td  width=35%>
								진행률
							</td>
						</tr>

						<tr>

							<!-- 하위 업무 루프문 시작 -->


							<?php
							
									$task_table_query = $ob3->su_function_combine_query_to_task_header_table_with_depth($_SESSION['process_hold_level'],$_SESSION['process_sub_hold_level'],15,8388607,$_SESSION['process_current_personal_task_priority'],$_SESSION['process_current_personal_task_state'],$_SESSION['process_current_personal_base_date'],$_SESSION['process_current_personal_limit_date']);
									$result_set = mysqli_query($conn,$task_table_query);
									while($row = mysqli_fetch_array($result_set)) {
							?>

								<tr>
									<td><?php
										echo"<a href='#' onclick='hrefClick_of_sub_task(".$row['task_level_code'].','.$row['task_level_sub_code'].','.$row['TID'].");'/>"; echo $row['task_name'];

									?>
									</td>


									<td><?php
										echo $row['task_base_date'];?>
									</td>
									<td><?php
										echo $row['task_limit_date'];?>
									</td>

									
									<td><?php
										$tmp = strtotime($row['task_elapsed_limit_date'])-strtotime($row['task_base_date']);
										echo $tmp/86400;
										?>
									</td>


									<td>

										<!-- 공정표 그래프의 퍼센트 연산하는 파트 -->

										<?php
												$sup = strtotime($_SESSION['now_date'])-strtotime($row['task_base_date']);
												$sub = strtotime($row['task_limit_date'])-strtotime($row['task_base_date']);
												if($sub==0){
													 $rate = 100;				 
												}else{
													$rate = $sup/$sub;
													$rate = $rate*100;

													$rate = $rate >100 ? 100 : $rate;
													$rate = $rate <0 ? 0 : $rate;
												}

													$rate_elapse = $ob4->su_recruit_function_calc_elapse_rate($conn,$ob3,$row['TID']);
													if($rate_elapse > $rate) $rate = $rate_elapse;

												echo "<div class='graph'>";
													echo "<strong class='bar' style='width: ".round($rate)."%;'>".round($rate,1)."%</strong>";
													echo "<strong class='bar2' style='width: ".round($rate_elapse)."%;'>".round($rate_elapse,1)."%</strong>";						
												echo "</div>";

										?>
									</td>	
								</tr>
							<?php


									if($ob4->su_function_is_have_extra_task($conn,$ob3,$row['TID'],0)){
										echo"<tr>";
										echo"<td colspan=6>";
									 	echo"<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';>"; 
										echo"<div style='background-color:#FFF'><font color='black' /> &nbsp▼</div>";
										echo"</a><DIV style='display:none';>";
										echo"<table style='background-color:#DDD'>";
										$ob4->su_recruit_function_make_tree($conn,$ob3,$row['TID'],0);
										echo"</table>";
										
                                 		echo"</DIV>";
										echo"</td>";
										echo"</tr>";
									}else{
										echo"<tr>";
										echo"<td colspan=6>";
										echo"<div><font color='black' /> &nbsp▽</div>";
										echo"</td>";
										echo"</tr>";
									}



           			 			}
							?>
							<!-- 루프문 끝 -->


						
					</table>
					</div>

					</div>
			

					     

					</div>
				
				
				</div>

			</div>
			

		
	<div style="padding:300px 0px 0px 1800px;"></div>
				<p style="background-color:coffee" class="bd" align="center">COPYRIGHT(C) 2017 SUNUNENG.ENG ALL RIGHTS RESERVED&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp주소 : 광주광역시 광산구 송정동 735 선운빌딩 3층 <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp연락처 : 062-651-9272 / FAX : 062-651-9271</p>
		
</header>


	<div style="height:1000px">

	<nav id="cd-lateral-nav" >
		<ul class="cd-navigation" >
		<p align="center"><img src="./src/su_rsc_sulogo_back.png" width="200" height="100" title="선운로고"/></p>
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

			<li>
			
			<a href="#0"> 
			<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div>! 공지사항</div>
					</a><DIV style='display:none'> 
					<a href = "./su_script_notice_active_only_interface.php" align = "right">
				<font color='white' >
				공지사항
				</font></a>
			
				<a href = "./su_script_notice_interface.php" align = "right">
					<font color='white'>
					공지사항 게시판
					</font></a>		
			
						</DIV>
			</a>
			
			
			</li>

			
			<li>
			
			<a href="#0"> 
			<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div>! 업무관리</div>
					</a><DIV style='display:none'> 
					<a href = "su_script_user_interface.php" align = "right">
				<font color='white' >
				전체 업무 검색
				</font></a>
			
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