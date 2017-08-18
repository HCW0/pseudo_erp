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

   $ob2 = new su_class_value_name_convert_with_code();

   $all_Money = 0;
   $use_Money = 0;
   $remaind_Money = 0;
?>

<!DOCTYPE>
<head> 
<meta http-equiv="content-script-type" content="text/javascript"> 
<title>공정표</title> 

<?php include('./modal_fab.php');?>

</head>


                    <script>    
                        /*달력 함수*/
                                $(function() {
                                    $(".datepicker1, .datepicker2, .datepicker3").datepicker({
                                    dateFormat: 'yy-mm-dd'
                                    });
                                });

					</script>

<body>
   <div class="BOX">
      <div class="menu_area">
         <h3>MENU</h3>
      </div>
					
      <div class="document_area">
         
         <h2>용역 관 리 대 장<?php echo $_SESSION['tmp_buffer']; ?></h2>
         
         <div class="filterBOX">
            <table>
               <tr>
                  <td>
                  
                     <span>사업년도 : </span>
                     <select name="" id="">
                        <option value="">1900</option>
                        <option value="">1950</option>
                        <option value="">2000</option>
                     </select>

                     <select name="" id="">
                        <option value="">01</option>
                        <option value="">06</option>
                        <option value="">12</option>
                     </select>
                  </td>

                  <td>
                     <span>등급 : </span>
                     <select name="" id="">
                        <option value="">01</option>
                        <option value="">02</option>
                        <option value="">03</option>
                     </select>
                  </td>

                  <td>
                     <span>본부 : </span>
                     <select name="" id="">
                        <option value="6">기술연구소</option>
                        <option value="5">전력사업</option>
                        <option value="4">공간정보</option>
                        <option value="7">경영지원</option>
                        <option value="8">총괄</option>
                     </select>
                  </td>

                  <td>
                     <span>부서 : </span>
                     <select name="" id="">
                        <option value="">디자인</option>
                        <option value="">개발</option>
                        <option value="">기획</option>
                     </select>
                  </td>

                  <td>
                     <span>담당자 : </span>
                     <select name="" id="">
                        <option value="">오창주</option>
                        <option value="">정미소</option>
                        <option value="">황치원</option>
                        <option value="">민병희</option>
                     </select>
                  </td>

                  <td>
                     <span>상태 : </span>
                     <select name="" id="">
                        <option value="">전체</option>
                        <option value="">진행</option>
                        <option value="">완료</option>
                     </select>
                  </td>
                  <td id="search">
                     <input type="text" name="" id="searchText" size="8">
                     <a href="#">검색</a>
                  </td>
               </tr>
            </table>
            <input type="button" value="[조회☞]">
         </div>

         <div class="dataArea">
            <div class="setting">
               <!-- 필터링 옵션 세팅은 자신의 정보를 기본으로 Default setting 시킨다.  -->
               <!-- 그리고 해당 class=setting 영역에서는 Default setting 값을 보여준다.  -->
               <table class="setting_Table">
                  <tr>
                     <td colspan=7>
                        <h2>용 역 관 리 대 장</h2>
                     </td>
                  </tr>
                  <tr>
                     <td><span>조회기준일 : </span></td>
                     <td><span>사업년도 : </span></td>
                     <td><span>업무등급 : </span></td>
                     <td><span>본부 : </span></td>
                     <td><span>부서 : </span></td>
                     <td><span>담당자 : </span></td>
                     <td><span>상태 : </span></td>
                  </tr>
               </table><!-- setting_Table end -->    
            </div><!-- setting end -->

            <div class="dataTable">
               <table class="table" border="1" >
                  <tr id="titleRow">
                     <td>No</td>
                     <td>
                        관리번호
                        <input type="button" value="▲" onclick="order(this,'u_c');" 
                        style="width : 15px; height : 15px; border : none; text-align:center;
                        background : #FFFFFF; outline : none; margin:0; padding:0;
                        ">
                        </td>
                     </td>
                     <td>사업명</td>
                     <td>
                        발주처
                        <input type="button" value="▲" onclick="order(this,'c_t');" 
                        style="width : 15px; height : 15px; border : none; text-align:center;
                        background : #FFFFFF; outline : none; margin:0; padding:0;
                        ">
                        </td>
                     <td>
                        발주감독
                        <input type="button" value="▲" onclick="order(this,'s_v');" 
                        style="width : 15px; height : 15px; border : none; text-align:center;
                        background : #FFFFFF; outline : none; margin:0; padding:0;
                        ">
                     </td>
                     <td>영업담당</td>
                     <td>
                        담당팀
                        <input type="button" value="▲" onclick="order(this,'m_d');" 
                        style="width : 15px; height : 15px; border : none; text-align:center;
                        background : #FFFFFF; outline : none; margin:0; padding:0;
                        ">

                     </td>
                     <td>담당팀장</td>
                     <td>
                        계약일
                        <input type="button" value="▲" onclick="order(this,'f_d');" 
                        style="width : 15px; height : 15px; border : none; text-align:center;
                        background : #FFFFFF; outline : none; margin:0; padding:0;
                        ">
                     </td>
                     <td>착수일</td>
                     <td>준공일</td>
                     <td>
                        계약금액
                        <input type="button" value="▲" onclick="order(this,'a_m');" 
                        style="width : 15px; height : 15px; border : none; text-align:center;
                        background : #FFFFFF; outline : none; margin:0; padding:0;
                        ">
                     </td>
                     <td>기성액</td>
                     <td>잔액</td>
                     <td>비고</td>
                     <td>
                        수금
                        <input type="button" value="▲" onclick="order(this,'g_m');" 
                        style="width : 15px; height : 15px; border : none; text-align:center;
                        background : #FFFFFF; outline : none; margin:0; padding:0;
                        ">
                     </td>
                     <td>
                        상태
                        <input type="button" value="▲" onclick="order(this,'a_c');" 
                        style="width : 15px; height : 15px; border : none; text-align:center;
                        background : #FFFFFF; outline : none; margin:0; padding:0;
                        ">
                     </td>
               
                     <td>
                        하도급
                     </td>
                  </tr>
                     <!-- Data 출력 스크립트릿  -->
                     <?php
                        $arr1   = "master_task_level_sub_code";       // 관리번호
                        $arr2   = "master_task_level_sub_name";        // 사업명
                        $arr3   = "master_name";                     // 발주처      참조 master_customer
                        $arr4   = "master_name";                    // 발주감독    참조  master_superviser
                        $arr5   = "master_user_info_name";               // 영업담당      참조 sub_level_orderer 
                        $arr6   = "master_department_info_name";       // 담당팀      참조 sub_level_section
                        $arr7   = "master_user_info_name";               // 담당팀장    참조 master_department_info_name
                        $arr8   = "sub_level_from_date";               // 계약일    
                        $arr9   = "sub_level_birth_date";              // 착수일    
                        $arr10  = "sub_level_to_date";                  // 준공일    
                        $arr11  = "all_money_master_code_field";       // 계약금액  
                        $arr12  = "use_money_master_code_field";       // 기성액    
                        $arr13  = "remaind_money_master_code_field";    // 잔액      
                        $arr14  = "etcetera";                      // 비고      
                        $arr15  = "complete_rate";                  // 상태      
                        $arr16  = "";   
                        $arr19  = "sub_management";                        // 수금
                                                         
                        $arr17  = "sub_level_orderer"; 
                        $arr18  = "sub_level_section";

                        // 직책은   sub_level_position
                        // 영업담당 master_user_info_table     : master_user_info_name 
                        // 발주처 master_customer_table        : master_code / master_name
                        // 담당팀 master_department_info_table : sid_combine_department / master_department_info_name                  
                        
                        $query =   "SELECT
                                    mt.$arr1, 
                                    mt.$arr2, 
                                    mc.$arr3,
                                    ms.$arr4,
                                    mu.$arr5,
                                    md.$arr6,
                                    
                                    mt.$arr8,
                                    mt.$arr9,
                                    mt.$arr10,
                                    mt.$arr11,
                                    mt.$arr12,
                                    mt.$arr13,
                                    mt.$arr14,
                                    mt.$arr15,
                                    mt.$arr19
                                 FROM    
                                    master_task_level_sub_info_table mt, 
                                    master_customer_table mc,
                                    master_department_info_table md, 
                                    master_user_info_table mu,   
                                    master_superviser_table ms
                                 WHERE 
                                    mt.master_customer = mc.master_code AND
                                    mt.sub_level_orderer = mu.SID AND
                                    mt.sub_level_order_section = md.sid_combine_department AND
                                    mt.master_superviser = ms.master_code
                                    ORDER BY master_task_level_sub_code DESC
                                 ";

                          $result = mysqli_query($conn,$query);  
                        $count = 0;
                        $am = 0;
                        $um = 0;
                        $rm = 0;
                        $line = "1";

                        while($row=mysqli_fetch_array($result))
                        {         
                           $all_Money += $row[9];
                           $use_Money += $row[10];

                           $remaind_Money = (int)$all_Money-(int)$use_Money;

                           $count++;
                           

                           $rowNum = array(9,10,11);
                           $moneyArry = array();
                           for($i=0; $i<3; $i++){
                              $moneyArry[$i] = number_format($row[$rowNum[$i]]);
                           }

                           $rowDay = array(6,7,8);
                           $dayArray = array();
                           for($i=0; $i<3; $i++){
                              $dayArray[$i] =  date("y.m.d",strtotime($row[$rowDay[$i]]));
                           }

                           $state = "진행중";
                           if(      $row[13] == 0){$activity ="false"; $state = "진행중";   }
                           else{   $activity ="true"; $state = "완료";   }

                           // 삼항식으로 줄여 주세요
                           if( $line == "0" ){ 
                              $line = "1";
                           }else {
                              $line = "0";
                           }

                           $fun = "";
                           $sub = "";
                           if($row[14]!=0){
                              $sub = "<button id='sub'></button>";
                              $fun= "state_activity(this.id,$row[0]);";
                           }

                           echo (
                           "
                           <tr id=\"rowData\" class=\"c$line rowData\" onclick=$fun>
                              <td style=\"width:1%;\">$count</td>
                              <td style=\"width:6%;\"><a href=\"#\">$row[0]</a></td>
                              <td style=\"width:19%;\" class=\"title\">$row[1]</td>
                              <td style=\"width:6%;\">$row[2]</td>
                              <td style=\"width:5%;\" class=\"coworker\">$row[3]</td>
                              <td style=\"width:4%;\">$row[4]</td>
                              <td style=\"width:7%;\">$row[5]</td>
                              <td style=\"width:4%;\">6</td>
                              <td style=\"width:4%;\">$dayArray[0]</td>
                              <td style=\"width:4%;\">$dayArray[1]</td>
                              <td style=\"width:4%;\">$dayArray[2]</td>
                              <td style=\"width:7%;\" class=\"_m\">$moneyArry[0]</td>
                              <td style=\"width:7%;\" class=\"_m\">$moneyArry[1]</td>
                              <td style=\"width:7%;\" class=\"_m\">$moneyArry[2]</td>
                              <td style=\"width:4%;\">$row[12]</td>      
                              <td style=\"width:4%;\"></td>      
                              <td style=\"width:4%;\" id=\"$activity\">$state</td>
                              <td style=\"width:5%;\">$sub</td>                     
                           </tr>
                           "
                           );

                        }

                        echo "<script>
                              am=$all_Money;
                              um=$use_Money;
                              rm=$remaind_Money;
                              count=".$count.";
                           </script>";
                           
                        $am = number_format($all_Money);
                        $um = number_format($use_Money);
                        $rm = number_format($remaind_Money);

                        // 발주처 자동 완성 기능으로 데이터를 배열로 저장
                        // 담당팀 클릭시 담당팀장 자동 선택 기능
                        // 상태 - 다양한 상태 지원 제공?

                     ?>
                  <tr id="inputLine">
                     
                     <td><input type="button"id="field01" class="inputTEXT" value="추가" onclick="insertData();" ></td>
                     <td><input type="text"  id="field02" name="field" class="inputTEXT"     placeholder="관리번호"  ></td>
                     <td><input type="text"  id="field03" name="field" class="inputTEXT"     placeholder="사업명"   onclick="autoComplete(this);" ></td>
                     <td><input type="text"  id="field04" name="field" class="inputTEXT"     placeholder="발주처"   onclick="autoComplete(this);"></td>
                     <td><input type="text"  id="field05" name="field" class="inputTEXT"     placeholder="발주감독" onclick="autoComplete(this);"></td>
                     <td><input type="text"  id="field06" name="field" class="inputTEXT"     placeholder="영업담당" onkeyUp="real_time_user(this,this.value);"></td>
                     <td>
                        <select name="field" class="inputTEXT depart">
                           <option value=""> 선택하세요 </option>
                           <?php
                              $select = "SELECT sid_combine_department,master_department_info_name from master_department_info_table";
                              $result = mysqli_query($conn,$select);  
                              $str = "";
                              while($row=mysqli_fetch_array($result))
                              {
                                 $str.="<option value=".$row[0].">$row[1]</option>";
                              }
                              echo $str;
                           ?>
                        </select>
                     </td>
                     
                     <td><input type="text"  id="field08" name="field" class="inputTEXT"     placeholder="담당팀장"  ></td>
                     <td><input type="text"  id="field09" name="field" class="inputTEXT date datepicker1" placeholder="계약일"      ></td>
                     <td><input type="text"  id="field10" name="field" class="inputTEXT date datepicker2" placeholder="착수일"      ></td>
                     <td><input type="text"  id="field11" name="field" class="inputTEXT date datepicker3" placeholder="준공일"      ></td>
                     <td><input type="text"  id="field12" name="field" class="inputTEXT"     placeholder="계약금액"    ></td>
                     <td><input type="text"  id="field13" name="field" class="inputTEXT"     placeholder="기성액"      ></td>
                     <td><input type="text"  id="field14" name="field" class="inputTEXT"     placeholder="잔액"        ></td>
                     <td><input type="text"  id="field15" name="field" class="inputTEXT"     placeholder="비고"        ></td>
                     <td><input type="text"  id="field17" name="field" class="inputTEXT" placeholder="수금"  value="1"></td>
                     <td>
                        <select name="field" class="inputTEXT depart">
                           <option value="1">진행중</option>
                           <option value="2">완료</option>
                           <option value="3">경고</option>
                        </select>
                     </td>
                     <td><btton id="sub_add">+</btton></td>
                  </tr>
                  
                  <tr id="filter_last">
                      <?php
                        echo "         
                           <td colspan=2>합계</td>
                           <td> $count 건</td>
                           <td> $count 개소</td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td><span class=\"tm\">$am</span></td>
                           <td><span class=\"tm\">$um</span></td>
                           <td><span class=\"tm\">$rm</span></td>
                           <td></td>
                           <td></td>
                           <td></td>
                        "
                     ?>
                  </tr>
               </table>
            </div><!--dataTable -->
         </div><!-- .dataArea end -->
      </div><!-- .document_area end -->
   </div><!-- .BOX end -->
   <style type="text/css">
      .detail_area {
         width : 1500px;
         height : 100%;
         background : rgb(59,89,152);
         z-index : 6;
         display : none;
         box-shadow: 10px 10px 3px #888888;
      }
      #test1{
         color : white;
         text-align : center;
      }

      .testDIV{
         margin : 0;
         padding : 0;
         background : white;
         position : absolute;
         /* opacity: 0.5; */
      }

      .detail_table{
         border : 1px solid black;
         width : 100%;
         height : 80%;
      }
   </style>
   <div class="testDIV">
      <div class="detail_area">
         <table class="detail_table">
            <tr id="test1">
               <td>관리번호</td>
               <td>회사명</td>
               <td>내용</td>
               <td>하도 비율</td>
               <td>감독관</td>
               <td>계약일</td>
               <td>시작일</td>
               <td>마침일</td>
               <td>계약금</td>
               <td>선금</td>
               <td>잔금</td>
            </tr>
         </table>
      </div>
   </div>
 
   <div class="Tqiwrcmdqiw125qiehawqf4531"></div>

    <!-- 새로운 달력 자바 스크립트 소스-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>                     
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body> 
</html>
