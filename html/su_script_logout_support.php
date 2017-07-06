<?php  
        session_start();
        unset($_SESSION['is_login']);  
       session_destroy();
       session_start();
        $_SESSION['msg'] = 'log out!';
         header('Location: ./su_script_login_interface.php');
?>