<html>


<?php
session_start();
    function my_autoloader($class){
         include './classes/'.$class.'.php';
    }

 spl_autoload_register('my_autoloader');
 $conn = mysqli_connect('localhost','root','9708258a');
        if(!$conn) { $_SESSION['msg']='DB연결에 실패하였습니다.';
                     header('Location: ./su_script_login_interface.php');
        }
 
        $use = mysqli_select_db($conn,"suproject");
        if(!$use) die('cannot open db'.mysqli_error($conn));


    $ob = new su_class_sid_analysis();
    $ob->su_function_sid_analysis($conn, $_SESSION['my_sid_code']);
    echo $_SESSION['my_department_code'];
    echo $_SESSION['my_position_code'];
    echo $_SESSION['my_sid_code'];

    $ip_address=$_SERVER["SERVER_ADDR"];
    if($ip_address=='127.0.0.1') $ip_address = 'localhost';
    $ip_port=$_SERVER["SERVER_PORT"];
    $_SESSION['now_date'] = date("Y-m-d");
    $_SESSION['root'] = "http://$ip_address:$ip_port/";
    if($ip_address=='127.0.0.1') $ip_address = 'localhost';

    header('Location: ./test2.php');
  
 
?>
