<!DOCTYPE html>

<html>

<?php
    session_start();
	include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_combine_box.php');


// class 객체 생성

		$ob1 = new su_class_task_table_config();
		$ob2 = new su_class_value_name_convert_with_code();
		$ob3 = new su_class_value_combine_combobox_value_to_mysql_query();
		$UI_form_ob = new su_class_UI_format_generator();		


		//임시코드

		if(isset($_SESSION['current_ap_task_level_code'])==false){
			$_SESSION['current_ap_base_date']=$_SESSION['now_date'];
			$_SESSION['current_ap_limit_date']=$_SESSION['now_date'];
			$_SESSION['current_ap_task_level_code'] = 15;
			$_SESSION['current_ap_task_level_sub_code'] =999;
			$_SESSION['current_ap_task_order_section'] = 15;
			$_SESSION['current_ap_task_orderer'] = 8388607;
			$_SESSION['current_ap_task_priority'] = 3;
			$_SESSION['current_ap_task_state'] = 99;
		}



		
?>


	<head>
		<title>test</title>
		<meta charset="utf-8" />
		
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php 	include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_include_jquery.php'); ?>
	
	
<style>
  table {
    width: 100%;
    border-top: 1px solid #444444;
    border-collapse: collapse;
  }
  th {
    border-bottom: 1px solid #444444;
    padding: 1px;
    text-align: center;
  }
  td {
    border-bottom: 1px solid #444444;
    padding: 1px;
    text-align: center;
  }
  #left{
	  text-align: left;

  }

  th:nth-child(2n), td:nth-child(2n) {
    background-color: #;
  }
  th:nth-child(2n+1), td:nth-child(2n+1) {
    background-color: #;
  }
  
  
  .fixed-table-container {
        width: 1300px;
        height: 150px;
        border: 1px solid #000;
        position: relative;
        padding-top: 30px; /* header-bg height값 */
    }
    .header-bg {
        background: skyblue;
        height: 30px; /* header-bg height값 */
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        border-bottom: 1px solid #000;
    }
	.foot-bg {
        background: skyblue;
        height: 20px; /* header-bg height값 */
        position: absolute;
        bottom: 0;
        right: 0;
        left: 0;
        border-bottom: 1px solid #000;
    }
    .table-wrapper {
        overflow-x: hidden;
        overflow-y: auto;
        height: 100%;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    td {
        border-bottom: 1px solid #ccc;
        padding: 5px;
    }
    td + td {
        border-left: 1px solid #ccc;
    }
    th {
        padding: 0px; /* reset */
    }
    .th-text {
        position: absolute;
        top: 0;
        width: inherit;
        line-height: 30px; /* header-bg height값 */
        border-left: 1px solid #000;
    }
	.th-text2 {
        position: absolute;
        bottom: 0;
        width: inherit;
        line-height: 20px; /* header-bg height값 */
        border-left: 1px solid #000;
    }
    th:first-child .th-text {
        border-left: none;
    }
	#wrapper{
	  padding: 0px 0px 0px 70px;
  }
</style>

<script language="javascript">
				window.resizeTo(screen.availWidth/1.29,screen.availHeight*0.36); // 지정한 크기로 변한다.(가로,세로)
				//window.resizeBy(500,500); // 지정한 크기만큼 더하거나 빼져서 변한다.
 </script>



	<script>               /*달력 함수*/
         $(function() {
            $("#datepicker1, #datepicker2").datepicker({
               dateFormat: 'yy-mm-dd'
            });
         });

    </script>

  </head>
	<body>

	
	<header>
		
	<div id="wrapper" style="width:100%" "height:150px">

				<?php
					//$UI_form_ob->su_function_get_title('결제 경로 관리 화면',$_SESSION['my_name'],$_SESSION['my_position'],$_SESSION['my_department'],'su_script_user_personal_interface');
				?>




				<div style="padding:20px 0px 20px 0px;">

						<div>부서명
							<?php 
								echo $ob2->su_function_convert_name($conn,"master_department_info_table","sid_combine_department",$_SESSION['my_department_code'],"master_department_info_name");														
							?>
						</div>

						<div>유저명
							<?php
								echo $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$_SESSION['my_sid_code'],"master_user_info_name");														
      						?>          
   							</select>	
						</div>

				</div>





				<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:150px; overflow:auto">
					<thead>
				

					<table>
						<tr>
						<th width="12%" text-align="center">
						<div class="th-text">최종결제자</div>
						</th>
						<th width="11%" text-align="center">
							<div class="th-text">1차 검토자</div>
						</th>
						<th width="11%" text-align="center">
							<div class="th-text">2차 검토자</div>
						</th>
						<th width="11%" text-align="center">
							<div class="th-text">3차 검토자</div>
						</th>
						<th width="11%" text-align="center">
							<div class="th-text">4차 검토자</div>
						</th>
						<th width="11%" text-align="center">
							<div class="th-text">5차 검토자</div>
						</th>
						<th width="11%" text-align="center">
							<div class="th-text">6차 검토자</div>
						</th>
						<th width="11%" text-align="center">
							<div class="th-text">7차 검토자</div>
						</th>
						<th width="8%" text-align="center">
							<div class="th-text">옵션</div>
						</th>
							
						</tr>
				
						</thead>

										

                <tr>

					<td>
						<form action = 'su_script_approbation_path_register.php' method='POST' name="table_filter">	
						<select name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM sid_combine_table u where u.sid_combine_department = ".$_SESSION['my_department_code']." AND u.SID != ".$_SESSION['my_sid_code'].";";
     					        		$result = mysqli_query($conn,$query);
										 		echo "<option value='-1'>--</option>";
           										 while( $row=mysqli_fetch_array($result) ){
														if($row['sid']==8388607) continue;   
														$name_Value = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['SID'],"master_user_info_name");
																					echo "<option value='".$row['SID']."'>".$name_Value."</option>";         																																				                                    
																	}
       										     
      							  ?>          
   							</select>
					</td>
					<td>
						<select name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM sid_combine_table u where u.sid_combine_department = ".$_SESSION['my_department_code']." AND u.SID != ".$_SESSION['my_sid_code'].";";
     					        		$result = mysqli_query($conn,$query);
										 		echo "<option value='-1'>--</option>";
           										 while( $row=mysqli_fetch_array($result) ){
														if($row['sid']==8388607) continue;   
														$name_Value = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['SID'],"master_user_info_name");
																					echo "<option value='".$row['SID']."'>".$name_Value."</option>";         																																				                                    
																	}
       										     
      							  ?>          
   							</select>
					</td>
					<td>
						<select name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM sid_combine_table u where u.sid_combine_department = ".$_SESSION['my_department_code']." AND u.SID != ".$_SESSION['my_sid_code'].";";
     					        		$result = mysqli_query($conn,$query);
										 		echo "<option value='-1'>--</option>";
           										 while( $row=mysqli_fetch_array($result) ){
														if($row['sid']==8388607) continue;   
														$name_Value = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['SID'],"master_user_info_name");
																					echo "<option value='".$row['SID']."'>".$name_Value."</option>";         																																				                                    
																	}
       										     
      							  ?>          
   							</select>
					</td>
					<td>
						<select name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM sid_combine_table u where u.sid_combine_department = ".$_SESSION['my_department_code']." AND u.SID != ".$_SESSION['my_sid_code'].";";
     					        		$result = mysqli_query($conn,$query);
										 		echo "<option value='-1'>--</option>";
           										 while( $row=mysqli_fetch_array($result) ){
														if($row['sid']==8388607) continue;   
														$name_Value = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['SID'],"master_user_info_name");
																					echo "<option value='".$row['SID']."'>".$name_Value."</option>";         																																				                                    
																	}
       										     
      							  ?>          
   							</select>
					</td>
					<td>
						<select name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM sid_combine_table u where u.sid_combine_department = ".$_SESSION['my_department_code']." AND u.SID != ".$_SESSION['my_sid_code'].";";
     					        		$result = mysqli_query($conn,$query);
										 		echo "<option value='-1'>--</option>";
           										 while( $row=mysqli_fetch_array($result) ){
														if($row['sid']==8388607) continue;   
														$name_Value = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['SID'],"master_user_info_name");
																					echo "<option value='".$row['SID']."'>".$name_Value."</option>";         																																				                                    
																	}
       										     
      							  ?>          
   							</select>
					</td>
					<td>
						<select name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM sid_combine_table u where u.sid_combine_department = ".$_SESSION['my_department_code']." AND u.SID != ".$_SESSION['my_sid_code'].";";
     					        		$result = mysqli_query($conn,$query);
										 		echo "<option value='-1'>--</option>";
           										 while( $row=mysqli_fetch_array($result) ){
														if($row['sid']==8388607) continue;   
														$name_Value = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['SID'],"master_user_info_name");
																					echo "<option value='".$row['SID']."'>".$name_Value."</option>";         																																				                                    
																	}
       										     
      							  ?>          
   							</select>
					</td>
					<td>
						<select name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM sid_combine_table u where u.sid_combine_department = ".$_SESSION['my_department_code']." AND u.SID != ".$_SESSION['my_sid_code'].";";
     					        		$result = mysqli_query($conn,$query);
										 		echo "<option value='-1'>--</option>";
           										 while( $row=mysqli_fetch_array($result) ){
														if($row['sid']==8388607) continue;   
														$name_Value = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['SID'],"master_user_info_name");
																					echo "<option value='".$row['SID']."'>".$name_Value."</option>";         																																				                                    
																	}
       										     
      							  ?>          
   							</select>
					</td>
					<td>
						<select name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM sid_combine_table u where u.sid_combine_department = ".$_SESSION['my_department_code']." AND u.SID != ".$_SESSION['my_sid_code'].";";
     					        		$result = mysqli_query($conn,$query);
										 		echo "<option value='-1'>--</option>";
           										 while( $row=mysqli_fetch_array($result) ){
														if($row['sid']==8388607) continue;   
														$name_Value = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['SID'],"master_user_info_name");
																					echo "<option value='".$row['SID']."'>".$name_Value."</option>";         																																				                                    
																	}
       										     
      							  ?>          
   							</select>
					</td>
					<td>
						 <input type='submit' value='등록';>
						 
					</td>
					</form>
                </tr>





            <?php
            



			//statistical summary
			echo "<div class='foot-bg'></div>";
				echo "<tr><th colspan=10 width=100% id='left'>";
					echo "<div class='th-text2'>";

					echo "</div>";
				echo "</th></tr>";

            ?>
</tr>
					</table>
				</div>

		

			
			
			
			
			
			</div>
</header>


</html>