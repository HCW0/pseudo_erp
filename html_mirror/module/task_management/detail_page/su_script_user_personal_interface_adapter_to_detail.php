<!DOCTYPE html>

<html>

<?php
    session_start();
	include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_combine_box.php');

// class 객체 생성
$ob1 = new su_class_task_table_config();
$ob2 = new su_class_value_name_convert_with_code();
$ob3 = new su_class_value_combine_combobox_value_to_mysql_query();
$UI_form_ob = new su_class_UI_format_generator();
$ob4 = new su_class_calc_the_date();



// 테이블 콤보박스의 필드값 초기화
if (isset($_SESSION['current_personal_dstate']) == false) {
	$_SESSION['current_personal_dstate'] = '99';
}

if (isset($_SESSION['current_personal_base_date']) == false) {
	$_SESSION['current_personal_base_date'] = $ob4->su_function_convert_this_week_begin($_SESSION['now_date']);
	$_SESSION['current_personal_limit_date'] = $ob4->su_function_convert_this_week_ends($_SESSION['now_date']);
}

if (isset($_SESSION['reserve_index']) == false) {
	$_SESSION['reserve_index'] = 0;
	$_SESSION['current_task_check_bottan'] = true;
	$_SESSION['reserve_task_check_bottan'] = true;
}

if (isset($_SESSION['current_personal_task_level_code']) == false) {
	$_SESSION['current_personal_dstate'] = '99';
	$_SESSION['current_personal_base_date'] = $ob4->su_function_convert_this_week_begin($_SESSION['now_date']);
	$_SESSION['current_personal_limit_date'] = $ob4->su_function_convert_this_week_ends($_SESSION['now_date']);
	$_SESSION['current_personal_task_order_section'] = $ob1->su_function_init_config($conn, $_SESSION['my_sid_code'], "task_order_section");

if ($_SESSION['task_master'] != $_SESSION['my_sid_code']) {
	$_SESSION['current_personal_task_orderer'] = $_SESSION['my_sid_code'];
}
else {
	$_SESSION['current_personal_task_orderer'] = 8388607;
	}
	$_SESSION['current_personal_task_priority'] = $ob1->su_function_init_config($conn, $_SESSION['my_sid_code'], "task_priority");
	$_SESSION['current_personal_task_state'] = $ob1->su_function_init_config($conn, $_SESSION['my_sid_code'], "task_state");
}

if (isset($_SESSION['radio_index']) == false) { // 0 = 전체 1 = 현업 2 = 계획
	$_SESSION['radio_index'] = 0;
}


?>

	<!-- 하드 코딩된 함수 이하 -->



	<script>

		function hrefClick(course, course2) {
			// You can't define php variables in java script as $course etc.


			var popUrl = "../../approbation_management/approbation_info/detail/su_script_task_approbation_detail_pop_up.php"; //팝업창에 출력될 페이지 URL
			var popOption = "resizable=no, scrollbars=no, status=no;"; //팝업창 옵션(optoin)
			window.open(popUrl + '?AID=' + course + '&TID=' + course2, popOption, 'width=680,height=680');



		}

		function hrefClick_of_sub_task(level, sub_level, tid) {
			// You can't define php variables in java script as $course etc.

			var popOption = "fullscreen=0, resizable=0, scrollbars=0, status=0;"; //팝업창 옵션(optoin)
			var popUrl = "/view/su_script_gate_view_of_task.php"; //팝업창에 출력될 페이지 URL
			window.open(popUrl + '?level=' + level + '&sub_level=' + sub_level + '&tid=' + tid, popOption,
				'height= 253px width=912px');




		}

		function hrefClick_of_sub_task_b(level, sub_level, tid) {
			// You can't define php variables in java script as $course etc.

			var popOption = "fullscreen=0, resizable=0, scrollbars=0, status=0;"; //팝업창 옵션(optoin)
			var popUrl = "/view/su_script_gate_view_of_task_if_requester_equals_to_task_maker.php"; //팝업창에 출력될 페이지 URL
			window.open(popUrl + '?level=' + level + '&sub_level=' + sub_level + '&tid=' + tid, popOption,
				'height= 253px width=912px');




		}

		function selectEvent(selectObj, field_index) {
			// You can't define php variables in java script as $course etc.


			var popUrl = "./common_func/su_function_real_time_combobox_personal_adapter.php"; //팝업창에 출력될 페이지 URL
			var popOption = "width=680, height=680, resizable=no, scrollbars=no, status=no;"; //팝업창 옵션(optoin)
			window.location.href = popUrl + '?var=' + selectObj.value + '&index=' + field_index;



		}

			/*달력 함수*/
			$(function () {
				$("#datepicker1, #datepicker2").datepicker({
					dateFormat: 'yy-mm-dd'
				});
			});



	</script>


	<head>
		<title>test</title>
		<meta charset="utf-8" />

		<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_include_jquery.php'); ?>

		<style>
			table {
				width: 100%;
				border-top: 1px solid #444444;
				border-collapse: collapse;
				vertical-align: middle;
			}

			td {
				border-bottom: 1px solid #444444;
				padding: 1px;
				text-align: center;
				vertical-align: middle;
			}

			th {
				border-bottom: 1px solid #444444;
				padding: 1px;
				text-align: center;
				vertical-align: middle;
			}

			#left {
				text-align: left;
			}

			th:nth-child(2n),
			td:nth-child(2n) {
				background-color: #;
			}

			th:nth-child(2n+1),
			td:nth-child(2n+1) {
				background-color: #;
			}

			#wrapper {
				padding: 0px 0px 0px 66px;
			}


			.fixed-table-container {
				width: 1500px;
				height: 550px;
				border: 1px solid #000;
				position: relative;
				padding-top: 30px;
				/* header-bg height값 */
			}

			#left {
				text-align: left;
			}

			.header-bg {
				background: skyblue;
				height: 30px;
				/* header-bg height값 */
				position: absolute;
				top: 0;
				right: 0;
				left: 0;
				border-bottom: 1px solid #000;
			}

			.foot-bg {
				background: skyblue;
				height: 20px;
				/* header-bg height값 */
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

			td+td {
				border-left: 1px solid #ccc;
			}

			th {
				padding: 0px;
				/* reset */
			}

			.th-text {
				position: absolute;
				top: 0;
				width: inherit;
				line-height: 30px;
				/* header-bg height값 */
				border-left: 1px solid #000;
			}

			.th-text2 {
				position: absolute;
				bottom: 0;
				width: inherit;
				line-height: 20px;
				/* header-bg height값 */
				border-left: 1px solid #000;
			}

			th:first-child .th-text {
				border-left: none;
			}
		</style>



	</head>

	<body>


		<header>
			<a id="cd-menu-trigger" href="#0"><span class="cd-menu-text">메뉴&nbsp &nbsp &nbsp &nbsp</span></a>


			<div id="wrapper" style="width:100%" "height:300px">


				<?php
		$UI_form_ob->su_function_get_title('업무 과정', $_SESSION['my_name'], $_SESSION['my_position'], $_SESSION['my_department'], 'su_script_user_personal_interface');
		?>


					<div style='float:left;'>
						업무등급 :
						<?php echo $ob2->su_function_convert_name($conn, "master_task_level_info_table", "master_task_level_code", $_SESSION['current_personal_task_level_code'], "master_task_level_name"); ?><br /> 사업명 :
						<?php echo $ob2->su_function_convert_name($conn, "master_task_level_sub_info_table", "master_task_level_sub_code", $_SESSION['current_personal_task_level_sub_code'], "master_task_level_sub_name"); ?><br />


						<?php 
				if ($_SESSION['current_personal_task_level_sub_code'] != 999) {
					echo "<input type='button' name='버튼' value='신규등록' onclick=\"window.open('./write/su_script_table_write_interface.php?type=new','win','width=800,height=700,toolbar=0,scrollbars=0,resizable=0')\"/><br />";
				}
				?>


					</div>
					<div style="padding:0px 0px 0px 1066px;">

						<form action='outsource6.php' method='POST' name="table_filter">

							<span align="right">
	
									<?php
									switch ($_SESSION['radio_index']) {

										case -1 :
											echo "<input type='radio' onclick='selectEvent(this.value,14)' checked>일일 ";
											echo "<input type='radio' onclick='selectEvent(this.value,7)'>주간 ";
											echo "<input type='radio' onclick='selectEvent(this.value,8)'>월간 ";
											echo "<input type='radio' onclick='selectEvent(this.value,9)'>연간 ";
											break;
										case 0 :
											echo "<input type='radio' onclick='selectEvent(this.value,14)' >일일 ";
											echo "<input type='radio' onclick='selectEvent(this.value,7)' checked>주간 ";
											echo "<input type='radio' onclick='selectEvent(this.value,8)'>월간 ";
											echo "<input type='radio' onclick='selectEvent(this.value,9)'>연간 ";
											break;
										case 1 :
											echo "<input type='radio' onclick='selectEvent(this.value,14)' >일일 ";
											echo "<input type='radio' onclick='selectEvent(this.value,7)'>주간 ";
											echo "<input type='radio' onclick='selectEvent(this.value,8)'' checked>월간 ";
											echo "<input type='radio' onclick='selectEvent(this.value,9)'>연간 ";
											break;
										case 2 :
											echo "<input type='radio' onclick='selectEvent(this.value,14)' >일일 ";
											echo "<input type='radio' onclick='selectEvent(this.value,7)'>주간 ";
											echo "<input type='radio' onclick='selectEvent(this.value,8)'>월간 ";
											echo "<input type='radio' onclick='selectEvent(this.value,9)' checked>연간 ";
											break;
									}

									echo "&nbsp &nbsp &nbsp &nbsp &nbsp";

									if ($_SESSION['current_task_check_bottan'] && $_SESSION['reserve_task_check_bottan']) {


										echo "<input type='checkbox' onclick='selectEvent(this.value,12)' checked>실적업무 ";
										echo "<input type='checkbox' onclick='selectEvent(this.value,13)' checked>계획업무 ";

									}
									else if ($_SESSION['current_task_check_bottan'] && (!$_SESSION['reserve_task_check_bottan'])) {

										echo "<input type='checkbox' onclick='selectEvent(this.value,12)' checked>실적업무 ";
										echo "<input type='checkbox' onclick='selectEvent(this.value,13)'>계획업무 ";

									}
									else if ( (!$_SESSION['current_task_check_bottan']) && $_SESSION['reserve_task_check_bottan']) {

										echo "<input type='checkbox' onclick='selectEvent(this.value,12)'>실적업무 ";
										echo "<input type='checkbox' onclick='selectEvent(this.value,13)' checked>계획업무 ";

									}
									else {


										echo ("<script> 
																								
																			alert('다른 부서에 실적등록을 할 수 없습니다.');  

                                   		 									</script>");

										$_SESSION['current_task_check_bottan'] = true;
										$_SESSION['reserve_task_check_bottan'] = true;
										echo "<input type='checkbox' onclick='selectEvent(this.value,12)' checked>실적업무 ";
										echo "<input type='checkbox' onclick='selectEvent(this.value,13)' checked>계획업무 ";
									}


									?>
									

	

									


								
						</span>


							<br />
							<br />


							<span>시작일</span>
							<?php
						echo '<input type="text" name = "task_select_box[]" id="datepicker1" onchange="javascript:selectEvent(this,5);" value="' . $_SESSION['current_personal_base_date'] . '">'
						?>
								<span>/ 마감일</span>
								<?php
						echo '<input type="text" name = "task_select_box[]" id="datepicker2" onchange="javascript:selectEvent(this,6);" value="' . $_SESSION['current_personal_limit_date'] . '">'
						?>
									<br /><br />


					</div>


					<div class="fixed-table-container">
						<div class="header-bg"></div>
						<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
							<thead>


								<table>
									<tr>
										<th width="3%" text-align="center">
											<div class="th-text">NO</div>
										</th>




										<th width="20%" text-align="center">
											<div class="th-text">업무명</div>
										</th>

										<th width="11%" text-align="center">

											<?php if ($_SESSION['current_personal_task_level_sub_code'] != 999) {
							echo "<div class='th-text'>담당부서</div>";
						}
						else {
							echo "<div class='th-text'>사업명</div>";
						}
						?>

										</th>





										<th width="13%" text-align="center">
											<div class="th-text">작성자
												<select name="task_select_box[]" onchange="javascript:selectEvent(this,2);">	
       							 <?php
		
										//즉 권한 MAX가 아닌 경우
															$query = "SELECT * FROM sid_combine_table u where " . $_SESSION['my_department_code'] . " = u.sid_combine_department AND u.is_valid=1 AND u.sid_combine_position <= " . $_SESSION['my_position_code'] . ";";



															echo "<option value=8388607>전체</option>";
															$result = mysqli_query($conn, $query);

															while ($row = mysqli_fetch_array($result)) {
																$name_Value = $ob2->su_function_convert_name($conn, "master_user_info_table", "SID", $row['SID'], "master_user_info_name");
																if ($row['SID'] == $_SESSION['current_personal_task_orderer']) {
																	echo "<option value='" . $row['SID'] . "' selected>" . $name_Value . "</option>";
																}
																else {
																	echo "<option value='" . $row['SID'] . "'>" . $name_Value . "</option>";
																}

															}
															?>          
   							</select> </div>
										</th>


										<th width="12%" text-align="center">
											<div class="th-text">진행상태
												<select name="task_select_box[]" onchange="javascript:selectEvent(this,10);">		
       							 <?php
															$query = "SELECT * FROM dmaster_state_info_table";
															$result = mysqli_query($conn, $query);
															echo "<option value='99'>전체</option>";
															while ($row = mysqli_fetch_array($result)) {
																if ($row['master_code'] != 99 && $row['master_code'] % 10 != 0) {
																	if ($row['master_code'] == $_SESSION['current_personal_dstate']) {
																		echo "<option value='" . $row['master_code'] . "' selected>" . $row['master_state_detail_name'] . "</option>";
																	}
																	else {
																		echo "<option value='" . $row['master_code'] . "'>" . $row['master_state_detail_name'] . "</option>";
																	}
																}
															}
															?>          
   							</select> </div>
										</th>





										<th width="13%" text-align="center">
											<div class="th-text">결제현황
												<select name="task_select_box[]" onchange="javascript:selectEvent(this,4);">		
       							 <?php
															$query = "SELECT * FROM master_state_info_table";
															$result = mysqli_query($conn, $query);
															echo "<option value='99'>전체</option>";
															while ($row = mysqli_fetch_array($result)) {

																if ($row['master_task_state_info_code'] != 99) {



																	if ($row['master_task_state_info_code'] == $_SESSION['current_personal_task_state']) {
																		echo "<option value='" . $row['master_task_state_info_code'] . "' selected>" . $row['master_task_state_info_name'] . "</option>";
																	}

																	else {
																		echo "<option value='" . $row['master_task_state_info_code'] . "'>" . $row['master_task_state_info_name'] . "</option>";
																	}



																}
															}
															?>          
   							</select> </div>
										</th>

										<th width="9%" text-align="center">
											<div class="th-text">우선도
												<select name="task_select_box[]" onchange="javascript:selectEvent(this,3);">	
       							 <?php
															$query = "SELECT * FROM master_priority_info_table";
															$result = mysqli_query($conn, $query);
															echo "<option value='3'>전체</option>";
															while ($row = mysqli_fetch_array($result)) {
																if ($row['master_task_priority_info_code'] != 3) {
																	if ($row['master_task_priority_info_code'] == $_SESSION['current_personal_task_priority']) {
																		echo "<option value='" . $row['master_task_priority_info_code'] . "' selected>" . $row['master_task_priority_info_name'] . "</option>";
																	}
																	else {
																		echo "<option value='" . $row['master_task_priority_info_code'] . "'>" . $row['master_task_priority_info_name'] . "</option>";
																	}
																}
															}
															?>          
   							</select> </div>
										</th>


										<th width="9%" text-align="center">
											<!-- 폐기된 기능 :: 업무 검색 기능(비동기성)
							<input type="submit" name="Release" value="Click to Release">
						-->

											<div class="th-text">작성일자 </div>

											</form>
										</th>


										<th width="10%" text-align="center">


											<div class="th-text">결제옵션 </div>

											</form>
										</th>


									</tr>

									<tr>

							</thead>
							<?php

				/*
				// 각 필드 콤보박스의 입력 값 확인하는 로직
				// 테이블 위치에 코드값으로 바로 표시됨.
				echo "<br />";
				echo "<br />";
				echo "debug status";
				echo "<br />";
				echo '업무 레벨 ';
				echo $_SESSION['current_personal_task_level_code'];
				echo "<br />";
				echo '업무 코드 ';
				echo $_SESSION['current_personal_task_level_sub_code'];
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
				echo '담당자';
				echo $_SESSION['task_master'];
				echo "<br />";
				echo '담당부서';	
				echo $_SESSION['current_personal_task_order_section'];
			 */


			$task_table_query = $ob3->su_function_combine_query_to_task_header_table_spaghetti_wo_kiwameru($_SESSION['current_personal_task_level_code'], $_SESSION['current_personal_task_level_sub_code'], $_SESSION['current_personal_task_order_section'], $_SESSION['current_personal_task_orderer'], $_SESSION['current_personal_task_priority'], $_SESSION['current_personal_task_state'], $_SESSION['current_personal_dstate']);
			$result_set = mysqli_query($conn, $task_table_query);

				
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


								</tr>

								<?php
		$cnt = 1;
		if ($result_set) {
			while ($row = mysqli_fetch_array($result_set)) {


				if (!$ob4->su_function_date_conflict_senser($_SESSION['current_personal_base_date'], $_SESSION['current_personal_limit_date'], $row['task_base_date'], $row['task_limit_date'])) {
					continue;
				}


				if(!($row['task_orderer']==$_SESSION['my_sid_code'] || $row['TID']==$row['super_task_TID'])){
					continue;
				}

				?>
									<tr>
										<td>
											<?php echo $cnt++ ?>
										</td>


										<td id='left'>
											<?php
						$tag = "";
						if ($row['reserve_flag'] == 1) {
							$tag = " (계획)";
						}

						if ($_SESSION['my_sid_code'] == $row['task_orderer'] && $row['task_state'] == 5) {
							echo "<a href='#' onclick='hrefClick_of_sub_task_b(" . $row['task_level_code'] . ',' . $row['task_level_sub_code'] . ',' . $row['TID'] . ");'/>";
							echo $row['task_name'] . $tag;
						}
						else {
							echo "<a href='#' onclick='hrefClick_of_sub_task(" . $row['task_level_code'] . ',' . $row['task_level_sub_code'] . ',' . $row['TID'] . ");'/>";
							echo $row['task_name'] . $tag;
						}
						?>
										</td>
										<td>
											<?php 
									if ($_SESSION['current_personal_task_level_sub_code'] != 999) {
										echo $ob2->su_function_convert_name($conn, "master_department_info_table", "sid_combine_department", $row['task_order_section'], "master_department_info_name");
									}
									else {
										echo $ob2->su_function_convert_name($conn, "master_task_level_sub_info_table", "master_task_level_sub_code", $row['task_level_sub_code'], "master_task_level_sub_name");
									}

									?>
										</td>
										<td>
											<?php echo
										$ob2->su_function_convert_name($conn, "master_user_info_table", "SID", $row['task_orderer'], "master_user_info_name");
									?>
										</td>

										<td>
											<?php 
									if ($row['task_detail_state']) {

										$revision = $row['task_detail_state'];
										echo $ob2->su_function_convert_name($conn, "dmaster_state_info_table", "master_code", $revision, "master_state_detail_name");
									}
									else {
										echo '-';
									}
									?>
										</td>

										<td>
											<?php 
									echo $ob2->su_function_convert_name($conn, "master_state_info_table", "master_task_state_info_code", $row['task_state'], "master_task_state_info_name");

									
								// 결제가 완료가 아닌 경우에는 상태 옆에, 현재 결제 담당자의 이름을 보여줘야한다.
										$query = "select * from task_approbation_table where " . $row['TID'] . " = TID";
										$result = mysqli_query($conn, $query);
										$row2 = mysqli_fetch_array($result);
										$field_name = $row2['current_sid'] . "_layer_aida_sid";
										if ($row2['current_sid'] >= 8) {
											$field_name = 'end_order';
										}

										if ($row['task_state'] != 70 && $row['task_state'] != 5) {
										echo " ( ";
										echo $ob2->su_function_convert_name($conn, "master_user_info_table", "SID", $row2[$field_name], "master_user_info_name");;
										echo " ) ";
										}

									?>
										</td>

										<td>
											<?php echo
										$ob2->su_function_convert_name($conn, "master_priority_info_table", "master_task_priority_info_code", $row['task_priority'], "master_task_priority_info_name");
									?>
										</td>

										<td>
											<?php
					echo $row['task_birth_date'];

					?>


										</td>

										<td>
											<?php
					if ($_SESSION['my_sid_code'] == $row2[$field_name] && $row['task_state'] != 70 && $row['task_state'] != 5) {
						echo "<a href='#' onclick='hrefClick(" . $row2['AID'] . ',' . $row2['TID'] . ");'/>결제하기</a><br>";
					}
					else {
						echo "--";
					}
					?>


										</td>

									</tr>


									<?php

											}
										}


			//statistical summary
										echo "<div class='foot-bg'></div>";
										echo "<tr><th>";
										echo "<div class='th-text2'>";
										if (!$result_set) {
											echo "일치하는 항목이 없습니다.";
										}
										else {
											echo "합계 : ";
											echo mysqli_num_rows($result_set);
											echo "건";
										}
										echo "</div>";
										echo "</th></tr>";

										?>

										</table>
						</div>


						<div id="footer" style="padding:70px 0px 0px 1110px;">


						</div>
						<div id="footer" style="padding:50px 0px 0px 800px;">

						</div>
						<p style="background-color:coffee" class="bd" align="center">COPYRIGHT(C) 2017 SUNUNENG.ENG ALL RIGHTS RESERVED&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp주소
							: 광주광역시 광산구 송정동 735 선운빌딩 3층 <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp연락처
							: 062-651-9272 / FAX : 062-651-9271</p>
					</div>
		</header>

	<?php include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_slide_menu.php');?>

	</body>

</html>