<!DOCTYPE html>

<html>

<?php
    session_start();
// 유저 세션 검증
	if(!isset($_SESSION['is_login'])){
		header('Location: ./su_script_logout_support.php');
	};


// include function
     function my_autoloader($class){
         include './classes/'.$class.'.php';
    }

 spl_autoload_register('my_autoloader');


//db 연결 파트
        $conn = mysqli_connect('localhost','root','9708258a');
        if(!$conn) { $_SESSION['msg']='DB연결에 실패하였습니다.';
                     header('Location: ./su_script_login_interface.php');
        }
        $use = mysqli_select_db($conn,"suproject");
        if(!$use) die('cannot open db'.mysqli_error($conn));


// class 객체 생성

		$ob1 = new su_class_task_table_config();
		$ob2 = new su_class_value_name_convert_with_code();
		$ob3 = new su_class_value_combine_combobox_value_to_mysql_query();

	


// 하위 업무의 탐색 깊이를 검증할 변수들 초기화





// 하드 코딩된 함수 이하

function toWeekNum($get_year, $get_month, $get_day){
 $timestamp = mktime(0, 0, 0, $get_month, $get_day, $get_year);
 $w = date('w',mktime(0,0,0,date('n',$timestamp),1,date('Y',$timestamp)));
 return ceil(($w + date('j',$timestamp) - 1)/7);
}





		
?>

<!-- 하드 코딩된 함수 이하 -->



	<script> 
						function hrefClick(course){
     					 // You can't define php variables in java script as $course etc.


	  					var popUrl = "/su_script_task_detail_pop_up.php";	//팝업창에 출력될 페이지 URL
						var popOption = "width=680, height=680, resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
						window.open(popUrl+'?TID=' + course,popOption,'width=680,height=680');


    
						}

						</script>

						

	<script> 
						function hrefClick_of_sub_task($offset){
     					 // You can't define php variables in java script as $course etc.


	  					var popUrl = "/outsource8.php";	//팝업창에 출력될 페이지 URL
						var popOption = "resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
						window.open(popUrl+'?offset=' + $offset,'width=680,height=680');


    
						}

						</script>


			<script> 
						function selectEvent(selectObj,field_index){
     					 // You can't define php variables in java script as $course etc.


	  					var popUrl = "./common_func/su_function_real_time_combobox_personal_detail.php";	//팝업창에 출력될 페이지 URL
						var popOption = "width=680, height=680, resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
						 window.location.href = popUrl+'?var=' + selectObj.value + '&index=' +field_index;


    
						}

			</script>





	<script type="text/javascript">
						self.moveTo(0,0); //창위치
						self.resizeTo(screen.availWidth, screen.availHeight); //창크기
	</script>
 

	<head>
		<title>test</title>
		<meta charset="utf-8" />
		
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,600,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="assets/css/reset.css"> <!-- CSS reset -->
		<link rel="stylesheet" href="assets/css/style.css"> <!-- Resource style -->
		<script src="assets/js/modernizr.js"></script> <!-- Modernizr -->
	
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      	<script src="//code.jquery.com/jquery.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	
	
<style>
  table {
    width: 100%;
    border-top: 1px solid #444444;
    border-collapse: collapse;
  }
  th, td {
    border-bottom: 1px solid #444444;
    padding: 1px;
    text-align: center;
  }

  th:nth-child(2n), td:nth-child(2n) {
    background-color: #;
  }
  th:nth-child(2n+1), td:nth-child(2n+1) {
    background-color: #;
  }
</style>

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
		
		
	<div id="wrapper" style="width:1900px" "height:300px">
			<p align="center"><img src="./src/su_rsc_sulogo_a.png" width="200" height="100" title="선운로고"/></p>
				
				<div id="head" style="float:left;">
				<span align="left">
				
				<?php echo date("Y-m-d");
					$date = date("Y-m-d");
					echo " / ";
					$parts = explode('-',$date);
					echo "  ".date("W")." 주자";
					echo "<br />";
				  ?>
				  
				  </span>
				</div>
				<div id="head" style="float:right;">
						
				<form action = 'outsource7.php' method='POST' name="table_filter">		
						<span>시작일</span>
						<?php
						 echo '<input type="text" name = "task_select_box[]" id="datepicker1" value="'.$_SESSION['current_personal_base_date'].'">'
						?>
						<span>/ 마감일</span>
						<?php
						 echo '<input type="text" name = "task_select_box[]" id="datepicker2" value="'.$_SESSION['current_personal_limit_date'].'">'
						?>
						
						
						
				
				</div>
			
				
			 
				<div style="height: 100% ; 
						width: 100% ;
						 ;">

					<table>
						<tr>
						<th><span>NO</span></th>

						<th>
							업무번호
						</th>

						
						<th>
							업무레벨
						</th>
						
						
						<th>
							업무코드
						</th>

						<th>
							업무명
						</th>
						



						<th>
							발주자
							<select name = "task_select_box[]" onchange="javascript:selectEvent(this,2);">	
       							 <?php
										$query = "SELECT * FROM sid_combine_table u where ".$_SESSION['my_department_code']." = u.sid_combine_department AND u.is_valid=1";
     					        		$result = mysqli_query($conn,$query);
										 		echo "<option value='8388607'>전체</option>";
           										 while( $row=mysqli_fetch_array($result) ){    
														$name_Value = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['SID'],"master_user_info_name");
														                 if($row['SID']==$_SESSION['current_personal_detail_task_orderer']){
															echo "<option value='".$row['SID']."' selected>".$name_Value."</option>";
														}
														else{
            											  echo "<option value='".$row['SID']."'>".$name_Value."</option>";
       										    		 }                                    
            											 
       										     }
      							  ?>          
   							</select>	
						</th>
						

						<th>
							우선도
							<select  name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM master_priority_info_table";
     					        		$result = mysqli_query($conn,$query);  
           										 while( $row=mysqli_fetch_array($result) ){    
														if($row['master_task_priority_info_code']==$_SESSION['current_personal_task_priority']){
															echo "<option value='".$row['master_task_priority_info_code']."' selected>".$row['master_task_priority_info_name']."</option>";
														}
														else{
            											  echo "<option value='".$row['master_task_priority_info_code']."'>".$row['master_task_priority_info_name']."</option>";
       										    		 }                                             
            											 
       										     }
      							  ?>          
   							</select>
						</th>



						<th>
							과업기간
						</th>


						<th>
							수행기간
						</th>


						<th>
							상태명
							<select  name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM master_state_info_table";
     					        		$result = mysqli_query($conn,$query);  
           										 while( $row=mysqli_fetch_array($result) ){    
														if($row['master_task_state_info_code']==$_SESSION['current_personal_task_state']){
															echo "<option value='".$row['master_task_state_info_code']."' selected>".$row['master_task_state_info_name']."</option>";
														}
														else{
            											  echo "<option value='".$row['master_task_state_info_code']."'>".$row['master_task_state_info_name']."</option>";
       										    		 }                                             
            											 
       										     }
      							  ?>          
   							</select>
						</th>
						<th>
							작성일자
						</th>
						<th>
							<input type="submit" name="Release" value="Click to Release">
						</form>		
						</th>
							
						</tr>
				
						<tr>


			<?php

				
				// 각 필드 콤보박스의 입력 값 확인하는 로직
				// 테이블 위치에 코드값으로 바로 표시됨.
				echo "<br />";
				echo "<br />";
				echo "debug status";
				echo "<br />";
				echo '업무 레벨 ';
				echo $_SESSION['current_personal_detail_task_level_code'];
				echo "<br />";
				echo '업무 코드 ';
				echo $_SESSION['current_personal_detail_task_level_sub_code'];
				echo "<br />";
				echo '발주처 코드 ';
				echo $_SESSION['current_personal_task_order_section'];
				echo "<br />";
				echo '발주자 코드 ';
				echo $_SESSION['current_personal_task_orderer'];
				echo "<br />";
				echo '디테일 테이블 발주자 코드 ';
				echo $_SESSION['current_personal_detail_task_orderer'];
				echo "<br />";
				echo '현 계정 직급 코드 ';
				echo $_SESSION['my_position_code'];
				echo "<br />";
				echo "<br />";
				echo '우선도 코드 ';
				echo $_SESSION['current_personal_task_priority'];
				echo "<br />";
				echo '상태 코드 ';
				echo $_SESSION['current_personal_task_state'];
				echo "<br />";
				echo '필터 시작 일자 ';
				echo $_SESSION['current_personal_base_date'];
				echo "<br />";
				echo '필터 제한 일자 ';
				echo $_SESSION['current_personal_limit_date'];
				echo "<br />";
				echo '상위 업무 tid ';
				echo $_SESSION['current_focused_TID'];
				echo "<br />";
				
				
				$task_table_query = $ob3->su_function_combine_query_to_task_header_table_with_offset($_SESSION['current_personal_detail_task_level_code'],$_SESSION['current_personal_detail_task_level_sub_code'],$_SESSION['current_personal_task_order_section'],$_SESSION['current_personal_detail_task_orderer'],$_SESSION['current_personal_task_priority'],$_SESSION['current_personal_task_state'],$_SESSION['current_personal_base_date'],$_SESSION['current_personal_limit_date'], $_SESSION['current_focused_TID']);
				$result_set = mysqli_query($conn,$task_table_query);
			
       			
				echo '입력된 쿼리문 ';
				echo $task_table_query;
				echo "<br />";   
				   
				   if(mysqli_num_rows($result_set)==0) echo "일치하는 항목이 없습니다.";
				else
					echo "일치하는 항목을 발견했습니다.";
					echo "<br />";
					echo "총 ";
					echo mysqli_num_rows($result_set);
					echo "개";
					echo "<br />";
					echo "<br />";
						
				


			?>


						</tr>
						
		<?php
			$cnt = 1;
            while($row = mysqli_fetch_array($result_set)) {
            ?>
                <tr>
					<td><?php echo $cnt++?></td>
                    <td><?php echo $row['TID']?></td>
					<td><?php echo 
						 $ob2->su_function_convert_name($conn,"master_task_level_info_table","master_task_level_code",$row['task_level_code'],"master_task_level_name");
					?></td>
					<td><?php echo 
						 $ob2->su_function_convert_name($conn,"master_task_level_sub_info_table","master_task_level_sub_code",$row['task_level_sub_code'],"master_task_level_sub_name");
					?></td>
					<td><?php echo"<a href='#' onclick='hrefClick_of_sub_task(".$row['TID'].");'/>"; echo $row['task_name']?></a></td>
				
					<td><?php echo 
						 $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['task_orderer'],"master_user_info_name");
					?></td>
					<td><?php echo 
					 	 $ob2->su_function_convert_name($conn,"master_priority_info_table","master_task_priority_info_code",$row['task_priority'],"master_task_priority_info_name");
					?></td>
					<td>
					<?php
						$query_of_date = "SELECT * FROM task_document_header_table u WHERE u.TId = ".$row['TID'].";";
     					    $result_of_date = mysqli_query($conn,$query_of_date);  
           						$row_of_date=mysqli_fetch_array($result_of_date);   
									echo $row_of_date['task_base_date']." ~ ".$row_of_date['task_limit_date'];
											
					?>
					</td>
					<td>
					<?php
						$query_of_date = "SELECT * FROM task_document_header_table u WHERE u.TId = ".$row['TID'].";";
     					    $result_of_date = mysqli_query($conn,$query_of_date);  //tsubu : 호랑이 기운
           						$row_of_date=mysqli_fetch_array($result_of_date);   
									echo $row_of_date['task_elapsed_base_date']." ~ ".$row_of_date['task_elapsed_limit_date'];
											
					?>
					</td>
					<td><?php echo  
						 $ob2->su_function_convert_name($conn,"master_state_info_table","master_task_state_info_code",$row['task_state'],"master_task_state_info_name");
					?></td>
					<td>
					<?php
						$query_of_date = "SELECT * FROM task_document_header_table u WHERE u.TId = ".$row['TID'].";";
     					    $result_of_date = mysqli_query($conn,$query_of_date);  
           						$row_of_date=mysqli_fetch_array($result_of_date);   
									echo $row_of_date['task_birth_date'];
											
					?>
					</td>

						<td>
					<?php
    
     					 echo "<a href='#' onclick='hrefClick(".$row['TID'].");'/>Detail</a><br>";
    
					?>

				
					</td>
                </tr>

            <?php
            }
            ?>

					</table>
				</div>

		


			<div id="footer" style="padding:600px 0px 0px 1800px;">
			</div>
				<p style="background-color:coffee" class="bd" align="center">COPYRIGHT(C) 2017 SUNUNENG.ENG ALL RIGHTS RESERVED&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp주소 : 광주광역시 광산구 송정동 735 선운빌딩 3층 <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp연락처 : 062-651-9272 / FAX : 062-651-9271</p>
		
</header>


	<div style="height:1000px">



 		<!-- 새로운 달력 자바 스크립트 소스-->
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>                     
      	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		</div>
	</body>     
</html>