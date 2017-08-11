
<?php
 session_start();

	$addr = $_GET['home'];


	echo "<script>window.open('".$_SESSION['root']."module/login/su_script_session_info_init.php');";
	echo "self.close();</script>";


?>
    