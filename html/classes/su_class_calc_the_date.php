<?php

    class su_class_calc_the_date{

            function su_function_convert_this_week_begin($date_string){

                      $day_o_week = date('w', strtotime($date_string));
                      return date("Y-m-d", strtotime($date_string."-".$day_o_week."day"));


            }
            
            function su_function_convert_this_week_end($date_string){

                      $day_o_week = date('w', strtotime($date_string));
                      $day_o_week = 6 - $day_o_week;
                      return date("Y-m-d", strtotime($date_string."+".$day_o_week."day"));


            }
                        
            function su_function_convert_this_month_begin($date_string){

                        $year = date('Y', strtotime($date_string));
                        $month = date('m', strtotime($date_string));

                        $start = date("Y-m-d", mktime(0, 0, 0, $month , 1, $year)); 

                        return $start;


            }
                                    
            function su_function_convert_this_month_end($date_string){

                        $year = date('Y', strtotime($date_string));
                        $month = date('m', strtotime($date_string));

                        $end = date("Y-m-d", mktime(0, 0, 0, $month+1 , 0, $year)); 

                        return $end;


            }

                                    
            function su_function_convert_this_year_begin($date_string){

                        $year = date('Y', strtotime($date_string));
                        $month = 1;

                        $start = date("Y-m-d", mktime(0, 0, 0, $month , 1, $year)); 

                        return $start;


            }
                                              
            function su_function_convert_this_year_end($date_string){

                        $year = date('Y', strtotime($date_string));
                        $month = 12;

                        $end = date("Y-m-d", mktime(0, 0, 0, $month+1 , 0, $year)); 

                        return $end;


            }

    }

?>