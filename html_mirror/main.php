<?php
    session_start();
        
    $ip_address=$_SERVER["SERVER_ADDR"];
    if($ip_address=='127.0.0.1') $ip_address = 'localhost';
    $ip_port=$_SERVER["SERVER_PORT"];
    $_SESSION['now_date'] = date("Y-m-d");
    $_SESSION['root'] = "http://$ip_address:$ip_port/";
    $_SESSION['root_no_wrapper'] = "$ip_address:$ip_port/";
    
    header("location: ".$_SESSION['root']."module/login/su_script_login_interface.php");





?>