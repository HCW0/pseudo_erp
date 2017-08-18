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
						var popOption = "width=680, height=680, resizable=yes, scrollbars=yes, status=no;";    //팝업창 옵션(optoin)
						window.open(popUrl+'?TID=' + course,popOption,'width=680,height=680');


    
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
   
    border-collapse: collapse;
  }
  th, td {
   
    padding: 1px;
    text-align: center;
  }

  th:nth-child(2n), td:nth-child(2n) {
    background-color: #;
  }
  th:nth-child(2n+1), td:nth-child(2n+1) {
    background-color: #;
  }
 /*첫번째 라인 마스터테이블*/
  #content1,#content2,#content3,#content4,#content5,#content6{
	 
	  float:left;
	  width:16.66%;
	  height:500px;
	  margin: 0px 0px 20px 0px;
  }
 /*두번째 라인 마스터테이블*/
  #content7,#content8,#content9,#content10,#content11,#content12{
	 
	  float:left;
	  width:16.66%;
	  height:500px;
  }
  #logo{
	  
	  padding:0px 0px 50px 0px;
  }
  
  
  
  #wrapper{
	  padding: 0px 0px 0px 0px;
  }
  	

	 .fixed-table-container {
        width: 280px;
        height: 500px;
        border: 1px solid #000;
        position: relative;
        padding-top: 30px; /* header-bg height값 */
    }
    .header-bg {
        background: skyblue;
        height: 30px; /* header-bg height값 */
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        border-bottom: 1px solid #000;
    }
	    .foot-bg {
        background: skyblue;
        height: 20px; /* header-bg height값 */
        position: absolute;
        bottom: 0;
        right: 0;
        left: 0;
        border-bottom: 1px solid #000;
    }
    .table-wrapper {
        overflow-x: hidden;
        overflow-y: auto;
        height: 100%;
    }
    table {
        width: 100%;
		 
        border-collapse: collapse;
    }
    td {
        border-bottom: 1px solid #ccc;
        padding: 5px;
    }
    td + td {
        border-left: 1px solid #ccc;
    }
    th {
        padding: 0px; /* reset */
    }
    .th-text {
        position: absolute;
        top: 0;
        width: inherit;
        line-height: 30px; /* header-bg height값 */
        border-left: 1px solid #000;
    }
	   .th-text2 {
        position: absolute;
        bottom: 0;
        width: inherit;
        line-height: 20px; /* header-bg height값 */
        border-left: 1px solid #000;
    }
    th:first-child .th-text {
        border-left: none;
    }
	
	.minsu{
		text-align:center;
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
			
				<div style="font-size:35px; text-align:center; letter-spacing:15px; line-height:3;">관리자 모드</p>
				</div>
			
			<div id="content1">
			
				<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
				<table >
				<thead>
					<tr style="font-size:25px;color:green; border-top:2px solid black;">
						<th class="minsu" colspan="3">
							<div class="th-text">직급</div>
						</th>
					</tr>
						
					<tr style="border-bottom:2px solid black;">
						<div class="th-text"><th>no</th></div>
					<div class="th-text"><th>코드</th></div>
					<div class="th-text"><th>직급명</th></div>
					</tr>
				</thead>
								
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr><tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr><tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr><tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr><tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr><tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr><tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr><tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
				
				</table>
				</div>
			</div>
			</div>
			</div>
			
			<div id="content2">
			<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
				<table >
				<thead>
					<tr style="font-size:25px;color:green; border-top:2px solid black;">
						<th colspan="3">
							<div class="th-text">업무</div>
						</th>
					</tr>
						
					<tr style="border-bottom:2px solid black;">
						<div class="th-text"><th>no</th></div>
					<div class="th-text"><th>코드</th></div>
					<div class="th-text"><th>업무명</th></div>
					</tr>
				</thead>
								
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
				
				</table>
				</div>
			</div>
			</div>
			
			<div id="content3">
			
				<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
				<table >
				<thead>
					<tr style="font-size:25px;color:green; border-top:2px solid black;">
						<th colspan="3">
							<div class="th-text">진척도</div>
						</th>
					</tr>
						
					<tr style="border-bottom:2px solid black;">
						<div class="th-text"><th>no</th></div>
					<div class="th-text"><th>코드</th></div>
					<div class="th-text"><th>상태</th></div>
					</tr>
				</thead>
								
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
				
				</table>
				</div>
			</div>
			</div>
			
			<div id="content4">
			
				<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
				<table >
				<thead>
					<tr style="font-size:25px;color:green; border-top:2px solid black;">
						<th colspan="3">
							<div class="th-text">우선도</div>
						</th>
					</tr>
						
					<tr style="border-bottom:2px solid black;">
						<div class="th-text"><th>no</th></div>
					<div class="th-text"><th>코드</th></div>
					<div class="th-text"><th>우선순위</th></div>
					</tr>
				</thead>
								
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
				
				</table>
				</div>
			</div>
			</div>
			
			<div id="content5">
				
				<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
				<table >
				<thead>
					<tr style="font-size:25px;color:green; border-top:2px solid black;">
						<th colspan="3">
							<div class="th-text">직원정보</div>
						</th>
					</tr>
						
					<tr style="border-bottom:2px solid black;">
						<div class="th-text"><th>no</th></div>
					<div class="th-text"><th>코드</th></div>
					<div class="th-text"><th>이름</th></div>
					</tr>
				</thead>
								
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
				
				</table>
				</div>
			</div>
			</div>
			
			<div id="content6">
				
				<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
				<table >
				<thead>
					<tr style="font-size:25px;color:green; border-top:2px solid black;">
						<th colspan="3">
							<div class="th-text">부서</div>
						</th>
					</tr>
						
					<tr style="border-bottom:2px solid black;">
						<div class="th-text"><th>no</th></div>
					<div class="th-text"><th>코드</th></div>
					<div class="th-text"><th>부서명</th></div>
					</tr>
				</thead>
								
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
				
				</table>
				</div>
			</div>
			</div>
			
			<div id="content7">
				
				<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
				<table >
				<thead>
					<tr style="font-size:25px;color:green; border-top:2px solid black;">
						<th colspan="3">
							<div class="th-text">ㅇ</div>
						</th>
					</tr>
						
					<tr style="border-bottom:2px solid black;">
						<div class="th-text"><th>no</th></div>
					<div class="th-text"><th>코드</th></div>
					<div class="th-text"><th>ㅇ</th></div>
					</tr>
				</thead>
								
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
				
				</table>
				</div>
			</div>
			</div>
			
			<div id="content8">
				
				<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
				<table >
				<thead>
					<tr style="font-size:25px;color:green; border-top:2px solid black;">
						<th colspan="3">
							<div class="th-text">ㅇ</div>
						</th>
					</tr>
						
					<tr style="border-bottom:2px solid black;">
						<div class="th-text"><th>no</th></div>
					<div class="th-text"><th>코드</th></div>
					<div class="th-text"><th>ㅇ</th></div>
					</tr>
				</thead>
								
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
				
				</table>
				</div>
			</div>
			</div>
			
			<div id="content9">
				
				<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
				<table >
				<thead>
					<tr style="font-size:25px;color:green; border-top:2px solid black;">
						<th colspan="3">
							<div class="th-text">ㅇ</div>
						</th>
					</tr>
						
					<tr style="border-bottom:2px solid black;">
						<div class="th-text"><th>no</th></div>
					<div class="th-text"><th>코드</th></div>
					<div class="th-text"><th>ㅇ</th></div>
					</tr>
				</thead>
								
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
				
				</table>
				</div>
			</div>
			</div>
			
			<div id="content10">
				
				<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
				<table >
				<thead>
					<tr style="font-size:25px;color:green; border-top:2px solid black;">
						<th colspan="3">
							<div class="th-text">ㅇ</div>
						</th>
					</tr>
						
					<tr style="border-bottom:2px solid black;">
						<div class="th-text"><th>no</th></div>
					<div class="th-text"><th>코드</th></div>
					<div class="th-text"><th>ㅇ</th></div>
					</tr>
				</thead>
								
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
				
				</table>
				</div>
			</div>
			</div>
			
			<div id="content11">
				
				<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
				<table >
				<thead>
					<tr style="font-size:25px;color:green; border-top:2px solid black;">
						<th colspan="3">
							<div class="th-text">ㅇ</div>
						</th>
					</tr>
						
					<tr style="border-bottom:2px solid black;">
						<div class="th-text"><th>no</th></div>
					<div class="th-text"><th>코드</th></div>
					<div class="th-text"><th>ㅇ</th></div>
					</tr>
				</thead>
								
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
				
				</table>
				</div>
			</div>
			</div>
			
			<div id="content12">
				
				<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
				<table >
				<thead>
					<tr style="font-size:25px;color:green; border-top:2px solid black;">
						<th colspan="3">
							<div class="th-text">ㅇ</div>
						</th>
					</tr>
						
					<tr style="border-bottom:2px solid black;">
						<div class="th-text"><th>no</th></div>
					<div class="th-text"><th>코드</th></div>
					<div class="th-text"><th>ㅇ</th></div>
					</tr>
				</thead>
								
					<tr>
						<td>.</td>
						<td>.</td>
						<td>.</td>
					</tr>
				
				</table>
				</div>
			</div>
			</div>
			
			
			
			
			
			<div id="footer" style="margin:630px 0px 0px 1700px; ">
				    <input type="button" name="버튼" value="추가" onclick="window.open('./rhksflwkplus.php','win','width=400,height=180,toolbar=0,scrollbars=0,resizable=0')";>
					<input type="button" name="버튼" value="삭제" onclick="window.open('./rhksflwkminus.php','win','width=400,height=150,toolbar=0,scrollbars=0,resizable=0')";>
					<input type="button" name="버튼" value="수정" onclick="window.open('./rhksflwkedit.php','win','width=400,height=180,toolbar=0,scrollbars=0,resizable=0')";>
					
			</div>
				<p style="background-color:coffee" class="bd" align="center">COPYRIGHT(C) 2017 SUNUNENG.ENG ALL RIGHTS RESERVED&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp주소 : 광주광역시 광산구 송정동 735 선운빌딩 3층 <br/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp연락처 : 062-651-9272 / FAX : 062-651-9271</p>
		
</header>


	<div style="height:1400px">

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

			
			<li>
			
				<a href="#0"> 
				<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';> 
							<div>! 업무관리</div>
						</a><DIV style='display:none'> 
						<a href = "su_script_user_interface.php" align = "right">
					<font color='white' >
					전체 업무 검색
					</font></a>
				
					<a href = "su_script_user_personal_interface.php" align = "right">
						<font color='white'>
						내 업무
						</font></a>		
				
							</DIV>
				</a>
			
			
			</li>

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