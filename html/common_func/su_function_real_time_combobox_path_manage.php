  <?php
       session_start();
       $var = $_GET['var'];
       $index = $_GET['index'];



       switch($index){

        case 0 :
           $_SESSION['current_department_of_management_path']=$var;
            $_SESSION['current_sid_of_management_path'] = -1;
            echo "case  0";
            echo "<br />";
           break;
        case 1 :
           $_SESSION['current_sid_of_management_path']=$var;
           echo "case  1";
                       echo "<br />";
           break;

       

       }
       echo 'var';
    echo $var;
            echo "<br />";
            echo 'index';
    echo $index;
            echo "<br />";
            echo '세션 부서';
    echo $_SESSION['current_department_of_management_path'];
            echo "<br />";
            echo '세션 sod';
    echo $_SESSION['current_sid_of_management_path'];
            echo "<br />";


       header("location: ".$_SESSION['root']."/su_script_approbation_management_interface.php");

    ?>
