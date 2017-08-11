<!DOCTYPE html>

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
		$ob2 = new su_class_value_name_convert_with_code();
		$ob3 = new su_class_value_combine_combobox_value_to_mysql_query();
		$UI_form_ob = new su_class_UI_format_generator();		
		$ob5 = new su_class_sid_cache_manager($conn,$_SESSION['my_sid_code']);
		$ob6 = new su_class_sid_variable_container_manager();

			$_SESSION['my_name'] = $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$_SESSION['my_sid_code'],"master_user_info_name");
			$_SESSION['my_position'] = $ob2->su_function_convert_name($conn,"master_position_info_table","sid_combine_position",$_SESSION['my_position_code'],"master_position_info_name");
			$_SESSION['my_department'] = $ob2->su_function_convert_name($conn,"master_department_info_table","sid_combine_department",$_SESSION['my_department_code'],"master_department_info_name");



			// if(isset($_SESSION['backword_flag'])==514){
			// 			$ob3 = new su_class_message_handler();
			// 			$ob3->su_function_call_confirm_message_yes_next($conn,712,'su_script_logout_support');
			// 			echo "<script>history.go(1)</script>";
						
			// }

			// if(!isset($_SESSION['backword_flag'])){
				
			// 			 echo "<script>window.location.href='su_script_user_personal_interface.php'</script>";
			// }



?>




		


<!-- 하드 코딩된 함수 이하 -->


<script> 
function hrefClick(course,type){
      // You can't define php variables in java script as $course etc.

		if(type==1){
	  		var popUrl = "/su_script_notice_pop_up.php";	//팝업창에 출력될 페이지 URL
		}else{
			var popUrl = "/su_format_former_doc.php";
		}
		var popOption = "resizable=no, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
		window.open(popUrl+'?notice_id=' + course,popOption,'width=491px,height=' +  screen.availHeight/3);
 
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
  a{ color:blue;}
  a:hover { color:blue;}
  a:active { color:red;}
  a:visited { color:purple;}

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
  
  
  .fixed-table-container {
        width: 1000px;
        height: 550px;
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
		height: 20px;
		/* header-bg height값 */
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
		vertical-align:middle;
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
		text-align:center;
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
		line-height: 20px;
		/* header-bg height값 */
		border-left: 1px solid #000;
	}
    th:first-child .th-text {
        border-left: none;
    }
	#wrapper{
		position:relative;
		top:50%;
		left:50%;
	  	padding: 0px 0px 0px 0px;
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


		
	<div id="wrapper" style="width:1050px" "height:300px">

					<?php
						$UI_form_ob->su_function_get_title('공지사항 게시판',$_SESSION['my_name'],$_SESSION['my_position'],$_SESSION['my_department'],'su_script_user_personal_interface');
					?>
		
						
				<form action = 'outsource.php' method='POST' name="table_filter">		


		
				
			 
				<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
					<thead>

						 
					<table>
						<tr>
						<th  width=3%><div class="th-text">NO</div></th>

						<th width="7%">
							<div class="th-text">등급</div>
						</th>
						
						<th width="7%">
							<div class="th-text">종류</div>
						</th>						
						
						<th  width=21% >
							<div class="th-text" >문서제목</div>
						</th>

						<th  width=25% >
							<div class="th-text" >유효기간</div>
						</th>

						<th  width=11% >
							<div class="th-text" >개시일</div>
						</th>

						<th  width=8% >
							<div class="th-text" >개시자</div>
						</th>


						<th width=10% >
							<div class="th-text" >담당부서</div>
						</th>
						

						<th  width=8% >
							<div class="th-text" >상태</div>
						</th>

						</thead>



						
		<?php   // kokokara honhen

			$cnt = 0;
			$task_table_query = "select * from notice_document_header_table order by notice_birth_date DESC,notice_priority DESC;";
			$result_set = mysqli_query($conn,$task_table_query);
            while($result_set&&($row = mysqli_fetch_array($result_set))) {
			$is_valid = (strtotime($_SESSION['now_date']) >= strtotime($row['notice_base_date'])) && (strtotime($_SESSION['now_date']) <= strtotime($row['notice_limit_date']));
			if(!$is_valid) continue;

			// 신규 표시 프로세스 파트
			$new_icon_flag = false;	
			if($ob5->su_fucntion_is_cache_have($conn,0,$_SESSION['my_sid_code'],$row['notice_id'])==0){
				$new_icon_flag = true;
			}

			if(!$new_icon_flag) continue;

            ?>
                <tr>
					<td><?php echo ++$cnt?></td>

					<td><?php 
						switch($row['notice_priority']){
							case 0 : echo '보통'; break;
							case 1 : echo "<font color='red' />긴급"; break;
						}
					?></td>
					<td>
						공지
					</td>
					<td>

							<?php
								if($new_icon_flag){
									echo "<a href='#' onclick='hrefClick(".$row['notice_id'].",1);'/>".$row['notice_name']."</a>";
									echo "<font color='red'> new ! </font>";
								}else{
									echo "<a href='#' onclick='hrefClick(".$row['notice_id'].",1);'/>".$row['notice_name']."</a>";
								}
							?>


					</td>

					<td><?php echo $row['notice_base_date']."~".$row['notice_limit_date']?></td>
					<td><?php echo $row['notice_birth_date']?></td>
					<td><?php
							echo $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['notice_orderer'],"master_user_info_name");
						?></td>
					<td><?php
							echo $ob2->su_function_convert_name($conn,"master_department_info_table","sid_combine_department",$row['notice_order_section'],"master_department_info_name");
						?></td>
					<td width=7%><?php 

						if($is_valid){
							echo "<img src='./src/on_sign.png'/ width=50% height=5%>";
						}else{
							echo "<img src='./src/off_sign.png'/ width=50% height=5%>";
						}
						?>
					</td>
                </tr>

            <?php
            }
			$cnt2=0;
			$task_table_query = "select * from former_document_header_table where (appro_state=70 or orderer=".$_SESSION['my_sid_code']." or former_ref=".$_SESSION['my_department_code'].") order by birth_date DESC,priority DESC;";
			$result_set = mysqli_query($conn,$task_table_query);
            while($row = mysqli_fetch_array($result_set)) {
			$is_valid = (strtotime($_SESSION['now_date']) >= strtotime($row['from_date'])) && (strtotime($_SESSION['now_date']) <= strtotime($row['to_date']));
			// 수신 대상 잡는거

				if($row['orderer']!=$_SESSION['my_sid_code']){
					if(!$ob6->su_function_thesse_code_have_parameter($conn,$_SESSION['my_sid_code'],$row['former_recv'])){
						continue;
					};
				}



			// 신규 표시 프로세스 파트
			$new_icon_flag = false;	
			if($ob5->su_fucntion_is_cache_have($conn,1,$_SESSION['my_sid_code'],$row['former_id'])==0){
				$new_icon_flag = true;
			}

			if(!$new_icon_flag) continue;

            ?>
                <tr>
					<td><?php echo ++$cnt2?></td>

					<td><?php 
						switch($row['priority']){
							case 0 : echo '보통'; break;
							case 1 : echo "<font color='red' />긴급"; break;
						}
					?></td>
					<td>
						공문
					</td>
					<td>
							<?php									
								if($new_icon_flag){
									echo "<a href='#' onclick='hrefClick(".$row['former_id'].",5);'/>".$row['former_title']."</a>";
									echo "<font color='red'> new ! </font>";
								}else{
									echo "<a href='#' onclick='hrefClick(".$row['former_id'].",5);'/>".$row['former_title']."</a>";
								}
							?>


					</td>

					<td><?php echo $row['from_date']."~".$row['to_date']?></td>
					<td><?php echo $row['birth_date']?></td>
					<td><?php
							echo $ob2->su_function_convert_name($conn,"master_user_info_table","SID",$row['orderer'],"master_user_info_name");
						?></td>
					<td><?php
							echo $ob2->su_function_convert_name($conn,"master_department_info_table","sid_combine_department",$row['order_section'],"master_department_info_name");
						?></td>
					<td width=7%><?php 
						

						
						if($is_valid && $row['appro_state']==70){
							echo "<img src='./src/on_sign.png'/ width=50% height=5%>";
						}else{
							echo "<img src='./src/off_sign.png'/ width=50% height=5%>";
						}
						?>
					</td>
                </tr>

				<?php

						
					}


//statistical summary
					echo "<div class='foot-bg'></div>";
					echo "<tr><th>";
					echo "<div class='th-text2'>";
					$all=$cnt+$cnt2;
					if ($all==0) {
						echo "신규 문건이 없습니다.";
						if(!isset($_SESSION['flag'])){
							echo "<script>window.location.href='su_script_home_key.php'</script>";
						}
						
					}
					else {
						$_SESSION['flag'] = 1;
						echo "합계 : ";
						echo $all;
						echo "건 / ";
						echo "공지 : ";
						echo $cnt;
						echo "건 / ";
						echo "공문 : ";
						echo $cnt2;
						echo "건";
					}
					echo "</div>";
					echo "</th></tr>";

				?>



					</table>
				</div>


		</div>
</header>


	
	</body>    
 

</html>