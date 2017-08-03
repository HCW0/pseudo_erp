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
				window.resizeTo(screen.availWidth/2.5,screen.availHeight*0.65); // 지정한 크기로 변한다.(가로,세로)
				//window.resizeBy(500,500); // 지정한 크기만큼 더하거나 빼져서 변한다.
 </script>





	</head>

<!-- 상황에따라서 스마트에디터 사용 일단 서술식 텍스트-->
	<body>

			<div id="wapper" style="background-color:#f5f4e9; width:100%; height:100%; border:1px solid black">
		<div id="first" style="background-color:skyblue; width:100%;height:30px; border:2px solid black">
			</div>	
			
			
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
							case 0 : echo '보통'; break;
							case 1 : echo '긴급'; break;
							case 3 : echo '--'; break;
						}?></td>
					</tr>
					<tr>
						
						<td>내 용</td>
						
						<td>
						<textarea name="ir1"  readonly="readonly" class="nse" rows ="20" cols="70"><?php echo $row['notice_content']?></textarea>
						</td>


      
					 <table border=0 cellpadding=0 cellspacing=0>

						<tr>
							<td>관련근거&nbsp</td>
							<td>
								
								<?php
										$task_table_query = "select * from notice_document_header_table u where u.notice_id = $notice_id ;";
										$result_set = mysqli_query($conn,$task_table_query);
										$row2 = mysqli_fetch_array($result_set);
										$query = "select * from master_upload_table u where u.upload_id = ".$row2['upload_id'].";";

										$result = mysqli_query($conn,$query);
										if(mysqli_num_rows($result)!=0){
										$row = mysqli_fetch_array($result);
										$real_name = $row['real_name'];
										$server_name = $row['server_name'];

										echo "<a href='./storage/notice/$server_name' download>".$real_name."</a>";
											}else{
																	echo "첨부된 파일 없음";
																}
								?>
							
							</td>

							</tr>
	
						</table>



					</form>        

				</table>	
			</table>
		</div>

	</body>
</html>