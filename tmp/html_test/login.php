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
    <div style="
	width:200px; height:250px;">
	
    </div>
	<p align="center"><img src="선운로고.png" width="200" height="100" title="선운로고"/></p>
    <form  action='login_proc.php' method='POST'>
        <p align="center" >&nbsp&nbspID:
        <input type = 'text' name = 'id'/></P>

        <p align="center">PW:
        <input   type = 'password' name = 'pw'/></P>

       <p align="center"> <input  type = 'submit' value = 'login' name = 'login'/></p>
    </form>

    <?php
        if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
        }
    ?>

	<div style="
	width:200px; height:280px;">
	
    </div>
	</div id="footer">
				<p class="bd" align="center">COPYRIGHT(C) 2017 SUNUNENG.ENG ALL RIGHTS RESERVED&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp주소 : 광주광역시 광산구 송정동 735 선운빌딩 3층 <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp연락처 : 062-651-9272 / FAX : 062-651-9271</p>
		</div>
</body>

</html>