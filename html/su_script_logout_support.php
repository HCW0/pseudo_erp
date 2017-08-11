<?php  
        session_start();


// include function
     function my_autoloader($class){
         include './classes/'.$class.'.php';
    }

 spl_autoload_register('my_autoloader');


//db 연결 파트
        $conn = mysqli_connect('localhost','root','9708258a');
        if(!$conn) { $_SESSION['msg']='DB연결에 실패하였습니다.';
                     header('Location: ./su_script_login_interface.php');
        }
        $use = mysqli_select_db($conn,"suproject");
        if(!$use) die('cannot open db'.mysqli_error($conn));

        unset($_SESSION['is_login']);  
       session_destroy();
       session_start();
        $_SESSION['msg'] = 'log out!';
         header('Location: ./su_script_login_interface.php');   

                        
?>