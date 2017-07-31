<?php

    class su_class_value_combine_combobox_value_to_mysql_query{

            function su_function_combine_query_to_task_header_table($level,$sub_level,$order_dpt,$orderer,$priority,$state,$base_date,$limit_date){

                    $query_head = 'select * from task_document_header_table u where ';

                    
                    $query_where_level = $level!=15 ? "u.task_level_code = $level AND " : "";
                    $query_where_sub_level = $sub_level!=999 ? "u.task_level_sub_code = $sub_level AND ": "";
                    $query_where_order_dpt = $order_dpt!=15 ? "u.task_order_section = $order_dpt AND ": "";
                    $query_where_orderer = $orderer!=8388607 ? "u.task_orderer = $orderer AND ": "";
                    $query_where_state = $state!=99 ? "u.task_state = $state AND " :  "";
                    $query_where_base_date = $base_date!="" ? "u.task_base_date >= '$base_date' AND ": "";
                    $query_where_limit_date = $limit_date!="" ? "u.task_limit_date <= '$limit_date' AND ": "";
                    $query_where_priority = $priority!=3 ? "u.task_priority = $priority ": "(u.task_priority = 0 OR u.task_priority = 1)";
                        $query_where_semi_colon = ";";
                      
                      return $query_head.$query_where_level.$query_where_sub_level.$query_where_order_dpt.$query_where_orderer.$query_where_state.$query_where_base_date.$query_where_limit_date.$query_where_priority.$query_where_semi_colon;

            }

            function su_function_combine_query_to_task_header_table_spaghetti_wo_kiwameru($level,$sub_level,$order_dpt,$orderer,$priority,$state,$dstate){

                    $query_head = "select * from task_document_header_table u where ";
                    if($_SESSION['current_task_check_bottan']&&$_SESSION['reserve_task_check_bottan']){
                                                                 $query_reserve = " ";
                    }else if($_SESSION['current_task_check_bottan']&&(!$_SESSION['reserve_task_check_bottan'])){
                                                                 $query_reserve = " u.reserve_flag = 0 AND  ";
                    }else if((!$_SESSION['current_task_check_bottan'])&&$_SESSION['reserve_task_check_bottan']){
                                                                 $query_reserve = " u.reserve_flag = 1 AND  ";
                    }else{
                                                                 $query_reserve = "u.task_level_code==1234567 AND ";
                    }
                    
                    $query_where_level = $level!=15 ? "u.task_level_code = $level AND " : "";
                    $query_where_sub_level = $sub_level!=999 ? "u.task_level_sub_code = $sub_level AND ": "";
                    $query_where_order_dpt = $order_dpt!=15 ? "u.task_order_section = $order_dpt AND ": "";
                    $query_where_orderer = $orderer!=8388607 ? "u.task_orderer = $orderer AND ": "";
                    $query_where_state = $state!=99 ? "u.task_state = $state AND " :  "";
                    $query_where_dstate = $dstate!=99 ? "u.task_detail_state = $dstate AND " :  "";
                    $query_where_priority = $priority!=3 ? "u.task_priority = $priority ": "(u.task_priority = 0 OR u.task_priority = 1)";
                        $query_where_semi_colon = ";";
                      
                      return $query_head.$query_reserve.$query_where_level.$query_where_sub_level.$query_where_order_dpt.$query_where_orderer.$query_where_state.$query_where_dstate.$query_where_priority.$query_where_semi_colon;

            }


            function su_function_combine_query_to_task_header_table_lower_only($level,$sub_level,$order_dpt,$orderer,$priority,$state,$base_date,$limit_date){

                    $query_head = "select * from task_document_header_table u where u.task_order_position <= ".$_SESSION['my_position_code']." AND ";

                    
                    $query_where_level = $level!=15 ? "u.task_level_code = $level AND " : "";
                    $query_where_sub_level = $sub_level!=999 ? "u.task_level_sub_code = $sub_level AND ": "";
                    $query_where_order_dpt = $order_dpt!=15 ? "u.task_order_section = $order_dpt AND ": "";
                    $query_where_orderer = $orderer!=8388607 ? "u.task_orderer = $orderer AND ": "";
                    $query_where_state = $state!=99 ? "u.task_state = $state AND " :  "";
                    $query_where_base_date = $base_date!="" ? "u.task_base_date >= '$base_date' AND ": "";
                    $query_where_limit_date = $limit_date!="" ? "u.task_limit_date <= '$limit_date' AND ": "";
                    $query_where_priority = $priority!=3 ? "u.task_priority = $priority ": "(u.task_priority = 0 OR u.task_priority = 1)";
                        $query_where_semi_colon = ";";
                      
                      return $query_head.$query_where_level.$query_where_sub_level.$query_where_order_dpt.$query_where_orderer.$query_where_state.$query_where_base_date.$query_where_limit_date.$query_where_priority.$query_where_semi_colon;

            }



            function su_function_combine_query_to_task_header_table_with_depth($level,$sub_level,$order_dpt,$orderer,$priority,$state,$base_date,$limit_date){

                    $query_head = 'select * from task_document_header_table u where u.TID = u.super_task_TID AND ';

                    
                    $query_where_level = $level!=15 ? "u.task_level_code = $level AND " : "";
                    $query_where_sub_level = $sub_level!=999 ? "u.task_level_sub_code = $sub_level AND ": "";
                    $query_where_order_dpt = $order_dpt!=15 ? "u.task_order_section = $order_dpt AND ": "";
                    $query_where_orderer = $orderer!=8388607 ? "u.task_orderer = $orderer AND ": "";
                    $query_where_state = $state!=99 ? "u.task_state = $state AND " :  "";
                    $query_where_base_date = $base_date!="" ? "u.task_base_date >= '$base_date' AND ": "";
                    $query_where_limit_date = $limit_date!="" ? "u.task_limit_date <= '$limit_date' AND ": "";
                    $query_where_priority = $priority!=3 ? "u.task_priority = $priority ": "(u.task_priority = 0 OR u.task_priority = 1)";
                        $query_where_semi_colon = ";";
                      
                      return $query_head.$query_where_level.$query_where_sub_level.$query_where_order_dpt.$query_where_orderer.$query_where_state.$query_where_base_date.$query_where_limit_date.$query_where_priority.$query_where_semi_colon;

            }




            function su_function_combine_query_to_task_header_table_ms_page($level,$sub_level,$section){

                    $query_head = 'select DISTINCT * from master_task_level_sub_info_table u where ';

                    
                    $query_where_level = $level!=15 ? "u.master_task_level_code = $level AND " : "";
                    $query_where_section = $section!=15 ? "u.sub_level_order_section = $section AND " : "";
                    $query_where_sub_level = $sub_level!=999 ? "u.master_task_level_sub_code = $sub_level ": "u.master_task_level_sub_code != 999 ";
                    $query_order = "ORDER BY master_task_level_code";
                    $query_where_semi_colon = ";";
                      
                      return $query_head.$query_where_level.$query_where_section.$query_where_sub_level.$query_order.$query_where_semi_colon;

            }


            function su_function_combine_query_to_task_header_table_with_offset($level,$sub_level,$order_dpt,$orderer,$priority,$state,$base_date,$limit_date,$upper_tid){

                    $query_head = "select * from task_document_header_table u where u.super_task_TID='$upper_tid' AND ";


                    $query_where_level = $level!=15 ? "u.task_level_code = $level AND " : "";
                    $query_where_sub_level = $sub_level!=999 ? "u.task_level_sub_code = $sub_level AND ": "";
                    $query_where_order_dpt = $order_dpt!=15 ? "u.task_order_section = $order_dpt AND ": "";
                    $query_where_orderer = $orderer!=8388607 ? "u.task_orderer = $orderer AND ": "";
                    $query_where_state = $state!=99 ? "u.task_state = $state AND " :  "";
                    $query_where_base_date = $base_date!="" ? "u.task_base_date >= '$base_date' AND ": "";
                    $query_where_limit_date = $limit_date!="" ? "u.task_limit_date <= '$limit_date' AND ": "";
                    $query_where_priority = $priority!=3 ? "u.task_priority = $priority ": "(u.task_priority = 0 OR u.task_priority = 1)";
                        $query_where_semi_colon = ";";
                      
                      return $query_head.$query_where_level.$query_where_sub_level.$query_where_order_dpt.$query_where_orderer.$query_where_state.$query_where_base_date.$query_where_limit_date.$query_where_priority.$query_where_semi_colon;

            }
          

          


            
          

    }

?>