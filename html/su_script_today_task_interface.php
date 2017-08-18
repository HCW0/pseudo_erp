<!DOCTYPE html>

<html>

<?php
    session_start();
	include('./classes/su_class_common_header.php');


// class 객체 생성

		$ob1 = new su_class_task_table_config();
		$ob2 = new su_class_value_name_convert_with_code();
		$ob3 = new su_class_value_combine_combobox_value_to_mysql_query();
		$UI_form_ob = new su_class_UI_format_generator();		
		$ob5 = new su_class_sid_cache_manager($conn,$_SESSION['my_sid_code']);

		
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
		
		<!-- <meta name="viewport" content="width=device-width, initial-scale=1" /> -->

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
	  padding: 0px 0px 0px 66px;
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
		<a id="cd-menu-trigger" href="#0"><span class="cd-menu-text">메뉴&nbsp &nbsp &nbsp &nbsp</span></a>

		
	<div id="wrapper" style="width:1050px" "height:300px">

					<?php
						$UI_form_ob->su_function_get_title('금일 업무 게시판',$_SESSION['my_name'],$_SESSION['my_position'],$_SESSION['my_department'],'su_script_user_personal_interface');
					?>
		
						
				<form action = 'outsource.php' method='POST' name="table_filter">		


		
				
			 
				<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
					<thead>

						 
					<table>
						<tr>
							<th  width=8%><div class="th-text">구분</div></th>

							<th  width=8%><div class="th-text">NO</div></th>

							<th width="21%">
								<div class="th-text">업무명</div>
							</th>				
							
							<th  width=21% >
								<div class="th-text" >진행상태</div>
							</th>

							<th  width=21% >
								<div class="th-text" >결제상태</div>
							</th>

							<th  width=21% >
								<div class="th-text" >우선도</div>
							</th>
						</tr>
						</thead>



						
		<?php   // kokokara honhen
			$cnt = 0;
			$task_table_query = "select * from task_document_header_table where reserve_flag = 0 AND task_orderer = ".$_SESSION['my_sid_code']." AND task_birth_date = '".$_SESSION['now_date']."';";
			$result_set = mysqli_query($conn,$task_table_query);
            while($row = mysqli_fetch_array($result_set)) {

            ?>
                <tr>
					<td><?php  if($cnt==0) echo '실적업무'; ?></td>

					<td><?php echo ++$cnt; ?></td>

					<td>
						<?php echo $row['task_name']; ?>
					</td>

					<td>
						<?php
							echo $ob2->su_function_convert_name($conn,"dmaster_state_info_table","master_code",$row['task_detail_state'],"master_state_detail_name");
						?>
					</td>

					<td>
						<?php
							echo $ob2->su_function_convert_name($conn,"master_state_info_table","master_task_state_info_code",$row['task_state'],"master_task_state_info_name");
						?>
					</td>

					<td>
						<?php
							echo $ob2->su_function_convert_name($conn,"master_priority_info_table","master_task_priority_info_code",$row['task_priority'],"master_task_priority_info_name");
						?>
					</td>

				</tr>

            <?php
            }
						$cnt2 = 0;
			$task_table_query = "select * from task_document_header_table where reserve_flag = 1 AND task_orderer = ".$_SESSION['my_sid_code']." AND task_birth_date = '".$_SESSION['now_date']."';";
			$result_set = mysqli_query($conn,$task_table_query);
            while($row = mysqli_fetch_array($result_set)) {



			?>

                <tr>
					<td><?php  if($cnt2==0) echo '계획업무'; ?></td>

					<td><?php echo ++$cnt2; ?></td>

					<td>
						<?php echo $row['task_name']; ?>
					</td>

					<td>
						<?php
							echo $ob2->su_function_convert_name($conn,"dmaster_state_info_table","master_code",$row['task_detail_state'],"master_state_detail_name");
						?>
					</td>

					<td>
						<?php
							echo $ob2->su_function_convert_name($conn,"master_state_info_table","master_task_state_info_code",$row['task_state'],"master_task_state_info_name");
						?>
					</td>

					<td>
						<?php
							echo $ob2->su_function_convert_name($conn,"master_priority_info_table","master_task_priority_info_code",$row['task_priority'],"master_task_priority_info_name");
						?>
					</td>

				</tr>
            <?php
            }

					echo "<div class='foot-bg'></div>";
					echo "<tr><th>";
					echo "<div class='th-text2'>";
					$all_cnt = $cnt+$cnt2;
					if ($all_cnt==0) {
						echo "일치하는 항목이 없습니다.";
					}
					else {
						echo "합계 : ";
						echo $all_cnt;
						echo "건";
						echo "  /  실적 : ";
						echo $cnt;
						echo "건";
						echo "  /  계획 : ";
						echo $cnt2;
						echo "건";
						
						
					}
					echo "</div>";
					echo "</th></tr>";



			?>

					</table>
		

		</div>
</header>

	<?php include('./classes/su_class_common_rear.php');?>
	
	</body>    
 

</html>