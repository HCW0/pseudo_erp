<!DOCTYPE html>
<html>

<?php
    session_start();
    if(isset($_SESSION['is_login'])){
        header("location: ".$_SESSION['root']."/module/login/su_script_session_info_init.php");
    }
?>



<head>

    <meta charset="utf-8"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	
    <title>login</title>
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width, height=device-height">
       
        <script type="text/javascript"> 

            // 주소창 자동 닫힘 
            window.addEventListener("load", function(){ 
            setTimeout(loaded, 100); 

            }, false); 

            function loaded(){ 
            window.scrollTo(0, 1); 
            } 

        </script> 

</head>



<body>
    <div style="width:200px; height:100px;"></div>

	<p align="center"><img src=<?php echo $_SESSION['root']."src/su_rsc_sulogo.png"; ?> width="200" height="200" title="선운로고"/></p>
    
    
    <form  action='./su_script_login_process.php' method='POST'>
        <p align="center" >ID:
        <input type = 'text' name = 'id'/></P>

        <p align="center">PW:
        <input   type = 'password' name = 'pw'/></P>

        <p align="center"> <input  type = 'submit' value = 'Login' name = 'login'/></p>
    </form>



    <?php
        if(isset($_SESSION['msg'])){
                echo '<p align="center">';
                echo $_SESSION['msg'];
                echo '</p>';
                unset($_SESSION['msg']);   
        }
    ?>





	<div style="width:100px; height:100px;"></div>   
	<div id="footer"><p class="bd" align="center">COPYRIGHT(C) 2017 SUNUNENG.ENG ALL RIGHTS RESERVED 연락처 : 062-651-9272 / FAX : 062-651-9271</p></div>
</body>

</html>