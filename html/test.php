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


    $ob1 = new su_class_sid_analysis();
    $ob1->su_function_sid_analysis($conn,123);
    echo $_SESSION['my_name'];
    echo $_SESSION['my_department'];
    echo $_SESSION['my_position'];
   header('Location: ./su_script_user_interface.php');
  
 
?>


<head></head>

<body>
    <form action='./su_script_login_interface.php' method='post'>

        <input type='submit' value='logout' name='out_process'>
        <?php  
        


        unset($_SESSION['is_login']);  
        $_SESSION['msg'] = 'log out!';
        ?>
    </form>
    </body>


</html>