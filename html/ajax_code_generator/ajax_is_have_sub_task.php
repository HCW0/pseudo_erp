<?php
	session_start();
	
	// include function
			function my_autoloader($class){
				include '../classes/'.$class.'.php';
			}
			spl_autoload_register('my_autoloader');



	//db 연결 파트
			$conn = mysqli_connect('localhost','root','9708258a');
			if(!$conn) { $_SESSION['msg']='DB연결에 실패하였습니다.';
						header('Location: ../su_script_login_interface.php');
			}
			$use = mysqli_select_db($conn,"suproject");
			if(!$use) die('cannot open db'.mysqli_error($conn));


	// 기타 공정표용 함수들 임포트
			include('../su_script_process_table_func.php'); // ajax 스크립트 기준으로는 해당 파일이 상위에 있겠지./

	//코드 parse to 가독데이터
			$ob2 = new su_class_value_name_convert_with_code();



	//리스너에서 던진 값을 가져온다.$_COOKIE

			$type = $_REQUEST['type'];
			$val = $_REQUEST['val'];
			$subid = $_REQUEST['subid'];


	// 기타 함수

			//해당 업무 또는 용역에 포함된 업무가 있는지 파악하는 함수, 어디다 쓰냐면 초록색 동그라미를 만드는데 사용한다.
		function green_circle_gray_chip2($conn,$val,$type){

				//헤더의 상태값에 변화될 상세 상태값들을 가져온다.
				//type은 다음과 같은 의미를 가진다.
				//0 -> 용역(사업)에서 해당 사업에 소속된 업무로
				//1 -> 업무가 하위 업무를 가지는 경우

				switch($type){
					case 0:

						$query = "SELECT count(*) as cnt from task_document_header_table WHERE task_level_sub_code = $val AND super_task_TID = TID;";

					break;

					case 1:

						$query = "SELECT count(*) as cnt from task_document_header_table WHERE super_task_TID = $val AND super_task_TID != TID;";

					break;
				}

						$result = mysqli_query($conn,$query);
						$row = mysqli_fetch_array($result);


						if($row['cnt']!=0){
							$result_t = true;
						}else{
							$result_t = false;
						}

				return $result_t;

		}





	//헤더의 상태값에 변화될 상세 상태값들을 가져온다.
			//0 -> 용역(사업)에서 해당 사업에 소속된 업무로
			//1 -> 업무가 하위 업무를 가지는 경우
			switch($type){
				case 0:

					$query = "SELECT count(*) as cnt from task_document_header_table WHERE task_level_sub_code = $val AND super_task_TID = TID;";

				break;

				case 1:

					$query = "SELECT count(*) as cnt from task_document_header_table WHERE super_task_TID = $val AND super_task_TID != TID;";

				break;
			}

					$result = mysqli_query($conn,$query);
					$row = mysqli_fetch_array($result);


					if($row['cnt']!=0){
						$result_t = 1;
					}else{
						$result_t = 0;
					}
					// 여기서 함수 자체를 잘라도 됨. cnt 갯수 새는 함수랑 하위 항목들 찾는 함수로 //


					$hyper_text = '';
      				if($result_t==1 && $type==0){  // 해당 용역에 포함된 업무를 하이퍼텍스트로 만드는 파트
							$query = "SELECT *  from task_document_header_table WHERE task_level_sub_code = $val  AND super_task_TID = TID;";
							$result = mysqli_query($conn,$query);
								for($i = 0 ; $i < $row['cnt'];$i++){

										$target_field = 'sub_code_'.$type.'_'.$val;
										$hyper_text = $hyper_text."<tr id=".$target_field.">";
										$frow = mysqli_fetch_array($result);  // name__ *f -> function
										$random_code = "선운-".$val."-".$frow['TID'];
											//리턴값인 hyper_text에 값을 더해가서 이걸 호출한 tr에 td 엘리먼트로 append 시킨다.
												$hyper_text = $hyper_text."<td width='2%'>--</td>";											
												//$hyper_text = $hyper_text."<td>".$ob2->su_function_convert_name($conn, "master_task_level_info_table", "master_task_level_code", $frow['task_level_code'], "master_task_level_name")."</td>";
												$hyper_text = $hyper_text."<td>--</td>";
												$hyper_text = $hyper_text."<td>".$random_code."</td>";	
												$hyper_text = $hyper_text."<td  id='left'>"."<a href=#0 style='padding: 0px 0px 0px 10px;' onclick='javascript:sub_task_open(1,".$frow['TID'].")' >".$frow['task_name']."</a></td>";
												$hyper_text = $hyper_text."<td>--</td>";	
												$hyper_text = $hyper_text."<td>--</td>";													
												$hyper_text = $hyper_text."<td>".$frow['task_base_date']."</td>";
												$hyper_text = $hyper_text."<td>".$frow['task_limit_date']."</td>";
											// 여기까지는 필수 입력 값이라서, null 체크 안함.
												/* 이하 null 체크 시작 */
											// 아래 3 필드는 돈관련 필드 3개
												
												$hyper_text = $hyper_text."<td>".currecy_format_generator($frow['all_money_master_code_field'])."</td>";
												$hyper_text = $hyper_text."<td>".currecy_format_generator($frow['use_money_master_code_field'])."</td>";
												$hyper_text = $hyper_text."<td>".currecy_format_generator($frow['remaind_money_master_code_field'])."</td>";

											// 비고... 버튼으로 활용 할지

												$hyper_text = $hyper_text."<td>".$ob2->su_function_convert_name($conn, "dmaster_state_info_table", "master_code", $frow['task_detail_state'], "master_state_detail_name")."</td>";
												$hyper_text = $hyper_text."<td>".fill_null_space($frow,'complete_rate','0%')."</td>";

	
												if(green_circle_gray_chip2($conn,$frow['TID'],1)){
													$hyper_text = $hyper_text."<td>"."<a href=#0 onclick=sub_task_open(1,".$frow['TID'].",$target_field)><font color='green' />●</a></td>";
												}else{
													$hyper_text = $hyper_text."<td><font color='gray' />●</a></td>";
												}


												$hyper_text = $hyper_text."<td><div class='graph'><strong class='bar2' style='width: \'".$frow['complete_rate']."\'%;'>".$frow['complete_rate']."%</strong></div></td>";										
												$hyper_text = $hyper_text.'</tr>';

								}
					}else if($result_t==1 && $type==1){
						//1타입이면, depth2(업무현황)에서 하위 업무를 보는 경우를 말한다.
						//result_t가 하위업무가 있는지 없는지를 알리는 플래그로 값이 1이면 하위 업무가 존재한다는 뜻이된다.$_COOKIE



							$query = "SELECT *  from task_document_header_table WHERE super_task_TID = $val AND super_task_TID != TID;";
							$result = mysqli_query($conn,$query);
								for($i = 0 ; $i < $row['cnt'];$i++){

										$target_field = 'sub_code_'.$type.'_'.$val;
										$hyper_text = $hyper_text."<tr id=".$target_field.">";
										$frow = mysqli_fetch_array($result);  // name__ *f -> function
										$random_code = "선운-".$val."-".$frow['TID'];
										
											//리턴값인 hyper_text에 값을 더해가서 이걸 호출한 tr에 td 엘리먼트로 append 시킨다.
												$hyper_text = $hyper_text."<td width='2%'>--</td>";											
											//$hyper_text = $hyper_text."<td>".$ob2->su_function_convert_name($conn, "master_task_level_info_table", "master_task_level_code", $frow['task_level_code'], "master_task_level_name")."</td>";
												$hyper_text = $hyper_text."<td>--</td>";
												$hyper_text = $hyper_text."<td>".$random_code."</td>";	
												$hyper_text = $hyper_text."<td  id='left'>"."<a href=#0 style='padding: 0px 0px 0px 10px;'  onclick='javascript:sub_task_open(1,".$frow['TID'].")' >".$frow['task_name']."</a></td>";
												$hyper_text = $hyper_text."<td>--</td>";	
												$hyper_text = $hyper_text."<td>--</td>";													
												$hyper_text = $hyper_text."<td>".$frow['task_base_date']."</td>";
												$hyper_text = $hyper_text."<td>".$frow['task_limit_date']."</td>";
											// 여기까지는 필수 입력 값이라서, null 체크 안함.

												/* 이하 null 체크 시작 */

											// 아래 3 필드는 돈관련 필드 3개
												
												$hyper_text = $hyper_text."<td>".currecy_format_generator($frow['all_money_master_code_field'])."</td>";
												$hyper_text = $hyper_text."<td>".currecy_format_generator($frow['use_money_master_code_field'])."</td>";
												$hyper_text = $hyper_text."<td>".currecy_format_generator($frow['remaind_money_master_code_field'])."</td>";

											// 비고... 버튼으로 활용 할지

												$hyper_text = $hyper_text."<td>".$ob2->su_function_convert_name($conn, "dmaster_state_info_table", "master_code", $frow['task_detail_state'], "master_state_detail_name")."</td>";
												$hyper_text = $hyper_text."<td>".fill_null_space($frow,'complete_rate','0%')."</td>";

												if(green_circle_gray_chip2($conn,$frow['TID'],1)){
													$hyper_text = $hyper_text."<td>"."<a href=#0 onclick=sub_task_open(1,".$frow['TID'].",$target_field)><font color='green' />●</a></td>";
												}else{
													$hyper_text = $hyper_text."<td><font color='gray' />●</a></td>";
												}

												$hyper_text = $hyper_text."<td><div class='graph'><strong class='bar2' style='width: \'".$frow['complete_rate']."\'%;'>".$frow['complete_rate']."%</strong></div></td>";										
												$hyper_text = $hyper_text.'</tr>';


								}

					}else{
														echo "<script>alert('nooo')</script>";

					}	

					echo $hyper_text;
?>
