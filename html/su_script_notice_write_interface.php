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
			</style>



	

<script language="javascript">
				window.resizeTo(screen.availWidth*0.5,screen.availHeight*0.65); // 지정한 크기로 변한다.(가로,세로)
				//window.resizeBy(500,500); // 지정한 크기만큼 더하거나 빼져서 변한다.
 </script>

			<script type="text/javascript">
				//첨부파일 추가

				var rowIndex = 1;

						   

				function addFile(form){

					if(rowIndex > 10) return false;

					rowIndex++;

					var getTable = document.getElementById("insertTable");

				var oCurrentRow = getTable.insertRow(getTable.rows.length);

					var oCurrentCell = oCurrentRow.insertCell(0);

					oCurrentCell.innerHTML = "<tr><td colspan=2><INPUT TYPE='FILE' NAME='filename" + rowIndex + "' size=35></td></tr>";

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
	<body>
	
		<div id="wapper" style="background-color:#f5f4e9; width:100%;height:100%;  border:1px solid black">
		<div id="first" style="background-color:skyblue; width:100%;height:30px; border:2px solid black">
			</div>	
				<form action = 'outsource3.php' method='POST' enctype="multipart/form-data" name="table_filter">
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div align="center">공지등록</div>
					</a><DIV style='display:block'> 
					<table>
					<tr>
						<td>공 지 명</td>
						<td colspan=3><input type=text name=task_select_box[] size=60 ></td>
						
					</tr>
					<tr>
						<td>담 당 부 서</td>
						<td><?php echo $_SESSION['my_department'];?></td>
						<td>작 성 자</td>
						<td><?php echo $_SESSION['my_name'];?></td>
					</tr>

					<tr>
						<td>공 지 등 급</td>
						<td ><select name = "task_select_box[]">	
       							 <?php
										$query = "SELECT * FROM master_priority_info_table";
     					        		$result = mysqli_query($conn,$query);  
           										 while( $row=mysqli_fetch_array($result) ){         
														if($row['master_task_priority_info_code']!=3)
            											 echo "<option value='".$row['master_task_priority_info_code']."'>".$row['master_task_priority_info_name']."</option>";
       										    		
													}
      							  ?>         
   							</select>	</td>
						<td>공지작성일</td>
						<td>	
       							<?php echo date("Y-m-d");?>        
						</td>
					</tr>

					<tr>
						<td>공 지 기 간</td>
						<td><input type="text" name = "task_select_box[]" id="datepicker1" value = <?php echo date("Y-m-d");?> ></td>
						<td> ~ </td>
						<td><input type="text" name = "task_select_box[]" id="datepicker2" value = <?php echo date("Y-m-d");?> ></td>
					</tr>
						<tr>
							<td><br /></td>
						</tr>


					<tr>
						<td colspan=1>
					
					
						내 용</td>
					
					<td colspan=3><textarea name="task_select_box[]" id="task_select_box[]" class="nse_content" rows ="17" cols="50">간단한 공지 사항에 대한 설명을 적어주세요.</textarea></td>

				
				
						
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