  <?php
       session_start();


            $_SESSION['current_base_date'] = $_POST['task_select_box'][0];
            $_SESSION['current_limit_date'] = $_POST['task_select_box'][1];
            $_SESSION['current_task_level_code'] = $_POST['task_select_box'][2];
            $_SESSION['current_task_level_sub_code'] = $_POST['task_select_box'][3];
			$_SESSION['current_task_order_section'] = $_POST['task_select_box'][4];
            $_SESSION['current_task_orderer'] = $_POST['task_select_box'][5];
			$_SESSION['current_task_priority'] = $_POST['task_select_box'][6];
			$_SESSION['current_task_state'] = $_POST['task_select_box'][7];


             header('location: ./su_script_user_interface.php');

    ?>

