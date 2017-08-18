
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



        $target_tid = $_GET['target'];
        $type = $_GET['type'];


//상신
        if($type==0){

                    //  
                        $iquery = "SELECT * FROM task_approbation_table WHERE TID = $target_tid AND appro_type_flag = 1";
                        $iresult = mysqli_query($conn,$iquery);
                        $irow = mysqli_fetch_array($iresult);

                        $path_number = $irow['key_index'];

                        $min_find_query = "select * from task_approbation_path_table where sid=".$_SESSION['my_sid_code']." AND key_index = $path_number;";
                        $result_min = mysqli_query($conn,$min_find_query);
                        $row_min = mysqli_fetch_array($result_min);
                        $min = $row_min['min_sid'];




		    $query = "update task_document_header_table set task_state = 10 where TID = $target_tid;";
		    mysqli_query($conn,$query);
		    $query = "update task_approbation_table set current_sid = $min where TID = $target_tid AND appro_type_flag = 1;";
		    mysqli_query($conn,$query);

        $_SESSION['current_focused_TID'] = $target_tid;
		echo "<script> opener.location.reload(); </script>";
		echo "<script>window.location.href='su_script_user_personal_detail_interface.php?tid=".$target_tid."'</script>";


        }


//하위승인
        if($type==1){

        $task_table_query2 = "SELECT * FROM task_document_header_table u where ".$target_tid." = u.super_task_TID AND u.TID != u.super_task_TID AND task_state>=10 AND task_state<=30;";
                                    $result_set2 = mysqli_query($conn,$task_table_query2);
                                    if(mysqli_num_rows($result_set2)!=0){
                                            while($row2 = mysqli_fetch_array($result_set2)) {
                                            
                                                    $query = "update task_document_header_table set task_state = 70 where TID = ".$row2['TID'].";";
		                                            mysqli_query($conn,$query);
                                            
                                            }
                                    }
        }





//하위반려
        if($type==2){

        $task_table_query2 = "SELECT * FROM task_document_header_table u where ".$target_tid." = u.super_task_TID AND u.TID != u.super_task_TID;";
                                    $result_set2 = mysqli_query($conn,$task_table_query2);
                                    if(mysqli_num_rows($result_set2)!=0){
                                            while($row2 = mysqli_fetch_array($result_set2)) {
                                            
                                                    $query = "update task_document_header_table set task_state = 20 where TID = ".$row2['TID'].";";
		                                            mysqli_query($conn,$query);
                                            
                                            }
                                    }


        }



        $_SESSION['current_focused_TID'] = $target_tid;
		echo "<script> opener.location.reload(); </script>";
		echo "<script>window.location.href='su_script_user_personal_detail_interface_b.php?tid=".$target_tid."'</script>";



?>


