 <?php
      session_start();

	include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_user_login_check.php');
	include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_class_loader.php');
	include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_db_connecter.php');

            $ob3 = new su_class_message_handler();
            $TID = $_GET['TID'];
            
            if(isset($_GET['valid'])){
                  $valid = $_GET['valid'];
            }else{
            $valid = 0;
            }

          
            if($valid==0){
		                        echo "<script> var reply = confirm('업무를 삭제하시겠습니까?');";
                                    echo "if(reply == false)";
                                    echo "history.go(-1);";
                                    echo 'window.location.href = "';
                                    echo "su_script_task_delete_process.php?TID=".$TID."&valid=514";
                                    echo '";';
                                    echo '</script>';
            }
      // 하위 업무 검색 :: 하위 업무가 존재한다면 외래키 제약 조건과 같은 원리로 삭제 모듈이 취소된다.    
            $task_table_query2 = "SELECT * FROM task_document_header_table u where ".$TID." = u.super_task_TID AND u.TID != u.super_task_TID ;";
		$result_set2 = mysqli_query($conn,$task_table_query2);
            if(mysqli_num_rows($result_set2)!=0){
                  $valid = 0;
                  $ob3->su_function_call_message($conn,840,'su_script_user_personal_detail_interface');
               
            }

      // 업무 삭제하는 로직
             if($valid==514){
                        $task_table_query2 = "delete from task_document_header_table where TID=$TID;";
                        $result_set2 = mysqli_query($conn,$task_table_query2);
                        $ob3->su_function_call_message_callback($conn,841);
                              echo "<script> opener.location.reload(); </script>";
                              echo "<script> self.close(); </script>"; 
                    }
                  

    ?>
