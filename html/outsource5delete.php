
  <?php
      session_start();


	
// 유저 세션 검증
	if(!isset($_SESSION['is_login'])){
		header('Location: ./su_script_logout_support.php');
	};

// 삭제 플래그 초기화
      	if(!isset($_SESSION['kill_flag'])){
                  $_SESSION['kill_flag'] = 514;
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

            $ob3 = new su_class_message_handler();
            $TID = $_GET['TID'];
            $_SESSION['kill_flag'] = $_GET['kill_flag'];
            


            echo "삭제하려는 업무 코드";
            echo "<br />";
            echo $TID;
          

            if($_SESSION['kill_flag']!=513){
		      $ob3->su_function_call_confirm_message_of_kill_task($conn,839,$TID);
            }

      // 하위 업무 검색 :: 하위 업무가 존재한다면 외래키 제약 조건과 같은 원리로 삭제 모듈이 취소된다.    
            $task_table_query2 = "SELECT * FROM task_document_header_table u where ".$TID." = u.super_task_TID AND u.TID != u.super_task_TID ;";
		$result_set2 = mysqli_query($conn,$task_table_query2);
            if(mysqli_num_rows($result_set2)!=0){
                  if($_SESSION['kill_flag']!=513)
                  $ob3->su_function_call_message($conn,840,'su_script_user_personal_detail_interface');
               
            }


                  if($_SESSION['kill_flag']==514){
                        $task_table_query2 = "delete from task_document_header_table where TID=$TID;";
                        $result_set2 = mysqli_query($conn,$task_table_query2);
                        $ob3->su_function_call_message_callback($conn,841);
                    }
                  echo $task_table_query2;
                  echo $_SESSION['kill_flag'];
                  $_SESSION['kill_flag'] = 514;
            echo "<script> opener.location.reload(); </script>";
            echo "<script> self.close(); </script>"; 

    ?>


