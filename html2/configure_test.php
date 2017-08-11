<!DOCTYPE html>

<html>

<?php
    session_start();
	$_SESSION['my_sid_code'] = 1;

// 유저 세션 검증
	


// include function
  


//db 연결 파트
  


// class 객체 생성

	


// 하드 코딩된 함수 이하

function toWeekNum($get_year, $get_month, $get_day){
 $timestamp = mktime(0, 0, 0, $get_month, $get_day, $get_year);
 $w = date('w',mktime(0,0,0,date('n',$timestamp),1,date('Y',$timestamp)));
 return ceil(($w + date('j',$timestamp) - 1)/7);
}





		
?>

<!-- 하드 코딩된 함수 이하 -->







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
				
				<div id="combo" style="float:left;">
				
				            업무레벨
							<select name = "task_select_box[]">	
       							 <?php
										
      							  ?>         
   							</select>	
							업무코드
							<select name = "task_select_box[]">	
       							 <?php
										
      							  ?>         
   							</select>	
							발주처
							<select  name = "task_select_box[]">	
       							 <?php
										
      							  ?>          
   							</select>
							발주자
							<select  name = "task_select_box[]">	
       							 <?php
										
      							  ?>          
   							</select>
					
	


	
	</header>


	<nav id="cd-lateral-nav">
		<ul class="cd-navigation">
		<p align="center"><img src="./src/su_rsc_sulogo_a.png" width="200" height="200" title="선운로고"/></p>
			<li><a class="current" href="#0">* * * *</a></li>

				<a >이름
				<font color='white'><?php
					
				?></font></a>
			
				<a>부서
					<font color='white'><?php
					
				?></font></a>		
			
				<a>직급
					<font color='white'><?php
					
				?></font></a>

				<a>사번
					<font color='white'><?php
				
				?></font></a>

				<a href = "./su_script_logout_support.php">로그아웃</a>
			
			</li> 
				
		</ul> 

		
			<a class="current" href="#0">* * * *</a>
			<a href="#0"> ! 공지사항</a></li>
			<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
					<div>과업관리</div>
					</a><DIV style='display:none'> 
					<a>&nbsp&nbsp&nbsp일일 업무관리</a>
					<a>&nbsp&nbsp&nbsp주간 업무관리</a>
					<a>&nbsp&nbsp&nbsp월간 업무관리</a>
					</div>
			<a href="#0"> # 결제함</a></li>
			<a href="#0"> * 설정</a></li>
		<!-- cd-single-item-wrapper -->

		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="assets/js/main.js"></script> <!-- Resource jQuery -->
		<script language="JavaScript" src="assets/js/date_picker.js"></script>

 		<!-- 새로운 달력 자바 스크립트 소스-->
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>                     
      	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		
	</body>     
</html>