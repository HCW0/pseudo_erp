<!DOCTYPE HTML>

<html>
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


  </head>
	<body>

	
		<header>
			<a id="cd-menu-trigger" href="#0"><span class="cd-menu-text">메뉴</span><span class="cd-menu-icon"></span></a>

			
		<div id="wrapper" style="width:1900px" "height:300px">
				<p align="center"><img src="선운로고.png" width="200" height="100" title="선운로고"/></p>
				<p id="head" align="right">업무관리시스템</p>
					
					<div id="head" align="right">
							
						
							<span>시작일</span>
							<input type="text" name="target_date">
							<input type="button" value="Date" onClick="datePicker(event,'target_date')">
							<span>/ 마감일</span>
							<input type="text" name="target_date">
							<input type="button" value="Date" onClick="datePicker(event,'target_date',1)">
							
							
							</select>
							&nbsp&nbsp/&nbsp&nbsp&nbsp검색
							<select name="검색">
								<option value="">검색</option>
								<option value="제목">제목</option>
								<option value="요청자">요청자</option>
							</select>
							<input type="text" name="searchbox">
					
					</div>
				
					
				 
					<div style="height: 100% ; 
							width: 100% ;
							margin:10px ;">

													<table>
							<tr>
							<th class="jb-th-1">NO</th>
							<th><select name="중요도">
							<option value="">중요</option>
							<option value="O">O</option>
							<option value="X">X</option>
							</th>
							<th>제목</th>
							<th>발신자</th>
							<th>상태</th>
							</tr>
							<?php
							
							$host = 'localhost';
							$user = 'root';
							$pw = '1234';
							$dbName = 'minsu';
							$mysqli = new mysqli($host, $user, $pw, $dbName);
							
				
							 if(mysqli_connect_errno())
									{
										echo "DB connect error";
									}
									
									$sql = "SELECT * FROM paper";
									$res = $mysqli->query($sql);
									$num_result = $res->num_rows;
									
							
							for($i=0; $i<$num_result; $i++)
							{
								$row = $res->fetch_assoc();
								echo "<tr>";
								echo "<td align='center'>".$row['이름']."</td>";
							  
								echo "<td align='center'>".$row['no']."</td>";

								echo "<td align='center'>
							<num=".$row['num']."'>".$row['제목']."</a></td>";       
								echo "<td align='center'>
							<num=".$row['num']."'>".$row['상태']."</a></td>";                    
								echo "</tr>";
							if(time() - strtotime($글작성날짜) <= 60 * 60 * 24 * 2){
								echo "<img src='new.png' alt='new' />";
							}
							}
							
							  mysqli_close($mysqli);
				 
							  
							?> 
							</table>
					</div>
					
				<div id="footer" style="padding:600px 0px 0px 1800px;">
							<input type="button" name="버튼" value="공문등록" onclick="window.open('http://localhost/paper-write.php','win','width=670,height=540,toolbar=0,scrollbars=10,resizable=0')";>

				</div>
					<p style="background-color:coffee" class="bd" align="center">COPYRIGHT(C) 2017 SUNUNENG.ENG ALL RIGHTS RESERVED&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp주소 : 광주광역시 광산구 송정동 735 선운빌딩 3층 <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp연락처 : 062-651-9272 / FAX : 062-651-9271</p>
			
		</header>


		<nav id="cd-lateral-nav">
			<ul class="cd-navigation">
			<p align="center"><img src="선운로고.png" width="200" height="200" title="선운로고"/></p>
				<li class="item-has-children">
					<a >이름</a>
				<!--	<ul class="sub-menu">
						<li><a href="#0">Brand</a></li>
						<li><a href="#0">Web Apps</a></li>
						<li><a href="#0">Mobile Apps</a></li>
					</ul> -->
				</li> <!-- item-has-children -->

				<li class="item-has-children">
					<a>부서</a>
				<!--	<ul class="sub-menu">
						<li><a href="#0">Product 1</a></li>
						<li><a href="#0">Product 2</a></li>
						<li><a href="#0">Product 3</a></li>
						<li><a href="#0">Product 4</a></li>
						<li><a href="#0">Product 5</a></li>
					</ul> -->
				</li> <!-- item-has-children -->

				<li class="item-has-children">
					<a>직급</a>
				<!--	<ul class="sub-menu">
						<li><a href="#0">London</a></li>
						<li><a href="#0">New York</a></li>
						<li><a href="#0">Milan</a></li>
						<li><a href="#0">Paris</a></li>
					</ul> -->
				</li> <!-- item-has-children -->
			</ul> <!-- cd-navigation -->

			<ul class="cd-navigation cd-single-item-wrapper">
				<li><a href="#0">Tour</a></li>
				<li><a href="#0">Login</a></li>
				<li><a href="#0">Register</a></li>
				<li><a href="#0">Pricing</a></li>
				<li><a href="#0">Support</a></li>
			</ul> <!-- cd-single-item-wrapper -->

			<ul class="cd-navigation cd-single-item-wrapper">
				<li><a class="current" href="#0">Journal</a></li>
				<li><a href="#0">FAQ</a></li>
				<li><a href="#0">Terms &amp; Conditions</a></li>
				<li><a href="#0">Careers</a></li>
				<li><a href="#0">Students</a></li>
			</ul> <!-- cd-single-item-wrapper -->

			
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
			<script src="assets/js/main.js"></script> <!-- Resource jQuery -->
			<script language="JavaScript" src="assets/js/date_picker.js"></script>

			
	</body>     
</html>