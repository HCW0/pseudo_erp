<!DOCTYPE html>

	<?php
		session_start();
		include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_class_loader.php');
		include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_db_connecter.php');
		include($_SERVER['DOCUMENT_ROOT'].'/header/su_header_user_login_check.php');
	?>


			<script> 
				function hrefClick(course){
					// You can't define php variables in java script as $course etc.


						var popUrl = "/su_script_notice_pop_up.php";	//팝업창에 출력될 페이지 URL
						var popOption = "width=450, height=450, resizable=yes, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
						window.open(popUrl+'?notice_id=' + course,popOption,'width=575,height=286');


					
				}
			</script>


<html>
	<head>
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale= 1, maximum-scale=2, user-scalable=yes">
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<script type="text/javascript" src="nse_files/js/HuskyEZCreator.js" charset="utf-8"></script>
			
			
			<title>글쓰기</title>
			
			
			<style>
					@import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
					body {
						font-family: 'Nanum Gothic', sans-serif;
					}
					
					ul,li{list-style:none;}

					#TopSlider{ text-align:left; width:600px; height:350px; border-top:2px solid #d2d2d2; }
					#TopSlider div{ visibility:hidden; }
					#top_0{background-color:ivory; border:1px solid #d2d2d2; }
					#top_1{background-color:ivory; border:1px solid #d2d2d2;}
					#top_2{background-color:ivory; border:1px solid #d2d2d2;}
					#top_3{background-color:ivory; border:1px solid #d2d2d2;}
					#top_4{background-color:ivory; border:1px solid #d2d2d2;}
					#top_5{background-color:ivory; border:1px solid #d2d2d2;}
					#top_6{background-color:ivory; border:1px solid #d2d2d2;}
					#top_7{background-color:ivory; border:1px solid #d2d2d2;}
					#top_8{background-color:ivory; border:1px solid #d2d2d2;}
					#top_9{background-color:ivory; border:1px solid #d2d2d2;}
					#top_10{background-color:ivory; border:1px solid #d2d2d2;}
					#top_11{background-color:ivory; border:1px solid #d2d2d2;}


					#ul_btns{float:left; width:800px; text-align:center; }
					#ul_btns a{float:left; width:130px; border:2px solid #e0e0e0;}
					#ul_btns .on{background-color:ivory;}

					#footer{ margin:200px 0px 0px 0px;}
				
					

					html,body{
					 
					}
					body{
					  text-align:center;
					}
					body:before{
					  content:'';
					  height:100%;
					  
					  display:inline-block;
					  vertical-align:middle;
					}
					button{
					  background:#1AAB8A;
					  color:#fff;
					  border:none;
					  position:relative;
					  height:60px;
					  font-size:1.6em;
					  padding:0 2em;
					  cursor:pointer;
					  transition:800ms ease all;
					  outline:none;
					}
					button:hover{
					  background:#fff;
					  color:#1AAB8A;
					}
					button:before,button:after{
					  content:'';
					  position:absolute;
					  top:0;
					  right:0;
					  height:2px;
					  width:0;
					  background: #1AAB8A;
					  transition:400ms ease all;
					}
					button:after{
					  right:inherit;
					  top:inherit;
					  left:0;
					  bottom:0;
					}
					button:hover:before,button:hover:after{
					  width:800px;
					  transition:800ms ease all;
					}
					@media(max-width:1300px){
						#start{
							width:800px;
					}
					}

			</style>
								
								
								<script   
										src="https://code.jquery.com/jquery-3.0.0.min.js" 
										integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0="   
										crossorigin="anonymous">
								</script>
							
								<script>
								
									var intv;
									var current = 0;
									var sIdx = 0;
									var sCnt =  4;
									
								
									function startTopSlider() {
										intv = setInterval(function () {
											$("#ul_btns").find("a").eq(current++ % sCnt).click();
										}, 3000);
									}
								
									function setBnr(idx, bnr, allTab, addCls) {
										$(bnr).css("visibility", "hidden")
											.eq(idx).css("visibility", "visible");
										$(allTab).removeClass(addCls);
										$(allTab).eq(idx).addClass(addCls);
									}
								
									$(document).ready(function () {
										
										//set init
										$("#top_0").css("visibility", "visible");
										$("#btn_0").addClass("on");
										startTopSlider();
										
										
										$("#ul_btns").find("a").click(function(){
											var idx = $(this).attr("id").split("_")[1];
											setBnr(idx, "#TopSlider > div" , "#ul_btns > a" , "on" );
											
										});
								
										
									});
								</script>

			

	</head>


	<body id="start" style="background-color:ivory; text-align:center; width:100%;">

	<div id="wrapper" align="center" style=" height:100%; margin:0px 0px 0px 0px; "> <!--화면을 가운데 맞춤 -->
	
	<p align="center"><img src="./src/su_rsc_sulogo_a.png" width="200" height="100" title="선운로고"/></p>
		
			<strong align="center">공 지 사 항</strong>
		    <div id="TopSlider"  style="background-color:ivory; ">

		

		<?php
			// 하드 코딩된 함수 이하

	

			//해당 사원정보 세션으로 캐시테이블 초기화

			$cache_query = "select * from notice_cache_temp_table u where u.SID = ".$_SESSION['my_sid_code'].";";
			$result_set = mysqli_query($conn,$cache_query);
			//$row = mysqli_fetch_array($result_set)


			if(mysqli_num_rows($result_set)==0){
					// 캐시테이블에 해당 유저 정보가 없는 경우 정보 추가
					$cache_query = "Insert into notice_cache_temp_table(SID,notice_standard_date) Values(".$_SESSION['my_sid_code'].",'". $_SESSION['now_date']."');";
					$result_set = mysqli_query($conn,$cache_query);


			}else{
			
			
		
				$cache_query = "select * from notice_cache_temp_table u where u.SID = ".$_SESSION['my_sid_code']." AND u.notice_standard_date !='".$_SESSION['now_date']."';";
				$result_set = mysqli_query($conn,$cache_query);

				if(mysqli_num_rows($result_set)>0){
						// 날짜가 다른 경우 날짜를 포함해서 전체적인 테이블 엔터티를 초기화 시킨다.

						$cache_query = "delete from notice_cache_temp_table where SID=".$_SESSION['my_sid_code'].";";
						$result_set = mysqli_query($conn,$cache_query);
						$cache_query = "Insert into notice_cache_temp_table(SID,notice_standard_date) Values(".$_SESSION['my_sid_code'].",'". $_SESSION['now_date']."');";
						$result_set = mysqli_query($conn,$cache_query);


				}
			

			}


			
			// 캐시에서 자신의 사원 스페이스 키를 가져온다.
			$sid_cache_table_query = "select * from notice_cache_temp_table u where u.SID = ".$_SESSION['my_sid_code'].";";
			$sid_cache_table_query_result_set = mysqli_query($conn,$sid_cache_table_query);
			$row_of_sid_cache_table_query_result_set = mysqli_fetch_array($sid_cache_table_query_result_set);



			// 활성화된 공지만을 가져온다.
			$activated_notice_find_query = "select * from notice_document_header_table u where u.notice_priority = 1 AND u.notice_base_date <= '".$_SESSION['now_date']."' AND u.notice_limit_date >= '".$_SESSION['now_date']."';";
			$activated_notice_find_query_result_set = mysqli_query($conn,$activated_notice_find_query);


			$count=0;
			while($row_of_activated_notice_find_query_result_set = mysqli_fetch_array($activated_notice_find_query_result_set)){

					// 활성화된 공지 정보를 1개 가져온다.
					$activated_notice_number = $row_of_activated_notice_find_query_result_set['notice_id'];
					$compare_flag = false;

							for($cnt = 1 ; $cnt < 13 ; $cnt++){

									if($row_of_sid_cache_table_query_result_set["notice_flag_$cnt"]==$activated_notice_number){
											$compare_flag=true;
											break;

									}


							}
					// compare가 true가 된 경우 : 해당 공지는 이미 본 공지임.
					// 딱히 하는 거 없음.

					// compare가 false가 된 경우 : 해당 공지를 캐시에 추가함.
					if($compare_flag==false){
							if($row_of_sid_cache_table_query_result_set['cache_index']>=12){


										$cache_index_to_zero = "update notice_cache_temp_table set cache_index = 0 where SID = ".$_SESSION['my_sid_code'].";";
						 				$ex_query = mysqli_query($conn,$cache_index_to_zero);

							}

									// 캐시값 1 증가.
										$cache_index_one_up = "update notice_cache_temp_table set cache_index = cache_index + 1 where SID = ".$_SESSION['my_sid_code'].";";
						 				$ex_query = mysqli_query($conn,$cache_index_one_up);


									// 증가된 캐시값 가져오기

										$cache_index_to_zero = "select * from notice_cache_temp_table u where u.SID = ".$_SESSION['my_sid_code'].";";
						 				$ex_query = mysqli_query($conn,$cache_index_to_zero);
										$row9 = mysqli_fetch_array($ex_query);

									// 캐시에 공지 정보 추가
										$field = $row9['cache_index'];
										$call_name_index = "notice_flag_$field";
										$cache_index_input = "update notice_cache_temp_table set $call_name_index = $activated_notice_number where SID = ".$_SESSION['my_sid_code'].";";
						 				$ex_query = mysqli_query($conn,$cache_index_input);


									// UI

											echo "<p id='top_".$count++."'>"."<a href='#' onclick='hrefClick(".$row_of_activated_notice_find_query_result_set['notice_id'].");'>".$row_of_activated_notice_find_query_result_set['notice_name']."</a>";
											echo "<br />";
											echo "</p>";

									
						}
					

			}
			if($count==0){
				
						 echo "<script>window.location.href='".$_SESSION['root']."/module/task_management/su_script_user_personal_interface.php'</script>";
			}


?>





       
    </div>
			<!--버튼 
				<div id="TopSliderBtn" style="background-color:ivory; width:800px ; height:100px">
					<ul id="ul_btns">
						
					<?php
						// for($count = 0; $count < $var; $count++){
						// 	echo "<a href='#' id='btn_".$count."'><li>●</li></a>";
						// }
					?>
						
					</ul>
				</div>
			-->

				<h1 align="center">&nbsp</h1>
				<div align="center">

				<button type="button" onclick=<?php echo "location.href='".$_SESSION['root']."/module/task_management/su_script_user_personal_interface.php'"?>>확 인</button>
			
			<!--	<button type="button" onclick="location.href='su_script_approbation_interface.php'">결재관리</button>
				<button type="button" onclick="location.href='su_script_notice_interface.php'">공지사항</button>
				<button type="button" onclick="location.href='su_script_configure_interface.php'"> 설&nbsp&nbsp&nbsp&nbsp 정 </button>
			 -->

		
	</div>


						<div id="footer" style="width:850px">
								<p class="bd" align="center">COPYRIGHT(C) 2017 SUNUNENG.ENG ALL RIGHTS RESERVED 연락처 : 062-651-9272 / FAX : 062-651-9271</p>
						</div>

				</div>
		</body>
</html>