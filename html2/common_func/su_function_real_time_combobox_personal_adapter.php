  <?php
       session_start();
       $var = $_GET['var'];
       $index = $_GET['index'];

        // include function
            function my_autoloader($class){
                include '../classes/'.$class.'.php';
            }

        spl_autoload_register('my_autoloader');



        // class 객체 생성

        $ob4 = new su_class_calc_the_date();

       switch($index){

        case 0 :
           $_SESSION['current_personal_task_level_code']=$var;
            $_SESSION['current_personal_task_level_sub_code'] = 999;
            echo "case  0";
            echo "<br />";
           break;
        case 1 :
           $_SESSION['current_personal_task_level_sub_code']=$var;
           echo "case  1";
                       echo "<br />";
           break;
        case 2 :
           $_SESSION['current_personal_task_orderer']=$var;
           echo "case  2";
                       echo "<br />";
           break;
        case 3 :
           $_SESSION['current_personal_task_priority']=$var;
           echo "case  3";
                       echo "<br />";
           break;
        case 4 :
           $_SESSION['current_personal_task_state']=$var;
           echo "case  4";
                       echo "<br />";
           break;
        case 5 :
           $_SESSION['current_personal_base_date']=$var;
           echo "case  5";
                       echo "<br />";
           break;
        case 6 :
           $_SESSION['current_personal_limit_date']=$var;
           echo "case  6";
                       echo "<br />";
           break;
        case 7 :
           $_SESSION['radio_index']=0;
           $_SESSION['current_personal_base_date']=$ob4->su_function_convert_this_week_begin($_SESSION['now_date']);
           $_SESSION['current_personal_limit_date']=$ob4->su_function_convert_this_week_end($_SESSION['now_date']);
           echo "case  7";
                       echo "<br />";
           break;
        case 8 :
        $_SESSION['radio_index']=1;
           $_SESSION['current_personal_base_date']=$ob4->su_function_convert_this_month_begin($_SESSION['now_date']);
           $_SESSION['current_personal_limit_date']=$ob4->su_function_convert_this_month_end($_SESSION['now_date']);
           echo "case  8";
                       echo "<br />";
           break;
        case 9 :
        $_SESSION['radio_index']=2;
           $_SESSION['current_personal_base_date']=$ob4->su_function_convert_this_year_begin($_SESSION['now_date']);
           $_SESSION['current_personal_limit_date']=$ob4->su_function_convert_this_year_end($_SESSION['now_date']);
           echo "case  9";
                       echo "<br />";
           break;

        case 10 :
           $_SESSION['current_personal_dstate']=$var;
           echo "case  10";
                       echo "<br />";
           break;

        case 12 :
        $_SESSION['reserve_index']=0;
        $_SESSION['current_task_check_bottan']=!$_SESSION['current_task_check_bottan'];

           break;

        case 13 :
        $_SESSION['reserve_index']=1;
        $_SESSION['reserve_task_check_bottan']=!$_SESSION['reserve_task_check_bottan'];

           break;

        case 14 :
        $_SESSION['radio_index']=-1;
        $_SESSION['current_personal_base_date']=$_SESSION['now_date'];
        $_SESSION['current_personal_limit_date']=$_SESSION['now_date'];
        
           break;


       }



       //debug section
       echo $_SESSION['current_personal_task_level_code'];
                   echo "<br />";
       echo $_SESSION['current_personal_task_level_sub_code'];
                   echo "<br />";
       echo $index;
                   echo "<br />";
       header("location: ".$_SESSION['root']."/su_script_user_personal_interface_adapter_to_detail.php");

    ?>
