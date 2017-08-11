<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_class_loader.php');
include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_db_connecter.php');
include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_server_state_check.php');


// 객체 생성 파트 

$msg_ob = new su_class_message_handler();


//id pw 비교 파트
    
        $mquery = 'select * from account_table u where u.ID = \''.$_POST['id'].'\';';
        $result_id = mysqli_query($conn,$mquery);
        if(mysqli_num_rows($result_id)==0) echo "실패2!";

         $row = mysqli_fetch_assoc($result_id);
          $_SESSION['my_sid_code']= $row['SID'];
          $flag_Value = $row['FLAG_ACCOUNT_LOCK'];
         if($flag_Value) {
              $msg_ob->su_function_call_message($conn,155,'su_script_login_interface');
          die();   
         }


        $mquery = 'select u.PASSWORD from account_table u where u.PASSWORD = \''.$_POST['pw'].'\' AND u.ID = \''.$_POST['id'].'\';';
        $result_pw = mysqli_query($conn,$mquery);
        if(mysqli_num_rows($result_pw)==0) $result_pw=false;


if(($_POST['id']!=null)&&($_POST['pw']!=null)){

    if(($result_id)&&($result_pw)){
        $_SESSION['is_login']=true;
        $_SESSION['id']=$_POST['id'];
         header("Location: ".$_SESSION['root']."/module/login/su_script_session_info_init.php");   
    }else{
        if(($result_id)&&($result_pw==false)){
            $worker = new su_class_login_support();
            $worker->incorrect_cnt($_POST['id'],$conn,$msg_ob);
        }else{
       
         $_SESSION['msg']='존재하지 않는 계정입니다.';
         header("Location: ".$_SESSION['root']."/module/login/su_script_login_interface.php");   
        }
    }

}else{
    $_SESSION['msg']='값이 입력되지 않았습니다!';
         header("Location: ".$_SESSION['root']."/module/login/su_script_login_interface.php");   

}



?>