<?php


include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_user_login_check.php');
include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_class_loader.php');
include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_db_connecter.php');
include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_server_state_check.php');


// 하드 코딩된 함수 이하

function toWeekNum($get_year, $get_month, $get_day){
 $timestamp = mktime(0, 0, 0, $get_month, $get_day, $get_year);
 $w = date('w',mktime(0,0,0,date('n',$timestamp),1,date('Y',$timestamp)));
 return ceil(($w + date('j',$timestamp) - 1)/7);
}




		






?>