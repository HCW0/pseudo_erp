
  <?php
       session_start();


            $level = $_GET['level'];
            $sub_level = $_GET['sub_level'];
            $tid = $_GET['tid'];
            


            echo "검색하려는 업무 코드";
            echo "<br />";
            echo $level;
            echo "<br />";
            echo "검색하려는 업무 서브 코드";
            echo "<br />";
            echo $sub_level;
            echo "<br />";
           

          	

                  //detail init
                  $_SESSION['current_personal_detail_task_orderer'] = 8388607;
                  $_SESSION['current_personal_detail_task_level_code'] = $level;
			$_SESSION['current_personal_detail_task_level_sub_code'] = $sub_level;
                  $_SESSION['current_focused_TID'] = $tid;
                  

            header('location: ./su_script_user_personal_detail_interface.php');

    ?>


