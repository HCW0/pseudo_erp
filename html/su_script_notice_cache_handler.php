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
		$ob2 = new su_class_value_name_convert_with_code();
		$ob3 = new su_class_value_combine_combobox_value_to_mysql_query();
		


// 하드 코딩된 함수 이하

	



		//해당 사원정보 세션으로 캐시테이블 초기화

			$cache_query = "select * from notice_cache_temp_table u where u.SID = ".$_SESSION['my_sid_code'].";";
			$result_set = mysqli_query($conn,$cache_query);
			//$row = mysqli_fetch_array($result_set)
			echo $cache_query;
			echo "<br />";

			if(mysqli_num_rows($result_set)==0){
					// 캐시테이블에 해당 유저 정보가 없는 경우 정보 추가
					$cache_query = "Insert into notice_cache_temp_table(SID,notice_standard_date) Values(".$_SESSION['my_sid_code'].",'". $_SESSION['now_date']."');";
					$result_set = mysqli_query($conn,$cache_query);
					
					echo '신규 유저 정보 등록';
					echo "<br />";

					echo $cache_query;
					echo "<br />";

			}else{
			
			
		
				$cache_query = "select * from notice_cache_temp_table u where u.SID = ".$_SESSION['my_sid_code']." AND u.notice_standard_date !='".$_SESSION['now_date']."';";
				$result_set = mysqli_query($conn,$cache_query);

				if(mysqli_num_rows($result_set)>0){
						// 날짜가 다른 경우 날짜를 포함해서 전체적인 테이블 엔터티를 초기화 시킨다.

						$cache_query = "delete from notice_cache_temp_table where SID=".$_SESSION['my_sid_code'].";";
						$result_set = mysqli_query($conn,$cache_query);
						$cache_query = "Insert into notice_cache_temp_table(SID,notice_standard_date) Values(".$_SESSION['my_sid_code'].",'". $_SESSION['now_date']."');";
						$result_set = mysqli_query($conn,$cache_query);

						echo '기존 유저 정보 갱신';
						echo "<br />";

						echo $cache_query;
						echo "<br />";
				}
			

			}


			
			// 캐시에서 자신의 사원 스페이스 키를 가져온다.
			$sid_cache_table_query = "select * from notice_cache_temp_table u where u.SID = ".$_SESSION['my_sid_code'].";";
			$sid_cache_table_query_result_set = mysqli_query($conn,$sid_cache_table_query);
			$row_of_sid_cache_table_query_result_set = mysqli_fetch_array($sid_cache_table_query_result_set);



			// 활성화된 공지만을 가져온다.
			$activated_notice_find_query = "select * from notice_document_header_table u where u.notice_priority = 1 AND u.notice_base_date <= '".$_SESSION['now_date']."' AND u.notice_limit_date >= '".$_SESSION['now_date']."';";
			$activated_notice_find_query_result_set = mysqli_query($conn,$activated_notice_find_query);



			while($row_of_activated_notice_find_query_result_set = mysqli_fetch_array($activated_notice_find_query_result_set)){

					// 활성화된 공지 정보를 1개 가져온다.
					$activated_notice_number = $row_of_activated_notice_find_query_result_set['notice_id'];
					$compare_flag = false;

							for($cnt = 1 ; $cnt < 13 ; $cnt++){

									if($row_of_sid_cache_table_query_result_set["notice_flag_$cnt"]==$activated_notice_number){
											$compare_flag=true;
											break;
											echo "echo!";
											echo "<br />";
									}


							
					// compare가 true가 된 경우 : 해당 공지는 이미 본 공지임.
					// 딱히 하는 거 없음.

					// compare가 false가 된 경우 : 해당 공지를 캐시에 추가함.
					if($compare_flag==false){
							$sid_cache_table_query_result_set = mysqli_query($conn,$sid_cache_table_query);
							if($row_of_sid_cache_table_query_result_set['cache_index']>=12){


										$cache_index_to_zero = "update notice_cache_temp_table set cache_index = 0 where SID = ".$_SESSION['my_sid_code'].";";
						 				$ex_query = mysqli_query($conn,$cache_index_to_zero);

							}

									// 캐시값 1 증가.
										$cache_index_one_up = "update notice_cache_temp_table set cache_index = cache_index + 1 where SID = ".$_SESSION['my_sid_code'].";";
						 				$ex_query = mysqli_query($conn,$cache_index_one_up);
										 echo $cache_index_one_up;

									// 캐시에 공지 정보 추가
										$call_name_index = $row_of_sid_cache_table_query_result_set['notice_flag_3'];
										$cache_index_input = "update notice_cache_temp_table set $call_name_index = $activated_notice_number where SID = ".$_SESSION['my_sid_code'].";";
						 				$ex_query = mysqli_query($conn,$cache_index_input);
										 echo $row_of_sid_cache_table_query_result_set["notice_flag_$cnt"];
										 echo "<br />";
										echo $cache_index_input;
										 echo "<br />";
										echo $call_name_index;

									//
									echo $row_of_activated_notice_find_query_result_set['notice_name']."<br />";
									echo "<a href='#' onclick='hrefClick(".$row_of_activated_notice_find_query_result_set['notice_id'].");'/>공지 자세히 보기</a><br>";
						}
					}

			}

?>



<script> 
function hrefClick(course){
      // You can't define php variables in java script as $course etc.


	  	var popUrl = "/su_script_notice_pop_up.php";	//팝업창에 출력될 페이지 URL
		var popOption = "width=450, height=450, resizable=yes, scrollbars=no, status=no;";    //팝업창 옵션(optoin)
		window.open(popUrl+'?notice_id=' + course,popOption,'width=650px,height=455px');


    
}
</script>







</html>