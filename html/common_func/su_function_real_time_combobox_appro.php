  <?php
       session_start();
       $var = $_GET['var'];
       $index = $_GET['index'];



       switch($index){

        case 0 :
           $_SESSION['current_ap_task_level_code']=$var;
            $_SESSION['current_ap_task_level_sub_code'] = 999;
            echo "case  0";
            echo "<br />";
           break;
        case 1 :
           $_SESSION['current_ap_task_level_sub_code']=$var;
           echo "case  1";
                       echo "<br />";
           break;
        case 2 :
           $_SESSION['current_ap_task_orderer']=$var;
           echo "case  2";
                       echo "<br />";
           break;
        case 3 :
           $_SESSION['current_ap_task_priority']=$var;
           echo "case  3";
                       echo "<br />";
           break;
        case 4 :
           $_SESSION['current_ap_task_state']=$var;
           echo "case  4";
                       echo "<br />";
           break;
        case 5 :
           $_SESSION['current_ap_base_date']=$var;
           echo "case  5";
                       echo "<br />";
           break;
        case 6 :
           $_SESSION['current_ap_limit_date']=$var;
           echo "case  6";
                       echo "<br />";
           break;
        case 7 :
           $_SESSION['current_ap_task_detail_state']=$var;
           echo "case  6";
                       echo "<br />";
           break;
       

       }



       //debug section
       echo $_SESSION['current_ap_task_level_code'];
                   echo "<br />";
       echo $_SESSION['current_ap_task_level_sub_code'];
                   echo "<br />";
       echo $index;
                   echo "<br />";
       header("location: ".$_SESSION['root']."/su_script_approbation_interface.php");

    ?>
