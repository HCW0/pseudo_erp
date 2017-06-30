<?php
session_start();


//db 연결 파트
        $conn = mysqli_connect('localhost','root','9708258a');
        if(!$conn) { $_SESSION['msg']='DB연결에 실패하였습니다.';
                     header('Location: ./login.php');
        }

//id pw 비교 파트
        $use = mysqli_query($conn,"use suproject");
        if(!$use) echo "실패1!";

        $mquery = 'select u.ID from account_table u where u.ID = \''.$_POST['id'].'\';';
      // echo $mquery;
        $result_id = mysqli_query($conn,$mquery);
        if(mysqli_num_rows($result_id)==0) echo "실패2!";
        
        $mquery = 'select u.PASSWORD from account_table u where u.PASSWORD = \''.$_POST['pw'].'\' AND u.ID = \''.$_POST['id'].'\';';
      // echo $mquery;
        $result_pw = mysqli_query($conn,$mquery);
        if(mysqli_num_rows($result_pw)==0) $result_pw=false;


if(($_POST['id']!=null)&&($_POST['pw']!=null)){

    if(($result_id)&&($result_pw)){
        $_SESSION['is_login']=true;
        $_SESSION['id']=$_POST['id'];
        header('Location: ./test.php');
    }else{
         $_SESSION['msg']='invalid input';
        header('Location: ./login.php');
    }

}else{
    $_SESSION['msg']='값이 입력되지 않았습니다!';
    header('Location: ./login.php');
}

?>