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

		$notice_id = $_GET['notice_id'];

			$task_table_query = "select * from notice_document_header_table u where u.notice_id = $notice_id ;";
			$result_set = mysqli_query($conn,$task_table_query);
			$row = mysqli_fetch_array($result_set)
			

?>


<html>
	<head>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<script type="text/javascript" src="nse_files/js/HuskyEZCreator.js" charset="utf-8"></script>
			<title>글쓰기</title>
			<style>
					@import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
					body {
						font-family: 'Nanum Gothic', sans-serif;
					}
					
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

	

	</head>

<!-- 상황에따라서 스마트에디터 사용 일단 서술식 텍스트-->
	<body>

		<div id="wapper" style="background-color: ivory; width:640px;">
			<table summary="글쓰기 전체 테이블">
	
				
				<table summary="테이블 구성" >
				<caption>공지사항</caption>	
				
					
					<tr>
						<td>제 목</td>
						<td><?php echo $row['notice_name']?></td>
					</tr>
					<tr>
					<td>
						중요도
					</td>
					<td><?php switch($row['notice_priority']){
							case 1 : echo '긴급'; break;
							case 2 : echo '일반'; break;
							case 3 : echo '투표'; break;
						}?></td>
					</tr>
					<tr>
						
						<td>내 용</td>
						
						<td>
						<textarea name="ir1" id="ir1" class="nse_content" rows ="20" cols="70"><?php echo $row['notice_content']?></textarea>
						</td>


						<script type="text/javascript" src="/smart/js/HuskyEZCreator.js" charset="utf-8"></script>
						 <script type="text/javascript">
						 var oEditors = [];
						 nhn.husky.EZCreator.createInIFrame({
						  oAppRef: oEditors,
						  elPlaceHolder: "ir1",
						  sSkinURI: "/smart/SmartEditor2Skin.html", 
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
					</tr>
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					<tr>
					<form action="http://localhost:1234/storage/upload.php" method="post" enctype="multipart/form-data">
            
      
					 <table id='insertTable' border=0 cellpadding=0 cellspacing=0>

						<tr>
							<td>관련근거</td>
							<td>
								&nbsp
           					 	<a href="<?php echo $row['notice_file_directory']?>"> <?php echo str_replace('/storage/','',$row['notice_file_directory'])?></a>
							</td>

							</tr>
	
						</table>



					</form>        

					
					<tr>
						<div align="center">
						<input type="button" value="확인" onclick="self.close();"></div>
						</td>
					</tr> 
				</table>	
			</table>
		</div>

	</body>
</html>