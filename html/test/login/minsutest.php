<!DOCTYPE HTML>

<html>
	<head>
		<title>test</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

	<title>CSS</title>
    <style>
      table {
    width: 100%;
    border-top: 1px solid #444444;
    border-collapse: collapse;
  }
  th, td {
    border-bottom: 1px solid #444444;
    padding: 10px;
    text-align: center;
  }

  th:nth-child(2n), td:nth-child(2n) {
    background-color: #bbbbbb;
  }
  th:nth-child(2n+1), td:nth-child(2n+1) {
    background-color: #aaaaaa;
  }
    </style>
	
	<style type="text/css">
		#head  { background-color:silver; }
		#content { background-color:orange; }
		#footer  { background-color:pink; } 
		</style>
<style>
    .bd{
        vertical-align:bottom;
    }
</style>


  </head>
	<body>

  
	  <div id="wrapper">
		<div id="header">
			<p align="center"><img src="선운로고.png" width="200" height="100" title="선운로고"/></p>
			<p id="head" align="right">업무관리시스템</p	>
			
		</div>
				<div id="head" style="
							padding: 0px  0px  30px  1050px ;">
						<input type="checkbox" name="chk_info" value="반려">반려                         
						<input type="checkbox" name="chk_info" value="미완료">미완료                 
						<input type="checkbox" name="chk_info" value="완료">완료                   
		
						&nbsp&nbsp/&nbsp&nbsp&nbsp마감일 
						<th><select name="년도">
						<option value="">년도</option>
						<option value="2010">2010</option>
						<option value="2011">2011</option>
						<option value="2012">2012</option>
						<option value="2013">2013</option>
						<option value="2014">2014</option>
						<option value="2015">2015</option>
						<option value="2016">2016</option>
						<option value="2017">2017</option>
						</select></th>
		
						<select name="월">
						<option value="">월</option>
						<option value="01">01</option>
						<option value="02">02</option>
						<option value="03">03</option>
						<option value="04">04</option>
						<option value="05">05</option>
						<option value="06">06</option>
						<option value="07">07</option>
						<option value="08">08</option>
						<option value="09">09</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						</select>
		
						<th><select name="일">
						<option value="">일</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>
						</select>
						&nbsp&nbsp/&nbsp&nbsp&nbsp검색
						<select name="검색">
						<option value="">검색</option>
						<option value="제목">제목</option>
						<option value="요청자">요청자</option>
						</select>
						<input type="text" name="searchbox">
				</div>
				<div style="height: 500px ; 
						width: 1800px ;
						border: 5px   solid  black ;">
						<table>
						<thead>
						<tr>
						<th class="jb-th-1">NO</th>
						<th><select name="중요도">
						<option value="">중요</option>
						<option value="O">O</option>
						<option value="X">X</option>
						</th>
						<th><select name="업무코드">
						<option value="">업무코드</option>
						<option value="학생">--</option>
						<option value="회사원">--</option>
						<option value="기타">--</option>
						</select></th>
						<th>업무명</th>
						<th>요청자</th>
						<th>요청일</th>
						<th>마감일</th>
						<th>상태</th>
						</tr>
						</thead>
						</table>
				</div>
			<div style=";
						padding: 20px 10px 10px 1730px;">
						<input type="button" name="버튼" value="업무등록" onclick="window.open('http://naver.com','win','width=1000,height=500,toolbar=0,scrollbars=0,resizable=0')";>

			</div id="footer">
				<p class="bd" align="center">COPYRIGHT(C) 2017 SUNUNENG.ENG ALL RIGHTS RESERVED&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp주소 : 광주광역시 광산구 송정동 735 선운빌딩 3층 <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp연락처 : 062-651-9272 / FAX : 062-651-9271</p>
		</div>
	</body>     
</html>