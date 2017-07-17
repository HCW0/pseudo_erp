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


		//임시코드

		if(isset($_SESSION['current_task_level_code'])==false){
			$_SESSION['current_base_date']="";
			$_SESSION['current_limit_date']="";
			$_SESSION['current_task_level_code'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_level_code");
			$_SESSION['current_task_level_sub_code'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_level_sub_code");
			$_SESSION['current_task_order_section'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_order_section");
			$_SESSION['current_task_orderer'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_orderer");
			$_SESSION['current_task_priority'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_priority");
			$_SESSION['current_task_state'] = $ob1->su_function_init_config($conn,$_SESSION['my_sid_code'],"task_state");
		}

		$ob2 = new su_class_value_name_convert_with_code();
			$_SESSION['my_name'] = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$_SESSION['my_sid_code'],"master_user_info_name");
			$_SESSION['my_position'] = $ob2->su_function_convert_name($conn,"master_position_info_table","sid_combine_position",$_SESSION['my_position_code'],"master_position_info_name");
			$_SESSION['my_department'] = $ob2->su_function_convert_name($conn,"master_department_info_table","sid_combine_department",$_SESSION['my_department_code'],"master_department_info_name");


		$ob3 = new su_class_value_combine_combobox_value_to_mysql_query();
		


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



	<head>
		<title>test</title>
		<meta charset="utf-8" />
		
<!--		<meta name="viewport" content="width=device-width, initial-scale=1" />  -->
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=2, user-scalable=yes">

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

  <!--  스마트폰 가로+세로 -->
	@media only screen and (min-device-width : 320px) and (max-device-width : 480px){
	}

  <!--	 스마트폰 가로 --> 
	@media only screen and (min-width : 321px) {
	}

	 <!-- 스마트폰 세로  -->
	@media only screen and (max-width : 320px) {
	}

	<!-- iPhone4와 같은 높은 크기 세로 -->
	@media
	only screen and (-webkit-min-device-pixel-ratio : 1.5),  
	only screen and (min-device-pixel-ratio : 1.5) {  
	
	}

	<!-- iPhone4와 같은 높은 해상도 가로  -->
	@media only screen and (min-width : 640px) {
	}

	<!-- iPad 가로+세로 -->
	@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) {
	}

	<!-- iPad 가로 -->
	@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : landscape) {
	}

	<!-- iPad 세로 -->
	@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) and (orientation : portrait) {
	}

	<!-- 데스크탑 브라우저 가로 -->
	@media only screen and (min-width : 1224px) {
	}

	<!-- 큰 모니터 -->
	@media only screen and (min-width : 1824px) {
	}
	
	  <!-- UI Object 가로 -->
        .h_graph ul{margin:0 50px 0 50px;padding:1px 0 0 0;border:1px solid #ddd;border-top:0;border-right:0;font-size:11px;font-family:Tahoma, Geneva, sans-serif;list-style:none}
        .h_graph li{position:relative;margin:10px 0;vertical-align:top;white-space:nowrap}
        .h_graph .g_term{position:absolute;top:0;left:-50px;width:40px;font-weight:bold;color:#767676;line-height:20px;text-align:right}
        .h_graph .g_bar{display:inline-block;position:relative;height:20px;border:1px solid #ccc;border-left:0;background:#e9e9e9}
        .h_graph .g_bar span{position:absolute;top:0;right:-50px;width:40px;color:#767676;line-height:20px}
       <!--UI Object -->
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
						
				<form action = 'outsource.php' method='POST' name="table_filter">		
						<span>시작일</span>
						<?php
						 echo '<input type="text" name = "task_select_box[]" id="datepicker1" value="'.$_SESSION['current_base_date'].'">'
						?>
						<span>/ 마감일</span>
						<?php
						 echo '<input type="text" name = "task_select_box[]" id="datepicker2" value="'.$_SESSION['current_limit_date'].'">'
						?>
						
						
						
				
				</div>
			
				
			 
				<div style="height: 100% ; 
						width: 100% ;
						 ;">
				<div class="h_graph">
					<table>
						<tr>
						<th rowspan='2'><span>NO</span></th>
						
						<th rowspan='2'>
							등급
						</th>
						
						<th rowspan='2'>
							업무번호
						</th>

						<th rowspan='2'>
							사업명
						</th>
						
						
						<th rowspan='2'>
							발주
							
						</th>
						<th rowspan='2'>
							감독
						</th>
		
						<th colspan='2'>
							계약
						</th>

						<th rowspan='2'>
							착수일
							
						</th>


						<th rowspan='2'>
							준공일
							
						</th>
						

						<th rowspan='2'>
							계약금
							
						</th>


						<th rowspan='2'>
							기성
						</th>


						<th rowspan='2'>
							잔액
						</th>


						<th rowspan='2'>
							비고	
						</th>
						
						<th rowspan='2'>
							상태
						</th>
						<th rowspan='2'>
							진척도
						</th>
						
						
						<td colspan='12'>
						진척도 그래프
						</td>
						
						<th rowspan='2'>
							<input type="submit" name="Release" value="Click">
						</form>		
						</th>
							
						</tr>
				
						<tr>
							<th>시작</th>
							<th>종료</th>
							<th>1월</th>
							<th>2월</th>
							<th>3월</th>
							<th>4월</th>
							<th>5월</th>
							<th>6월</th>
							<th>7월</th>
							<th>8월</th>
							<th>9월</th>
							<th>10월</th>
							<th>11월</th>
							<th>12월</th>		
						</tr>
						
						<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
						<td>.</td>
						<td>.</td>
						<td>.</td>
						<td>.</td>
						<td>.</td>
						<td>.</td>
						<td>.</td>
						<td>.</td>
						<td>.</td>
						<td>.</td>
						<td>.</td>
						<td>.</td>
						<td>.</td>
						<!-- 진척도 그래프-->
						<th colspan='12' style="text-align:left">
							<span class="g_bar" style="width:100%"><span>100%</span></span>
							<p></p>
							<span class="g_bar" style="width:80%"><span>80%</span></span>
						</th>
						</td>
						
						</tr>
				</div>
			

						</tr>
						
		

					</table>
				</div>

		


			<div id="footer" style="padding:600px 0px 0px 1800px;">
						<input type="button" name="버튼" value="업무등록" onclick="window.open('./su_script_table_write_interface.php','win','width=800,height=700,toolbar=0,scrollbars=0,resizable=0')";>

			</div>
				<p style="background-color:coffee" class="bd" align="center">COPYRIGHT(C) 2017 SUNUNENG.ENG ALL RIGHTS RESERVED&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp주소 : 광주광역시 광산구 송정동 735 선운빌딩 3층 <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp연락처 : 062-651-9272 / FAX : 062-651-9271</p>
		
</header>


	<div style="height:1000px">

	<nav id="cd-lateral-nav" >
		<ul class="cd-navigation" >
		
		<div style="margin:70px 0px 30px 0px;">
		<p align="center" ><img src="./src/su_rsc_sulogo_back.png" width="200" height="170" title="선운로고"/></p>
		</div>	
			<li><a class="current" href="#0">* * * *</a></li>

				<a >이름
				<font color='white'><?php
					echo $_SESSION['my_name'];
				?></font></a>
			
				<a>부서
					<font color='white'><?php
					echo $_SESSION['my_department'];
				?></font></a>		
			
				<a>직급
					<font color='white'><?php
					echo $_SESSION['my_position'];
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
			<li><a href="su_script_approbation_interface.php"> # 결제함</a></li>
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