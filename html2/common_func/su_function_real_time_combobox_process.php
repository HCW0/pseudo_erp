
<?php
    session_start();



// include function
     function my_autoloader($class){
         include '../classes/'.$class.'.php';
    }

 spl_autoload_register('my_autoloader');



// class 객체 생성

		$ob4 = new su_class_calc_the_date();
       

        $var = $_GET['var'];
        $index = $_GET['index'];





      switch($index){


          case 0 : 
              $_SESSION['process_hold_level']=$var;
              $_SESSION['process_sub_hold_level']=999;
              break;
              
          case 1 :
              $_SESSION['process_sub_hold_level']=$var;
              
              break;
              
          case 2 :
              $_SESSION['process_current_personal_task_priority']=$var;
              
              break;
              
          case 3 :
              $_SESSION['process_current_personal_task_state']=$var;
              
              break;

        case 7 :
           $_SESSION['process_radio_index']=0;
           $_SESSION['process_current_personal_base_date']=$ob4->su_function_convert_this_week_begin($_SESSION['now_date']);
           $_SESSION['process_current_personal_limit_date']=$ob4->su_function_convert_this_week_end($_SESSION['now_date']);
           echo "case  7";
                       echo "<br />";
           break;
        case 8 :
           $_SESSION['process_radio_index']=1;
           $_SESSION['process_current_personal_base_date']=$ob4->su_function_convert_this_month_begin($_SESSION['now_date']);
           $_SESSION['process_current_personal_limit_date']=$ob4->su_function_convert_this_month_end($_SESSION['now_date']);
           echo "case  8";
                       echo "<br />";
           break;
        case 9 :
           $_SESSION['process_radio_index']=2;
           $_SESSION['process_current_personal_base_date']=$ob4->su_function_convert_this_year_begin($_SESSION['now_date']);
           $_SESSION['process_current_personal_limit_date']=$ob4->su_function_convert_this_year_end($_SESSION['now_date']);
           echo "case  9";
                       echo "<br />";
           break;

      }

     header("location: ".$_SESSION['root']."/su_script_process_table_interface.php");
    ?>

