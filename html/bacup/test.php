<html>

<head></head>

<body>
    <form action='login.php' method='post'>

        <input type='submit' value='logout' name='out_process'>
        <?php  
        session_start();  
        unset($_SESSION['is_login']);  
        $_SESSION['msg'] = 'log out!';
        ?>
    </form>
    </body>


</html>