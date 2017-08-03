<?php

    class su_class_db_view_generator{





            function su_function_throw_view_query($conn,$query,$view_name){

                    // vidw parameter context
                    //
                    // CREATE VIEW viewname AS
                    // -> SELECT + FROM + WHERE +;




                          $ref_query = "DROP VIEW IF EXISTS $view_name;";
                          mysqli_query($conn,$ref_query);
                          $result = mysqli_query($conn,$query);
                          $this->su_function_throw_table_name($conn,$view_name);

            }


            function su_function_throw_table_name($conn,$table_name){









                $script_serial_string_zoku_triple_s = "<table>";

                    $query_of_gathering_field = "SHOW COLUMNS FROM $table_name"; 
                    $result = mysqli_query($conn,$query_of_gathering_field);
                    $length = mysqli_num_rows($result);


                $script_serial_string_zoku_triple_s = $script_serial_string_zoku_triple_s."<tr class='subject'>";

                        for($cnt = 0 ; $cnt < $length ; $cnt++){
                            
                             $row=mysqli_fetch_array($result);
                 $script_serial_string_zoku_triple_s = $script_serial_string_zoku_triple_s."<th>".$row[0]."</th>";
                            
                            }


                 $script_serial_string_zoku_triple_s = $script_serial_string_zoku_triple_s."</tr>";


                    $query_of_gathering_entity = "SELECT * FROM $table_name";
                    $result = mysqli_query($conn,$query_of_gathering_entity);


                    while($row=mysqli_fetch_array($result)){
     
                $script_serial_string_zoku_triple_s = $script_serial_string_zoku_triple_s."<tr class='data'>";

                        for($cnt = 0 ; $cnt < $length ; $cnt++){
                 $script_serial_string_zoku_triple_s = $script_serial_string_zoku_triple_s."<td>".$row[$cnt]."</td>";
                        }


                 $script_serial_string_zoku_triple_s = $script_serial_string_zoku_triple_s."</tr>";
                        
                    }
                    
                 $script_serial_string_zoku_triple_s = $script_serial_string_zoku_triple_s."</table>";

                
                return $script_serial_string_zoku_triple_s;

                //echo "$('.search_Views').append('$script_serial_string_zoku_triple_s');";

        
            }

         
    }

?>