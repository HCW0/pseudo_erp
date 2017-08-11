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
?>

<!DOCTYPE>
<head> 
<meta charset="utf-8"> 
<title>공정표</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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




<style type="text/css">

body { margin : 0px; padding : 0px; background : ivory}
ul   { margin : 0px; padding : 0px; list-style-type : none;}

.search_Views .subject li input[type=button]{
	font-size : 5px;
	margin : 0;
	padding : 0;
}
.search_Views .data li input[type=button]{
	border : 0;
	outline : 0;
	background : none;
	color : blue;
	float : left;
	font-size :16px;
}

.process_table_Contanier {
	margin : 0px;
	padding : 0px;
}

.issue_Planning_Container {
	width : 100%;
	height : 100%;
}
.issue_Planning_View {
	width : 1100px;
	height : 500px;
	margin : 0 auto;
	background : ivory;
}
.search { clear : both;}
.search>li { float : left; margin-right : 10px;}
.search>li>input[type=radio] {
	margin : 0px;
	padding : 0px;
}
.search_Option {
	width : 1000px;
	padding : 0px;
	margin-bottom : 50px;
}
.search_Views {
	clear : both;
	width : 1030px;
	display : block; 
	background : white;
}
.search_Views .subject>li:first-child{
	border-left : 1px solid black;
}
.search_Views .subject>li{
	float : left;
	width : 148px;
	border : 1px solid gray;
	border-left : none;
	text-align : center;
	background-color : white;
	padding-bottom : 2px;
}
.search_Views .data>li{
	float : left;
	width : 148px;
	border : 1px solid gray;
	border-left : none;
	border-top : none;
	text-align : center;
}
.search_Views .data .col:first-child{	
	text-align : right;
}

.search_Views .data .col span {
	padding-right : 3px;

}

.search_Views .data .no {
	border-left : 1px solid gray;
}

.search_Views .data .price {
	text-align : right;
}

.search_Views .data .price span {
	padding-right : 23px;
}

.search_Views .data li > span {
	overflow : hidden;
}

.search_Views .data .t > span {
	color : blue;
}


.test {
	width : 1200px;
	height : 400px;
	background : white;
	z-index : 10;
	position : absolute;
	top : 10%;
	left : 10%;
	box-shadow: 5px 5px 5px 0px lightgray;
}

.test h2 { 
	display : block;
}

</style>

<script type="text/javascript">

	$(function(){

		// 동적으로 생선된 태그는 아래와 같은 방법으로 함수를 실행한다.
		// 클래스를 부여한 태그를 타겟으로 하여 클릭할 때 타겟과 맞다면
		// 지우지 않으며 타겟 외 영역을 클릭할 때 지워진다.
		$(document).on("click",$(".test"),function(event){
			if(!$(event.target).hasClass("test")){
				$(".test").remove();
			}
		});

		var data="";
		<?php
			$query = "SELECT TID, coworkspace, task_name, all_money_master_code_field, coworker , task_base_date, task_limit_date, progress_rate from task_document_header_table t where t.TID = t.super_task_TID";
     		$result = mysqli_query($conn,$query);  
			$count = 0;
           	while($row=mysqli_fetch_array($result))
			{         	
				$count++;	
				echo ("data+=
							'<ul class=\"data\" id=\"$row[0]\" onclick=\"planning_Detail_Page(this,this.id)\">'+
							'<li class=\"no\" style=\'width:30px\'><span>$count</span></li>'+
							'<li class=\"col\">'+	
								'<label><span>$row[1]</span></label>'+
							'</li>'+
							'<li class=\"t\" ><span>$row[2]</span></li>'+
							'<li class=\"price\"><span>$row[3]원</span></li>'+
							'<li style=\"width:100px\"><span>$row[4]</span></li>'+
							'<li>$row[5]</li>'+
							'<li>$row[6]</li>'+
							'<li><span>$row[7]%</span></li>'+
							'</ul>';"
				);
			}
		?>
		$(".search_Views").append(data);
	});

	
	// 발주금액, 보안등급, 계획 진척도 
	//  OrderBy : asc , desc
	// var state = $("#"+obj.id).val();
	// obj 는 자기 자신 this를 return 하는 함수로 부터 object를 받는다.
	// obj.id는 자신의 id 값을 return 한다.
	// 그리고 .val()은 자신이 가지고 있는 value 값을 return
	// 그 데이터를 state 에 담는다.

	// count == 1 asc
	// count == 2 desc

	// 중요한 것은 3개의 컬럼 정렬을 통해서 연속적인 정렬로 더 정교한 데이터를 만들 것 인지
	// 컬럼 한 개씩만의 정렬로써 원하는 데이터만 볼 것인가?

	// 일단 현재는 한 개씩 OrderBy해서 보여 주는 것으로 하겠다.
	// 코드 간결화 필요
	var oldObj = "";
	function orderBy(obj){
		
		if(oldObj.id!=obj.id){
			$("#"+oldObj.id).val("▲");
		}
		oldObj = obj;
		
		var state = $("#"+obj.id).val();

		if(state=="▲"){
			state = "▼";
			ByAjax(1,obj.id);
		}else{
			state = "▲";
			ByAjax(2,obj.id);
		}

		$("#"+obj.id).val(state);
	}

	function ByAjax(flag,id){
		$.post('../ajax_code_generator/ajax_orderBy.php?flag='+flag+"&col="+id,function(Data){
			detail_Page(Data,1);
		});
	}

	// Event function : input tag click [radio]
	function fun_input(obj,data){
		fun_radio_event(obj.id);
	}

	// input[type=radio] tag event function
	// 기준시간 주간/월간/년간 코드(value) 값으로 검색할 수 있다.
	function fun_radio_event(id){
		console.log($("#"+id).val());
	}

	// select onchange 될 때마다 선택한 값을 가져온다.
	function select_event(obj){
		console.log(obj.value);
	}

	// ajax 비동기 통신을 이용한 실시간 데이터 전송 및 데이터 변환
	// 상세 보기를 위한 function ajax
	function planning_Detail_Page(obj,id){
		$.post('../ajax_code_generator/planning_ajax_detail.php?code='+id,function(data){
			detail_Page(data,0);
		});
	}

	// function detail_Page(Data)
	// 1.발주처에서 클릭된 + 함수는 해당 코드에 맞는 데이터를 긁어 온다.
	//   긁어 오는 데이터는 상위 업무 및 하위 업무와 업무 달성률 등이다.

	// 2. OrderBy ASC,DESC 함수도 function detail_Page를 사용한다.
	// Flag 
	// 0 : detail
	// 1 : order By
	function detail_Page(data,flag){
		if(flag==0){
			$(".issue_Planning_Container").append(data);
			var test = $(".subject");
			var top = test.offset().top;
			var right = test.offset().right;
			$(".test").css({"top":top,"left":right});
		}else if(flag==1){
			$(".data").empty();
			$(".search").append(data);
		}
	}

</script>
</head>


<body>


<header>
		<a id="cd-menu-trigger" href="#0"><span class="cd-menu-text">메뉴&nbsp &nbsp &nbsp &nbsp</span></a>


	<!--큰 그림 안에 표현 하려고 하는 것의 공간 DIV  -->
	<div class="issue_Planning_Container" style="padding: 0px 0px 0px 108px;">
		<!--   -->
		<div class="issue_Planning_View">
			<div class="search_Option">
				<ul class="search">
					<li>
						<label>주 거래처</label>
						<select onchange="select_event(this)">
							<option>전체</option>
							<option>한국전력공사</option>
							<option>한국지리공사</option>
							<option>한국도로교통</option>
							<option>원자력발전소</option>
						</select>
					</li>

					<li>
						<label>발주 금액</label>
						<select onchange="select_event(this)">
							<option>전체</option>
							<option value=1>1백만~1천만</option>
							<option value=3>1천만~3천만</option>
							<option value=7>3천만~7천만</option>
							<option value=10>7천만~10천만</option>
							<option value=90>10천만~90천만</option>
						</select>
					</li>
				</ul>

				<ul class="search">
					<li>
						<label>기준시간</label>
						<input type="radio" name="cal" id="r1" value="7"  onclick="fun_input(this,this.value);"> <label for="r1">주간</label>
						<input type="radio" name="cal" id="r2" value="31" onclick="fun_input(this,this.value);"> <label for="r2">월간</label>
						<input type="radio" name="cal" id="r3" value="365"onclick="fun_input(this,this.value);"> <label for="r3">년간</label>
					</li>
					<li>
						<label>달력</label>	
					</li>
				</ul>
				<input type="button" value="reset" onclick="window.location.reload();">
			</div>

			<div class="search_Views">
				<ul class="subject">
					<li style="width:30px;">no</li>
					<li><span>발주처</span></li>
					<li>
						<span>사업명</span>
					</li>
					<li>
						<span>발주 금액</span>
						<input type="button" id="p" value="▲" onclick="orderBy(this);"/>
					</li>
					<li style="width:100px;"><span>감독관<span></li>
					<li><span>시작일<span></li>
					<li><span>마감일<span></li>
					<li>
						<span>계획 진척도<span>
						<input type="button" id="pp" value="▲" onclick="orderBy(this);"/>
					</li>
				</ul>
			</div>
		</div>
	</div>




</header>

		<?php include('./classes/su_class_common_rear.php');?>
</body> 
</html>
