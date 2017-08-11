<?php
//
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


			$ob2 = new su_class_value_name_convert_with_code();



// 직급에 따른 화면 분배 파트

		


	if($_SESSION['my_position_code']>=4){
		// 부서장 테이블로
			header('Location: ./su_script_user_personal_interface.php');

	}else if($_SESSION['my_position_code']==3){
		// 과 관리장 테이블
			header('Location: ./su_script_user_personal_interface.php');

	}else{
		// 대리 아래 일반 작업 테이블
			header('Location: ./su_script_user_personal_interface.php');

	}


?>