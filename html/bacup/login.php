<!DOCTYPE html>
<html>

<?php
    session_start();
    if(isset($_SESSION['is_login'])){
        header('location: ./test.php');
    }
?>

<head>
    <meta charset="utf-8"/>
    <title>login</title>
</head>

<body>
    <h2>GOGOGOGO</h2>
    <p>Type ur account</p>

    <form action='login_proc.php' method='POST'>
        <p>ID:
        <input type = 'text' name = 'id'/></P>

        <p>PW:
        <input type = 'password' name = 'pw'/></P>

        <input type = 'submit' value = 'game' name = 'login'/>
    </form>

    <?php
        if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
        }
    ?>

</body>

</html>