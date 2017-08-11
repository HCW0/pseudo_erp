
<?php
	session_start();


	
// 유저 세션 검증
	if(!isset($_SESSION['is_login'])){
		header('Location: ./su_script_logout_support.php');
	};


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



        $target_tid = $_GET['target'];


		$query = "update task_document_header_table set task_state = 10 where TID = $target_tid;";
       
		mysqli_query($conn,$query);
         $_SESSION['current_focused_TID'] = $target_tid;
		echo "<script> opener.location.reload(); </script>";
		echo "<script>window.location.href='su_script_user_personal_detail_interface.php'</script>";



?>


