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
		$UI_form_ob = new su_class_UI_format_generator();
        $ob4 = new su_class_calc_the_date();

// 테이블 콤보박스의 필드값 초기화
		
		if(!isset($_SESSION['personal_radio_index'])){
			$_SESSION['personal_radio_index']=0;
		}

		if(isset($_SESSION['current_personal_gate_task_level_code'])==false){
			$_SESSION['current_personal_gate_task_level_code'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_level_code");
			$_SESSION['current_personal_gate_task_level_sub_code'] = 999;
			$_SESSION['current_personal_gate_base_date']=$ob4->su_function_convert_this_week_begin($_SESSION['now_date']);;
			$_SESSION['current_personal_gate_limit_date']=$ob4->su_function_convert_this_week_end($_SESSION['now_date']);;
			$_SESSION['current_personal_gate_task_order_section'] = $_SESSION['my_department_code'];
		}




		if(isset($_SESSION['current_personal_task_level_code'])==false){
			$_SESSION['current_personal_base_date']="";
			$_SESSION['current_personal_limit_date']="";
			$_SESSION['current_personal_task_level_code'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_level_code");
			$_SESSION['current_personal_task_level_sub_code'] = 999;
			$_SESSION['current_personal_task_order_section'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_order_section");
			$_SESSION['current_personal_task_orderer'] = $_SESSION['my_sid_code'];
			$_SESSION['current_personal_task_priority'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_priority");
			$_SESSION['current_personal_task_state'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_state");
		}

			if(isset($_SESSION['radio_index'])==false){ // 0 = 전체 1 = 현업 2 = 계획
				$_SESSION['radio_index'] = 0;
			}



// 뒤로가기 버튼 연타시, 로그아웃 해주는 플래그

			$_SESSION['backword_flag'] = 514;




// 하드 코딩된 함수 이하

function toWeekNum($get_year, $get_month, $get_day){
 $timestamp = mktime(0, 0, 0, $get_month, $get_day, $get_year);
 $w = date('w',mktime(0,0,0,date('n',$timestamp),1,date('Y',$timestamp)));
 return ceil(($w + date('j',$timestamp) - 1)/7);
}





		
?>

<!-- 하드 코딩된 함수 이하 -->



						

	<script> 
						function hrefClick_of_sub_task(level,sub_level,master){
     					 // You can't define php variables in java script as $course etc.

						var popOption = "fullscreen=yes, resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
	  					var popUrl = "/outsource5adapter.php";	//팝업창에 출력될 페이지 URL
						window.location.href = popUrl+'?level=' + level +'&sub_level=' + sub_level +'&master=' + master;

					

    
						}

						</script>

	<script> 
						function selectEvent(selectObj,field_index){
     					 // You can't define php variables in java script as $course etc.


	  					var popUrl = "./common_func/su_function_real_time_combobox_personal_intf.php";	//팝업창에 출력될 페이지 URL
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
  th, td {
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
  #wrapper{
	  padding: 0px 0px 0px 66px;
  }
  	

	 .fixed-table-container {
        width: 1200px;
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
		<a id="cd-menu-trigger" href="#0"><span class="cd-menu-text">메뉴&nbsp &nbsp &nbsp &nbsp</span></a>
		
		
	<div id="wrapper" style="width:100%"; "height:300px">

			<?php
				$UI_form_ob->su_function_get_title('업무 현황',$_SESSION['my_name'],$_SESSION['my_position'],$_SESSION['my_department'],'su_script_user_personal_interface');
			?>
				<input type="button" name="버튼" value="사업 등록" onclick="window.open('./su_script_table_write_personal_interface.php','win','width=800,height=700,toolbar=0,scrollbars=0,resizable=0')";>
				<div id="head" style="padding:0px 0px 0px 766px;">
						
				<form action = 'outsource6.php' method='POST' name="table_filter">		






													<?php

															switch ($_SESSION['personal_radio_index']){
														
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









				<br />
				<span>시작일</span>
						<?php
						 echo '<input type="text" name = "task_select_box[]" id="datepicker1" onchange="javascript:selectEvent(this,5);" value="'.$_SESSION['current_personal_gate_base_date'].'">'
						?>
						<span>/ 마감일</span>
						<?php
						 echo '<input type="text" name = "task_select_box[]" id="datepicker2" onchange="javascript:selectEvent(this,6);" value="'.$_SESSION['current_personal_gate_limit_date'].'">'
						?>
						
				<br />
				
				
				
				
				
				
				
				
				
				
				
				
				
				</div>
				


				

						 
					<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
					<thead>
					
					<table>
						<tr>



						
						<th   width="18%" text-align="center">
							<div class="th-text">업무등급
							<select name = "task_select_box[]" onchange="javascript:selectEvent(this,0);">	
       							 <?php
										$query = "SELECT * FROM master_task_level_info_table";
     					        		$result = mysqli_query($conn,$query);  
										 echo "<option value='15'>전체</option>";
           										 while( $row=mysqli_fetch_array($result) ){   
														if($row['master_task_level_code']!=15){      
														if($row['master_task_level_code']==$_SESSION['current_personal_gate_task_level_code']){
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
						</th>
						<th   width="20%" text-align="center">
							<div class="th-text">발주처
							<select name = "task_select_box[]" onchange="javascript:selectEvent(this,2);">	
       							 <?php
										$query = "SELECT * FROM master_department_info_table";
     					        		$result = mysqli_query($conn,$query);  
										 echo "<option value='15'>전체</option>";
           										 while( $row=mysqli_fetch_array($result) ){   
														if($row['sid_combine_department']!=15){      
														if($row['sid_combine_department']==$_SESSION['current_personal_gate_task_order_section']){
															echo "<option value='".$row['sid_combine_department']."' selected>".$row['master_department_info_name']."</option>";
														}
														else{
            											 echo "<option value='".$row['sid_combine_department']."'>".$row['master_department_info_name']."</option>";
       										    		 }
													}
												}
      							  ?>         
   							</select>
							</div>
						</th>
						
						<th   width="25%" text-align="center">
							<div class="th-text">사업명</div>
						</th>
						<th width = "10%" text-align="center">
							<div class="th-text">담당자</div>
						</th>
						<th   width="20%" text-align="center">
							<div class="th-text">사업기간</div>
						</th>
						<th   width="7%" text-align="center">
							<div class="th-text">상태</div>
						</td>
						
					</form>		
	
						
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
				echo $_SESSION['current_personal_gate_task_level_code'];
				echo "<br />";
				echo '업무 코드 ';
				echo $_SESSION['current_personal_gate_task_level_sub_code'];
				echo "<br />";
				echo '발주처 코드 ';
				echo $_SESSION['current_personal_task_order_section'];
				echo "<br />";
				echo '발주자 코드 ';
				echo $_SESSION['current_personal_task_orderer'];
				echo "<br />";
				echo '우선도 코드 ';
				echo $_SESSION['current_personal_task_priority'];
				echo "<br />";
				echo '상태 코드 ';
				echo $_SESSION['current_personal_task_state'];
				echo "<br />";
				echo '필터 시작 일자 ';
				echo $_SESSION['current_personal_base_date'];
				echo "<br />";
				echo '필터 제한 일자 ';
				echo $_SESSION['current_personal_limit_date'];
				echo "<br />";
				*/


				$task_table_query = $ob3->su_function_combine_query_to_task_header_table_ms_page($_SESSION['current_personal_gate_task_level_code'],$_SESSION['current_personal_gate_task_level_sub_code'],$_SESSION['current_personal_gate_task_order_section']);
				$result_set = mysqli_query($conn,$task_table_query);

				
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
			$tmp_field = '';
			$tmp_field_compare = '';

			$second_tmp_field_name='';
			$seconde_tmp_field_compare='';

            while($row = mysqli_fetch_array($result_set)) {


				
						if(!$ob4->su_function_date_conflict_senser($_SESSION['current_personal_gate_base_date'],$_SESSION['current_personal_gate_limit_date'],$row['sub_level_from_date'],$row['sub_level_to_date'])){
							continue;
						}

            ?>
                <tr>

					<td><?php 
						 $tmp_field_compare = $ob2->su_function_convert_name($conn,"master_task_level_info_table","master_task_level_code",$row['master_task_level_code'],"master_task_level_name");
						 if($tmp_field!=$tmp_field_compare){
								echo $tmp_field_compare;
								$tmp_field = $tmp_field_compare;
								$second_tmp_field_name='';
						 }
					
					?>
					</td>
					<td>
						<?php
							$second_tmp_field_compare = $ob2->su_function_convert_name($conn,"master_department_info_table","sid_combine_department",$row['sub_level_order_section'],"master_department_info_name"); 
							if($second_tmp_field_name!=$second_tmp_field_compare){
							echo"<a href='#' onclick='hrefClick_of_sub_task(15,999,".$row['sub_level_master_sid'].");'/>";
							echo $second_tmp_field_compare;
							 $second_tmp_field_name = $second_tmp_field_compare;
							}
						?>
					</td>				
					<td id='left'>
						<?php 
						echo"<a href='#' onclick='hrefClick_of_sub_task(".$row['master_task_level_code'].','.$row['master_task_level_sub_code'].','.$row['sub_level_master_sid'].");'/>";
						echo $ob2->su_function_convert_name($conn,"master_task_level_sub_info_table","master_task_level_sub_code",$row['master_task_level_sub_code'],"master_task_level_sub_name");
						
						
						?>
					</td>
					<td>
						<?php 
							
							echo $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['sub_level_master_sid'],"master_user_info_name");
						?>
					</td>
					<td>
						<?php echo $row['sub_level_from_date']."  ~  ".$row['sub_level_to_date']; ?>					
					</td>
					<td>
						--
					</td>

                </tr>













            <?php
            }



			//statistical summary
			echo "<div class='foot-bg'></div>";
				echo "<tr><th>";
				echo "<div class='th-text2'>";
			   if(mysqli_num_rows($result_set)==0){ echo "일치하는 항목이 없습니다.";
				}else{
					echo "합계 : ";
					echo mysqli_num_rows($result_set);
					echo "건";
				}
				echo "</div>";
				echo "</th></tr>";

            ?>
</tr>
					</table>
				</div>













			<div  id="footer" style="padding:70px 0px 0px 930px;">
				

			</div>
		
		
		
		
		
		
		
		
		
			<div id="footer" style="padding:50px 0px 0px 800px;">













			</div>
				<p style="background-color:coffee" class="bd" align="center">COPYRIGHT(C) 2017 SUNUNENG.ENG ALL RIGHTS RESERVED&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp주소 : 광주광역시 광산구 송정동 735 선운빌딩 3층 <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp연락처 : 062-651-9272 / FAX : 062-651-9271</p>
		
		
		
		
		
		
		
		
		
		
		
		
		</div>
</header>




















<div style="height:1000px">

	<nav id="cd-lateral-nav" >
		<ul class="cd-navigation" >
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