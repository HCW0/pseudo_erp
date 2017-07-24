<?php

    class su_class_folder_table_manager{

            function su_function_is_have_extra_task($conn,$ob3,$TID,$count){
                     // parameter
                     // conn은 데이터베이스 연결 객체
                     // ob3은 질의 관련 클래스의 인스턴스
                     // TID는 하위 업무 검색할 key
                     // count는 해당 함수가 몇 번째 재귀호출 되었는지 나타냄.
                     // 기본적으로 su~script~process_table_interface에서 호출되며 호출할 때는 count 인자를 0으로 넘겨준다.


                      $query = "select * from task_document_header_table u where u.TID != u.super_task_TID AND u.super_task_TID = $TID";

                      $result_set = mysqli_query($conn,$query);
                      if(mysqli_num_rows($result_set)==0) return false;
                      return true;
            }

            function su_recruit_function_make_tree($conn,$ob3,$TID,$count){
                     // parameter
                     // conn은 데이터베이스 연결 객체
                     // ob3은 질의 관련 클래스의 인스턴스
                     // TID는 하위 업무 검색할 key
                     // count는 해당 함수가 몇 번째 재귀호출 되었는지 나타냄.
                     // 기본적으로 su~script~process_table_interface에서 호출되며 호출할 때는 count 인자를 0으로 넘겨준다.


                      $query = "select * from task_document_header_table u where u.TID != u.super_task_TID AND u.super_task_TID = $TID";

                      $result_set = mysqli_query($conn,$query);
                      if(mysqli_num_rows($result_set)==0) return; 

                                            						echo"<tr>";
                                                                        echo"<td width=25%>하위업무</td>";
                                                                        echo"<th width=25% colspan=2>과업기간</th>";
                                                                        echo"<td width=15%>수행일수</td>";
                                                                        echo"<td width=35%>진행률</td>";
                                                                    echo"</tr>";

                                            while($row = mysqli_fetch_array($result_set)) {
                                                            echo "<tr>";
                                                                echo "<td>";
                                                                    echo"<a href='#' onclick='hrefClick_of_sub_task(".$row['task_level_code'].','.$row['task_level_sub_code'].','.$row['TID'].");'/>"; echo $row['task_name'];
                                                                
                                                                echo "</td>";


                                                                echo "<td>";
                                                                    echo $row['task_base_date'];
                                                                echo "</td>";
                                                                echo "<td>";
                                                                    echo $row['task_limit_date'];
                                                                echo "</td>";

                                                                
                                                                echo "<td>";
                                                                    $tmp = strtotime($row['task_elapsed_limit_date'])-strtotime($row['task_base_date']);
                                                                    echo $tmp/86400;
                                                                    
                                                                echo "</td>";
                                                                echo "<td>";
                                                                    $sup = strtotime($_SESSION['now_date'])-strtotime($row['task_base_date']);
                                                                    $sub = strtotime($row['task_limit_date'])-strtotime($row['task_base_date']);
                                                                    if($sub==0){
                                                                        $rate = 100;				 
                                                                    }else{
                                                                        $rate = $sup/$sub;
                                                                        $rate = $rate*100;

                                                                        $rate = $rate >100 ? 100 : $rate;
                                                                        $rate = $rate <0 ? 0 : $rate;
                                                                    }

                                                                        $rate_elapse = $this->su_recruit_function_calc_elapse_rate($conn,$ob3,$row['TID']);
                                                                        if($rate_elapse > $rate) $rate = $rate_elapse;

                                                                echo "<div class='graph'>";
                                                                echo "<strong class='bar' style='width: ".round($rate)."%;'>".round($rate,1)."%</strong>";
                                                                echo "<strong class='bar2' style='width: ".round($rate_elapse)."%;'>".round($rate_elapse,1)."%</strong>";						
                                                                echo "</div>";
                                                                echo "</td>";
                                                                echo "</tr>";



                                                            
									if($this->su_function_is_have_extra_task($conn,$ob3,$row['TID'],0)){
										echo"<tr>";
										echo"<td colspan=6>";
									 	echo"<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';>"; 
										echo"<div style='background-color:#FFF'><font color='black' /> &nbsp▼</div>";
										echo"</a><DIV style='display:none';>";
										echo"<table style='background-color:#DDD'>";
										$this->su_recruit_function_make_tree($conn,$ob3,$row['TID'],0);
										echo"</table>";
										
                                 		echo"</DIV>";
										echo"</td>";
										echo"</tr>";
									}else{
										echo"<tr>";
										echo"<td colspan=6>";
										echo"<div><font color='black' /> &nbsp▽</div>";
										echo"</td>";
										echo"</tr>";
									}
                                                        

                                        }
                                 

            }
            function su_recruit_function_calc_elapse_rate($conn,$ob3,$TID){

                   
                    $_SESSION['sum_sub_span']=0;
                    $_SESSION['result']=0;
                    

                    $this->su_recruit_function_calc_elapse_rate_sub($conn,$ob3,$TID);

                      if($_SESSION['sum_sub_span']==0){

                                if($_SESSION['result']==0){
                                        $sol=1;
                                }else{
                                        $sol=0;
                                }

                      }else{
                       $sol = $_SESSION['result']/$_SESSION['sum_sub_span'];
                      }
                      

                       return $sol * 100;
                       		
            }


 function su_recruit_function_calc_elapse_rate_sub($conn,$ob3,$TID){

          
                      $query = "select * from task_document_header_table u where u.TID != u.super_task_TID AND u.super_task_TID = $TID"; 
                      $result_set = mysqli_query($conn,$query);
                      if(mysqli_num_rows($result_set)==0){

                            		$task_table_query2 = "select * from task_document_header_table u where u.TID = $TID";
									$result_set2 = mysqli_query($conn,$task_table_query2);
									$row2 = mysqli_fetch_array($result_set2);

                                                
												$sup_elapse = strtotime($row2['task_elapsed_limit_date'])-strtotime($row2['task_base_date']);
												$sub = strtotime($row2['task_limit_date'])-strtotime($row2['task_base_date']);
												

                                                $_SESSION['sum_sub_span'] = $_SESSION['sum_sub_span'] + $sub;
                                                $_SESSION['result'] =  $_SESSION['result'] + $sup_elapse;
                                                /* debug
                                                echo $sub;
                                                echo "<br />";
                                                echo $sup_elapse;
                                                echo "<br />";
                                                */
                                        return;
												
                      }else{
                            while($row = mysqli_fetch_array($result_set)) {
                                    $this->su_recruit_function_calc_elapse_rate_sub($conn,$ob3,$row['TID']);
                            }
                            return;
                      }
                       		
            }




            

    }

?>