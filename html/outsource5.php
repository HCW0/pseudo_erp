
  <?php
       session_start();

            $local_depth_position = $_GET['selected_depth'];
            $level = $_GET['level'];
            $sub_level = $_GET['sub_level'];
            
            echo "검색하려는 직책 코드";
            echo "<br />";
            echo $local_depth_position;
            echo "<br />";
            echo "검색하려는 업무 코드";
            echo "<br />";
            echo $level;
            echo "<br />";
            echo "검색하려는 업무 서브 코드";
            echo "<br />";
            echo $sub_level;
            echo "<br />";
           
           
		
		              $_SESSION['depth_position_offset']=$_SESSION['my_position_code']-$local_depth_position;
                  echo $_SESSION['depth_position_offset'];

          	

                  //detail init
                  $_SESSION['current_personal_detail_task_orderer'] = 8388607;
                  $_SESSION['current_personal_detail_task_level_code'] = $level;
			            $_SESSION['current_personal_detail_task_level_sub_code'] = $sub_level;

            header('location: ./su_script_user_personal_detail_interface.php');

    ?>


