<?php


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
							return $trow['result'];
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
						function generate_sel_box($conn,$master_table,$field,$default,$where=''){
									$table_name = $master_table;
									$table_key = get_primary_key_name($conn,$table_name);
									$where_cond = $where;
									$query = "SELECT * FROM ".$table_name.' '.$where_cond.' order by '.$table_key.' desc';
									
									$result = mysqli_query($conn,$query);
									$hypertext = '';
										while( $row=mysqli_fetch_array($result) ){    
											if($row[$table_key]==$default){     
													$hypertext = $hypertext."<option value='".$row[$table_key]."' selected>".$row[$field]."</option>";
											}else{
													$hypertext = $hypertext."<option value='".$row[$table_key]."'>".$row[$field]."</option>";
											}
										}

									return $hypertext;
						}

						//디비에 저장된 금액은 전부 정수형이기 때문에, 화폐 포맷으로 만들어줄 필요가 있다.
						//더불어서 금액 단위에 따라 값을 보정하는 로직도 여기서 한번에 행한다.
						function currecy_format_generator($value,$class=''){

									switch($_SESSION['currency_unit']){
											
											case 1 :
												$value /= 1000;
											break;

											case 2 :
												$value /= 10000;
											break;

											case 3 :
												$value /= 1000000;
											break;

									}

									if($value==''){
										return "<div class='$class' id='center'>--</div>";
									}
									return "<div class='$class' id='right'>".number_format($value)."</div>";
						}


						//해당 업무 또는 용역에 포함된 업무가 있는지 파악하는 함수, 어디다 쓰냐면 초록색 동그라미를 만드는데 사용한다.
						function green_circle_gray_chip($conn,$val,$type){

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


?>