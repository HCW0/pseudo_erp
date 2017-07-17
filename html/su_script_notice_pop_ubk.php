<!DOCTYPE html>


<?php
	echo $_GET['notice_id'];
?>



<html>
<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>글쓰기</title>
<style>
		@import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
		body {
			font-family: 'Nanum Gothic', sans-serif;
		}
</style>




</head>

<!-- 상황에따라서 스마트에디터 사용 일단 서술식 텍스트-->
<body>

<div id="wapper" style="background-color: ivory; width:500px; height:500px;">
	<table summary="글쓰기 전체 테이블">
		
		
   		<colgroup>
   			<col width="100%">
   			<col width="100%">
   		</colgroup>
   	

		<table summary="테이블 구성" >
		<caption style="margin:10px;">반 려</caption>	
    		<tr>
				<td>제 목</td>
				<td><input type=text name=reception size=65 maxlength=65></td>
			</tr>
     			<td>사 유</td>
     			<td><textarea name=content rows ="23" cols="50"></textarea></td>
    		</tr>
    		<tr>
     			<td colspan=2><hr size=1></td>
    		</tr>
			
			<!--검토자 고려해서 만들기-->
			
    		<tr>
     			<td colspan="2"><div align="center">
     			<input type="submit" value="반려" >&nbsp;&nbsp;
         		<input type="button" value="뒤로" onclick='self.close()'></div>
     			</td>
    		</tr> 
				
		</table>
	</form> 
</table>
</div>

</body>
</html>