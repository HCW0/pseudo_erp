<?php


	
// 유저 세션 검증, is_login 세션이 null이라는 것은 로그인 정보가 파기된 경우를 나타내고
// 논리적으로 해당 계정에 서비스를 지속시킬 필요가 없으므로 로그아웃 모듈로 리다이렉트 시킨다.


	if(!isset($_SESSION['is_login'])){
		header('Location: ./su_script_logout_support.php');
	};
?>
