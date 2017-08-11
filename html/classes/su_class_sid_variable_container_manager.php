<?php
    
    class su_class_sid_variable_container_manager{



        // sid 기준으로 특정한 인력 묶음을 만드는 클래스이다.$_COOKIE
        // 원리는 직렬화를 이용한다.$_COOKIE
        // sid는 기본적으로 9자리의 정수형이므로 9자리가 되도록 zero_padding을 한 9자리 문자열sid를
        // 더해서 문자열코드를 배열로써 저장하는 것이다.$_COOKIE
        // 적당한 테이블에 vchar 필드를 90길이로 만들면 최대 10명을 저장할 수 있는 필드가 될 것이다.$_COOKIE
        //
        //
        // 선운이앤지는 기본적으로 sid가 고유번호로 되어 있고
        // 어디에 쓸지 모를 다용도 비트하나를 붙여서 10자리로 만들어 보내자. 이 경우 1의 경우에는 선운이앤지 사원 2~9이면 다른 발주업체의 사원이라던가.$_COOKIE
        //
        //
        // 부서의 경우에는 부서코드를 주면, 해당 부서내의 모든 sid를 zero_padding + reserve_bit 시켜서 문자열 코드 셋을 리턴하도록 하자.$_COOKIE




            function __construct(){ 

                

            }


           function su_function_decode($code){

				return substr($code,7,3);
           }

        
           function su_function_thesse_code_have_parameter($conn,$sid,$memory_id){
                                $target = $this->zero_padding($sid,1);
				$compare_container = $this->su_function_analysis_serialized_code($conn,$memory_id);
                                $cnt = count($compare_container);
                                $compare_container = array_unique($compare_container);
                                $cnt2 = count($compare_container);
                                return $cnt==$cnt2;
           }

           function su_function_generate_array_miner($conn){
                   if(!isset($_SESSION['receive_arr'])) return;

                        $result_array = array();
                   	$len = count($_SESSION['receive_arr']);
                        for($cnt = 0 ; $cnt < $len ; $cnt ++){
                                if(isset($_SESSION['receive_arr'][$cnt])){
                                        
                                        if($_SESSION['receive_arr'][$cnt]<0){
                                                $target = -1*$_SESSION['receive_arr'][$cnt];
                                                $tmp=$this->su_function_generate_serialized_code_against_department($conn,$target);
                                                $result_array=array_merge($result_array,$tmp);
                                        }else{
                                                $target = $_SESSION['receive_arr'][$cnt];
                                                $string = $this->zero_padding($target,1);
                                                $result_array[] = $string;
                                        }

                                }
                        }

                        
                        $result_array = array_unique($result_array);
                        sort($result_array);

                        $code = $this->su_function_generate_serialized_code_array($conn,$result_array);
                        $result_key = $this->su_function_register_serialized_code($conn,$code);

                        return $result_key;

           }


           function su_function_generate_input_list($conn,$ob2,$key){
                   if(!isset($_SESSION['receive_arr'])) return;
                                
                        $sresult='';
                   	$len = count($_SESSION['receive_arr']);
                        for($cnt = 0 ; $cnt < $len ; $cnt ++){
                                if(isset($_SESSION['receive_arr'][$cnt])){
                                        
                                        if($cnt!=$len-1){
                                                $tag = ',';
                                        }else{
                                                $tag ='';
                                        }

                                        if($_SESSION['receive_arr'][$cnt]<0){
                                                $target = -1*$_SESSION['receive_arr'][$cnt];
                                                $sresult = $sresult.$ob2->su_function_convert_name($conn,"master_department_info_table","sid_combine_department",$target,"master_department_info_name").$tag;
                                        }else{
                                                $target = $_SESSION['receive_arr'][$cnt];
                                                $sresult = $sresult.$ob2->su_function_convert_name($conn,"master_user_info_table","SID",$target,"master_user_info_name").$tag;
                                        }



                                }
                        }

                        
                        $table_name = 'sid_serialize_code_table';
                        $table_key = 's_table_key';
                        $table_map = 's_input';

                        $query2 =  "update $table_name set $table_map = '$sresult' where $table_key = ".$key;
                        $result2 = mysqli_query($conn,$query2);

           }



            function zero_padding($target,$reserve_code){
                if(strlen($target)>9) return $target;
                while(strlen($target)<9){
                        $target = '0'.$target;
                }
                return $reserve_code.$target;
            }



            function su_function_generate_serialized_code_against_department($conn,$department_code){

                    $query = "select * from sid_combine_table where sid_combine_department = $department_code";
                    $result = mysqli_query($conn,$query);
                    $result_sarray = array();
                        if(!$result) return $result_sarray;
                    while($result&&($row = mysqli_fetch_array($result))){

                                $target = $row['SID'];
                                $tmp = $this->zero_padding($target,1);
                                $result_sarray[] = $tmp;
                            }

                    return $result_sarray;
            }

            function su_function_generate_serialized_code_array($conn,$array){

                $code='';
                foreach ($array as &$value) { 
                        $code = $code.$this->su_function_generate_serialized_code_against_mono_sid($conn,$value);           
                } 
                return $code;

            }


            function su_function_generate_serialized_code_against_mono_sid($conn,$sid){
                    $result_sarray = '';

                    $target = $sid;
                    $tmp = $this->zero_padding($target,1);
                    $result_sarray = $result_sarray.$tmp;
                
                    return $result_sarray;
            }

            function su_function_register_serialized_code($conn,$code):int{
                    $table_name = 'sid_serialize_code_table';
                    $table_key = 's_table_key';
                    $table_map = 's_code';
            
                    $result_val = -1;
                    $query = "select * from $table_name where  $table_map = $code";
                    $result = mysqli_query($conn,$query);
                    if($result&&mysqli_num_rows($result)>0){
                            $row = mysqli_fetch_array($result);
                            $result_val = $row[$table_key];
                    }else{
                        $query2 = "Insert into $table_name($table_map) values($code)";
                        $result2 = mysqli_query($conn,$query2);
                        $result_val = $this->su_function_register_serialized_code($conn,$code);
                    }
                    
                    return $result_val;
            }



            function su_function_analysis_serialized_code($conn,$key){

                    $table_name = 'sid_serialize_code_table';
                    $table_key = 's_table_key';
                    $table_map = 's_code';

                    $result_array = array();
                    $query = "select * from $table_name where  $table_key = $key";
                    $result = mysqli_query($conn,$query);
                    $row = mysqli_fetch_array($result);
                    $target = $row[$table_map];
                    $cnt_ea = strlen($target)/10;
                    $len = strlen($target);

                    for($cnt=0;$cnt<$cnt_ea;$cnt++){
                        $element = substr($target,0,10);
                        $target = substr($target,10,$len - $cnt*10);
                        $result_array[] = $element;

                    }
                
                    return $result_array;
            }





    }

?>