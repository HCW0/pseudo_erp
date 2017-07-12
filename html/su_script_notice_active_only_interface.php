<!DOCTYPE html>

<html>

<?php
    session_start();

	if(!isset($_SESSION['most_significient_login_flag']))
	$_SESSION['most_significient_login_flag'] = 514;


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


		//임시코드

		$ob2 = new su_class_value_name_convert_with_code();

		$ob3 = new su_class_value_combine_combobox_value_to_mysql_query();
		


// 하드 코딩된 함수 이하

	$_SESSION['my_name'] = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$_SESSION['my_sid_code'],"master_user_info_name");
			$_SESSION['my_position'] = $ob2->su_function_convert_name($conn,"master_position_info_table","sid_combine_position",$_SESSION['my_position_code'],"master_position_info_name");
			$_SESSION['my_department'] = $ob2->su_function_convert_name($conn,"master_department_info_table","sid_combine_department",$_SESSION['my_department_code'],"master_department_info_name");






		
?>

<!-- 하드 코딩된 함수 이하 -->


<script> 
function hrefClick(course){
      // You can't define php variables in java script as $course etc.


	  	var popUrl = "/su_script_notice_pop_up.php";	//팝업창에 출력될 페이지 URL
		var popOption = "width=370, height=360, resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
		window.open(popUrl+'?notice_id=' + course,popOption,'width=520px,height=380px');


    
}
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
		<a id="cd-menu-trigger" href="#0"><span class="cd-menu-text">메뉴</span><span class="cd-menu-icon"></span></a>

		
	<div id="wrapper" style="width:1900px" "height:300px">
			<p align="center"><img src="./src/su_rsc_sulogo_a.png" width="200" height="100" title="선운로고"/></p>
				
		
						
				<form action = 'outsource.php' method='POST' name="table_filter">		

		
				
			 
				<div style="height: 100% ; 
						width: 100% ;
						 ;">

					<table>
						<tr>
						<th><span>NO</span></th>

						<th>
							공지번호
						</th>

						
						<th>
							공지등급
						</th>
						
						
						<th>
							공지이름
						</th>

						<th>
							공지기간
						</th>

						<th>
							개시일
						</th>

						<th>
							개시자
						</th>


						<th>
							담당부서	
						</th>
						

						<th>
							상태
						</th>

						
		<?php
			$cnt = 1;
			$date = date("Y-m-d");
			$task_table_query = "select * from notice_document_header_table u where u.notice_base_date <= '$date' AND  u.notice_limit_date >= '$date';";
			$result_set = mysqli_query($conn,$task_table_query);
            while($row = mysqli_fetch_array($result_set)) {
            ?>
                <tr>
					<td><?php echo $cnt++?></td>
                    <td><?php echo $row['notice_id']?></td>
					<td><?php 
						switch($row['notice_priority']){
							case 0 : echo '보통'; break;
							case 1 : echo '긴급'; break;
						}
					?></td>

					<td>

<?php
    
      echo "<a href='#' onclick='hrefClick(".$row['notice_id'].");'/>".$row['notice_name']."</a><br>";
    
?>



					</td>

					<td><?php echo $row['notice_base_date']."~".$row['notice_limit_date']?></td>
					<td><?php echo $row['notice_birth_date']?></td>
					<td><?php
							echo $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['notice_orderer'],"master_user_info_name");
						?></td>
					<td><?php
							echo $ob2->su_function_convert_name($conn,"master_department_info_table","sid_combine_department",$row['notice_order_section'],"master_department_info_name");
						?></td>
					<td><?php 
						$is_valid = (time() >= strtotime($row['notice_base_date'])) && (time() <= strtotime($row['notice_limit_date']));
					echo $is_valid ? '활성중' : '비활성'; ?></td>
                </tr>

            <?php
            }
            ?>

					</table>
				</div>

		


			<div id="footer" style="padding:600px 0px 0px 1800px;">
						<input type="button" name="버튼" value="공지등록" onclick="window.open('./su_script_notice_write_interface.php','win','width=700,height=350,toolbar=0,scrollbars=0,resizable=0')";>

			</div>
				<p style="background-color:coffee" class="bd" align="center">COPYRIGHT(C) 2017 SUNUNENG.ENG ALL RIGHTS RESERVED&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp주소 : 광주광역시 광산구 송정동 735 선운빌딩 3층 <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp연락처 : 062-651-9272 / FAX : 062-651-9271</p>
		
</header>

	<div style="height:1000px">


	<nav id="cd-lateral-nav" >
		<ul class="cd-navigation" >
		<p align="center"><img src="./src/su_rsc_sulogo_back.png" width="200" height="100" title="선운로고"/></p>
			<li><a class="current" href="#0">* * * *</a></li>

				<a >이름
				<font color='white'><?php
					echo $_SESSION['my_name'];
				?></font></a>
			
				<a>부서
					<font color='white'><?php
					echo  $_SESSION['my_department'];
				?></font></a>		
			
				<a>직급
					<font color='white'><?php
					echo  $_SESSION['my_position'];
				?></font></a>

				<a>사번
					<font color='white'><?php
					echo $_SESSION['my_sid_code'];
				?></font></a>

				<a href = "./su_script_logout_support.php">로그아웃</a>
			
			</li> 
				
		</ul> 

		<ul class="cd-navigation cd-single-item-wrapper">
			<li><a class="current" href="#0">* * * *</a></li>
			<li>
			
			<a href="#0"> 
			<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div>! 공지사항</div>
					</a><DIV style='display:none'> 
					<a href = "./su_script_notice_active_only_interface.php" align = "right">
				<font color='white' >
				공지사항
				</font></a>
			
				<a href = "./su_script_notice_interface.php" align = "right">
					<font color='white'>
					공지사항 게시판
					</font></a>		
			
						</DIV>
			</a>
			
			
			</li>
			<li><a href="su_script_user_interface.php"> # 업무관리</a></li>
			<li><a href="#0"> # 결제함</a></li>
			<li><a href="su_script_configure_interface.php"> # 설정</a></li>
		</ul> <!-- cd-single-item-wrapper -->

		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="assets/js/main.js"></script> <!-- Resource jQuery -->
		<script language="JavaScript" src="assets/js/date_picker.js"></script>

 		<!-- 새로운 달력 자바 스크립트 소스-->
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>                     
      	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		
		</div>
	</body> 





		















</html>