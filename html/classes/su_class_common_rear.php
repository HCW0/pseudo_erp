

		<div style="height:1000px">

			<nav id="cd-lateral-nav">
				<ul class="cd-navigation">

					<br />
					<br />
					<br />
					<p align="center"><img src="./src/su_rsc_sulogo_back.png" width="200" height="100" title="선운로고" /></p>
					<br />
					<br />
					<li><a class="current" href="#0">* * * *</a></li>

					<a>이름
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

					<a href="./su_script_logout_support.php">로그아웃</a>

					</li>

				</ul>

				<ul class="cd-navigation cd-single-item-wrapper">
					<li><a class="current" href="#0">* * * *</a></li>


					<li><a href="./su_script_notice_interface.php"> # 공지사항</a></li>

					<li>

						<a href="#0"> 
			<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';><div>! 업무관리</div></a><DIV style='display:none'><a href="su_script_user_personal_interface.php" align="right">
								<font color='white'>
									내 업무
								</font>
							</a>

							<a href="su_script_today_task_interface.php" align="right">
								<font color='white'>
									금일 업무
								</font>
							</a>

							<a href="su_script_process_table_interface.php" align="right">
								<font color='white'>
									공정표 조회
								</font>
							</a>

						</DIV>
						</a>


					</li>

					<li><a href="su_script_approbation_interface.php"> # 결제함</a></li>
					<!-- <li><a href="su_script_former_document_interface.php"> # 공문함</a></li> -->
					<li>

						<a href="#0"> 
			<a href=#none onclick=this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';><div># 관리자 기능</div></a><DIV style='display:none'><a href="su_script_approbation_management_interface.php" align="right">
								<font color='white'>
									결제 루트 설정
								</font>
							</a>

							<a href="su_script_user_personal_dp_management_interface.php" align="right">
								<font color='white'>
									용역관리대장
								</font>
							</a>

						</DIV>
						</a>


					</li>
				</ul>
				<!-- cd-single-item-wrapper -->


				<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
				<script src="assets/js/main.js"></script>
				<!-- Resource jQuery -->
				<script language="JavaScript" src="assets/js/date_picker.js"></script>

				<!-- 새로운 달력 자바 스크립트 소스-->
				<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
				<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		</div>