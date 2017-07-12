  <?php
       session_start();

 
           
            if(isset($_SESSION['depth_position_offset'])){
		
		              $_SESSION['depth_position_offset']++;

          	};

            if(isset($_SESSION['current_personal_detail_task_orderer'])){

						      $_SESSION['current_personal_detail_task_orderer'] = 8388607;

		        };
        

             header('location: ./su_script_user_personal_detail_interface.php');

    ?>
