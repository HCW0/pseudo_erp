
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
		$ob2 = new su_class_value_name_convert_with_code();
		$ob4 = new su_class_calc_the_date();
           
            $level = $_GET['level'];
            $sub_level = $_GET['sub_level'];

      
   
            echo "검색하려는 업무 코드";
            echo "<br />";
            echo $level;
            echo "<br />";
            echo "검색하려는 업무 서브 코드";
            echo "<br />";
            echo $sub_level;
            echo "<br />";
           
           
                  $_SESSION['current_personal_base_date']=$ob4->su_function_convert_this_week_begin($_SESSION['now_date']);
			$_SESSION['current_personal_limit_date']=$ob4->su_function_convert_this_week_end($_SESSION['now_date']);
		             

                  //detail init
                  $_SESSION['hold_level'] = $level;
                  $_SESSION['sub_hold_level'] = $sub_level;




				$_SESSION['current_personal_task_orderer'] = $_SESSION['my_sid_code'];


                  $_SESSION['current_personal_task_level_code'] = $level;
			$_SESSION['current_personal_task_level_sub_code'] = $sub_level;
                  
                  if($sub_level==999) $_SESSION['current_personal_task_orderer']=8388607;



                  $_SESSION['radio_index'] = 0;









            header('location: ./su_script_user_personal_interface_adapter_to_detail.php');

    ?>


