<?php  
        session_start();
        unset($_SESSION['is_login']);  
        $_SESSION['msg'] = 'log out!';
         header('Location: ./su_script_login_interface.php');
?>