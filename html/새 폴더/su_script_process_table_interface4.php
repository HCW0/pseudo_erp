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

	$ob2 = new su_class_value_name_convert_with_code();

	$all_Money = 0;
	$use_Money = 0;
	$remaind_Money = 0;
?>

<!DOCTYPE>
<head> 
<meta charset="utf-8"> 
<title>공정표</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/flatpickr/dist/flatpickr.min.css">
<script src="https://unpkg.com/flatpickr"></script>


<style type="text/css">
	@import url('http://fonts.googleapis.com/earlyaccess/nanumgothic.css');
	body, table, div, p 		   { font-family:'Nanum Gothic';    }
	body,div       				   { margin : 0; 	 padding : 0;   }
	select { outline : none;}
	option { text-align : right; }
	a 	   { }

	.BOX 	       				   { margin : 0; 	 padding : 0;     width:100%; height:100%; background : gray; position : relative;}
	.BOX .menu_area    			   { width : 0;  height : 100%;   background : black;      float : left; display : inline-block; color : white; margin-right : 10px;}
	.BOX .document_area 		   { width : 2000px; height : 100%;   background : #FFFFFF;   }	
	.BOX .document_area .filterBOX { width : 1700px; height : 30px;   background : #FFFFFF;   }
	.BOX .document_area .filterBOX TABLE  			  { display : inline-block; margin : 0; padding : 0; }
	.BOX .document_area .filterBOX TABLE tr td 		  { width : 170px;}
	.BOX .document_area .filterBOX input[type=button] { margin : 0; padding-top : 5px; border : none; background : white; float : right; outline : none;}
	.BOX .document_area .filterBOX select 			  { border : none; height : 20px;}
	.BOX .document_area .filterBOX #search			  { border-bottom : 1px solid #007BE6; width : 120px;}
	.BOX .document_area .filterBOX #search a		  { text-decoration : none; color : black;}
	.BOX .document_area .filterBOX #searchText 		  { outline : none; border : none;}
	
	.BOX .document_area .dataArea .dataTable .table   		    { width : 1700px; border : 1px solid black;	border-collapse : collapse;	} 
	.BOX .document_area .dataArea .dataTable .table>tr>td 	    { border : 1px solid black;	display : inline-block;}
	.BOX .document_area .dataArea .dataTable table #titleRow 	{ width : 100px;	text-align : center; background : #FFFFFF;	}
	.BOX .document_area .dataArea .dataTable table #filter_last>td:first-child  {	text-align : center;}
	.BOX .document_area .dataArea .dataTable table #filter_last 				{	text-align : right;	height : 50px; }

	.BOX .document_area .dataArea .dataTable table .c0 { background-color : white;}
	.BOX .document_area .dataArea .dataTable table .c1 { background-color : #DCF2D6;}
	.BOX .document_area .dataArea .dataTable table #rowData 			{ text-align : right; }
	.BOX .document_area .dataArea .dataTable table #rowData:hover	{ background : #E0E6F8; }
	.BOX .document_area .dataArea .dataTable table #rowData td			{ text-align : right; min-width:100%;}
	.BOX .document_area .dataArea .dataTable table #rowData .title 		{ text-align : left; padding-left : 10px; width:315px;}
	.BOX .document_area .dataArea .dataTable table #rowData .coworker	{ width : 100px;}
	.BOX .document_area .dataArea .dataTable table #rowData ._m 		{ text-align : right; }
	.BOX .document_area .dataArea .dataTable table #rowData #false 		{ background : yellow;}
	.BOX .document_area .dataArea .dataTable table #rowData #true 		{ background : green; }
	.BOX .document_area .dataArea .dataTable table #rowData td 			{ text-align : center; }
	.BOX .document_area .dataArea .dataTable table #inputLine td     	{ margin : 0;  padding:0;   height:27px; text-align:center;}
 	.BOX .document_area .dataArea .dataTable table #inputLine .inputTEXT
	{  margin : 0;  padding:0px; padding-bottom:0px; width:100%; height :27px; outline:none; border:none; background:white; text-align:center;}

	.BOX .document_area .dataArea .dataTable table #inputLine .inputTEXT:hover { border-bottom : 1px solid green; width:100%; }
	.BOX .document_area .dataArea .dataTable table #inputLine .inputTEXT:focus { background : yellow; }	

	.BOX .document_area .dataArea .setting .setting_Table 				{ width : 1700px;	border : 1px solid black;	border-bottom : none;	}
	.BOX .document_area .dataArea .setting .setting_Table tr:first-child{ text-align : center; }

</style>

<script type="text/javascript">
	
	// Event를 위해서 만들어 놓은 전역 변수
	var elements = null;
	
	// No : countting
	var count = 0;
	
	// column change Color
	var line = 0;

	var am = ""; // all_money 
	var um = ""; // use_money
	var rm = ""; // remain_money

	$(function(){

		$(".date").flatpickr({
			dateFormat: "y.m.d"
		});

		// 누르는 값에 따라 실시간 DB 조회 혹은 등등 function을 위해 남겨 놓은 코드
		elements = document.querySelectorAll('input[class="inputTEXT"]');
		for(var i=0; i<elements.length; i++){
			elements[i].addEventListener('click',action);
		}
	})

	// 실제 action 되는 함수
	function action(event){
		console.dir(event);
	}

	// 상태 필드를 클릭하면 해당 필드의 상세 정보를 볼 수 있도록 하려고 했으나
	// tr 단위로 클릭하면 볼 수 있게 수정해야 할 것이다.
	function state_activity(obj,n,t){
		$.post('../ajax_code_generator/ajax_detail_interface4.php?list_num='+n,function(data){
			
		});
	}

	//특수문자, 날짜 정규화
	function regExp(string){
		var str = string;
		var regExp = /[\{\}\\/?,.;:|\)*~`!^\-_+<>@\#$%&\\\=\(\'\"]/gi;
		
		if(regExp.test(str) ){
			alert("특수 문자는 제한 됩니다.");
			return false;
		}
		return true;
	}

	// 추가 버튼 함수
	function insertData(){

		// field라는 name을 가지고 있는 모든 element들을 배열 형태로 fields에 담는다.
		var data = [];
		var fields = document.getElementsByName("field");

		for(var i=0; i<fields.length; i++){
			var field = fields[i];
			if(field.value.trim() == "" || field.value.trim() == null ){
				alert("빈 칸이 있습니다.");
				$("#"+field.id).focus();
				return;
			}
		}

		// 특수 문자 유효성을 검증하기 위한 함수입니다.
		for(var i=0; i<fields.length; i++){
			if(!regExp(field.value.trim())){
				$("#"+field.id).focus();
				return;
			}
		}

		// 그리고 각 element들의 value 값을 배열 data에 담는다.
		for(var i=0; i<fields.length; i++){
			data[i] = fields[i].value;
		}

		// 위 두 단계에 걸쳐 데이터만 존재하는 배열을 ajax 함수 인자에 추가한다.
		$.post('../ajax_code_generator/ajax_detail_interface4.php?data='+data+"&count="+count+"&line="+line,function(data){		
			// append 와 반대로 앞에 추가된다.
			$("#inputLine").before(data);
			
			count++;

			// tr 별로 색상 바꾸기 flag
			if(line==0){ line=1; }else{ line=0;	}
			
			// 입력 필드를 초기화 한다.
			for(var i=0; i<fields.length; i++){
				fields[i].value="";
			}

			// 여러개의 .rowData 중에서 마지막번째 tr 중 클래스 .m을 가진 element들을 배열로 가져온다.
			var _m = $(".rowData:last>._m");
			
			// String Data 이면서 ','가 추가 되어 있기 때문에 ','를 지우고 형변환 후에 전역 변수 am,um,rm에 add한다.
			am=Number(eval(am,parseInt(_m[0].textContent.replace(",",""))));
			um+=parseInt(_m[1].textContent.replace(",",""));
			rm+=parseInt(_m[2].textContent.replace(",",""));

			var m_arr = [ am, um, rm] ;
			for(var i=0; i<3; i++){
				// 위 에서 합산된 데이터를 sum 필드에 초기화 하기 전에 ','를 붙여주는 작업을 한다. function numberWithCommas()
				$(".tm").eq(i).html(numberWithCommas(m_arr[i]));
			}
		});
	}
	
	// 화폐 단위 마다 콤마(,)를 찍기 위한 정규식 사용 함수
	function numberWithCommas(x) {
    	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	var oldObj = "";
	var state = "";
	var kind = "DESC";

	function order(obj,comm){
	
		if(oldObj!=obj){
			$(oldObj).val("▲");
		}
		oldObj = obj;

		if($(obj).val()=="▲"){
			state = "▼";
			kind = "DESC";
		}else{
			state = "▲";
			kind = "ASC";
		}
		orderBy(kind,comm);
		$(obj).val(state);		
	}

	function orderBy(kind,comm){
		$.post('../ajax_code_generator/ajax_detail_interface4.php?order='+kind+'&col='+comm+"&count="+count+"&line="+line,function(data){		
			$(".rowData").remove();
			$("#inputLine").before(data);
		});
	}

</script>
</head>
<body>
	<div class="BOX">
		<div class="menu_area">
			<h3>MENU</h3>
		</div>

		<div class="document_area">
			
			<h2>용역 관 리 대 장</h2>
			
			<div class="filterBOX">
				<table>
					<tr>
						<td>
							<span>사업년도 : </span>
							<select name="" id="">
								<option value="">1900</option>
								<option value="">1950</option>
								<option value="">2000</option>
							</select>

							<select name="" id="">
								<option value="">01</option>
								<option value="">06</option>
								<option value="">12</option>
							</select>
						</td>

						<td>
							<span>등급 : </span>
							<select name="" id="">
								<option value="">01</option>
								<option value="">02</option>
								<option value="">03</option>
							</select>
						</td>

						<td>
							<span>본부 : </span>
							<select name="" id="">
								<option value="6">기술연구소</option>
								<option value="5">전력사업</option>
								<option value="4">공간정보</option>
								<option value="7">경영지원</option>
								<option value="8">총괄</option>
							</select>
						</td>

						<td>
							<span>부서 : </span>
							<select name="" id="">
								<option value="">디자인</option>
								<option value="">개발</option>
								<option value="">기획</option>
							</select>
						</td>

						<td>
							<span>담당자 : </span>
							<select name="" id="">
								<option value="">오창주</option>
								<option value="">정미소</option>
								<option value="">황치원</option>
								<option value="">민병희</option>
							</select>
						</td>

						<td>
							<span>상태 : </span>
							<select name="" id="">
								<option value="">전체</option>
								<option value="">진행</option>
								<option value="">완료</option>
							</select>
						</td>
						<td id="search">
							<input type="text" name="" id="searchText" size="8">
							<a href="#">검색</a>
						</td>
					</tr>
				</table>
				<input type="button" value="[조회☞]">
			</div>

			<div class="dataArea">
				<div class="setting">
					<!-- 필터링 옵션 세팅은 자신의 정보를 기본으로 Default setting 시킨다.  -->
					<!-- 그리고 해당 class=setting 영역에서는 Default setting 값을 보여준다.  -->
					<table class="setting_Table">
						<tr>
							<td colspan=7>
								<h2>용 역 관 리 대 장</h2>
							</td>
						</tr>
						<tr>
							<td><span>조회기준일 : </span></td>
							<td><span>사업년도 : </span></td>
							<td><span>업무등급 : </span></td>
							<td><span>본부 : </span></td>
							<td><span>부서 : </span></td>
							<td><span>담당자 : </span></td>
							<td><span>상태 : </span></td>
						</tr>
					</table><!-- setting_Table end --> 	
				</div><!-- setting end -->

				<div class="dataTable">
					<table class="table" border="1" >
						<tr id="titleRow">
							<td>No</td>
							<td>관리번호</td>
							<td>사업명</td>
							<td>
								발주처
								<input type="button" value="▲" onclick="order(this,'c_t');" 
								style="width : 15px; height : 15px; border : none; text-align:center;
								background : #FFFFFF; outline : none; margin:0; padding:0;
								">
								</td>
							<td>발주감독</td>
							<td>영업담당</td>
							<td>담당팀</td>
							<td>담당팀장</td>
							<td>
								계약일
								<input type="button" value="▲" onclick="order(this,'f_d');" 
								style="width : 15px; height : 15px; border : none; text-align:center;
								background : #FFFFFF; outline : none; margin:0; padding:0;
								">
							</td>
							<td>착수일</td>
							<td>준공일</td>
							<td>
								계약금액
								<input type="button" value="▲" onclick="order(this,'a_m');" 
								style="width : 15px; height : 15px; border : none; text-align:center;
								background : #FFFFFF; outline : none; margin:0; padding:0;
								">
							</td>
							<td>기성액</td>
							<td>잔액</td>
							<td>비고</td>
							<td>상태</td>
							<td>
								수금
								<input type="button" value="▲" onclick="order(this,'g_m');" 
								style="width : 15px; height : 15px; border : none; text-align:center;
								background : #FFFFFF; outline : none; margin:0; padding:0;
								">
							</td>
						</tr>
							<!-- Data 출력 스크립트릿  -->
							<?php
								$arr1   = "master_task_level_sub_code"; 		// 관리번호
								$arr2   = "master_task_level_sub_name";  		// 사업명
								$arr3   = "master_name"; 				  		// 발주처		참조 master_customer
								$arr4   = "coworker"; 			 				// 발주감독
								$arr5   = "master_user_info_name"; 		  		// 영업담당	   참조 sub_level_orderer 
								$arr6   = "master_department_info_name"; 		// 담당팀		참조 sub_level_section
								$arr7   = "master_user_info_name"; 	  			// 담당팀장    참조 master_department_info_name
								$arr8   = "sub_level_from_date"; 		  		// 계약일    
								$arr9   = "sub_level_birth_date"; 		 		// 착수일    
								$arr10  = "sub_level_to_date"; 		  			// 준공일    
								$arr11  = "all_money_master_code_field"; 		// 계약금액  
								$arr12  = "use_money_master_code_field"; 		// 기성액    
								$arr13  = "remaind_money_master_code_field"; 	// 잔액      
								$arr14  = "etcetera"; 							// 비고	   
								$arr15  = "complete_rate";						// 상태	   
								$arr16  = "";									// 수금
								 										  
								$arr17  = "sub_level_orderer"; 
								$arr18  = "sub_level_section";

								// 직책은   sub_level_position
								// 영업담당 master_user_info_table     : master_user_info_name 
								// 발주처 master_customer_table        : master_code / master_name
								// 담당팀 master_department_info_table : sid_combine_department / master_department_info_name						
								
								$query =   "SELECT
												mt.$arr1, 
												mt.$arr2, 
												mc.$arr3,
												mt.$arr4,
												mu.$arr5,
												md.$arr6,
												
												mt.$arr8,
												mt.$arr9,
												mt.$arr10,
												mt.$arr11,
												mt.$arr12,
												mt.$arr13,
												mt.$arr14,
												mt.$arr15
											FROM 	
												master_task_level_sub_info_table mt, 
												master_customer_table mc,
												master_department_info_table md, 
												master_user_info_table mu	
											WHERE 
												mt.master_customer = mc.master_code AND
												mt.sub_level_orderer = mu.SID AND
												mt.sub_level_order_section = md.sid_combine_department
												ORDER BY sub_level_to_date DESC
											";

     							$result = mysqli_query($conn,$query);  
								$count = 0;
								$am = 0;
								$um = 0;
								$rm = 0;
								$line = "1";

								while($row=mysqli_fetch_array($result))
								{         
									$all_Money += $row[9];
									$use_Money += $row[10];
									$remaind_Money += $row[11];

									$count++;
									

									$rowNum = array(9,10,11);
									$moneyArry = array();
									for($i=0; $i<3; $i++){
										$moneyArry[$i] = number_format($row[$rowNum[$i]]);
									}

									$rowDay = array(6,7,8);
									$dayArray = array();
									for($i=0; $i<3; $i++){
										$dayArray[$i] =  date("y.m.d",strtotime($row[$rowDay[$i]]));
									}


									if(		$row[13] == "진행중"){$activity ="false";	}
									else{	$activity ="true";	}

									// 삼항식으로 줄여 주세요
									if( $line == "0" ){ 
										$line = "1";
									}else {
										$line = "0";
									}

									echo (
									"
									<tr id=\"rowData\" class=\"c$line rowData\" onclick=\"state_activity(this.id,$row[0]);\">
										<td style=\"width:1%;\">$count</td>
										<td style=\"width:6%;\">$row[0]</td>
										<td style=\"width:23%;\" class=\"title\">$row[1]</td>
										<td style=\"width:6%;\">$row[2]</td>
										<td style=\"width:4%;\" class=\"coworker\">$row[3]</td>
										<td style=\"width:4%;\">$row[4]</td>
										<td style=\"width:5%;\">$row[5]</td>
										<td style=\"width:4%;\">6</td>
										<td style=\"width:4%;\">$dayArray[0]</td>
										<td style=\"width:4%;\">$dayArray[1]</td>
										<td style=\"width:4%;\">$dayArray[2]</td>
										<td style=\"width:7%;\" class=\"_m\">$moneyArry[0]</td>
										<td style=\"width:7%;\" class=\"_m\">$moneyArry[1]</td>
										<td style=\"width:7%;\" class=\"_m\">$moneyArry[2]</td>
										<td style=\"width:4%;\">$row[12]</td>
										<td style=\"width:4%;\" id=\"$activity\">$row[13]</td>
										<td style=\"width:4%;\"></td>									
									</tr>
									"
									);
								}

								echo "<script>
									am=$all_Money;
									um=$use_Money;
									rm=$remaind_Money;
									count=".$count.";
									</script>";
									
								$am = number_format($all_Money);
								$um = number_format($use_Money);
								$rm = number_format($remaind_Money);
							?>
						<tr id="inputLine">
							<td><input type="button"id="field01" class="inputTEXT" value="추가" onclick="insertData();" ></td>
							<td><input type="text"  id="field02" name="field" class="inputTEXT" 	 placeholder="관리번호"  ></td>
							<td><input type="text"  id="field03" name="field" class="inputTEXT" 	 placeholder="사업명"    ></td>
							<td><input type="text"  id="field04" name="field" class="inputTEXT" 	 placeholder="발주처"    ></td>
							<td><input type="text"  id="field05" name="field" class="inputTEXT" 	 placeholder="발주감독"  ></td>
							<td><input type="text"  id="field06" name="field" class="inputTEXT" 	 placeholder="영업담당"  ></td>
							<td><input type="text"  id="field07" name="field" class="inputTEXT" 	 placeholder="담당팀"    ></td>
							<td><input type="text"  id="field08" name="field" class="inputTEXT" 	 placeholder="담당팀장"  ></td>
							<td><input type="text"  id="field09" name="field" class="inputTEXT date" placeholder="계약일"		></td>
							<td><input type="text"  id="field10" name="field" class="inputTEXT date" placeholder="착수일"		></td>
							<td><input type="text"  id="field11" name="field" class="inputTEXT date" placeholder="준공일"		></td>
							<td><input type="text"  id="field12" name="field" class="inputTEXT" 	 placeholder="계약금액"    ></td>
							<td><input type="text"  id="field13" name="field" class="inputTEXT" 	 placeholder="기성액"		></td>
							<td><input type="text"  id="field14" name="field" class="inputTEXT" 	 placeholder="잔액"  		></td>
							<td><input type="text"  id="field15" name="field" class="inputTEXT" 	 placeholder="비고"  		></td>
							<td>
								<select name="field" class="inputTEXT">
									<option value="진행중">진행중</option>
									<option value="완료">완료</option>
									<option value="경고">경고</option>
								</select>
							</td>
							<td><input type="text"  id="field17" name="field" class="inputTEXT" placeholder="수금"  value="1"></td>
						</tr>
						
						<tr id="filter_last">
							 <?php
								echo "			
									<td colspan=2>합계</td>
									<td> $count 건</td>
									<td> $count 개소</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td><span class=\"tm\">$am</span></td>
									<td><span class=\"tm\">$um</span></td>
									<td><span class=\"tm\">$rm</span></td>
									<td></td>
									<td></td>
									<td></td>
								"
							?>
						</tr>
					</table>
				</div><!--dataTable -->
			</div><!-- .dataArea end -->
		</div><!-- .document_area end -->
	</div><!-- .BOX end -->
	<style type="text/css">
		.detail_area {
			width : 1300px;
			height : 300px;
			background : gray;
			z-index : 10;
			position : absolute;
			top : 50px;
			left : 300px;
			display : none;
		}
	</style>
	<div class="detail_area">

		<table class="detail_table">
			<tr>
				<td>관리번호</td>
				<td>회사명</td>
				<td>발주처</td>
				<td>감독관</td>
				<td>영업담당</td>
				<td>담당팀</td>
				<td>담당팀장</td>
				<td>계약일</td>
				<td>착수일</td>
				<td>준공일</td>
				<td>계약금액</td>
				<td>기성액</td>
				<td>잔액</td>
				<td>대금</td>
				<td>선금</td>
				<td>잔금</td>
				<td>비고</td>
				<td>상태</td>
			</tr>
			<tr id="detail_data_area">

			</tr>
		</table>
	</div>
</body> 
</html>

