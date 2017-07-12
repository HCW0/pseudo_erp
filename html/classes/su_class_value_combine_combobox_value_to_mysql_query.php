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

            function su_function_combine_query_to_task_header_table_with_offset($level,$sub_level,$order_dpt,$orderer,$priority,$state,$base_date,$limit_date){
                    $offset = $_SESSION['my_position_code'] - $_SESSION['depth_position_offset'];
                    $query_head = "select * from task_document_header_table u where u.task_order_position = ".$offset." AND ";


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