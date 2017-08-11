<!DOCTYPE html>
<html>


		

	<head>
		<title>test</title>

		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,600,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="assets/css/reset.css">
		<!-- CSS reset -->
		<link rel="stylesheet" href="assets/css/style.css">
		<!-- Resource style -->
		<script src="assets/js/modernizr.js"></script>
		<!-- Modernizr -->

		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery.min.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


		<!--<link rel="stylesheet" href="assets/css/process_table.css">-->

	<style>
			/* assets/css/process_table에 있음. */
	#main {
			width: 100%;
			border-top: 1px solid #444444;
			border-collapse: collapse;
		}
		td,th {
			border-top: 1px solid #444444;
			border-bottom: 1px solid #444444;
			border-left: 1px solid #444444;
			padding: 0px;
			text-align: center;
			vertical-align: middle;
		}
		#left {
			text-align: left;
		}
		#center {
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
			width: 100%; 
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
			padding : 66px 0px 0px 316px;

		}

		.fixed-table-container {
			width: 1900px;
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
		}
		.foot-bg {
			background: skyblue;
			height: 20px; /* header-bg height값 */
			position: absolute;
			bottom: 0;
			right: 0;
			left: 0;
		}

		.table-wrapper {
			overflow-x: hidden;
			overflow-y: auto;
			height: 100%;
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
		td:first-child .th-text2 {
			border-left: 1px;
		}

		.just_fit{
			width:99%;
			border: 0;
			resize: none;
		}

	</style>

</head>










	<!-- P H P ! P H P ! -->

					<?php
						session_start();
						include('./classes/su_class_common_header.php');


					// class 객체 생성

							$ob1 = new su_class_task_table_config();
							$ob2 = new su_class_value_name_convert_with_code();
							$ob3 = new su_class_value_combine_combobox_value_to_mysql_query();
							$ob4 = new su_class_folder_table_manager();
							$UI_form_ob = new su_class_UI_format_generator();
							$time_calc_ob =  new su_class_calc_the_date();


					// 전역 세션 변수 선언
					


						if(!isset($_SESSION['time_unit'])){
							// 어떤 시간 단위로 업무를 검색할지? 정하는 전역변수
							// 0 => 일  / 1 => 주 / 2 => 월 / 3=> 년
							$_SESSION['time_unit'] = 0;
							// 디폴트는 일 단위임.
						}

						if(!isset($_SESSION['time_vector'])){
							// 검색할 시간의 방향, 저번 이번 다음
							// 0 => 저번  / 1 => 이번 / 2 => 다음
							$_SESSION['time_vector'] = 1;
							// 디폴트는 이번 단위임.
						}

						if(!isset($_SESSION['process_table_from'])){
							
							$_SESSION['process_table_from'] = $_SESSION['now_date'];
							$_SESSION['process_table_to'] = $_SESSION['now_date'];
							// 디폴트는 오늘임.
						}

						if(!isset($_SESSION['process_table_task_level'])){
							// 검색할 업무 등급
							$_SESSION['process_table_task_level'] = 15;
							// 디폴트는 전체임.
						}

						if(!isset($_SESSION['process_table_task_department'])){
							// 검색할 업무 부서							
							$_SESSION['process_table_task_department'] = 15;
							// 디폴트는 전체임.
						}

						if(!isset($_SESSION['process_table_task_orderer'])){
							// 검색할 업무 담당자							
							$_SESSION['process_table_task_orderer'] = 8388607;
							// 디폴트는 전체임.
						}

					// 지역 변수 선언

						$time_unit_array = array('day','week','month','year');
						$time_vector_array = array('last','this','next');




					// 셀렉트 박스를 위시한 여러 컴포넌트를 통해서, 디비로부터 긁어올 값을 구성할 때, 간단히 where_code를 변경시키는 방식으로

						$dtable_name = 'master_task_level_sub_info_table';
						$dtable_key = 'master_task_level_sub_code';
						$where_cond = "WHERE ";




					// PHP는 최초에 하이퍼 텍스트를 만듦, 해당 파트에서는 그러한 하이퍼 텍스트 생성 과정에 관여해서
					// 위에서 초기화되었거나 ajax를 통해 변한 세션 값들을 기준으로 쿼리문을 재구성할 것임.



						if(!isset($_SESSION['dquery'])){
							//DB 쿼리문
							$_SESSION['dquery'] = "SELECT * FROM $dtable_name "; 
						}else{

							if($_SESSION['time_unit']){
											$query_element = 
							}


						}	







					// 디버그 모드, 아래 주석을 풀거나 여튼 아래 세션 활성화 시키면 화면에 현재 세션 값들이 드러남.

						 $SESSION['__debug_flag'] = 514;
						if(isset($SESSION['__debug_flag'])){

										echo "<div style='padding: 0px 0px 0px 200px;'>";
										echo " **** **** D E B U G **** ****"."<br/>";
										echo " 0 -> 시단위				변수명 :  \$_SESSION['time_unit'] 현재 값 : ".$_SESSION['time_unit']."<br/>";
										echo " 1 -> 시벡터				변수명 : \$_SESSION['time_vector'] 현재 값 : ".$_SESSION['time_vector']."<br/>";
										echo " 2~3 -> from to date    변수명 : \$_SESSION['process_table_from'],\$_SESSION['process_table_to'] 현재 값 : ".$_SESSION['process_table_from']." ~ ".$_SESSION['process_table_to']."<br/>";
										echo " 4 -> 업무 등급			변수명 : \$_SESSION['process_table_task_level'] 현재 값 : ".$_SESSION['process_table_task_level']."<br/>";
										echo " 5 -> 업무 부서			변수명 : \$_SESSION['process_table_task_department'] 현재 값 : ".$_SESSION['process_table_task_department']."<br/>";
										echo " 6 -> 담당자				변수명 : \$_SESSION['process_table_task_orderer'] 현재 값 : ".$_SESSION['process_table_task_orderer']."<br/>";
										echo "</div>";

							unset($SESSION['__debug_flag']);
						}





					// 전용 함수

					//지정한 배열의 특정 필드가 null인지 평가해주는 논리함수
					function null_checker($array_name,$field_name){
							if(isset($array_name[$field_name])){
									return true;
							}
							return false;
					}

					//null체크에 이어서 추가 작업으로 빈 테이블을 원하는 문자로 채우는 문자함수
					function fill_null_space($array_name,$field_name,$delimiter){
							if(null_checker($array_name,$field_name)){
									return $array_name[$field_name];
							}
							return $delimiter;
					}

					//어떤 테이블의 어떤 필드의 총합을 리턴하는 정수함수
					function sum_attribute_which_against_a_unit_of_field_be_parameterized($conn,$table_name,$field_name,$where_cond=''){
							$tquery = "SELECT sum($field_name) as result FROM $table_name".$where_cond;
							$tresult = mysqli_query($conn,$tquery);
							$trow = mysqli_fetch_array($tresult);
							return $trow;
					}

					//토글 flag가 set이면 그래프를 그리는데, 그리는 기준은 일단 진행률임 플래그가 세워졌다면 그래프 그리는 hypertext 리턴함.
					//
					// function render_graph($flag,$percentage){
					// 		if(!$flag) return false;
								
					// 			$result = "<td><div class='graph'>".
					// 					"<strong class='bar2' style='width: ".$percentage."%;'>".$percentage."%</strong>".				
					// 					"</div></td>";

					// 		echo $result;
					// 		return true;		
					// }


						//특정 테이블의 주키 이름을 찾는 문자함수
						function get_primary_key_name($conn,$master_table){
									$table_name = $master_table;
									$query = "SHOW KEYS FROM ".$table_name." WHERE Key_name = 'PRIMARY'";
									$result = mysqli_query($conn,$query);
									$row = mysqli_fetch_array($result);

									return $row['Column_name'];
						}


						//코드가 너무 지저분해져서 따로 뺀 함수.
						function code_converter($conn,$master_table,$index,$field_name){
									$table_name = $master_table;
									$table_key = get_primary_key_name($conn,$table_name);
									$where_cond = "WHERE ".$table_key." = ".$index;
									$query = "SELECT * FROM ".$table_name.$where_cond;
									$result = mysqli_query($conn,$query);
									$row = mysqli_fetch_array($result);
									
									return $row[$field_name];
						}


						//특정한 마스터 테이블의 값들을 가지고 value는 키값 name은 마스터 코드 이름을 가지는 셀렉트 박스를 만드는 함수
						//where파라미터에는 where조건을 쓰면 된다.
						function generate_sel_box($conn,$master_table,$field,$where=''){
									$table_name = $master_table;
									$table_key = get_primary_key_name($conn,$table_name);
									$where_cond = $where;
									$query = "SELECT * FROM ".$table_name.' '.$where_cond;
									echo $query;
									echo $table_key;
									$result = mysqli_query($conn,$query);

									$hypertext = '';
										while( $row=mysqli_fetch_array($result) ){         
											$hypertext = $hypertext."<option value='".$row[$table_key]."'>".$row[$field]."</option>";
										
										}

									return $hypertext;
						}

					?>



	<!-- J A V A S ~ T -->

					<!-- <script>  id기준으로 칼럼추가하는 자바스크립트, 이름은 im_tr_n 꼴이다.
							function add_col(){
									$.post('./ajax_code_generator/ajax_add_col.php',
										function(Data){
												//str = "<input type=text name=recv style='width:99%; border: 0; resize: none;' value="+Data+">";
												$('#im_tr_0').append('<th>그래프</th>');
												//var test = document.getElementsByName("im_tr");

												// console.dir(test[1].id);
												// console.dir($("#"+test[1].id));
									});
							}
					</script> -->

					<script>  
							function func_session_of_graph(name,data){
										if (window.sessionStorage) {
														sessionStorage.setItem(name, data);
														//var position = sessionStorage.getItem('저장된 이름');
										 }
							}

							function add_col(){
									var flag = sessionStorage.getItem('graph_toggle'); 
									if(!flag || flag=='false'){
																		$.ajax({
																			url:'./ajax_code_generator/ajax_open_graph.php',
																			dataType:'json',
																			success:function(data){
																							$('#im_tr_head').append("<th colspan='6' id='im_grp_head'><div class='th-text'>그래프</div></th>");
																								var cnt = 0;
																								for(var index in data){
																									var target_field = "#im_tr_"+index;
																									var percentage = (data[index] == null) ? 0 : data[index];
																									var add_hypertext = "'<td colspan=6 id=im_grp_"+index+"><div class='graph'><strong class='bar2' style='width: "+percentage+"%;'>"+percentage+"%</strong></div></td>'";
																									$(target_field).append(add_hypertext);
																									cnt++;
																							}
																						
																							$('#table_off').append("<td colspan='6' id='im_grp_tail'><div class='th-text2'></div></td>");
																							func_session_of_graph('graph_toggle',true);
																							func_session_of_graph('graph_numbers',cnt);
																			}
																		})
									}else{
																		func_session_of_graph('graph_toggle',false);
																		var cnt = sessionStorage.getItem('graph_numbers'); 

																		for(var i=0;i<cnt;i++){
																			var target_field = "#im_grp_"+i;
																			$(target_field).detach();
																		}
																		$('#im_grp_head').detach();
																		$('#im_grp_tail').detach();
									}
							}
			



							//필드마다 ajax 만들면 관리가 어려우니 이 함수 하나로 퉁친다.
							//각 셀렉트 박스의 아이디와 value 값을 가지고 와서, ajax를 통해 세션을 수정하고
							//화면을 리프레쉬 하는 것으로, 변경된 세션 값에 의해서 화면이 갱신될 것이다.
							function select_box_event_listener(value,selectbox_number){
																		$.post('./ajax_code_generator/ajax_select_box_event_handler.php?val='+value+"&type="+selectbox_number,
																		function(Data){
																			//refresh logic here
																			window.location.href=window.location.href;
																		});
							}





					</script> 


					<script>               /*달력 함수*/
						$(function() {
								$("#datepicker1, #datepicker2").datepicker({
								dateFormat: 'yy-mm-dd'
								});
							});

					</script>



		<!-- 여기 까지는 로직용 스크립트 코드 -->


		<!-- 아래는 UI를 다루는 스크립트 코드 + 하이퍼텍스트 -->

<body>

	
	<header>
	<a id="cd-menu-trigger" href="#0"><span class="cd-menu-text">메뉴&nbsp &nbsp &nbsp &nbsp</span></a>

	<div id="wrapper" style="width:100%">

			

		<!--전체 컨테이너-->
		<div id = 'fly' style="width:1900px" style="float:right;" >
				
		

				<!-- 슬라이드 메뉴 외 컨테이너 -->				
				<div>

					<!-- 타이틀용 -->
					<div style="padding:0px 0px 20px 0px;">
						<?php
							$UI_form_ob->su_function_get_title('과업 관리', $_SESSION['my_name'], $_SESSION['my_position'], $_SESSION['my_department'], 'su_script_user_personal_interface');
						?>
					</div>
					

					<!-- 타이틀 ~ 테이블 사이 -->


					<!-- 조회 버튼-->
					<div style="padding: 0px 0px 20px 0px; border: 1px solid #000;">
							<center><< 조 회 버 튼 >></center>
							<br />
							<table width=100% border=1>

								<tr>
									<th>
										<select onchange='select_box_event_listener(this.value,0)'><!-- 리스너 0 번 : 시단위 -->
												<?php
													$tag = $time_unit_array[$_SESSION['time_unit']];
													$len = count($time_unit_array);
													for($cnt=0;$cnt<$len;$cnt++){
														if($time_unit_array[$cnt]==$tag){
															echo "<option value='$cnt' selected>".$time_unit_array[$cnt]." 단위</input>";
														}else{
															echo "<option value='$cnt'>".$time_unit_array[$cnt]." 단위</input>";
														}
													}
												?>
										</select>
									</th>
									<th><!-- 리스너 1 번 : 시간 벡터 -->
										<?php
													$tag2 = $time_vector_array[$_SESSION['time_vector']];
													$len2 = count($time_vector_array);
													for($cnt2=0;$cnt2<$len2;$cnt2++){
														if($time_vector_array[$cnt2]==$tag2){
															echo "<input type='radio' onclick='select_box_event_listener($cnt2,1)' checked>".$time_vector_array[$cnt2].$tag."  </input>";
														}else{
															echo "<input type='radio' onclick='select_box_event_listener($cnt2,1)' >".$time_vector_array[$cnt2].$tag."  </input>";
														}
													}

										?>
									</th>
								</tr>

								<tr><!-- 리스너 2~3 번 : 검색 기간 from to -->
									<th>
										From
									</th>
									<th>
										<input type="text" id="datepicker1" class='just_fit' onchange="javascript:select_box_event_listener(this.value,2);" value = <?php echo $_SESSION['process_table_from']; ?>>
									</th>

									<th>
										To
									</th>
									<th>
										<input type="text" id="datepicker2" class='just_fit' onchange="javascript:select_box_event_listener(this.value,3);" value = <?php echo $_SESSION['process_table_to']; ?>>
									</th>

									<th>등 급</th><!-- 리스너 4 번 : 업무 등급 .. 대외비,대외주관,연구 등등 -->
									<th>
										<select class='just_fit' onchange='select_box_event_listener(this.value,4)'>	
       											 <?php echo generate_sel_box($conn,'master_task_level_info_table','master_task_level_name',$where='') ?>        
   										</select>
									</th>
									<th>부 서</th><!-- 리스너 5 번 : 담당부서  -->
									<th>
										<select class='just_fit' onchange='select_box_event_listener(this.value,5)'>	
       											 <?php echo generate_sel_box($conn,'master_department_info_table','master_department_info_name',$where='') ?>              
   										</select>
									</th>
									<th>담당자</th><!-- 리스너 6 번 : 담당자 -->
									<th>
										<select class='just_fit' onchange='select_box_event_listener(this.value,6)'>	
       											 <?php echo generate_sel_box($conn,'master_user_info_table','master_user_info_name',$where='') ?>              
   										</select>
									</th>										
								</tr>
							</table>

		 			</div>
					<!-- 조회 버튼 끝 -->

					<!-- 헤더 정보 -->
					<div style="padding: 0px 0px 20px 0px; border: 1px solid #000;">
							<center><< 사 업 공 정 표 >></center>
							<br />
							<br />
							<br />
							<table width=100% border=1>
								<tr>
									<th>*</th>
									<th>*</th>
									<th>*</th>
									<th>*</th>
								</tr>
							</table>
		 			</div>

					 <!-- 메인 테이블 시작 및 필드 틀고정 -->
					<div class="fixed-table-container" >
						<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
							<table id = 'main'>
								<thead>
									<div class="header-bg" >
									<tr id='im_tr_head' >
										<th width="2%" text-align="center"> <!-- set 1 -->
											<div class="th-text">NO</div>
										</th>
										<th width="8%" text-align="center">  <!-- set 2 -->
											<div class="th-text">등급</div>
										</th>
										<th width="4%" text-align="center"> 
											<div class="th-text">업무번호</div>
										</th>
										<th width="12%" text-align="center">  <!-- set 3 -->
											<div class="th-text">사업명</div>
										</th>
										<th width="4%" text-align="center">
											<div class="th-text">발주</div>
										</th>
										<th width="4%" text-align="center">
											<div class="th-text">감독</div>
										</th>
										<th width="7%" text-align="center">
											<div class="th-text">From</div>
										</th>
										<th width="7%" text-align="center"> 
											<div class="th-text">To</div>
										</th>
										<th width="6%" text-align="center"> <!-- set 4 -->
											<div class="th-text">계약금</div>
										</th>
										<th width="6%" text-align="center"> <!-- set 5 -->
											<div class="th-text">기성</div>
										</th>
										<th width="6%" text-align="center"> <!-- set 6-->
											<div class="th-text">잔액</div>
										</th>
										<th width="3%" text-align="center">  <!-- set R E M A I N  -->
											<div class="th-text">비고</div>
										</th>
										<th width="5%" text-align="center">
											<div class="th-text">상태</div>
										</th>
										<th width="5%" text-align="center">
											<div class="th-text">진척도</div>								
									</tr>
									
								</thead>

								<!-- 여기부터 php -->


									<?php
									
										//query here
										$dresult = mysqli_query($conn,$_SESSION['dquery']);
										$cnt = 0;
										while($row=mysqli_fetch_array($dresult)){

											echo "<tr id='im_tr_$cnt'>";
												echo "<td>".++$cnt."</td>";
												echo "<td>".$ob2->su_function_convert_name($conn, "master_task_level_info_table", "master_task_level_code", $row['master_task_level_code'], "master_task_level_name")."</td>";
												echo "<td>"."선운-".$row['master_customer']."-".$row['master_task_level_sub_code']."</td>";
												echo "<td>".$row['master_task_level_sub_name']."</td>";
												echo "<td>".$ob2->su_function_convert_name($conn, "master_customer_table", "master_code", $row['master_customer'], "master_name")."</td>";
												echo "<td>".$ob2->su_function_convert_name($conn, "master_superviser_table", "master_code", $row['master_superviser'], "master_name")."</td>";
												echo "<td>".$row['sub_level_from_date']."</td>";
												echo "<td>".$row['sub_level_to_date']."</td>";
											// 여기까지는 필수 입력 값이라서, null 체크 안함.
												/* 이하 null 체크 시작 */
											// 아래 3 필드는 돈관련 필드 3개
												
												echo "<td>".fill_null_space($row,'all_money_master_code_field','--')."</td>";
												echo "<td>".fill_null_space($row,'use_money_master_code_field','--')."</td>";
												echo "<td>".fill_null_space($row,'remaind_money_master_code_field','--')."</td>";

											// 비고... 버튼으로 활용 할지

												echo "<td><font color='green' />●</td>";
												echo "<td>".$ob2->su_function_convert_name($conn, "dmaster_state_info_table", "master_code", $row['task_detail_state'], "master_state_detail_name")."</td>";
												echo "<td>".fill_null_space($row,'complete_rate','0%')."</td>";



											echo "</tr>";




										}

									//마지막 라인에는 통계값을 넣는다.
											echo "<div class='foot-bg'>";
												echo "<tr id='table_off'>";
													echo "<td width='2%'><div class='th-text2'>합계</div></td>";
													echo "<td width='12%' id='left' colspan=2><div class='th-text2'>&nbsp &nbsp $cnt 건</div></td>";
													echo "<td width='34%' text-align='left' colspan=5><div class='th-text2'>*</div></td>";

													//각 필드의 금액 합하는 부분
													echo "<td width='6%'><div class='th-text2'>".fill_null_space(sum_attribute_which_against_a_unit_of_field_be_parameterized($conn,$dtable_name,'all_money_master_code_field'),'result',0)."</div></td>";
													echo "<td width='6%'><div class='th-text2'>".fill_null_space(sum_attribute_which_against_a_unit_of_field_be_parameterized($conn,$dtable_name,'use_money_master_code_field'),'result',0)."</div></td>";
													echo "<td width='6%'><div class='th-text2'>".fill_null_space(sum_attribute_which_against_a_unit_of_field_be_parameterized($conn,$dtable_name,'remaind_money_master_code_field'),'result',0)."</div></td>";
													echo "<td width='13%' colspan=3><div class='th-text2'>*</div></td>";
												echo "</tr></div>";
									?>


							</table>
						</div>
						<!-- 틀고정 몸통 -->	
					</div>
					<!-- 메인 테이블 끝 -->					
					<!-- 버튼용 -->
					
					<div>
						<input type=button onclick='javascript:add_col();' value=hiraku></input>
					</div>
				</div>	     

		</div>
		<!-- fly -->
				
				

	</div>
	<!-- wrapper -->
			

	</header>


					<!-- 슬라이드 메뉴 모듈 -->
				<?php include('./classes/su_class_common_rear.php');?>				

		<!-- 새로운 달력 자바 스크립트 소스-->
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>                     
      	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>     



</html>