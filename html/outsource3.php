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



		
    $notice_title = $_POST['task_select_box'][0];
    $notice_level = $_POST['task_select_box'][1];
    $notice_base_date = $_POST['task_select_box'][2];
    $notice_limit_date = $_POST['task_select_box'][3];
    $notice_contents = $_POST['task_select_box'][4]; 
    $my_name =  $_SESSION['my_sid_code'];
    $my_department = $_SESSION['my_department_code'];


    $msg_ob = new su_class_message_handler();
  
    if($notice_title==''||$notice_base_date==''||$notice_limit_date==''||$notice_contents==''){
              echo "uninvalid input error in task add module";
              echo "<br />";
              
              $msg_ob->su_function_call_message($conn,514,'su_script_notice_write_interface');

    }
    else{      

            $date = date("Y-m-d");
    	    $task_table_query = "Insert into notice_document_header_table(notice_name,notice_priority,notice_birth_date,notice_base_date,notice_limit_date,notice_content,notice_orderer,notice_order_section,notice_file_directory) Values('$notice_title',$notice_level,'$date','$notice_base_date','$notice_limit_date','$notice_contents',$my_name,$my_department,'none');";      
            echo $task_table_query;
           $result_set = mysqli_query($conn,$task_table_query);

           $msg_ob->su_function_call_message_callback($conn,516);
           echo "<script> self.close(); </script>"; 

    };
    ?>

