<?php

    class su_class_between_start_and_end{

            function su_function_between_two_sid_selectbox_format_generator($conn,$end_sid,$ob2){

                    $query = "SELECT * FROM sid_combine_table u WHERE u.SID=$end_sid;";
                    $result = mysqli_query($conn,$query);
                    $row=mysqli_fetch_array($result);
                    $end_position = $row['sid_combine_position'];
                    
                    $start_position = $_SESSION['my_position_code'];
                    $range = $end_position - $start_position;


                    if($range<=1) return; // 즉 최종결제자랑 1칸 이내인 경우, 둘 사이에 검토자가 없으므로.
                    $range--;

                    for($cnt=1;$cnt<$range;$cnt++){
                        
                                $middle_position = $_SESSION['my_position_code'] + $cnt;

                                        
										$query = "SELECT * FROM sid_combine_table u WHERE u.sid_combine_department=".$_SESSION['my_department_code']." AND u.sid_combine_position=$middle_position;";

                                        $result = mysqli_query($conn,$query); 
                                        if(mysqli_num_rows($result)==0) continue;
                                        echo"<tr>";
                                        echo"<td>";
                                        echo"중간검토자";
                                        echo"</td>";
                                        echo"<td>";
                                        echo"<select  name = '".$middle_position."layer_sid'>"; 
												 while($row=mysqli_fetch_array($result)){
                                                        
                                                        $name = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['SID'],"master_user_info_name");
                                                        echo "<option value='".$row['SID']."'>".$name."</option>";	
                                                 }
                                        echo"</select>";
                                        echo"</td>";
                                        echo"</tr>";
                    }
            }
    }

?>