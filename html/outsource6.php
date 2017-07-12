  <?php
       session_start();


            $_SESSION['current_personal_base_date'] = $_POST['task_select_box'][0];
            $_SESSION['current_personal_limit_date'] = $_POST['task_select_box'][1];
            $_SESSION['current_personal_task_level_code'] = $_POST['task_select_box'][2];
            $_SESSION['current_personal_task_level_sub_code'] = $_POST['task_select_box'][3];
            $_SESSION['current_personal_task_orderer'] = $_POST['task_select_box'][4];
			$_SESSION['current_personal_task_priority'] = $_POST['task_select_box'][5];
			$_SESSION['current_personal_task_state'] = $_POST['task_select_box'][6];


             header('location: ./su_script_user_personal_interface.php');

    ?>

