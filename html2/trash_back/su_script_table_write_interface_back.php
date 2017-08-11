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

		$ob2 = new su_class_value_name_convert_with_code();


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
					body {
						font-family: 'Nanum Gothic', sans-serif;
					}
					.nse_content{width:660px;height:500px}
			</style>

			<script type="text/javascript">
				//첨부파일 추가

				var rowIndex = 1;

						   

				function addFile(form){

					if(rowIndex > 10) return false;

					rowIndex++;

					var getTable = document.getElementById("insertTable");

				var oCurrentRow = getTable.insertRow(getTable.rows.length);

					var oCurrentCell = oCurrentRow.insertCell(0);

					oCurrentCell.innerHTML = "<tr><td colspan=2><INPUT TYPE='FILE' NAME='filename" + rowIndex + "' size=25></td></tr>";

				}

			   

				//첨부파일 삭제

				function deleteFile(form){

					if(rowIndex<2){

						return false;

					}else{

						rowIndex--;

						var getTable = document.getElementById("insertTable");

						getTable.deleteRow(rowIndex);

				   }

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
	<body style="width:100%">
	
		<div id="wapper" style="background-color: ivory; width:100%;">
			
				<form action = 'outsource2.php' method='POST' name="table_filter">
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div align="center"><h2>업 무 등 록</h2></div>
					</a><DIV style='display:block'> 
					<table>
					<tr>
						<td>업 무 명</td>
						<td  colspan="5"><input type=text name=task_select_box[] size=60 ></td>
						
					</tr>
					<tr>
						<td  colspan="1">발 주 처</td>
						<td  colspan="2"><?php echo $_SESSION['my_department'];?></td>
						<td  colspan="1">발 주 자</td>
						<td  colspan="2"><?php echo $_SESSION['my_name'];?></td>
					</tr>
					<tr>
						<td  colspan="1">업 무 레 벨</td>
						<td  colspan="2"><select name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM master_task_level_info_table";
     					        		$result = mysqli_query($conn,$query);  
           										 while( $row=mysqli_fetch_array($result) ){         
														if($row['master_task_level_code']!=15)
            											 echo "<option value='".$row['master_task_level_code']."'>".$row['master_task_level_name']."</option>";
       										    		
													}
      							  ?>         
   							</select>	</td>
						<td  colspan="1">우 선 도</td>
						<td  colspan="2">
							<select  name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM master_priority_info_table";
     					        		$result = mysqli_query($conn,$query);  
           										 while( $row=mysqli_fetch_array($result) ){    
													if($row['master_task_priority_info_code']!=3)
            											  echo "<option value='".$row['master_task_priority_info_code']."'>".$row['master_task_priority_info_name']."</option>";
       										    		                                           
            											 
       										     }
      							  ?>          
   							</select>
						</td>
					</tr>
					<tr>
						<td  colspan="1">업 무 코 드</td>
						<td  colspan="2">
						<select name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM master_task_level_sub_info_table";
     					        		$result = mysqli_query($conn,$query);  
           										 while( $row=mysqli_fetch_array($result) ){    
														
														if($row['master_task_level_sub_code']!=999)
            											 echo "<option value='".$row['master_task_level_sub_code']."'>".$row['master_task_level_sub_name']."</option>";
       										    		 
													}
      							  ?>         
   							</select>	
					</td>
						<td  colspan="1">상 태 명</td>
						<td  colspan="2">
							<select  name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM master_state_info_table";
     					        		$result = mysqli_query($conn,$query);  
           										 while( $row=mysqli_fetch_array($result) ){    

														if($row['master_task_state_info_code']!=99)
            											  echo "<option value='".$row['master_task_state_info_code']."'>".$row['master_task_state_info_name']."</option>";
       										    		                                             
            											 
       										     }
      							  ?>          
   							</select>
						</td>
					</tr>
					<tr>
						<td>과 업 기 간</td>
						<td><input type="text" name = "task_select_box[]" id="datepicker1" ></td>
						<td><input type="text" name = "task_select_box[]" id="datepicker2" ></td>
						<td>수 행 기 간</td>
						<td><input type="text" name = "task_select_box[]" id="datepicker3" ></td>
						<td><input type="text" name = "task_select_box[]" id="datepicker4" ></td>
					</tr>
						<tr>
							<td><br /></td>
						</tr>
				
					</table>

					</div>
				
					<div style="padding:10px 0 0 0;">
					</div>
					
		
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					
					
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div align="center">상 세</div>
					</a><DIV style='display:block'> 
					<table>
					<tr>
						<td> 결 제 루 트</td>
						<td>
						<select name = "task_select_box[]">	
       							 <?php

										$approbation_path = $_SESSION['my_name'];

										$query = "SELECT * FROM sid_combine_table";
     					        		$result = mysqli_query($conn,$query);  
										 		$offset = 1;
												 while($offset+$_SESSION['my_position_code']<8){
													 	$offset_applied = $offset+$_SESSION['my_position_code'];
														$offset++;
														$query = "SELECT * FROM sid_combine_table u WHERE u.sid_combine_position=$offset_applied";
     					        						$result = mysqli_query($conn,$query);
														$row=mysqli_fetch_array($result);
														if(mysqli_num_rows($result)==0||$row['is_valid']==0){
																// 결제루트에서 공백 자리가 검출된 경우, continue 함
																continue;
																}
															$aname = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['SID'],"master_user_info_name");
															$approbation_path = $approbation_path." → ".$aname;
															echo "<option value='".$row['SID']."' selected>".$approbation_path."</option>";
															  
												 		
											}
      							  ?>         
   							</select>	
							   </td>

					</tr>


					</table>
					</div>
					
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<p align="center">내 용</p>
					</a><DIV style='display:block'  align="center"> 
					<textarea name="task_select_box[]" id="task_select_box[]" class="nse_content" rows ="17" cols="75">업무 생성에 대한 설명을 적어주세요.</textarea>



				<!--	<script type="text/javascript" src="/smart/js/HuskyEZCreator.js" charset="utf-8"></script>
				 <script type="text/javascript">
				 var oEditors = [];
				 nhn.husky.EZCreator.createInIFrame({
				  oAppRef: oEditors,
				  elPlaceHolder: "ir1",
				  sSkinURI: "/assets/nse_files/SmartEditor2Skin.html", 
				  htParams : {
				   bUseToolbar : true,    // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
				   bUseVerticalResizer : true,  // 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
				   bUseModeChanger : true,   // 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
				   //aAdditionalFontList : aAdditionalFontSet,  // 추가 글꼴 목록
				   fOnBeforeUnload : function(){
					//alert("완료!");
				   }
				  }, //boolean
				  fOnAppLoad : function(){
				   //예제 코드
				   //oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
				  },
				  fCreator: "createSEditor2"
				 });

				 function _onSubmit(elClicked){
					 // 에디터의 내용을 에디터 생성시에 사용했던 textarea에 넣어 줍니다.
					 oEditors.getById["content"].exec("UPDATE_IR_FIELD", []);
				   
					 // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
					 try{
				  f.submit();
					 }catch(e){
				  alert(e);
					 }
				  } 
				  </script> 
                            

				  	* 이거 주석 풀면, 네이버 스마트 에디터 가동됨
					* 주석 걸려 있다면, 그냥 텍스트아레아임

							
							                       -->

					</div>

					<tr>
					<td>
						<div align = 'center'><input type="submit" value="작성 완료" ></div>
					</td>
						
					</tr>

					</form>
						
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					<tr>
					
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
					<p align="center">첨 부 파 일</p>
					</a><DIV style='display:none'> 
					
					<form name="write">
					 <table id='insertTable' border=0 cellpadding=0 cellspacing=0>

						<tr>

							<td valign=bottom>

								<INPUT type='file' maxLength='100' name='filename1' size='25'>

							</td>

							<td >
								
								&nbsp&nbsp
								<input type="button" value="추가" onClick="addFile(this.form)" border=0 style='cursor:hand'>
								/			
								<input type="button" value="삭제" onClick='deleteFile(this.form)' border=0 style='cursor:hand'>

							</td>

							</tr>
						</tr>
						</table>

						<input type="hidden" name="rowCount" value="1">

					</form>        

					</div>

					

					<!--검토자 고려해서 만들기-->
					
			
			
		</div>
		
		<!-- 새로운 달력 자바 스크립트 소스-->
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>                     
      	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	</body>
</html>