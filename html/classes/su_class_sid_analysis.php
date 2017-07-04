<?php
    
    class su_class_sid_analysis{

            function su_function_sid_analysis($conn,$sid){
                
                // sid를 인자로 받고 호출되는 함수로, 인자를 분석해서 php 세션의 부서 계급 인적정보 변수를 갱신하는 함수
                // sid를 통해 sid_combine_table을 참조하고, 거기에서 각 bit 값을 가져와서 php 세션을 갱신하게 구현한다. 
                // 필요에 따라서 화면전환을 지원하는 함수, 아니면 그냥 호출한 곳으로 돌아가는 함수를 만든다.


                      $mquery = 'select * from sid_combine_table u where u.SID = '.$sid.';'; 
                      $result_set = mysqli_query($conn,$mquery);
                        if(mysqli_num_rows($result_set)==0) {
                                            die ("invalide sid : sid_combine_table에 해당 계정의 sid가 유효하지 않은 값입니다.");
                                                // redirect 추가
                                            }

                            $row = mysqli_fetch_assoc($result_set);
                            $_SESSION['my_position'] = $row['sid_combine_position'];
                            $_SESSION['my_name'] = $row['sid_combine_name'];
                            $_SESSION['my_department'] = $row['sid_combine_department'];
      
                       
            }


    }

?>