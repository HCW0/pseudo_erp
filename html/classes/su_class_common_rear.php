<style>
	#cd-lateral-nav p {
		display: block;
		line-height: 2em;
		padding: 0 24px 0 24px;
		color: #aab5b7;
	}

	#cd-lateral-nav p.current {
    background-color: #3a4a4d;
    color: #FFF;
}	

</style>

<script>

	function no_history_redirect(vhref){

		window.location.replace(vhref);
	}

</script>

<?php


	if(!isset($_SESSION['now_page_coord'])){
			$_SESSION['now_page_coord'] = 1;
			// 현재 참조하고 있는 페이지를 메뉴에 표시할 때 사용하는 전역변수
			// 메뉴를 통해 화면을 변경할 때 마다, 해당 변수 값이 변경되고 값에 따라 메뉴의 모양이 변한다.
			//
			//
			// 현재 메뉴 순서대로 0부터의 값을 가진다.
			// 0 -> 공지
			// 1 -> 내 업무
			// 2 ...
	}




	function menu_generator($href,$menu_no,$menu_name,$align='left'){
		//리다이트될 위치, 위 세션변수의 번호, 표시될 메뉴의 이름을 입력하면 알아서 메뉴를 생성하는 함수.
							
							if($_SESSION['now_page_coord']==$menu_no){
								echo "<a href='#' onclick='no_history_redirect(\"$href\")' align=$align> <font color='red' /># ".$menu_name."</a>";
							}else{
								echo "<a href='#' onclick='no_history_redirect(\"$href\")' align=$align># ".$menu_name."</a>";						
							}
	}

	function be_container_open($base,$limit){
		//접기 기능을 가진 메뉴라면, 하위 메뉴가 열려있는 경우 자동으로 열려 있을 필요가 있는데 하위 메뉴의 페이지 번호 시작과 끝을 입력해서
		//메뉴의 기본 상태를 펼치게 할지 접게 할지 정하는 함수

							if($_SESSION['now_page_coord']>=$base && $_SESSION['now_page_coord']<=$limit){
								return 'block';
							}
							return 'none';

	}

?>







		<div style="height:1000px">

			<nav id="cd-lateral-nav">


				<ul class="cd-navigation cd-single-item-wrapper">


					<br />
					<br />
					<br />
					<p align="center"><img src="./src/su_rsc_sulogo_back.png" width="200" height="100" title="선운로고" /></p>
					<br />
					<br />
					<br />

					<li><p class="current">Menu</a></li>
					<br />
					<br />

					<li>

						<a href="#0"> 
							<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';><div>! 업무관리</div></a><DIV style='display:<?php echo be_container_open(1,2); ?>'>

										<?php
											echo menu_generator($_SESSION['home_address'],1,'내 업무','right');
										?>

										<?php
											echo menu_generator('su_script_process_table_interface.php',2,'공정표 조회','right');
										?>

						</DIV>
						</a>


					</li>

					<li>
										<?php
											echo menu_generator('su_script_approbation_interface.php',3,'결제함 열람');
										?>
					</li>

					<li>
										<?php
											echo menu_generator('su_script_notice_interface.php',0,'공지사항');
										?>
					</li>


					<li>



						<a href="#0"> 
							<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';><div>! 관리자 기능</div></a><DIV style='display:<?php echo be_container_open(4,5); ?>'>

										<?php
											// echo menu_generator('su_script_approbation_management_interface.php',4,'결제 경로 관리','right');
											// 위 페이지는 각 유저가 보유한 결제 경로를 삭제하거나 임의로 추가시킬 수 있는 기능을 담고 있다.
											// 요구사항에 의해 필요없는 기능으로 분류되어 주석처리됨./
										?>

										<?php
											echo menu_generator('su_script_user_personal_dp_management_interface.php',5,'용역 관리 대장','right');
										?>

						</DIV>
						</a>


					</li>
				</ul>








				<ul class="cd-navigation">


				<li><p class="current">User Info</p></li>

					<br />
					<br />

					<p><font color='#aab5b7' />이름
					<font color='white' /><?php
								echo $_SESSION['my_name'];
							?></p>

					<p>부서
					<font color='white'><?php
							echo $_SESSION['my_department'];
							?></font></p>

					<p>직급
					<font color='white'><?php
							echo $_SESSION['my_position'];
							?></font></p>

					<p>사번
					<font color='white'><?php
							echo $_SESSION['my_sid_code'];
							?></font></p>

					<a href="./su_script_logout_support.php">로그아웃</a>

					</li>

				</ul>






				<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
				<script src="assets/js/main.js"></script>
				<!-- Resource jQuery -->
				<script language="JavaScript" src="assets/js/date_picker.js"></script>

				<!-- 새로운 달력 자바 스크립트 소스-->
				<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
				<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		</div>