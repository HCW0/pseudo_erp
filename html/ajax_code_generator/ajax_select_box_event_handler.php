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




	//코드 parse to 가독데이터
			$ob2 = new su_class_value_name_convert_with_code();


	//리스너에서 던진 값을 가져온다.$_COOKIE

			$type = $_REQUEST['type'];
			$val = $_REQUEST['val'];

			//type
			// 0 -> 시단위				변수명 : $_SESSION['time_unit']
			// 1 -> 시벡터				변수명 : $_SESSION['time_vector']
			// 2~3 -> from to date    변수명 : $_SESSION['process_table_from'],$_SESSION['process_table_to']
			// 4 -> 업무 등급			변수명 : $_SESSION['process_table_task_level']
			// 5 -> 업무 부서			변수명 : $_SESSION['process_table_task_department']	
			// 6 -> 담당자				변수명 : $_SESSION['process_table_task_orderer']
			// 7 -> 금액 단위			변수명 : $_SESSION['currency_unit'];
			//
			// 타입값에 대응하는 세션 전역 변수의 값을 수정하면 끝			
              switch($type){

					case 0 :
						$_SESSION['toggle_datepicker'] = 0;
						$_SESSION['time_unit'] = $val;
					break;

					case 1 :
						$_SESSION['toggle_datepicker'] = 0;
						$_SESSION['time_vector'] = $val;
					break;
					
					case 2 :
						// $_SESSION['toggle_datepicker'] 는 자동검색을 할지 radio box check 검색을 할지 구분하는 플래그이다.
						$_SESSION['toggle_datepicker'] = 1;
						$_SESSION['process_table_from'] = $val;
					break;

					case 3 : // 날짜 데이터는 ""로 감싸주어야 한다.
						$_SESSION['toggle_datepicker'] = 1;
						$_SESSION['process_table_to'] = $val;
					break;

					case 4 :
						$_SESSION['process_table_task_level'] = $val;
					break;

					case 5 :
						$_SESSION['process_table_task_department'] = $val;
					break;

					case 6 :
						$_SESSION['process_table_task_orderer'] = $val;
					break;

					case 7 :
						$_SESSION['currency_unit'] = $val;
					break;

					case 8 :
						$_SESSION['process_table_task_state'] = $val;
					break;

			  }    


			// 주의!
      		  
?>
