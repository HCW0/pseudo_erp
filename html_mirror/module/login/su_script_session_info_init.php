<html>


<?php
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_class_loader.php');
include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_db_connecter.php');


    $ob = new su_class_sid_analysis();
    $ob->su_function_sid_analysis($conn, $_SESSION['my_sid_code']);

	$ob2 = new su_class_value_name_convert_with_code();
	$_SESSION['my_name'] = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$_SESSION['my_sid_code'],"master_user_info_name");
	$_SESSION['my_position'] = $ob2->su_function_convert_name($conn,"master_position_info_table","sid_combine_position",$_SESSION['my_position_code'],"master_position_info_name");
	$_SESSION['my_department'] = $ob2->su_function_convert_name($conn,"master_department_info_table","sid_combine_department",$_SESSION['my_department_code'],"master_department_info_name");


	$link = $_SESSION['root']."module/pop_up/su_script_pop_up_notice.php";
    header("location: $link");
  
 
?>
