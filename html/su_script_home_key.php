
<?php
 session_start();

	//$addr = $_GET['home']; // 각 화면의 홈 버튼에서 지정할 수 있는 주소를 받아옴, 쓰진 않을 거지만 활용의 여지가 있다.
	unset($_SESSION['backword_flag']);




	
	echo "<script>window.open('./su_script_redirect_to_main_zone.php');</script>";
	echo "<script>self.close();</script>";


?>
    