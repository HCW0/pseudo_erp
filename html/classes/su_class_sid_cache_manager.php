<?php
    
    class su_class_sid_cache_manager{




            function __construct($conn,$sid){ 

                $this->su_function_check_cache_status($conn,$sid,20);

            }




            function su_function_check_cache_status($conn,$sid,$size){
                    $query = "select * from sid_cache_temp_table where SID = $sid";
                    $result = mysqli_query($conn,$query);
                    if(mysqli_num_rows($result)==0){
                            $query = "Insert into sid_cache_temp_table(SID,cache_size,pivot_date) Values($sid,$size,'".$_SESSION['now_date']."');";     
                            $result = mysqli_query($conn,$query);
                    }else{
                        $row = mysqli_fetch_array($result);
                        if($row['pivot_date']!=$_SESSION['now_date']){
                            $query = "update sid_cache_temp_table set pivot_date = '".$_SESSION['now_date']."' where SID = $sid;";
                            mysqli_query($conn,$query);
                            $cache_size = $row['cache_size']+1;

                            for($cnt=1;$cnt<$cache_size;$cnt++){
                                //init former vier flag
                                $target_field = $cnt."_former_view_flag";
                                $query2 = "update sid_cache_temp_table set $target_field = NULL where SID = $sid;";
                                mysqli_query($conn,$query2);

                                //init notice too against which case pivot date was changed; 
                                $target_field = $cnt."_notice_view_flag";
                                $query2 = "update sid_cache_temp_table set $target_field = NULL where SID = $sid;";
                                mysqli_query($conn,$query2);

                            }

                            //change cache size
                            $query3 = "update sid_cache_temp_table set cache_size = $size where SID = $sid;";
                            mysqli_query($conn,$query3);


                        }
                    }
            }


            function su_fucntion_is_cache_have($conn,$type,$sid,$id):int{
                    $result_value = 0;
                    switch($type){

                        case 0 : // 공지인 경우

                               $tag = "_notice_view_flag";

                        break;

                        case 1 : // 공문인 경우 

                               $tag = "_former_view_flag";

                        break; 

                    }



                                $query = "select * from sid_cache_temp_table where SID = $sid";
                                $result = mysqli_query($conn,$query);
                                $row = mysqli_fetch_array($result);
                                $cache_size = $row['cache_size']+1;

                                for($cnt=1;$cnt<$cache_size;$cnt++){

                                    $target_field = $cnt.$tag;
                                    
                                    if($row[$target_field]==$id){
                                            $result_value = 1;
                                            break;
                                    }   

                                }

                    return $result_value;

            }

            function su_fucntion_add_data_to_cache($conn,$type,$sid,$id):int{
                    $result_value = $this->su_fucntion_is_cache_have($conn,$type,$sid,$id);

                    if($result_value==1){
                       return $result_value; 
                    }

                    switch($type){

                        case 0 : // 공지인 경우

                               $tag = "_notice_view_flag";

                        break;

                        case 1 : // 공문인 경우 

                               $tag = "_former_view_flag";

                        break; 

                    }

                                $query = "select * from sid_cache_temp_table where SID = $sid";
                                $result = mysqli_query($conn,$query);
                                $row = mysqli_fetch_array($result);
                                $cache_size = $row['cache_size']+1;

                                for($cnt=1;$cnt<$cache_size;$cnt++){

                                    $target_field = $cnt.$tag;
                                    
                                    if($row[$target_field]==NULL){
                                            $result_value = 1;
                                            $query2 = "update sid_cache_temp_table set $target_field = $id where SID = $sid;";
                                            mysqli_query($conn,$query2);
                                            break;
                                    }   

                                }

                                if($result_value==0){
                                    //메모리가 풀이면, 랜덤으로 데이터 하나에 붙여넣기 함.
                                    $result_value = 1;
                                    $randomNum = mt_rand(1, $cache_size-1);
                                    $target_field = $randomNum.$tag;
                                    $query2 = "update sid_cache_temp_table set $target_field = $id where SID = $sid;";
                                    mysqli_query($conn,$query2);

                                }

                    return $result_value;

            }



    }

?>