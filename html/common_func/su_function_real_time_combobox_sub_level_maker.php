  <?php
       session_start();
       $var = $_GET['var'];
       $index = $_GET['index'];
       

       echo $_SESSION['hold_level'];
       
      switch($index){

          case 0 : 
              $_SESSION['hold_level']=$var;
              $_SESSION['sub_hold_level']=1;
              $_SESSION['new_sub_level_awaked']=1;
              break;

          case 1 :
              $_SESSION['sub_hold_level']=$var;
              
              if($_SESSION['sub_hold_level']=='new'){
                  $_SESSION['new_sub_level_awaked']=2;
              }else{
                  $_SESSION['new_sub_level_awaked']=1;
              }
              break;
              

              
      }

      header("location: ".$_SESSION['root']."/su_script_table_write_personal_interface.php");
    ?>
