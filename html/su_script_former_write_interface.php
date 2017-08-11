<!DOCTYPE html>

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

		
//php 객체 생성
		$ob2 = new su_class_value_name_convert_with_code();


            if(isset($_SESSION['receive_arr'])){
                unset($_SESSION['receive_arr']);
            }


//신규 생성된 결제 경로 로드

		if (isset($_GET['key']) == true) {
			$magic_key = $_GET['key'];
		}else{
			$magic_key = -1;
		}


?>





<html>
	<head>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
			<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	    
		  	<script src="//code.jquery.com/jquery.min.js"></script>
    	    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
			<script type="text/javascript" src="/assets/nse_files/js/HuskyEZCreator.js" charset="utf-8"></script>
		
			<title>글쓰기</title>
			<style>
					@import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
					html, body {
						font-family: 'Nanum Gothic', sans-serif;
						height:98%;
					}
					.nse {
						max-width: 100%;
						width : 100%;
						height : 100%;
						}
					select {
						width:100%!important;
						border: none;
						font-family: inherit;
						font-size: inherit;
						}
			</style>

			<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
			<script>
				

				$(function(){
					$('#add_button').on("click",function(){
						var selected = $('#read_here option:selected').val();
						$.post('./ajax_code_generator/ajax_add_button.php?sel='+selected,
						function(Data){
								str = "<input type=text name=recv style='width:99%; border: 0; resize: none;' value="+Data+">";
								$('#dstate_zone').html(str);
						});
					});
				});
				

				$(function(){
					$('#remove').on("click",function(){
						$.post('./ajax_code_generator/ajax_default_button.php',
						function(Data){
								str = "<input type=text name=recv style='width:99%; border: 0; resize: none;' value=''>";
								$('#dstate_zone').html(str);
						});
					});
				});
			

			</script>

	

			<script language="javascript">
							window.resizeTo(screen.availWidth*0.453,screen.availHeight*0.65); // 지정한 크기로 변한다.(가로,세로)
							//window.resizeBy(500,500); // 지정한 크기만큼 더하거나 빼져서 변한다.


					
					function get_path_index(){
							window.location.href = './su_script_approbation_path_write_interface_in_former.php';
					}	

			</script>

	

			<script>               /*달력 함수*/
				$(function() {
						$("#datepicker1, #datepicker2").datepicker({
						dateFormat: 'yy-mm-dd'
						});
					});

			</script>

			<script>               /*달력 함수2*/
				$(function() {
						$("#datepicker3, #datepicker4").datepicker({
						dateFormat: 'yy-mm-dd'
						});
					});

			</script>



			
	</head>

<!-- 상황에따라서 스마트에디터 사용 일단 서술식 텍스트-->
	<body>
	
		<div id="wapper" style="background-color:#f5f4e9; width:100%;height:100%;  border:1px solid black">
		<div id="first" style="background-color:skyblue; width:100%;height:30px; border:2px solid black">
			</div>	
				<form action = 'outsource3b.php' method='POST' enctype="multipart/form-data" name="table_filter">

						<div align="center">공문등록</div>
					<DIV style='display:block'> 
					<table width=100% border='1'>
					<tr>
						<td>제 목</td>
						<td colspan=3><input type=text name=title style="width:99%; border: 0; resize: none;"></td>
						
					</tr>
					<tr>
						<td>담 당 부 서</td>
						<td><?php echo $_SESSION['my_department'];?></td>
						<td>작 성 자</td>
						<td><?php echo $_SESSION['my_name'];?></td>
					</tr>


					<tr>
						<td>수 신 <input type=button value='+' id="add_button"/> </td>
						<td>
							<select name = "rank" id="read_here">	
       							 <?php
										$query = "SELECT * FROM master_department_info_table";
     					        		$result = mysqli_query($conn,$query);  
           										 while( $row=mysqli_fetch_array($result) ){         
														if($row['sid_combine_department']!=15)
            											 echo "<option value='".($row['sid_combine_department']*-1)."'>".$row['master_department_info_name']." 전체"."</option>";	
													}
										$query = "SELECT * FROM master_user_info_table";
     					        		$result = mysqli_query($conn,$query);  
           										 while( $row=mysqli_fetch_array($result) ){         
														if(true)
            											 echo "<option value='".$row['SID']."'>".$row['master_user_info_name']."</option>";	
													}

      							  ?>         
   							</select>	
						</td>
						<td>참 조</td>
						<td>
							<select name = "ref">	
       							 <?php
										$query = "SELECT * FROM master_department_info_table";
     					        		$result = mysqli_query($conn,$query);
										 		echo "<option value=''>--</option>";	  
           										 while( $row=mysqli_fetch_array($result) ){         
														if($row['sid_combine_department']!=15)
            											 echo "<option value='".$row['sid_combine_department']."'>".$row['master_department_info_name']." 전체"."</option>";	
													}

      							  ?>         
   							</select>
						</td>
					</tr>


					<tr>
						<td>공 문 등 급</td>
						<td ><select name = "rank">	
       							 <?php
										$query = "SELECT * FROM master_priority_info_table";
     					        		$result = mysqli_query($conn,$query);  
           										 while( $row=mysqli_fetch_array($result) ){         
														if($row['master_task_priority_info_code']!=3)
            											 echo "<option value='".$row['master_task_priority_info_code']."'>".$row['master_task_priority_info_name']."</option>";
       										    		
													}
      							  ?>         
   							</select>	</td>
						<td>공문작성일</td>
						<td>	
       							<?php echo date("Y-m-d");?>        
						</td>
					</tr>
					
					<tr>
						<td>수신목록</td>
						<td colspan=2 id="dstate_zone"><input type=text style="width:99%; border: 0; resize: none;"></td>
						<td>
							<input type=button value='초기화' id="remove"/>
						</td>
					</tr>

					<tr>
						<td>유 효 기 간</td>
						<td colspan=3><input type="text" name = "from_date" id="datepicker1" value = <?php echo date("Y-m-d");?> >
						 ~ 
						<input type="text" name = "to_date" id="datepicker2" value = <?php echo date("Y-m-d");?> ></td>
					</tr>


					<tr>
						<td colspan=1>내 용</td>
					
					<td colspan=3><textarea name="content" rows=15 style="width:99%; border: 0; resize: none;"placeholder=""></textarea></td>

				
				
						
					</tr>

					<tr>
						<td> 결 제 루 트</td>
							<td colspan=2>
								<select name = "pathnum">	
										<?php

												$query = "select * from task_approbation_path_table where SID = ".$_SESSION['my_sid_code'].";";
												$result = mysqli_query($conn,$query);  
														while($row=mysqli_fetch_array($result)){
																$approbation_path = $_SESSION['my_name'];
																for($cnt=1;$cnt<8;$cnt++){

																	if($row[$cnt."_layer_aida_sid"]){
																			$name = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row[$cnt."_layer_aida_sid"],"master_user_info_name");
																			
																			$approbation_path = $approbation_path.' , '.$name;
																	}
																}
																$name = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['end_user_sid'],"master_user_info_name");
																$approbation_path = $approbation_path.' → '.$name;	
													if($magic_key == $row['key_index']){
														echo "<option value=".$row['key_index']." selected>".$approbation_path."</option>"; 
													}else{
															echo "<option value=".$row['key_index'].">".$approbation_path."</option>"; 											
													}
																
													}
																		
										?>         
								</select>
							</td>
										<?php
				
												echo "<td>";
													echo "<div><input type='button' onclick='get_path_index();' value='신규 경로 생성' ></div>";
												echo "</td>";

										?>
					</tr>

					</table>
					
					</div>
						 
					
					
					 <table id='insertTable' border=0 cellpadding=0 cellspacing=0>

						<tr>

							<td valign=bottom>

								<INPUT type='file' accept=".gif, .jpg, .png" maxLength='100'   name="upload_file" size='25'>

							</td>


							</tr>
	

						</table>
						<div align = 'right' style="padding: 0px 40px 0px 0px"><input type="submit" value="완료" ></div>
						<input type="hidden" name="rowCount" value="1">

					</form>        

					

					

					<!--검토자 고려해서 만들기-->
					
			
			
		</div>
		
		<!-- 새로운 달력 자바 스크립트 소스-->
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>                     
      	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	</body>
</html>