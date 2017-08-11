  <?php
       session_start();
       $var = $_GET['var'];
       $index = $_GET['index'];
       

       echo $_SESSION['hold_level'];
       
      switch($index){

          case 0 : 
              $_SESSION['hold_level']=$var;
              break;

          case 1 :
              $_SESSION['sub_hold_level']=$var;
              break;


      }

             header("location: ".$_SESSION['root']."module/task_management/detail_page/write/su_script_table_write_interface.php");

    ?>
