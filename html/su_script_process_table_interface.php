<!DOCTYPE html>
<html>


		

	<head>
		<title>test</title>

		<meta charset="utf-8" />
		<!-- <meta name="viewport" content="width=device-width, initial-scale=1" /> -->
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
		#right {
			text-align: right;
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
			padding : 66px 0px 0px 66px;

		}

		.fixed-table-container {
			width: 1834px;
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
						include('./su_script_process_table_func.php');
						$_SESSION['now_page_coord'] = 2; // 슬라이드 메뉴의 현재 위치 표시에 필요한 전역 변수 값을 변경하는 부분.

					// class 객체 생성

							$ob1 = new su_class_task_table_config();
							$ob2 = new su_class_value_name_convert_with_code();
							$ob3 = new su_class_value_combine_combobox_value_to_mysql_query();
							$UI_form_ob = new su_class_UI_format_generator();
							$time_calc_ob =  new su_class_calc_the_date();


					// 전역 세션 변수 선언



						if(!isset($_SESSION['currency_unit'])){
							// 어떤 금액 단위로 업무를 검색할지? 정하는 전역변수
							// 0 => 천원  / 1 => 만원 / 2 => 백만원
							$_SESSION['currency_unit'] = 0;
							// 디폴트는 천원 단위임.
						}


						if(!isset($_SESSION['time_unit'])){
							// 어떤 시간 단위로 업무를 검색할지? 정하는 전역변수
							// 0 => 일  / 1 => 주 / 2 => 월 / 3=> 년
							$_SESSION['time_unit'] = 0;
							// 디폴트는 일 단위임.
						}

						if(!isset($_SESSION['time_vector'])){
							// 검색할 시간의 방향, 저번 이번 다음
							// 0 => 저번  / 1 => 이번 / 2 => 다음
							$_SESSION['time_vector'] = 0;
							// 디폴트는 이번 단위임.
							// 공정표를 보는 사람은 주로 아침에 작일 등록되었던 공정표 현황을 원하므로, 디폴트는 어제 로 되어있음.
						}

						if(!isset($_SESSION['process_table_from'])){
							
							$_SESSION['process_table_from'] = $_SESSION['now_date'];
							$_SESSION['process_table_to'] = $_SESSION['now_date'];
							// 디폴트는 오늘임.
						}

						if(!isset($_SESSION['toggle_datepicker'])){
							
							$_SESSION['toggle_datepicker'] = 0;
							// radio box 등으로 항상 날짜가 정해져버리기 때문에, datepicker를 이용하여 원하는 기준을 입력하고 싶은 경우
							// radio box가 자동으로 발동해서 값이 입력되지 않는다. 따라서 flag를 두어 자유겁색/radio 검색을 두고
							// datapicker를 통해 값을 변경하는 경우에 flag를 1으로 돌려 자유 검색을 하도록 하고
							// 라디오 버튼이 움직인 경우에는 flag를 0으로 돌려서 radio box 체크 검색을 하도록 로직을 유도한다.
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

						if(!isset($_SESSION['process_table_task_state'])){
							// 검색할 업무 상태							
							$_SESSION['process_table_task_state'] = 99;
							// 디폴트는 전체임.
						}

					// 지역 변수 선언

						$time_unit_array = array('일일','주간','월간','연간');
						$time_vector_array = array(array('어제','오늘','내일'), array('지난주','이번주','다음주'), array('지난달','이번달','다음달'), array('작년','올해','내년'));

						$currency_unit_array = array('원금','천원','만원','백만원');	



					// 셀렉트 박스를 위시한 여러 컴포넌트를 통해서, 디비로부터 긁어올 값을 구성할 때, 간단히 where_code를 변경시키는 방식으로

						$dtable_name = 'master_task_level_sub_info_table';
						$dtable_key = 'master_task_level_sub_code';
						$where_cond = " WHERE ";




					// PHP는 최초에 하이퍼 텍스트를 만듦, 해당 파트에서는 그러한 하이퍼 텍스트 생성 과정에 관여해서
					// 위에서 초기화되었거나 ajax를 통해 변한 세션 값들을 기준으로 쿼리문을 재구성할 것임.



						
							//DB 쿼리문
							$_SESSION['dquery'] = "SELECT * FROM $dtable_name "; 
						
							//시구간 시벡터의 경우에는 결국 from to date를 수정하는 함수를 사용함.$_COOKIE
							//해당 함수들은 $time_calc_ob 객체 내부의 메서드를 활용했음.


							//자유검색/radio box check 검색 플래그가 clear 된 경우는 radio 검색함.
							if($_SESSION['toggle_datepicker']==0){

								//offset은 오늘 기준으로 얼마만큼 시간을 이동시킬 것인지 정하는 변수임.
								$offset = 1;
								switch($_SESSION['time_unit']+$_SESSION['time_vector']*10){

										//일단위변환																	
										case 0: // 어제
											$_SESSION['process_table_from'] = $_SESSION['process_table_to'] = $time_calc_ob->su_function_calc_add_offset($_SESSION['now_date'],-86400);
										break;
										case 10: // 오늘
											$_SESSION['process_table_from'] = $_SESSION['process_table_to'] = $time_calc_ob->su_function_calc_add_offset($_SESSION['now_date'],0);
										break;
										case 20: // 내일
											$_SESSION['process_table_from'] = $_SESSION['process_table_to'] = $time_calc_ob->su_function_calc_add_offset($_SESSION['now_date'],86400);
										break;

										
										//주단위변환																	
										case 1: // 지난주 : 이번주 시작 구하고 거기에서 7일 빼면 된다.
											$this_week_begin = $time_calc_ob->su_function_convert_this_week_begin($_SESSION['now_date']);
											$_SESSION['process_table_from'] = $time_calc_ob->su_function_calc_add_offset($this_week_begin,-7*86400);
											$_SESSION['process_table_to'] = $time_calc_ob->su_function_calc_add_offset($_SESSION['process_table_from'],7*86400);
										break;
										case 11: // 이번주
											$this_week_begin = $time_calc_ob->su_function_convert_this_week_begin($_SESSION['now_date']);
											$_SESSION['process_table_from'] = $this_week_begin;
											$_SESSION['process_table_to'] = $time_calc_ob->su_function_calc_add_offset($_SESSION['process_table_from'],7*86400);
										break;
										case 21: // 다음주
											$this_week_begin = $time_calc_ob->su_function_convert_this_week_begin($_SESSION['now_date']);
											$_SESSION['process_table_from'] = $time_calc_ob->su_function_calc_add_offset($this_week_begin,7*86400);
											$_SESSION['process_table_to'] = $time_calc_ob->su_function_calc_add_offset($_SESSION['process_table_from'],7*86400);
										break;

										
										//월단위변환
										case 2: // 지난달 : 이번달 시작 구하고 거기에서 한달 빼면 된다.
											$_SESSION['process_table_from'] = $time_calc_ob->su_function_convert_this_month_begin_with_offset($_SESSION['now_date'],-1);
											$_SESSION['process_table_to'] = $time_calc_ob->su_function_convert_this_month_end_with_offset($_SESSION['now_date'],-1);
										break;
										case 12: // 이번달
											$_SESSION['process_table_from'] = $time_calc_ob->su_function_convert_this_month_begin($_SESSION['now_date']);
											$_SESSION['process_table_to'] = $time_calc_ob->su_function_convert_this_month_end($_SESSION['now_date']);
										break;
										case 22: // 다음달
											$_SESSION['process_table_from'] = $time_calc_ob->su_function_convert_this_month_begin_with_offset($_SESSION['now_date'],1);
											$_SESSION['process_table_to'] = $time_calc_ob->su_function_convert_this_month_end_with_offset($_SESSION['now_date'],1);
										break;								

										
										//년단위변환 윤달의 존재..
										case 3: // 작년 : 이번달 시작 구하고 거기에서 한달 빼면 된다.
											$this_year_begin = $time_calc_ob->su_function_convert_this_year_begin($_SESSION['now_date']);
											$_SESSION['process_table_from'] = $time_calc_ob->su_function_calc_add_offset($this_year_begin,-365*86400);
											$_SESSION['process_table_to'] = $time_calc_ob->su_function_calc_add_offset($_SESSION['process_table_from'],365*86400);
										break;
										case 13: // 금년
											$this_year_begin = $time_calc_ob->su_function_convert_this_year_begin($_SESSION['now_date']);
											$_SESSION['process_table_from'] = $this_year_begin;
											$_SESSION['process_table_to'] = $time_calc_ob->su_function_calc_add_offset($_SESSION['process_table_from'],365*86400);
										break;
										case 23: // 내년
											$this_year_begin = $time_calc_ob->su_function_convert_this_year_begin($_SESSION['now_date']);
											$_SESSION['process_table_from'] = $time_calc_ob->su_function_calc_add_offset($this_year_begin,365*86400);
											$_SESSION['process_table_to'] = $time_calc_ob->su_function_calc_add_offset($_SESSION['process_table_from'],365*86400);
										break;	
										
								}
							}	

							// 시간관련 쿼리 종료

							// 등급 부서 담당자 상태 쿼리문 생성

							$query_element_of_level = ($_SESSION['process_table_task_level']==15) ? '' :  'master_task_level_code = '.$_SESSION['process_table_task_level']." AND ";
							$query_element_of_department = ($_SESSION['process_table_task_department']==15) ? '' :  'sub_level_order_section = '.$_SESSION['process_table_task_department']." AND ";							
							$query_element_of_orderer = ($_SESSION['process_table_task_orderer']==8388607) ? '' : 'sub_level_orderer = '.$_SESSION['process_table_task_orderer']." AND ";
							$query_element_of_state = ($_SESSION['process_table_task_state']==99) ? '' : 'task_detail_state = '.$_SESSION['process_table_task_state']." AND ";							
							$query_tail = ' 16>3; ';

							$where_cond = $where_cond.$query_element_of_level.$query_element_of_department.$query_element_of_orderer.$query_element_of_state.$query_tail;

							$_SESSION['dquery'] = $_SESSION['dquery'].$where_cond; 
							

							




					// 디버그 모드, 아래 주석을 풀거나 여튼 아래 세션 활성화 시키면 화면에 현재 세션 값들이 드러남.

						//  $SESSION['__debug_flag'] = 514;
						if(isset($SESSION['__debug_flag'])){

										echo "<div style='padding: 0px 0px 0px 200px;'>";
										echo " **** **** D E B U G **** ****"."<br/>";
										echo " 0 -> 시단위				변수명 :  \$_SESSION['time_unit'] 현재 값 : ".$_SESSION['time_unit']."<br/>";
										echo " 1 -> 시벡터				변수명 : \$_SESSION['time_vector'] 현재 값 : ".$_SESSION['time_vector']."<br/>";
										echo " 2~3 -> from to date    변수명 : \$_SESSION['process_table_from'],\$_SESSION['process_table_to'] 현재 값 : ".$_SESSION['process_table_from']." ~ ".$_SESSION['process_table_to']."<br/>";
										echo " 4 -> 업무 등급			변수명 : \$_SESSION['process_table_task_level'] 현재 값 : ".$_SESSION['process_table_task_level']."<br/>";
										echo " 5 -> 업무 부서			변수명 : \$_SESSION['process_table_task_department'] 현재 값 : ".$_SESSION['process_table_task_department']."<br/>";
										echo " 6 -> 담당자				변수명 : \$_SESSION['process_table_task_orderer'] 현재 값 : ".$_SESSION['process_table_task_orderer']."<br/>";
										echo " 7 -> 금액 단위			변수명 : \$_SESSION['currency_unit'] 현재 값 : ".$_SESSION['currency_unit']."<br/>";
										echo " 8 -> 업무 상태			변수명 : \$_SESSION['process_table_task_state'] 현재 값 : ".$_SESSION['process_table_task_state']."<br/>";
										echo "적용된 쿼리문 : ".$_SESSION['dquery'];
										echo "</div>";

							unset($SESSION['__debug_flag']);
						}


					?>



	<!-- J A V A S ~ T -->



					<script>  
							function func_session_of_graph(name,data){
										if (window.sessionStorage) {
														sessionStorage.setItem(name, data);
														//var position = sessionStorage.getItem('저장된 이름');
										 }
							}

							function add_col(){
									var flag = sessionStorage.getItem('graph_toggle'); 
									// if(!flag || flag=='false'){
										if(true){
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
																				window.location.href='./su_script_process_table_interface.php';
																		});
							}


							//지정한 사업 혹은 업무의 하위 업무를 해당 tr에 append하는 함수
							function sub_task_open(type,key,id){

								// 0인 경우, 헤더(사업) -> 업무현황 으로 들어가는 경우
								// 1인 경우, 업무현황 -> 해당 업무에 등록된 하위 업무로 들어가는 경우
								// key는 당연히 해당 엔터티의 키값으로 보통은 sub_level_code나 TID가 들어갈 것이다.
								// id는 하위 업무의 하이퍼텍스트가 추가될 영역이다.
								
									var target_field = "#sub_code_"+type+"_"+key;
									// 동적 생성될 아이디 만드는 공식=> sub_code_에 타입 0 또는 1을 더하구 고유값인 key를 더한다.
									// 타입이 0이면 사업에서 사업에 속한 업무 고르는 것
									// 타입이 1이면 업무현황에서 하위 업무를 고르는 것을 의미.


									//flag는 유저 세션에 존재하는 지정한 id에 저장된 값을 가지는 변수이다.
									//해당 값이 1이라면, 지정한 id는 웹페이지에 열려있다는 것을 알 수 있다.
									var flag = sessionStorage.getItem(target_field); 
												if(!flag || flag==0){

																$.post('./ajax_code_generator/ajax_is_have_sub_task.php?val='+key+"&type="+type+"&subid="+id,
																	function(Data){
																		func_session_of_graph(target_field,1); // 유저사이드 세션에 '해당 id의 하위업무가 열려있음'을 알린다.
																		$(id).after(Data);
																});
												}else{
													// func_session_of_graph(target_field,0); // 하위 업무를 웹에서 삭제하고, 플래그를 0으로 초기화한다.
																		
													// 			var ids = document.querySelectorAll(target_field); // Get a collection of cells with same ids
        											// 			var len = ids.length;
													// 			while(len>0){
													// 				$(target_field).remove();
													// 				len--;
													// 			}

													check_sub_task_open(type,key);

												}
							}

		

							function check_sub_task_open(type,key){
												
																		$.ajax({
																			url:'./ajax_code_generator/ajax_get_list_of_sub_task.php?key='+key+'&type='+type,
																			dataType:'json',
																			success:function(data){

																				for(var index in data){
																						target_field = data[index];	
				
																						func_session_of_graph(target_field,0); // 하위 업무를 웹에서 삭제하고, 플래그를 0으로 초기화한다.
																											
																						var ids = document.querySelectorAll(target_field); // Get a collection of cells with same ids
																						var len = ids.length;
																						while(len>0){
																							$(target_field).remove();
																							len--;
																						}												
																			
																				}			
																				
																			}
																		})

							}




					</script> 





					<script>               /*달력 함수*/
						$(function() {
								$("#datepicker1, #datepicker2").datepicker({
								dateFormat: 'yy-mm-dd'
								});
							});

						$(add_col());

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
							$UI_form_ob->su_function_get_title('공정표 조회', $_SESSION['my_name'], $_SESSION['my_position'], $_SESSION['my_department'], 'su_script_user_personal_interface');
						?>
					</div>
					

					<!-- 타이틀 ~ 테이블 사이 -->


					<!-- 조회 버튼-->
					<div style="padding: 0px 0px 20px 0px; border: 1px solid #000;">
							<center><< 검 색 옵 션 >></center>
							<br />
							<table width=100% border=1>

								<tr>

									<th><!-- 리스너 0 번 : 시단위 -->
										<select onchange='select_box_event_listener(this.value,0)'>
												<?php
													$tag = $time_unit_array[$_SESSION['time_unit']];
													$len = count($time_unit_array);
													for($cnt=0;$cnt<$len;$cnt++){
														if($time_unit_array[$cnt]==$tag){
															echo "<option value='$cnt' selected>".$time_unit_array[$cnt]." </input>";
														}else{
															echo "<option value='$cnt'>".$time_unit_array[$cnt]." </input>";
														}
													}
												?>
										</select>
									</th>

									<th><!-- 리스너 1 번 : 시간 벡터 -->
										<?php
													$tag2 = $time_vector_array[$_SESSION['time_unit']][$_SESSION['time_vector']];
													$len2 = count($time_vector_array[0]);
													for($cnt2=0;$cnt2<$len2;$cnt2++){
														if($time_vector_array[$_SESSION['time_unit']][$cnt2]==$tag2){
															echo "<input type='radio' onclick='select_box_event_listener($cnt2,1)' checked>".$time_vector_array[$_SESSION['time_unit']][$cnt2]."  </input>";
														}else{
															echo "<input type='radio' onclick='select_box_event_listener($cnt2,1)' >".$time_vector_array[$_SESSION['time_unit']][$cnt2]."  </input>";
														}
													}

										?>
									</th>
									<th>
										금액 단위
									</th>
									<th><!-- 리스너 7 번 : 금액 단위 -->
										<?php
													$tag3 = $currency_unit_array[$_SESSION['currency_unit']];
													$len3 = count($currency_unit_array);
													for($cnt3=0;$cnt3<$len3;$cnt3++){
														if($currency_unit_array[$cnt3]==$tag3){
															echo "<input type='radio' onclick='select_box_event_listener($cnt3,7)' checked>".$currency_unit_array[$cnt3]."  </input>";
														}else{
															echo "<input type='radio' onclick='select_box_event_listener($cnt3,7)'>".$currency_unit_array[$cnt3]."  </input>";
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
       											 <?php echo generate_sel_box($conn,'master_task_level_info_table','master_task_level_name',$_SESSION['process_table_task_level']) ?>        
   										</select>
									</th>
									<th>부 서</th><!-- 리스너 5 번 : 담당부서  -->
									<th>
										<select class='just_fit' onchange='select_box_event_listener(this.value,5)'>	
       											 <?php echo generate_sel_box($conn,'master_department_info_table','master_department_info_name',$_SESSION['process_table_task_department']) ?>              
   										</select>
									</th>
									<th>담당자</th><!-- 리스너 6 번 : 담당자 -->
									<th>
										<select class='just_fit' onchange='select_box_event_listener(this.value,6)'>	
       											 <?php echo generate_sel_box($conn,'master_user_info_table','master_user_info_name',$_SESSION['process_table_task_orderer']) ?>              
   										</select>
									</th>
									<th>상 태</th><!-- 리스너 8 번 : 상태 -->
									<th>
										<select class='just_fit' onchange='select_box_event_listener(this.value,8)'>	
       											 <?php echo generate_sel_box($conn,'dmaster_state_info_table','master_state_detail_name',$_SESSION['process_table_task_state'],' WHERE master_code%10=0 OR master_code=99') ?>              
   										</select>
									</th>											
								</tr>
							</table>

		 			</div>
					<!-- 조회 버튼 끝 -->

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
										<th width="7%" text-align="center"> 
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
										<th width="5%" text-align="center"> <!-- set R E M A I N  -->
											<div class="th-text">상태</div>
										</th>
										<th width="5%" text-align="center">
											<div class="th-text">진척도</div>
										</th>
										<th width="3%" text-align="center"> 
											<div class="th-text">비고</div>
										</th>								
									</tr>
									
								</thead>

								<!-- 여기부터 php -->


									<?php
									
										//query here
										$dresult = mysqli_query($conn,$_SESSION['dquery']);
										$cnt = 0;
										while($row=mysqli_fetch_array($dresult)){


										// 시간에 관련된 비교는 여기서 한다. 왜냐하면, 시구간에 대한 부등식 비교는 쿼리문으로 만들기 어렵기 때문

										$time_flag = ($row['sub_level_to_date']<$_SESSION['process_table_from'])||($row['sub_level_from_date']>$_SESSION['process_table_to']);
										if($time_flag) continue;


											echo "<tr id='im_tr_$cnt'>";
												$extra_tr_id_num = $cnt; // tmp 라고 하는 것은 앞의 필드 에서 바로 뒤의 필드에서 cnt 값이 증가하므로, 별도의 함수를 통해 원본 값을 유지한다..
												$random_code = "선운-".$row['master_customer']."-".$row['master_task_level_sub_code'];
												echo "<td>".++$cnt."</td>";
												echo "<td>".$ob2->su_function_convert_name($conn, "master_task_level_info_table", "master_task_level_code", $row['master_task_level_code'], "master_task_level_name")."</td>";
												echo "<td>".$random_code."</td>";
												echo "<td  id='left'>"."<a href=#0 style='padding: 0px 0px 0px 10px;' onclick='' />".$row['master_task_level_sub_name']."</td>";
												echo "<td>".$ob2->su_function_convert_name($conn, "master_customer_table", "master_code", $row['master_customer'], "master_name")."</td>";
												echo "<td>".$ob2->su_function_convert_name($conn, "master_superviser_table", "master_code", $row['master_superviser'], "master_name")."</td>";
												echo "<td>".$row['sub_level_from_date']."</td>";
												echo "<td>".$row['sub_level_to_date']."</td>";
											// 여기까지는 필수 입력 값이라서, null 체크 안함.
												/* 이하 null 체크 시작 */
											// 아래 3 필드는 돈관련 필드 3개

												echo "<td>".currecy_format_generator($row['all_money_master_code_field'])."</td>";
												echo "<td>".currecy_format_generator($row['use_money_master_code_field'])."</td>";
												echo "<td>".currecy_format_generator($row['remaind_money_master_code_field'])."</td>";

											// 비고... 버튼으로 활용 할지

												echo "<td>".$ob2->su_function_convert_name($conn, "dmaster_state_info_table", "master_code", $row['task_detail_state'], "master_state_detail_name")."</td>";
												echo "<td>".fill_null_space($row,'complete_rate','0%')."</td>";

												if(!green_circle_gray_chip($conn,$row['master_task_level_sub_code'],0)==0){
													echo "<td>"."<a href=#0 onclick=sub_task_open(0,".$row['master_task_level_sub_code'].",here_$extra_tr_id_num) /><font color='green' />●</td>";
												}else{
													echo "<td><font color='gray' />●</td>";
												}

											echo "</tr>";
											
											echo "<tr id='here_$extra_tr_id_num'></tr>"; // 여기에 하위 업무의 하이퍼 텍스트가 추가된다.



										}

									//마지막 라인에는 통계값을 넣는다.
											echo "<div class='foot-bg'>";
												echo "<tr id='table_off'>";
													echo "<td width='2%'><div class='th-text2'>합계</div></td>";
													echo "<td width='12%' id='left' colspan=2><div class='th-text2'>&nbsp &nbsp $cnt 건</div></td>";
													echo "<td width='34%' text-align='left' colspan=5><div class='th-text2'>*</div></td>";

													//각 필드의 금액 합하는 부분
													echo "<td width='6%'>".currecy_format_generator(sum_attribute_which_against_a_unit_of_field_be_parameterized($conn,$dtable_name,'all_money_master_code_field'),'th-text2')."</div></td>";
													echo "<td width='6%'>".currecy_format_generator(sum_attribute_which_against_a_unit_of_field_be_parameterized($conn,$dtable_name,'use_money_master_code_field'),'th-text2')."</div></td>";
													echo "<td width='6%'>".currecy_format_generator(sum_attribute_which_against_a_unit_of_field_be_parameterized($conn,$dtable_name,'remaind_money_master_code_field'),'th-text2')."</div></td>";
													echo "<td width='13%' colspan=3><div class='th-text2'>*</div></td>";
												echo "</tr>";
											echo "</div>";
									?>


							</table>
						</div>
						<!-- 틀고정 몸통 -->	
					</div>
					<!-- 메인 테이블 끝 -->					
					<!-- 버튼용 -->
					
					<div>
						<!-- <input type=button onclick='javascript:add_col();' value=hiraku></input> -->
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