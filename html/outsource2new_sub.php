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


//객체 생성

    $ob2 = new su_class_value_name_convert_with_code();
    $msg_ob = new su_class_message_handler();





//모듈 제원 초기화

      if(isset($_GET['valid'])){
                  $valid = $_GET['valid'];}
                  else{
                   $valid=1;   
                  }

if($valid==1){
    $_SESSION['new_sub_level'] = $_POST['task_select_box'][0];
	$_SESSION['new_sub_sub_level'] = 'new';
    if($_SESSION['new_sub_sub_level']=='new'){
        $_SESSION['new_sub_title'] = $_POST['task_select_box'][2];
    } 
    $_SESSION['sub_master'] = $_POST['commander'];
   
    $_SESSION['new_sub_base_date'] = $_POST['task_select_box'][3];
    $_SESSION['new_sub_limit_date'] = $_POST['task_select_box'][4];
}
    $my_name_code =  $_SESSION['my_sid_code'];
    $my_department_code = $_SESSION['my_department_code'];
    $my_position_code = $_SESSION['my_position_code'];



//메시지 파트

    if($valid==1){
    $msg_ob->su_function_call_confirm_message_no_next_binary($conn,911,'outsource2new_sub.php',0,514);
    }
    

    //debug
    echo "<br />";
    echo "task_title";
    echo "<br />";
    echo $_SESSION['new_sub_title'];
    
    echo "<br />";
    echo "task_level";
    echo "<br />";
    echo $_SESSION['new_sub_level'];

    echo "<br />";
    echo "task_sub_level";
    echo "<br />";
    echo $_SESSION['new_sub_sub_level'];
   
    echo "<br />";
    echo "date";
    echo "<br />";
    echo $_SESSION['new_sub_base_date'];
    echo "<br />";
    echo $_SESSION['new_sub_limit_date'];
    echo "<br />";





  
    if($_SESSION['sub_master']==8388607||($_SESSION['new_sub_sub_level']=='new'&&$_SESSION['new_sub_title']=='')||$_SESSION['new_sub_base_date']==''||$_SESSION['new_sub_limit_date']==''||$_SESSION['new_sub_sub_level']==''){
              echo "uninvalid input error in task add module";
              echo "<br />";
              
             // $msg_ob->su_function_call_message($conn,514,'su_script_table_write_personal_interface');

    }
    else if($_SESSION['new_sub_base_date']>$_SESSION['new_sub_limit_date']){
              $msg_ob->su_function_call_message($conn,513,'su_script_table_write_personal_interface');
    }

    else{      

            $date = date("Y-m-d");
            $task_sub_level =  $_SESSION['new_sub_level'];
            $task_title = $_SESSION['new_sub_title'];
            $task_base_date = $_SESSION['new_sub_base_date'];
            $task_limit_date = $_SESSION['new_sub_limit_date'];
            $task_commander = $_SESSION['sub_master'];
    	    $task_table_query = "Insert into master_task_level_sub_info_table(master_task_level_code,master_task_level_sub_name,sub_level_order_section,sub_level_position,sub_level_orderer,sub_level_from_date,sub_level_to_date,sub_level_birth_date,sub_level_master_sid) Values($task_sub_level,'$task_title',$my_department_code,$my_position_code,$my_name_code,'$task_base_date','$task_limit_date','$date',$task_commander);";      
            echo $task_table_query;
            echo "<br />";
   if($valid==0){
           $result_set = mysqli_query($conn,$task_table_query);
   
           $msg_ob->su_function_call_message_callback($conn,912);
           echo "<script> opener.location.reload(); </script>";
           echo "<script> self.close(); </script>"; 
             }
             else if($valid==514){
                    $msg_ob->su_function_call_message_callback($conn,913);
                    echo "<script> opener.location.reload(); </script>";
                    echo "<script> self.close(); </script>"; 
             }
             
    };
    ?>

