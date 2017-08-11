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
						$UI_form_ob->su_function_get_title('공지사항 게시판',$_SESSION['my_name'],$_SESSION['my_position'],$_SESSION['my_department'],'su_script_user_personal_interface');
					?>
		
						
				<form action = 'outsource.php' method='POST' name="table_filter">		


		
				
			 
				<div class="fixed-table-container">
					<div class="header-bg"></div>	 
					<div class="table-wrapper" style="width:100%; height:500px; overflow:auto">
					<thead>

						 
					<table>
						<tr>
			

						<th width=10% >
							<div class="th-text" >담당부서</div>
						</th>
						

						<th  width=8% >
							<div class="th-text" >상태</div>
						</th>

						</thead>



						
		<?php   // kokokara honhen
			$cnt = 1;
			$task_table_query = "select * from notice_document_header_table order by notice_birth_date DESC,notice_priority DESC;";
			$result_set = mysqli_query($conn,$task_table_query);
            while($row = mysqli_fetch_array($result_set)) {


			// 신규 표시 프로세스 파트
			$new_icon_flag = false;	
			if($ob5->su_fucntion_is_cache_have($conn,0,$_SESSION['my_sid_code'],$row['notice_id'])==0){
				$new_icon_flag = true;
			}

            ?>
                <tr>
			
					<td><?php
							echo $ob2->su_function_convert_name($conn,"master_department_info_table","sid_combine_department",$row['notice_order_section'],"master_department_info_name");
						?></td>
					<td width=7%><?php 
						$is_valid = (strtotime($_SESSION['now_date']) >= strtotime($row['notice_base_date'])) && (strtotime($_SESSION['now_date']) <= strtotime($row['notice_limit_date']));


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

			$task_table_query = "select * from former_document_header_table where (appro_state=70 or orderer=".$_SESSION['my_sid_code'].") order by birth_date DESC,priority DESC;";
			$result_set = mysqli_query($conn,$task_table_query);
            while($row = mysqli_fetch_array($result_set)) {



			// 신규 표시 프로세스 파트
			$new_icon_flag = false;	
			if($ob5->su_fucntion_is_cache_have($conn,1,$_SESSION['my_sid_code'],$row['former_id'])==0){
				$new_icon_flag = true;
			}

            ?>
                <tr>
					<td><?php echo $cnt++?></td>

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
						$is_valid = (strtotime($_SESSION['now_date']) >= strtotime($row['from_date'])) && (strtotime($_SESSION['now_date']) <= strtotime($row['to_date']));


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
            ?>



					</table>
				</div>

			<div style="padding:70px 0px 0px 0px;">
				<div style="float:right" /><input type="button" name="버튼" value="공지등록" onclick="window.open('./su_script_notice_write_interface.php','win','width=630,height=286,toolbar=0,scrollbars=0,resizable=0')";>
				<div style="float:right" /><input type="button" name="버튼" value="공문등록" onclick="window.open('./su_script_former_write_interface.php','win','width=630,height=286,toolbar=0,scrollbars=0,resizable=0')";>
			</div>

		</div>
</header>

	<?php include('./classes/su_class_common_rear.php');?>
	
	</body>    
 

</html>