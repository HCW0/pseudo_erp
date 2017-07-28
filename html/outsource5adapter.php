
  <?php
       session_start();

           
            $level = $_GET['level'];
            $sub_level = $_GET['sub_level'];
            $master = $_GET['master'];
      
   
            echo "검색하려는 업무 코드";
            echo "<br />";
            echo $level;
            echo "<br />";
            echo "검색하려는 업무 서브 코드";
            echo "<br />";
            echo $sub_level;
            echo "<br />";
           
           
		
		             

                  //detail init
                  $_SESSION['hold_level'] = $level;
                  $_SESSION['sub_hold_level'] = $sub_level;
                  $_SESSION['task_master'] = $master;
                  
			if($_SESSION['task_master']!=$_SESSION['my_sid_code']){
				$_SESSION['current_personal_task_orderer'] = $_SESSION['my_sid_code'];
			}else{
				$_SESSION['current_personal_task_orderer'] = 8388607;
			}

                  $_SESSION['current_personal_task_level_code'] = $level;
			$_SESSION['current_personal_task_level_sub_code'] = $sub_level;
                  
                  if($sub_level==999) $_SESSION['current_personal_task_orderer']=8388607;

            header('location: ./su_script_user_personal_interface_adapter_to_detail.php');

    ?>


