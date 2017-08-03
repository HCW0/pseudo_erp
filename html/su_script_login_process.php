<?php
session_start();


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
// 객체 생성
       

// 서버 점검 확인 파트
        $msg_ob = new su_class_message_handler();
         $flag = 'shut_down';
         $mquery = 'select * from server_state_table u where u.FLAG_NAME = \''.$flag.'\';';
         $result_set = mysqli_query($conn,$mquery);
         $row = mysqli_fetch_assoc($result_set);
         $flag_Value = $row['FLAG_VALUE'];
         if($flag_Value) {
              
              $msg_ob->su_function_call_message($conn,334,'su_script_login_interface');
         
          die();   
         }




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
        header("Location: ./test.php");
    }else{
        if(($result_id)&&($result_pw==false)){
            $worker = new su_class_login_support();
            $worker->incorrect_cnt($_POST['id'],$conn,$msg_ob);
        }else{
       
         $_SESSION['msg']='존재하지 않는 계정입니다.';
    
        header('Location: ./su_script_login_interface.php');
        }
    }

}else{
    $_SESSION['msg']='값이 입력되지 않았습니다!';
  
    header('Location: ./su_script_login_interface.php');
}



?>