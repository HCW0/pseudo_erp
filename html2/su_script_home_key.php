
<?php
 session_start();

	$addr = $_GET['home'];
	unset($_SESSION['backword_flag']);

	echo "<script>window.open('./test.php');";
	echo "self.close()</script>"











?>
    