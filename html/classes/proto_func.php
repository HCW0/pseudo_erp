
			$cache_query = "select * from notice_cache_temp_table u where u.SID = ".$_SESSION['my_sid_code'].";";
			$result_set = mysqli_query($conn,$cache_query);
			$row = mysqli_fetch_array($result_set);


			$task_table_query_banner = "select * from notice_document_header_table u where u.notice_priority = 1 AND u.notice_base_date <= '".$_SESSION['now_date']."' AND u.notice_limit_date >= '".$_SESSION['now_date']."';";
			echo $task_table_query_banner;
			$result_set_banner = mysqli_query($conn,$task_table_query_banner);
			while($var = mysqli_fetch_array($result_set_banner)) {
					$compare = false;
					$cnt = $row['cache_index'];
					if($cnt>0){
					while($cnt>0){
							if($row["notice_flag_$cnt"]==$var['notice_id']){
									$compare = true;
									break;	
							};


					$cnt--; 
				}
				if(!$compare){
						//등록되지 않은 공지사항 id라면 등록하면 된다.
						 $cache_query3 = "update notice_cache_temp_table set cache_index = cache_index+1 where SID = ".$_SESSION['my_sid_code'].";";
						 $result_set3 = mysqli_query($conn,$cache_query3);

						 $cache_query3 = "select * from notice_cache_temp_table u where u.SID = ".$_SESSION['my_sid_code'].";";
						 $result_set3 = mysqli_query($conn,$cache_query3);
						 $var2 = mysqli_fetch_array($result_set3);

						 $cache_query3 = "update notice_cache_temp_table set notice_flag_".$var2['cache_index']." = ".$var['notice_id']." where SID = ".$_SESSION['my_sid_code'].";";
						 $result_set3 = mysqli_query($conn,$cache_query3);
				}
					
			}else{

				
			}

			}
