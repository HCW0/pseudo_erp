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


//php 객체 생성


    $ob2 = new su_class_value_name_convert_with_code();
    $msg_ob = new su_class_message_handler();
    

//어떤 검토자 혹은 승인자가 읽었는지 확인하기 위한 변수 index


    	if(!isset($_GET['index'])){
				$index = -1;
		}else{
				$index = $_GET['index'];
		}

    	if(!isset($_GET['fid'])){
				$fid = -1;
		}else{
				$fid = $_GET['fid'];
		}

    	if(!isset($_GET['type'])){
				$type = -1;
		}else{
				$type = $_GET['type'];
		}


    switch($type){

    case 1 :  // 검토의 경우, 해당 검토자의 view 플래그를 새운다.
        echo 1;
    	$task_table_query2 = "select * from task_approbation_table u where u.TID = $fid AND u.appro_type_flag=1;";
		$result_set2 = mysqli_query($conn,$task_table_query2);
		$row2 = mysqli_fetch_array($result_set2);

        $target_aid = $row2['AID'];
        $target_field_name = $index."_layer_view_flag";
        $update_query = "update task_approbation_table set $target_field_name = 1 where AID = $target_aid;";
        mysqli_query($conn,$update_query);

    break;


    case 2 :  // 승인의 경우, 해당 공문의 상태를 변화 시킨다.
        echo 2;
        $update_query = "update former_document_header_table set appro_state = 70 where former_id = $fid;";
        mysqli_query($conn,$update_query);

    break;


    case 3 :  // 반려의 경우, view 플래그를 초기화 시킨다. 그리고 수정 상태로 돌린다.
        echo 3;
        for($cnt=1;$cnt<8;$cnt++){
                $task_table_query2 = "select * from task_approbation_table u where u.TID = $fid AND u.appro_type_flag=1;";
                $result_set2 = mysqli_query($conn,$task_table_query2);
                $row2 = mysqli_fetch_array($result_set2);

                $target_aid = $row2['AID'];
                $target_field_name = $cnt."_layer_view_flag";
                $update_query = "update task_approbation_table set $target_field_name = 0 where AID = $target_aid;";
                mysqli_query($conn,$update_query);

        }

                $update_query = "update former_document_header_table set appro_state = 5 where former_id = $fid;";
                mysqli_query($conn,$update_query);
    break;

    }

    echo "<script> opener.location.reload(); </script>";
    echo "<script> self.close(); </script>"; 

    
    ?>

