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


	//삭제할 위치의 타입(0 or 1)과 키값(sub_lv_code or TID)을 가지고 해당 노드를 루트로 하는 서브트리를 전부 구하고, 배열에는 서브트리 구성 노드의
	//값을 가지고 조합한 tr의 id를 넣는다.

	//즉, 해당 함수를 통해 얻은 배열 내부의 id 값을 전부 remove 시키면 된다.$_COOKIE

	//재귀적으로 하위 업무를 검색하여, id 값을 만들고 그것들을 배열에 저장하는 함수.			
		function recrusive_target_to_array($conn,$type,$key,&$array){
			if($type==0){
				$query = "SELECT * from task_document_header_table WHERE task_level_sub_code = $key AND super_task_TID = TID;";
				$target_key = 'task_level_sub_code';
			}else{
				$query = "SELECT * from task_document_header_table WHERE super_task_TID = $key AND super_task_TID != TID;";
				$target_key = 'TID';
			}

			$result = mysqli_query($conn,$query);

			$i = 0;
			while($row=mysqli_fetch_array($result)){
				$target_field = '#sub_code_'.$type.'_'.$row[$target_key];
				$array[] = $target_field;
				$target_field = '#sub_code_1_'.$key;
				$array[] = $target_field;			
				
				$array = array_unique($array);

				recrusive_target_to_array($conn,1,$row['TID'],$array);
			}
		}



	//리스너에서 던진 값을 가져온다.$_COOKIE

			$key = $_REQUEST['key'];
			$type = $_REQUEST['type'];


	$rarray = array();
	recrusive_target_to_array($conn,$type,$key,$rarray);

	echo json_encode($rarray);
		// print_r($rarray);
?>
