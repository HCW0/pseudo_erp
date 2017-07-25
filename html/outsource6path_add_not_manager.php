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


            $end_user = $_POST['task_select_box'][0];
            $layer1 = $_POST['task_select_box'][1];
            $layer2 = $_POST['task_select_box'][2];
            $layer3 = $_POST['task_select_box'][3];
            $layer4 = $_POST['task_select_box'][4];
			$layer5 = $_POST['task_select_box'][5];
			$layer6 = $_POST['task_select_box'][6];
            $layer7 = $_POST['task_select_box'][7];

            if($end_user>0){
            $query = "select max(key_index) as maxkey from task_approbation_path_table u where u.sid =".$_SESSION['my_sid_code'].";";
            $result = mysqli_query($conn,$query);
           	$row=mysqli_fetch_array($result);
            $max_key = $row['maxkey'] + 1;
            $start = $_SESSION['my_sid_code'];
            

            $task_detail_table_query = "Insert into task_approbation_path_table(SID,key_index,end_user_sid) Values($start,$max_key,$end_user);";
            mysqli_query($conn,$task_detail_table_query);
            echo $task_detail_table_query;
            $min = 10000;

            if($layer7!=-1){
                     $task_detail_table_layer7 = "update task_approbation_path_table set 7_layer_aida_sid = $layer7 where SID = $start AND key_index = $max_key";
                     mysqli_query($conn,$task_detail_table_layer7);
                     echo $task_detail_table_layer7;
                     $min=7;
            }
            if($layer6!=-1){
                     $task_detail_table_layer6 = "update task_approbation_path_table set 6_layer_aida_sid = $layer6 where SID = $start AND key_index = $max_key";
                     mysqli_query($conn,$task_detail_table_layer6);
                     echo $task_detail_table_layer6;
                     $min=6;
            }
            if($layer5!=-1){
                     $task_detail_table_layer5 = "update task_approbation_path_table set 5_layer_aida_sid = $layer5 where SID = $start AND key_index = $max_key";
                     mysqli_query($conn,$task_detail_table_layer5);
                     echo $task_detail_table_layer5;
                     $min=5;
            }
            if($layer4!=-1){
                     $task_detail_table_layer4 = "update task_approbation_path_table set 4_layer_aida_sid = $layer4 where SID = $start AND key_index = $max_key";
                     mysqli_query($conn,$task_detail_table_layer4);
                     echo $task_detail_table_layer4;
                     $min=4;
            }
            if($layer3!=-1){
                     $task_detail_table_layer3 = "update task_approbation_path_table set 3_layer_aida_sid = $layer3 where SID = $start AND key_index = $max_key";
                     mysqli_query($conn,$task_detail_table_layer3);
                     echo $task_detail_table_layer3;
                     $min=3;
            }
            if($layer2!=-1){
                     $task_detail_table_layer2 = "update task_approbation_path_table set 2_layer_aida_sid = $layer2 where SID = $start AND key_index = $max_key";
                     mysqli_query($conn,$task_detail_table_layer2);
                     echo $task_detail_table_layer2;
                     $min=2;
            }
            if($layer1!=-1){
                     $task_detail_table_layer1 = "update task_approbation_path_table set 1_layer_aida_sid = $layer1 where SID = $start AND key_index = $max_key";
                     mysqli_query($conn,$task_detail_table_layer1);
                     echo $task_detail_table_layer1;
                     $min=1;
            }
            if($min!=10000){
                     $task_detail_table_layer1 = "update task_approbation_path_table set min_sid = $min where SID = $start AND key_index = $max_key";
                     mysqli_query($conn,$task_detail_table_layer1);
            }
            }
            echo "<script>window.resizeTo(675,575);";
            echo "window.location.href = './su_script_table_write_interface.php';</script>";

    ?>

