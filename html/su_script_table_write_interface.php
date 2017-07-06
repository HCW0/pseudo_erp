<!DOCTYPE html>

<html>
	<head>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<script type="text/javascript" src="/assets/nse_files/js/HuskyEZCreator.js" charset="utf-8"></script>
			<title>글쓰기</title>
			<style>
					@import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
					body {
						font-family: 'Nanum Gothic', sans-serif;
					}
					.nse_content{width:660px;height:500px}
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
	<body style="width:100%">
	
		<div id="wapper" style="background-color: ivory; width:100%;">
			
				
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div align="center">헤 더</div>
					</a><DIV style='display:none'> 
					<table>
					<tr>
						<td>업 무 명</td>
						<td><input type=text name=reception size=30 ></td>
						<td>발 주 처</td>
						<td><input type=text name=reception size=30 ></td>
					</tr>
					<tr>
						<td>업 무 번 호</td>
						<td><input type=text name=reference size=30></td>
						<td>발 주 자</td>
						<td><input type=text name=reception size=30 ></td>
					</tr>
					<tr>
						<td>업 무 레 벨</td>
						<td><input type=text name=via size=30></td>
						<td>우 선 도</td>
						<td><input type=text name=reception size=30 ></td>
					</tr>
					<tr>
						<td>업 무 코 드</td>
						<td><input type=text name=title size=30></td>
						<td>상 태 명</td>
						<td><input type=text name=reception size=30 ></td>
					</tr>
					<tr>
						<td>과 업 기 간</td>
						<td><input type=text name=title size=30></td>
						<td>수 행 기 간</td>
						<td><input type=text name=reception size=30 ></td>
					</tr>
					<tr>
					</table>
					</div>
				
					<div style="padding:10px 0 0 0;">
					</div>
		
		
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					
					
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<div align="center">상 세</div>
					</a><DIV style='display:none'> 
					<table>
					<tr>
						<td>업 무 명</td>
						<td><input type=text name=reception size=30 ></td>
						<td>발 주 처</td>
						<td><input type=text name=reception size=30 ></td>
					</tr>
					<tr>
						<td>업 무 번 호</td>
						<td><input type=text name=reference size=30></td>
						<td>발 주 자</td>
						<td><input type=text name=reception size=30 ></td>
					</tr>
					<tr>
						<td>업 무 레 벨</td>
						<td><input type=text name=via size=30></td>
						<td>우 선 도</td>
						<td><input type=text name=reception size=30 ></td>
					</tr>
					<tr>
						<td>업 무 코 드</td>
						<td><input type=text name=title size=30></td>
						<td>상 태 명</td>
						<td><input type=text name=reception size=30 ></td>
					</tr>
					<tr>
						<td>과 업 기 간</td>
						<td><input type=text name=title size=30></td>
						<td>수 행 기 간</td>
						<td><input type=text name=reception size=30 ></td>
					</tr>
					<tr>
					</table>
					</div>
					
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
						<p align="center">내 용</p>
					</a><DIV style='display:none'> 
					<textarea name="ir1" id="ir1" class="nse_content" rows ="17" cols="75"></textarea>
				<!--	<script type="text/javascript" src="/smart/js/HuskyEZCreator.js" charset="utf-8"></script>
				 <script type="text/javascript">
				 var oEditors = [];
				 nhn.husky.EZCreator.createInIFrame({
				  oAppRef: oEditors,
				  elPlaceHolder: "ir1",
				  sSkinURI: "/assets/nse_files/SmartEditor2Skin.html", 
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
                            

				  	* 이거 주석 풀면, 네이버 스마트 에디터 가동됨
					* 주석 걸려 있다면, 그냥 텍스트아레아임

							
							                       -->
					</div>
				
						
					<tr>
						<td colspan=2><hr size=1></td>
					</tr>
					<tr>
					
					<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
					<p align="center">첨 부 파 일</p>
					</a><DIV style='display:none'> 
					
					<form name="write">
					 <table id='insertTable' border=0 cellpadding=0 cellspacing=0>

						<tr>

							<td valign=bottom>

								<INPUT type='file' maxLength='100' name='filename1' size='25'>

							</td>

							<td >
								
								&nbsp&nbsp
								<input type="button" value="추가" onClick="addFile(this.form)" border=0 style='cursor:hand'>
								/			
								<input type="button" value="삭제" onClick='deleteFile(this.form)' border=0 style='cursor:hand'>

							</td>

							</tr>
	
						</table>

						<input type="hidden" name="rowCount" value="1">

					</form>        

					</div>

					

					<!--검토자 고려해서 만들기-->
					
					<tr>
						<div style="text-align:center; margin:10px 0 0 0;">
						<input type="submit" value="확인" >&nbsp;&nbsp;
						<input type="button" value="뒤로" onclick="move('Board_List.jsp');"></div>
						</td>
					</tr> 
			
		</div>
		

	</body>
</html>