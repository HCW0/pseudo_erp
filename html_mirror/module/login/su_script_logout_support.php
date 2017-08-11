<?php  
        session_start();
include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_class_loader.php');
include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_db_connecter.php');


             
        unset($_SESSION['is_login']);  
       session_destroy();
       session_start();
        $_SESSION['msg'] = 'log out!';
         header("Location: ".$_SESSION['root']."/main.php");   



?>