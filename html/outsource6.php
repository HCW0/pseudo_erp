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


            $_SESSION['current_personal_base_date'] = $_POST['task_select_box'][0];
            $_SESSION['current_personal_limit_date'] = $_POST['task_select_box'][1];
            $_SESSION['current_personal_task_level_code'] = $_POST['task_select_box'][2];
            $_SESSION['current_personal_task_level_sub_code'] = $_POST['task_select_box'][3];
            $_SESSION['current_personal_task_orderer'] = $_POST['task_select_box'][4];
			$_SESSION['current_personal_task_priority'] = $_POST['task_select_box'][5];
			$_SESSION['current_personal_task_state'] = $_POST['task_select_box'][6];


             header('location: ./su_script_user_personal_interface.php');

    ?>

