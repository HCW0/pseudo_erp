<!DOCTYPE HTML>

<html>
	<head>
		<title>test</title>
		<meta charset="utf-8" />
		
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		

	
	
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
	  line-height:70%;
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
  </style>


  </head>
	<body>
	<div id="wrapper">
		<div id="first">
			<span><img src="선운로고.png" width="200" height="120" title="선운로고"/></span>
		</div>
	
		<div id="seocond">
			<p>수 신 : </p>
			<p>참 조 : </p>
			<p>(경유) : </p>
			<p>제 목 : </p>
			
		</div>
		
		<div style="height:820px; border-bottom:4px solid gray">
		<!--내용-->
		
		</div>
		
		<div id="footer">
		
			<span>작성 </span>
			&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			<span>검토 </span>
			&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			<span>승인 </span>
			<p> 문 서 번 호 : </p>
			<pre>시 행 일 자 :                                 접 수 (               )</pre>
			<p> 우520-831 &nbsp&nbsp&nbsp&nbsp 전라남도 나주시 산포면 마성2길 5</p>
			<p> 전화 062-651-9278 &nbsp&nbsp&nbsp/&nbsp&nbsp&nbsp 전송 062-651-9271&nbsp&nbsp&nbsp /&nbsp&nbsp&nbsp sununeng@hanmail.net &nbsp&nbsp&nbsp/&nbsp&nbsp&nbsp 공개
		</div>
	</div>

	<div id="last">
		<input type="button" value="결재" name="approval" onclick="window.open('http://localhost/approval.php','win','width=500,height=500,toolbar=0,scrollbars=0,resizable=0')">
		&nbsp&nbsp&nbsp/&nbsp&nbsp&nbsp
		<input type="button" value="반려" name="return" onclick="window.open('http://localhost/return.php','win','width=500,height=500,toolbar=0,scrollbars=0,resizable=0')";>		
	</body>     
</html>