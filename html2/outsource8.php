  <?php
       session_start();

 


            if(isset($_SESSION['current_personal_detail_task_orderer'])){

						      $_SESSION['current_personal_detail_task_orderer'] = 8388607;

		        };
            $_SESSION['current_focused_TID'] =$_GET['offset'];
        

             header('location: ./su_script_user_personal_detail_interface.php');

    ?>
