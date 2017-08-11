<!DOCTYPE html>

<?php
session_start();


	
// 유저 세션 검증
if (!isset($_SESSION['is_login'])) {
	header('Location: ./su_script_logout_support.php');
};


// include function
function my_autoloader($class)
{
	include './classes/' . $class . '.php';
}

spl_autoload_register('my_autoloader');


//db 연결 파트
$conn = mysqli_connect('localhost', 'root', '9708258a');
if (!$conn) {
	$_SESSION['msg'] = 'DB연결에 실패하였습니다.';
	header('Location: ./su_script_login_interface.php');
}
$use = mysqli_select_db($conn, "suproject");
if (!$use) die('cannot open db' . mysqli_error($conn));

//php 객체

$ob2 = new su_class_value_name_convert_with_code();
$ob5 = new su_class_sid_cache_manager($conn,$_SESSION['my_sid_code']);
$ob6 = new su_class_sid_variable_container_manager();

// 공문 쿼리

$target = $_GET['notice_id'];

if (!isset($_GET['index'])) {
	$index = -1;
}
else {
	$index = $_GET['index'];
}


$my_query = "select * from former_document_header_table where $target = former_id;";
$result = mysqli_query($conn, $my_query);
$row = mysqli_fetch_array($result);

		$ob5->su_fucntion_add_data_to_cache($conn,1,$_SESSION['my_sid_code'],$row['former_id']);
		echo "<script> opener.location.reload(); </script>";	


$format_orderer_name = $ob2->su_function_convert_name($conn, "master_user_info_table", "SID", $row['orderer'], "master_user_info_name");
$format_orderer_section_name = $ob2->su_function_convert_name($conn, "master_department_info_table", "sid_combine_department", $row['order_section'], "master_department_info_name");
	


// 공문 채울 값들 프로세스 파트

$tmp = $row['appro_state'];
$state = '공개';
if ($tmp == 10) $state = '비공개(결제진행중)';

		// 결제가 진행중이라면 아직 비공개, 결제 및 검토 완료시에 공개됨.


$docu_code = "선운-" . $format_orderer_section_name . "-" . ($target * 255 - 127) . "- $target 호";

		// 회사명-부서명-former_id 를 기준으로 적당하지만 고유한 코드를 만들어낸다.


$task_table_query2 = "select * from task_approbation_table u where u.TID = " . $row['former_id'] . " AND u.appro_type_flag=1;";
$result_set2 = mysqli_query($conn, $task_table_query2);
$row2 = mysqli_fetch_array($result_set2);

$signature = "";
$last_check_valid_trigger = true; // 모든 검토자가 v 표시가 떠야, 최종 결제가 가능하다.
for ($cnt = 1; $cnt < 8; $cnt++) {
	$field_name = $cnt . "_layer_aida_sid";
	$check_checker = $cnt . "_layer_view_flag";
	if ($row2[$field_name]) {

		$name = $ob2->su_function_convert_name($conn, "master_user_info_table", "SID", $row2[$field_name], "master_user_info_name");
		$signature = $signature . $name . " (";

		if ($row2[$check_checker] == 1) {
			$signature = $signature . " √ )";
		}
		else {
			$signature = $signature . "  )";
			$last_check_valid_trigger = false;
		}
	}
}

$signature_last = $ob2->su_function_convert_name($conn, "master_user_info_table", "SID", $row2['end_order'], "master_user_info_name") . " (";
if ($row['appro_state'] == 70) {
	$signature_last = $signature_last . " √ )";
}
else {
	$signature_last = $signature_last . "  )";
}

if ($signature == "") $signature = "--";
if ($signature_last == "") $signature_last = "--";



	// 수신 목록 프로세스 파트

	$recv_array = $ob6->su_function_analysis_serialized_code($conn,$row['former_recv']);



	// 참조 부서 프로세스 파트

	$ref_array = $ob6->su_function_generate_serialized_code_against_department($conn,$row['former_ref']);




	// 첨부파일 링크 프로세스 파트
$download_link = "";
$upload_query = "select * from master_upload_table u where u.upload_id = " . $row['upload_id'] . ";";
$result_set3 = mysqli_query($conn, $upload_query);
if($result_set3){
$update_row = mysqli_fetch_array($result_set3);


if ($update_row['server_name']) {
	$download_link = $_SESSION['root'] . "/storage/former/" . $update_row['server_name'];
}
}


?>

<html>
	<head>
		<title>test</title>
		<meta charset="utf-8" />
		
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		

	
<script language="javascript">
				window.resizeTo(screen.availWidth*0.42,screen.availHeight*0.96); // 지정한 크기로 변한다.(가로,세로)
				//window.resizeBy(500,500); // 지정한 크기만큼 더하거나 빼져서 변한다.





				function hrefClick(fid,index,id){

					var arr = ["","검토 완료","승인","반려"];

						var retVal = confirm("해당 공문을 "+arr[id]+"하시겠습니까?");

					if(retVal==true){
						alert(arr[id]+"처리되었습니다.");
						var popUrl = "./outsource3b_appro.php";
						window.open(popUrl+'?fid=' + fid + '&index=' + index + '&type=' + id,'width=491px,height=' +  screen.availHeight/3);
					}else{
						alert("취소하셨습니다.");
					}
				
				
				}

 </script>

	
<style>



  table {
    width: 100%;

    border-collapse: collapse;
  }
  th, td {
    padding: 5px;
  }

  th:nth-child(2n), td:nth-child(2n) {
    background-color: #;
  }
  th:nth-child(2n+1), td:nth-child(2n+1) {
    background-color: #;
  }

  #wrapper{
	width:800px; height:1220px;
	border: 2px solid black
}

  #first{
	text-align:center;
	margin:15px;
}
  #seocond{
	font-weight:bold;
	border-bottom:2px solid black;
	line-height:50%;
}

  #footer{
	  line-height:75%;
	  margin: 10px; 10px;
  }
  
  #last{
	  width:800px;
	  text-align:right;
	  margin:10px;
  }
  .span1{
	  align:right;
  }
  .watermark {
    opacity: 0.5;
    color: BLACK;
     /* position: fixed; */
    /* top: middle; */
     left: 50%;  
	}
  #sig{
	  opacity: 0.2;
	  display:block;
	  margin-left:auto;
	  margin-right:auto;
	  width:240px;
	  height:240px;
	  position:relative;
      left:280px;;
	  
  }

  </style>


  </head>
	<body>
	<div id="wrapper">
		<div id="first">
			<span><img src="src/su_rsc_sulogo_a.png" width="200" height="120" title="선운로고"/></span>
		</div>
	
		<div id="seocond">
			<p>수 신 : 
				<?php
					foreach($recv_array as &$var){
						$code = $ob6->su_function_decode($var);
						echo $ob2->su_function_convert_name($conn, "master_user_info_table", "SID", $code, "master_user_info_name")."  ";
					}
				?> 
			</p>
			<p>참 조 :
				<?php

				if($ref_array){
					foreach($ref_array as &$var){
						$code = $ob6->su_function_decode($var);
						echo $ob2->su_function_convert_name($conn, "master_user_info_table", "SID", $code, "master_user_info_name")."  ";
					}
				}else{
					echo '--';
				}
				?> 
			</p>
			<p>(경유) : <?php echo " -- " ?> </p>
			<p>제 목 : <?php echo $row['former_title']; ?> </p>
			
		</div>
		
		<div style="height:570px; display:table-row; vertical-align:middle;">  
		<!--내용-->
					<br /><br />
					 <?php echo nl2br($row['former_content']); ?>
		</div>
				<div style="height:240px; display:table-row; vertical-align:bottom; text-align:center;">  
		<!--내용-->
					 <?php if($row['appro_state']==70) echo "<img id='sig' src='./src/sig.png'/>"; ?>
		</div>
		<div id="footer" style="border-top:1px solid black; ">
			<br />


					<table>
						<tr>
							<td colspan=2>작성 : <?php echo $format_orderer_section_name . "  " . $format_orderer_name; ?></td>
							<td colspan=2 rowspan=2 style="vertical-align:top;">검토 <br/><br/>  <?php echo $signature; ?></td>
							<td colspan=2>승인 : <?php echo $signature_last; ?></td>
						</tr>
						<tr>
							<td colspan=6> 문 서 번 호 : <?php echo $docu_code; ?></td>
						</tr>
						<tr>
							<td colspan=2>시 행 일 자 : <?php echo $row['from_date']; ?> </td>
							<td colspan=4>접 수 (               )</td>
						</tr>
						<tr>
							<td colspan=2>우520-831 </td>
							<td colspan=2>전라남도 나주시 산포면 마성2길 5</td>
						</tr>
						<tr>
							<td>전화 062-651-9278</td>
							<td>전송 062-651-9271</td>
							<td>sununeng@hanmail.net</td>
							<td><?php echo $state; ?></td>
					  </tr>
					</table>
								<br />
								# 붙임 
								<?php 
								if ($download_link != '') {
									echo "<a href='$download_link' download>" . $update_row['real_name'] . "</a>";
								}
								else {
									echo " 파일 없음";
								}
								?>
		</div>

	</div>

	<div id="last">
	<?php
	if ($row['appro_state'] == 10) {
		if ($index != 8 && $index != -1) {
			echo "<input type='button' value='검토완료' name='approval' onclick='hrefClick($target,$index,1)';>";
			echo "<input type='button' value='반려' name='approval' onclick='hrefClick($target,$index,3)';>";
		}

		if ($index == 8 && $last_check_valid_trigger == true) {
			echo "<input type='button' value='승인' name='approval' onclick='hrefClick($target,$index,2)';>";
			echo "<input type='button' value='반려' name='approval' onclick='hrefClick($target,$index,3)';>";
		}
	}
	?>
	</div>
	</body>     
</html>