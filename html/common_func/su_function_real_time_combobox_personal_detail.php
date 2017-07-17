  <?php
       session_start();
       $var = $_GET['var'];
       $index = $_GET['index'];



       switch($index){

       
        case 2 :
           $_SESSION['current_personal_detail_task_orderer']=$var;
           echo "case  2";
                       echo "<br />";
           break;



       }



       //debug section
       echo $_SESSION['current_personal_task_level_code'];
                   echo "<br />";
       echo $_SESSION['current_personal_task_level_sub_code'];
                   echo "<br />";
       echo $index;
                   echo "<br />";
       header("location: ".$_SESSION['root']."/su_script_user_personal_detail_interface.php");

    ?>
