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


// 메시지 모듈

        $msg_ob = new su_class_message_handler();
        

 
       $approb_content = $_POST['opinion_write'][0];
       $approb_type = $_POST['opinion_write'][1];
       $AID = $_POST['opinion_write'][2];



        $query = "SELECT * FROM task_approbation_table u WHERE u.AID = $AID;";
     		$result = mysqli_query($conn,$query);  
        $row=mysqli_fetch_array($result);

        




       //debug
       echo 'aid';
       echo "<br />";
       echo $AID;
       echo "<br />";

       echo 'approb_content';
       echo "<br />";
       echo $approb_content;
       echo "<br />";
       
       echo 'approb_type';
       echo "<br />";
       echo $approb_type;
       echo "<br />";


       switch ($approb_type){

          case 0 : //중간 검토자
                        $offset = $row['current_sid']; //current sid는 어디까지나 숫자임, 필드값을 조합할 때 사용됨.
                        $var = "task_sq_".$row['current_sid']."layer_message";
                        while($offset<8){
                                        $offset++;
                                        $tmp = $offset.'_layer_aida_sid';
                                        $current_next_sid = $row[$tmp];
                                $query2 = "SELECT * FROM sid_combine_table u WHERE SID = $current_next_sid";
                                echo $query2;                     
                           	$result2 = mysqli_query($conn,$query2);
                                $row2=mysqli_fetch_array($result2);
                                if(mysqli_num_rows($result2)!=0&&$row2['is_valid']==1){
                                                break;
                                                }
                         }
                $task_detail_table_query3 = "update task_approbation_table set current_sid = ".$offset." where AID = $AID;";
                echo $task_detail_table_query3;
                mysqli_query($conn,$task_detail_table_query3);
                $task_detail_table_query3 = "update task_approbation_table set ".$var." = '".$approb_content."' where AID = $AID;";
                mysqli_query($conn,$task_detail_table_query3);
                 $task_detail_table_query3 = "update task_document_header_table set task_state = 10 where TID = ".$row['TID'].";";
                mysqli_query($conn,$task_detail_table_query3);
                

                $msg_ob->su_function_call_message_callback($conn,617);

                break;
 
                case 2 : //상신 최초결제자
                        $offset = $row['current_sid']; //current sid는 어디까지나 숫자임, 필드값을 조합할 때 사용됨.
                        $var = "task_sq_".$row['current_sid']."layer_message";
                        while($offset<8){
                                        $offset++;
                                        $tmp = $offset.'_layer_aida_sid';
                                        $current_next_sid = $row[$tmp];
                                $query2 = "SELECT * FROM sid_combine_table u WHERE SID = $current_next_sid";                     
                           	$result2 = mysqli_query($conn,$query2);
                                $row2=mysqli_fetch_array($result2);
                                if(mysqli_num_rows($result2)!=0&&$row2['is_valid']==1){
                                                break;
                                                }
                         }
                $task_detail_table_query3 = "update task_approbation_table set current_sid = ".$offset." where AID = $AID;";
                echo $task_detail_table_query3;
                mysqli_query($conn,$task_detail_table_query3);
                $task_detail_table_query3 = "update task_approbation_table set ".$var." = '".$approb_content."' where AID = $AID;";
                mysqli_query($conn,$task_detail_table_query3);
                $task_detail_table_query3 = "update task_document_header_table set task_state = 10 where TID = ".$row['TID'].";";
                mysqli_query($conn,$task_detail_table_query3);
                //결제 반려 -> 대기
                
                $msg_ob->su_function_call_message_callback($conn,614);

                break;

                 

                
                
          case 1 : //반려
                        $offset = $row['current_sid']; //current sid는 어디까지나 숫자임, 필드값을 조합할 때 사용됨.
                        $var = "task_sq_".$row['current_sid']."layer_message";
                        while($offset>0){
                                        $offset--;
                                        $tmp = $offset.'_layer_aida_sid';
                                        $current_next_sid = $row[$tmp];
                                $query2 = "SELECT * FROM sid_combine_table u WHERE SID = $current_next_sid";                     
                           	$result2 = mysqli_query($conn,$query2);
                                $row2=mysqli_fetch_array($result2);
                                if(mysqli_num_rows($result2)!=0&&$row2['is_valid']==1){
                                                break;
                                                }
                         }
                $task_detail_table_query3 = "update task_approbation_table set current_sid = ".$offset." where AID = $AID;";
                echo $task_detail_table_query3;
                mysqli_query($conn,$task_detail_table_query3);
                $task_detail_table_query3 = "update task_approbation_table set ".$var." = '".$approb_content."' where AID = $AID;";
                mysqli_query($conn,$task_detail_table_query3);
                $task_detail_table_query3 = "update task_document_header_table set task_state = 20 where TID = ".$row['TID'].";";
                mysqli_query($conn,$task_detail_table_query3);
                //반려상태
                $msg_ob->su_function_call_message_callback($conn,615);
                break;

                
       
                
                
          case -1 : //최종승인
                        $TID = $row['TID'];
                        $offset = $row['current_sid']; //current sid는 어디까지나 숫자임, 필드값을 조합할 때 사용됨.
                        $var = "task_sq_".$row['current_sid']."layer_message";
                        while($offset<8){
                                        $offset++;
                                        $tmp = $offset.'_layer_aida_sid';
                                        $current_next_sid = $row[$tmp];
                                $query2 = "SELECT * FROM sid_combine_table u WHERE SID = $current_next_sid";                     
                           	$result2 = mysqli_query($conn,$query2);
                                $row2=mysqli_fetch_array($result2);
                                if(mysqli_num_rows($result2)!=0&&$row2['is_valid']==1){
                                                break;
                                                }
                         }

                

                $task_detail_table_query3 = "select * from task_document_header_table u where u.TID != u.super_task_TID AND u.super_task_TID = $TID"; 
                $result = mysqli_query($conn,$task_detail_table_query3);
                if(mysqli_num_rows($result)==0){
                                $task_detail_table_query3 = "update task_document_header_table set task_state = 70 where TID = $TID;";
                                echo $task_detail_table_query3;
                                //완료
                }else{
                                $task_detail_table_query3 = "update task_document_header_table set task_state = 30 where TID = $TID;";
                                echo $task_detail_table_query3;
                                //진행
                                $tmp_flag = true;
                               while($row = mysqli_fetch_array($result)){
                                       if($row['task_state']!=70){
                                               $tmp_flag = false;
                                       } 
                               }
                               if($tmp_flag){
                                       $task_detail_table_query3 = "update task_document_header_table set task_state = 70 where TID = $TID;";
                               }

                };
                mysqli_query($conn,$task_detail_table_query3);


                $task_detail_table_query3 = "update task_approbation_table set ".$var." = '".$approb_content."' where AID = $AID;";
                echo $task_detail_table_query3;
                mysqli_query($conn,$task_detail_table_query3);
                $msg_ob->su_function_call_message_callback($conn,616);

                break;

                
       }
                echo "<script> opener.location.reload(); </script>";
               echo "<script> self.close(); </script>"; 

       

    ?>
