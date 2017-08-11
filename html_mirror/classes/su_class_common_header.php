<?php

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
	


// 하드 코딩된 함수 이하

function toWeekNum($get_year, $get_month, $get_day){
 $timestamp = mktime(0, 0, 0, $get_month, $get_day, $get_year);
 $w = date('w',mktime(0,0,0,date('n',$timestamp),1,date('Y',$timestamp)));
 return ceil(($w + date('j',$timestamp) - 1)/7);
}


// 서버 점검 확인 파트
        $msg_ob = new su_class_message_handler();
         $flag = 'shut_down';
         $mquery = 'select * from server_state_table u where u.FLAG_NAME = \''.$flag.'\';';
         $result_set = mysqli_query($conn,$mquery);
         $row = mysqli_fetch_assoc($result_set);
         $flag_Value = $row['FLAG_VALUE'];
         if($flag_Value) {
              
              $msg_ob->su_function_call_message($conn,334,'su_script_login_interface');
         
          die();   
         }



		






?>